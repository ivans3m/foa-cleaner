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
 * Encode a Vibetiles v3 style record as a URL-safe base64 string for `#style=...` links.
 *
 * Matches Vibetiles `decodeRecord()` in `assets/js/presets.js`.
 *
 * @since 1.1.0
 *
 * @param array<string, mixed> $record Vibetiles v3 style record.
 * @return string URL-safe base64 string without padding.
 */
function foa_cleaner_vibetiles_encode_record( array $record ): string {
	$json = wp_json_encode( $record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	if ( ! is_string( $json ) || '' === $json ) {
		return '';
	}

	// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- required by Vibetiles #style= URL format.
	return rtrim( strtr( base64_encode( $json ), '+/', '-_' ), '=' );
}

/**
 * Return FoA Cleaner's 6 curated Vibetiles shareable presets (4 Global Style
 * Variations + 2 typography/mood presets) with ready-to-use `?ldp-try#style=...` URLs.
 *
 * @since 1.1.0
 *
 * @param string $base_url Optional base URL for preview links (defaults to `home_url( '/' )`).
 * @return array<int, array{slug: string, label: string, summary: string, swatch: string, record: array<string, mixed>, url: string}>
 */
function foa_cleaner_get_vibetiles_curated_presets( string $base_url = '' ): array {
	$base = '' !== $base_url ? $base_url : home_url( '/' );
	$try  = add_query_arg( 'ldp-try', '1', $base );

	$presets = array(
		array(
			'slug'    => 'swiss-ink',
			'label'   => __( 'Swiss Ink', 'foa-cleaner' ),
			'summary' => __( 'Monochrome near-black accent on crisp white with sharp hairline grids.', 'foa-cleaner' ),
			'swatch'  => '#0F0E0C',
			'record'  => array(
				'architrave'   => 3,
				'label'        => 'Swiss Ink',
				'base'         => 'host',
				'radius'       => 'small',
				'borderWidth'  => 'hairline',
				'buttonColour' => 'accent',
				'colours'      => array(
					'light' => array(
						'background'  => '#FFFFFF',
						'background2' => '#F5F5F3',
						'card'        => '#F5F5F3',
						'text'        => '#0F0E0C',
						'mutedText'   => '#5C5A55',
						'accent'      => '#0F0E0C',
						'highlight'   => '#E5E5E0',
						'button'      => '#0F0E0C',
					),
					'dark'  => array(
						'background'  => '#0F0E0C',
						'background2' => '#171614',
						'card'        => '#1C1B19',
						'text'        => '#F7F7F5',
						'mutedText'   => '#A19E97',
						'accent'      => '#F7F7F5',
						'highlight'   => '#292825',
						'button'      => '#F7F7F5',
					),
				),
			),
		),
		array(
			'slug'    => 'warm-paper',
			'label'   => __( 'Warm Paper', 'foa-cleaner' ),
			'summary' => __( 'Editorial cream canvas, deep charcoal ink, and muted terracotta accents.', 'foa-cleaner' ),
			'swatch'  => '#B84A27',
			'record'  => array(
				'architrave'   => 3,
				'label'        => 'Warm Paper',
				'base'         => 'host',
				'radius'       => 'small',
				'borderWidth'  => 'hairline',
				'buttonColour' => 'accent',
				'colours'      => array(
					'light' => array(
						'background'  => '#FAF8F4',
						'background2' => '#F1EDE4',
						'card'        => '#F1EDE4',
						'text'        => '#1A1714',
						'mutedText'   => '#615B52',
						'accent'      => '#B84A27',
						'highlight'   => '#E5DFD3',
						'button'      => '#B84A27',
					),
					'dark'  => array(
						'background'  => '#171411',
						'background2' => '#211D18',
						'card'        => '#27221C',
						'text'        => '#FAF8F4',
						'mutedText'   => '#ABA396',
						'accent'      => '#E07A58',
						'highlight'   => '#352E26',
						'button'      => '#E07A58',
					),
				),
			),
		),
		array(
			'slug'    => 'midnight-slate',
			'label'   => __( 'Midnight Slate', 'foa-cleaner' ),
			'summary' => __( 'Native dark-first deep slate palette with electric FoA Blue accents.', 'foa-cleaner' ),
			'swatch'  => '#4D86FF',
			'record'  => array(
				'architrave'   => 3,
				'label'        => 'Midnight Slate',
				'base'         => 'host',
				'radius'       => 'small',
				'borderWidth'  => 'hairline',
				'buttonColour' => 'accent',
				'colours'      => array(
					'light' => array(
						'background'  => '#0B0D11',
						'background2' => '#13161D',
						'card'        => '#171B24',
						'text'        => '#F4F6FA',
						'mutedText'   => '#A1A8B8',
						'accent'      => '#4D86FF',
						'highlight'   => '#222733',
						'button'      => '#4D86FF',
					),
					'dark'  => array(
						'background'  => '#0B0D11',
						'background2' => '#13161D',
						'card'        => '#171B24',
						'text'        => '#F4F6FA',
						'mutedText'   => '#A1A8B8',
						'accent'      => '#4D86FF',
						'highlight'   => '#222733',
						'button'      => '#4D86FF',
					),
				),
			),
		),
		array(
			'slug'    => 'forest-studio',
			'label'   => __( 'Forest Studio', 'foa-cleaner' ),
			'summary' => __( 'Minimal studio canvas with sage-tinted surfaces and deep pine accents.', 'foa-cleaner' ),
			'swatch'  => '#1B4D3E',
			'record'  => array(
				'architrave'   => 3,
				'label'        => 'Forest Studio',
				'base'         => 'host',
				'radius'       => 'medium',
				'borderWidth'  => 'hairline',
				'buttonColour' => 'accent',
				'colours'      => array(
					'light' => array(
						'background'  => '#FBFBF9',
						'background2' => '#F1F3EE',
						'card'        => '#F1F3EE',
						'text'        => '#121A17',
						'mutedText'   => '#515E58',
						'accent'      => '#1B4D3E',
						'highlight'   => '#E0E5DF',
						'button'      => '#1B4D3E',
					),
					'dark'  => array(
						'background'  => '#0E1412',
						'background2' => '#151E1B',
						'card'        => '#1B2622',
						'text'        => '#F5F7F4',
						'mutedText'   => '#99A8A1',
						'accent'      => '#52A88B',
						'highlight'   => '#24332E',
						'button'      => '#52A88B',
					),
				),
			),
		),
		array(
			'slug'    => 'editorial-serif',
			'label'   => __( 'Editorial Serif', 'foa-cleaner' ),
			'summary' => __( 'Long-form essay mood with Newsreader serif typography, relaxed leading, and warm ivory paper.', 'foa-cleaner' ),
			'swatch'  => '#8C4A2F',
			'record'  => array(
				'architrave'   => 3,
				'label'        => 'Editorial Serif',
				'base'         => 'standard',
				'reading'      => 'comfortable',
				'radius'       => 'small',
				'borderWidth'  => 'hairline',
				'links'        => 'underlined',
				'quotes'       => 'sideLine',
				'buttonColour' => 'accent',
				'roles'        => array(
					'title'    => array( 'font' => 'newsreader' ),
					'headings' => array( 'font' => 'newsreader' ),
					'body'     => array(
						'font'       => 'newsreader',
						'lineHeight' => 'relaxed',
					),
					'quote'    => array( 'font' => 'newsreader' ),
					'meta'     => array( 'font' => 'mono' ),
				),
				'colours'      => array(
					'light' => array(
						'background'  => '#FBF9F5',
						'background2' => '#F2EFE9',
						'card'        => '#F2EFE9',
						'text'        => '#191815',
						'mutedText'   => '#635E56',
						'accent'      => '#8C4A2F',
						'highlight'   => '#E7E1D7',
						'button'      => '#191815',
					),
					'dark'  => array(
						'background'  => '#151412',
						'background2' => '#1E1C19',
						'card'        => '#24211D',
						'text'        => '#F5F2EC',
						'mutedText'   => '#A8A196',
						'accent'      => '#D48A6A',
						'highlight'   => '#302C26',
						'button'      => '#F5F2EC',
					),
				),
			),
		),
		array(
			'slug'    => 'high-contrast-mono',
			'label'   => __( 'High-Contrast Mono', 'foa-cleaner' ),
			'summary' => __( 'Technical blueprint aesthetic with JetBrains Mono headings, sharp 0px corners, and FoA Blue accents.', 'foa-cleaner' ),
			'swatch'  => '#2E70FF',
			'record'  => array(
				'architrave'     => 3,
				'label'          => 'High-Contrast Mono',
				'base'           => 'standard',
				'radius'         => 'none',
				'borderWidth'    => '1',
				'borderStrength' => '70',
				'buttonColour'   => 'accent',
				'roles'          => array(
					'title'    => array( 'font' => 'jetbrains-mono' ),
					'headings' => array( 'font' => 'jetbrains-mono' ),
					'body'     => array( 'font' => 'plex-sans' ),
					'meta'     => array( 'font' => 'jetbrains-mono' ),
					'code'     => array( 'font' => 'jetbrains-mono' ),
				),
				'colours'        => array(
					'light' => array(
						'background'  => '#FFFFFF',
						'background2' => '#F2F2F0',
						'card'        => '#FFFFFF',
						'text'        => '#000000',
						'mutedText'   => '#4A4A46',
						'accent'      => '#2E70FF',
						'highlight'   => '#E4E4DF',
						'button'      => '#000000',
					),
					'dark'  => array(
						'background'  => '#09090B',
						'background2' => '#141417',
						'card'        => '#141417',
						'text'        => '#FAFAFA',
						'mutedText'   => '#A1A1AA',
						'accent'      => '#5C91FF',
						'highlight'   => '#27272A',
						'button'      => '#FAFAFA',
					),
				),
			),
		),
	);

	foreach ( $presets as $index => $preset ) {
		$encoded                  = foa_cleaner_vibetiles_encode_record( $preset['record'] );
		$presets[ $index ]['url'] = '' !== $encoded ? $try . '#style=' . $encoded : $try;
	}

	/**
	 * Filter FoA Cleaner's curated Vibetiles shareable presets.
	 *
	 * @since 1.1.0
	 *
	 * @param array  $presets  Curated preset list.
	 * @param string $base_url Base URL used for preview links.
	 */
	return (array) apply_filters( 'foa_cleaner_vibetiles_curated_presets', $presets, $base );
}

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
