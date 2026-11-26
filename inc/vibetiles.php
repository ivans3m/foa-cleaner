<?php
/**
 * Optional Vibetiles Guest Mode compatibility layer.
 *
 * FoA Cleaner has zero hard dependency on Vibetiles. When Vibetiles is active,
 * this module ensures graceful coexistence:
 * - Yields standalone light/dark mode controls so Vibetiles owns color switching.
 * - Keeps semantic --foa-* CSS variables aligned with Vibetiles Guest Mode palettes
 *   and OKLab light/dark opposite-side switching.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether the Vibetiles plugin is active and running.
 *
 * @since 0.1.0
 *
 * @return bool True when Vibetiles is active on the current request.
 */
function foa_cleaner_vibetiles_active(): bool {
	$active = defined( 'ARCHITRAVE_PANEL_VERSION' )
		&& ( ! function_exists( 'architrave_panel_runs' ) || architrave_panel_runs() );

	/**
	 * Filter whether FoA Cleaner treats Vibetiles as active.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $active Detection result.
	 */
	return (bool) apply_filters( 'foa_cleaner_vibetiles_active', $active );
}

/**
 * Keep FoA Cleaner's accent & elevated surface custom properties synchronized
 * when Vibetiles Guest Mode remaps the theme palette.
 *
 * @since 0.1.0
 *
 * @param string $css     Generated Guest Mode palette CSS from Vibetiles.
 * @param array  $palette Theme color palette map.
 * @return string Extended Guest Mode palette CSS.
 */
function foa_cleaner_vibetiles_palette_sync( string $css, array $palette ): string {
	unset( $palette );

	$sync = "\n:root[data-chosen] {\n"
		. "\t--foa-accent-solid: var(--accent, var(--wp--preset--color--foa-blue, #2E70FF));\n"
		. "\t--foa-accent-solid-hover: color-mix(in srgb, var(--foa-accent-solid) 86%, #000000);\n"
		. "}\n"
		. ":root[data-theme$=\"-dark\"][data-chosen] :is(.has-contrast-background-color, .is-style-dark-band) {\n"
		. "\tbackground-color: color-mix(in srgb, var(--surface-base, #171613) 90%, #FFFFFF) !important;\n"
		. "\tcolor: var(--text-primary, #F6F4EE);\n"
		. "\tborder-color: var(--line, #262420);\n"
		. "}\n";

	return $css . $sync;
}
add_filter( 'live_design_panel_guest_palette_css', 'foa_cleaner_vibetiles_palette_sync', 10, 2 );

/**
 * Keep dark sections cohesive when Vibetiles toggles a guest theme to its
 * opposite light/dark side without selecting a custom colour tile.
 *
 * @since 0.1.0
 *
 * @param string $css     Generated opposite-side CSS from Vibetiles.
 * @param array  $palette Theme color palette map.
 * @param string $side    Detected native theme side ('light' or 'dark').
 * @return string Extended opposite-side CSS.
 */
function foa_cleaner_vibetiles_other_side_sync( string $css, array $palette, string $side ): string {
	unset( $palette );

	if ( 'light' === $side ) {
		$gate  = ':root[data-theme$="-dark"]:not([data-chosen]):not([data-colours])';
		$css  .= "\n" . $gate . " :is(.has-contrast-background-color, .is-style-dark-band) {\n"
			. "\tbackground-color: color-mix(in srgb, var(--wp--preset--color--surface, #171613) 90%, #FFFFFF) !important;\n"
			. "\tcolor: var(--wp--preset--color--surface-dark-text, #F6F4EE);\n"
			. "\tborder-color: var(--wp--preset--color--border, #262420);\n"
			. "}\n";
	}

	return $css;
}
add_filter( 'live_design_panel_guest_other_side_css', 'foa_cleaner_vibetiles_other_side_sync', 10, 3 );

/**
 * Inspect the current Vibetiles site-wide default style state.
 *
 * @since 1.1.0
 *
 * @return array{has_default: bool, default_id: string, default_label: string, saved_count: int}
 */
function foa_cleaner_get_vibetiles_site_default(): array {
	$state = array();

	if ( function_exists( 'architrave_site_styles' ) ) {
		$raw = architrave_site_styles();
		if ( is_array( $raw ) ) {
			$state = $raw;
		}
	} else {
		$raw = get_option( 'architrave_panel_site_styles', '' );
		if ( is_string( $raw ) && '' !== $raw ) {
			$decoded = json_decode( $raw, true );
			if ( is_array( $decoded ) ) {
				$state = $decoded;
			}
		}
	}

	$styles        = isset( $state['styles'] ) && is_array( $state['styles'] ) ? $state['styles'] : array();
	$default_id    = isset( $state['default'] ) && is_string( $state['default'] ) ? trim( $state['default'] ) : '';
	$default_label = '';

	if ( '' !== $default_id ) {
		foreach ( $styles as $style ) {
			if ( isset( $style['id'] ) && $style['id'] === $default_id && ! empty( $style['label'] ) ) {
				$default_label = (string) $style['label'];
				break;
			}
		}
		if ( '' === $default_label ) {
			$default_label = ucfirst( str_replace( '-', ' ', $default_id ) );
		}
	}

	return array(
		'has_default'   => '' !== $default_id,
		'default_id'    => $default_id,
		'default_label' => $default_label,
		'saved_count'   => count( $styles ),
	);
}

/**
 * Render the Vibetiles Live Design & Rollback panel on Appearance → FoA Cleaner
 * whenever Vibetiles is active.
 *
 * Lets administrators see whether a Vibetiles style is currently published as
 * the site-wide default and perform a 1-click soft rollback back to FoA Cleaner's
 * original Clean Design Light default while keeping all saved Vibetiles styles.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_vibetiles_panel(): void {
	if ( ! foa_cleaner_vibetiles_active() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$info       = foa_cleaner_get_vibetiles_site_default();
	$has_custom = $info['has_default'];
	$home_url   = home_url( '/' );
	?>
	<section class="foa-admin-panel" aria-labelledby="foa-vibetiles-panel-heading" data-foa-vibetiles-panel>
		<div class="foa-admin-panel__header">
			<div class="foa-vibetiles-status-row">
				<h2 id="foa-vibetiles-panel-heading" class="foa-admin-panel__title"><?php esc_html_e( 'Vibetiles Site Default & Rollback', 'foa-cleaner' ); ?></h2>
				<?php if ( $has_custom ) : ?>
					<span class="foa-plugin-badge is-installed" data-foa-vibetiles-badge>
						<?php
						printf(
							/* translators: %s: active Vibetiles site default style label */
							esc_html__( 'Site Default: %s', 'foa-cleaner' ),
							esc_html( $info['default_label'] )
						);
						?>
					</span>
				<?php else : ?>
					<span class="foa-plugin-badge is-active" data-foa-vibetiles-badge><?php esc_html_e( 'FoA Cleaner Default', 'foa-cleaner' ); ?></span>
				<?php endif; ?>
			</div>
			<p class="foa-admin-panel__subtitle">
				<?php esc_html_e( 'Open the Vibetiles panel on your live site as an administrator to design and publish a look as the site default for all visitors. Your theme files are never modified, and you can roll back to FoA Cleaner’s original Clean Design Light default here at any time while keeping your saved Vibetiles styles.', 'foa-cleaner' ); ?>
			</p>
		</div>

		<div class="foa-vibetiles-actions">
			<a href="<?php echo esc_url( $home_url ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Open Live Customizer', 'foa-cleaner' ); ?>
			</a>
			<button
				type="button"
				class="button button-secondary"
				data-foa-vibetiles-restore
				<?php disabled( ! $has_custom ); ?>
			>
				<?php esc_html_e( 'Restore FoA Cleaner Default', 'foa-cleaner' ); ?>
			</button>
			<span class="foa-plugin-active-note" data-foa-vibetiles-note>
				<?php
				if ( $has_custom ) {
					printf(
						/* translators: %d: number of saved Vibetiles styles kept on soft rollback */
						esc_html( _n( 'Keeps your %d saved Vibetiles style intact.', 'Keeps your %d saved Vibetiles styles intact.', $info['saved_count'], 'foa-cleaner' ) ),
						(int) $info['saved_count']
					);
				} else {
					esc_html_e( 'Visitors currently see FoA Cleaner’s original Clean Design Light default.', 'foa-cleaner' );
				}
				?>
			</span>
		</div>
		<p class="foa-plugin-card__message" role="status" aria-live="polite" data-foa-vibetiles-message></p>
	</section>
	<?php
}

/**
 * AJAX handler: soft-rollback Vibetiles site default back to FoA Cleaner Default
 * while keeping all saved Vibetiles styles intact.
 *
 * @since 1.1.0
 */
function foa_cleaner_ajax_restore_vibetiles_default(): void {
	check_ajax_referer( 'foa_cleaner_vibetiles_action', 'nonce' );

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_send_json_error(
			array( 'message' => __( 'You do not have permission to change theme appearance settings.', 'foa-cleaner' ) ),
			403
		);
	}

	if ( ! foa_cleaner_vibetiles_active() ) {
		wp_send_json_error(
			array( 'message' => __( 'Vibetiles is not currently active.', 'foa-cleaner' ) ),
			400
		);
	}

	if ( function_exists( 'architrave_site_styles' ) && function_exists( 'architrave_site_styles_write' ) ) {
		$state            = architrave_site_styles();
		$state['default'] = '';
		architrave_site_styles_write( $state );

		if ( function_exists( 'architrave_site_styles_purge' ) ) {
			architrave_site_styles_purge();
		}
	} else {
		$raw   = get_option( 'architrave_panel_site_styles', '' );
		$state = is_string( $raw ) && '' !== $raw ? json_decode( $raw, true ) : array();
		if ( ! is_array( $state ) ) {
			$state = array();
		}
		$state['default'] = '';
		update_option( 'architrave_panel_site_styles', wp_json_encode( $state ), true );
		$stamp = max( (int) get_option( 'architrave_panel_site_styles_stamp', 0 ) + 1, (int) floor( microtime( true ) * 1000 ) );
		update_option( 'architrave_panel_site_styles_stamp', $stamp, true );
	}

	$info = foa_cleaner_get_vibetiles_site_default();

	wp_send_json_success(
		array(
			'savedCount' => $info['saved_count'],
			'message'    => __( 'Restored FoA Cleaner Default for all visitors. Your saved Vibetiles styles remain intact.', 'foa-cleaner' ),
		)
	);
}
add_action( 'wp_ajax_foa_cleaner_restore_vibetiles_default', 'foa_cleaner_ajax_restore_vibetiles_default' );
