<?php
/**
 * Lightweight Appearance → FoA Cleaner settings page and theme option helpers.
 *
 * Provides site-owner toggles for default color mode (System / Light / Dark)
 * and micro-animations (enabled by default, easy opt-out), plus developer
 * filter hooks.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FOA_CLEANER_OPTION_KEY', 'foa_cleaner_options' );

/**
 * Return default values for FoA Cleaner theme options.
 *
 * @since 0.1.0
 *
 * @return array{default_color_mode: string, enable_motion: bool, enable_jetpack_portfolio: bool}
 */
function foa_cleaner_option_defaults(): array {
	return array(
		'default_color_mode'       => 'light',
		'enable_motion'            => true,
		'enable_jetpack_portfolio' => false,
	);
}

/**
 * Return merged FoA Cleaner theme options.
 *
 * @since 0.1.0
 *
 * @return array{default_color_mode: string, enable_motion: bool, enable_jetpack_portfolio: bool}
 */
function foa_cleaner_get_options(): array {
	$defaults = foa_cleaner_option_defaults();
	$saved    = get_option( FOA_CLEANER_OPTION_KEY, array() );

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return wp_parse_args( $saved, $defaults );
}

/**
 * Detect whether the active Global Style Variation has a dark canvas background
 * (e.g. Midnight Slate).
 *
 * @since 0.1.0
 *
 * @return bool True when the active global canvas luminance is dark (< 0.35).
 */
function foa_cleaner_active_variation_is_dark(): bool {
	if ( ! function_exists( 'wp_get_global_styles' ) || ! function_exists( 'wp_get_global_settings' ) ) {
		return false;
	}

	$styles = (array) wp_get_global_styles( array( 'color' ) );
	$bg     = isset( $styles['background'] ) ? trim( (string) $styles['background'] ) : '';

	if ( '' === $bg ) {
		return false;
	}

	if ( preg_match( '/^var\(--wp--preset--color--([a-z0-9-]+)\)$/i', $bg, $match ) || preg_match( '/^var:preset\|color\|([a-z0-9-]+)$/i', $bg, $match ) ) {
		$slug = $match[1];
		$sets = (array) wp_get_global_settings( array( 'color', 'palette' ) );
		foreach ( array( 'custom', 'theme' ) as $origin ) {
			if ( empty( $sets[ $origin ] ) || ! is_array( $sets[ $origin ] ) ) {
				continue;
			}
			foreach ( $sets[ $origin ] as $entry ) {
				if ( isset( $entry['slug'], $entry['color'] ) && $entry['slug'] === $slug ) {
					$bg = trim( (string) $entry['color'] );
					break 2;
				}
			}
		}
	}

	if ( ! preg_match( '/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $bg, $hex ) ) {
		return false;
	}

	$raw = $hex[1];
	if ( 3 === strlen( $raw ) ) {
		$raw = $raw[0] . $raw[0] . $raw[1] . $raw[1] . $raw[2] . $raw[2];
	}

	$r = hexdec( substr( $raw, 0, 2 ) ) / 255;
	$g = hexdec( substr( $raw, 2, 2 ) ) / 255;
	$b = hexdec( substr( $raw, 4, 2 ) ) / 255;

	$luminance = ( 0.2126 * $r ) + ( 0.7152 * $g ) + ( 0.0722 * $b );

	return $luminance < 0.35;
}

/**
 * Get the configured default color mode ('system', 'light', or 'dark').
 *
 * When a dark-first style variation (such as Midnight Slate) is active and the
 * user has not explicitly saved a different option, defaults to 'dark'.
 *
 * @since 0.1.0
 *
 * @return string Validated mode string.
 */
function foa_cleaner_get_default_color_mode(): string {
	$saved   = get_option( FOA_CLEANER_OPTION_KEY, array() );
	$allowed = array( 'system', 'light', 'dark' );

	if ( is_array( $saved ) && isset( $saved['default_color_mode'] ) && in_array( $saved['default_color_mode'], $allowed, true ) ) {
		$mode = $saved['default_color_mode'];
	} else {
		$mode = foa_cleaner_active_variation_is_dark() ? 'dark' : 'light';
	}

	/**
	 * Filter the default color mode for visitors without a saved preference.
	 *
	 * @since 0.1.0
	 *
	 * @param string $mode One of 'system', 'light', or 'dark'.
	 */
	$filtered = (string) apply_filters( 'foa_cleaner_default_color_mode', $mode );

	return in_array( $filtered, $allowed, true ) ? $filtered : $mode;
}

/**
 * Check whether Clean Design micro-animations are enabled.
 *
 * @since 0.1.0
 *
 * @return bool True when micro-animations are enabled.
 */
function foa_cleaner_is_motion_enabled(): bool {
	$options = foa_cleaner_get_options();
	$enabled = (bool) $options['enable_motion'];

	/**
	 * Filter whether Clean Design micro-animations are enabled.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $enabled True to enable subtle scroll-reveal and interaction transitions.
	 */
	return (bool) apply_filters( 'foa_cleaner_enable_motion', $enabled );
}

/**
 * Check whether optional Jetpack Portfolio theme support is enabled.
 *
 * Jetpack v14.4+ hides Custom Content Types in block themes unless the theme
 * declares `jetpack-portfolio` support or the option was already enabled.
 *
 * @since 1.1.0
 *
 * @return bool True when Jetpack Portfolio theme support should be declared.
 */
function foa_cleaner_is_jetpack_portfolio_enabled(): bool {
	$options = foa_cleaner_get_options();
	$enabled = ! empty( $options['enable_jetpack_portfolio'] );

	/**
	 * Filter whether FoA Cleaner declares theme support for Jetpack Portfolios.
	 *
	 * @since 1.1.0
	 *
	 * @param bool $enabled True to call `add_theme_support( 'jetpack-portfolio' )`.
	 */
	return (bool) apply_filters( 'foa_cleaner_enable_jetpack_portfolio', $enabled );
}

/**
 * Sanitize theme options before saving to the database.
 *
 * @since 0.1.0
 *
 * @param mixed $input Raw submitted form values.
 * @return array{default_color_mode: string, enable_motion: bool, enable_jetpack_portfolio: bool} Sanitized option array.
 */
function foa_cleaner_sanitize_options( $input ): array {
	$defaults = foa_cleaner_option_defaults();

	if ( ! is_array( $input ) ) {
		return $defaults;
	}

	$allowed_modes = array( 'system', 'light', 'dark' );
	$mode          = isset( $input['default_color_mode'] ) ? sanitize_key( (string) $input['default_color_mode'] ) : $defaults['default_color_mode'];

	return array(
		'default_color_mode'       => in_array( $mode, $allowed_modes, true ) ? $mode : $defaults['default_color_mode'],
		'enable_motion'            => ! empty( $input['enable_motion'] ),
		'enable_jetpack_portfolio' => ! empty( $input['enable_jetpack_portfolio'] ),
	);
}

/**
 * Schedule a one-time rewrite flush when Jetpack Portfolio support is toggled.
 *
 * @since 1.1.0
 *
 * @param mixed $old_value Previous option value.
 * @param mixed $new_value Updated option value.
 */
function foa_cleaner_maybe_flush_portfolio_rewrites( $old_value, $new_value ): void {
	$was_enabled = is_array( $old_value ) && ! empty( $old_value['enable_jetpack_portfolio'] );
	$is_enabled  = is_array( $new_value ) && ! empty( $new_value['enable_jetpack_portfolio'] );

	if ( $was_enabled !== $is_enabled ) {
		if ( $is_enabled && ( defined( 'JETPACK__VERSION' ) || class_exists( 'Automattic\Jetpack\Classic_Theme_Helper\Jetpack_Portfolio' ) ) ) {
			update_option( 'jetpack_portfolio', '1' );
		}
		set_transient( 'foa_cleaner_flush_rewrites', 1, MINUTE_IN_SECONDS );
	}
}
add_action( 'update_option_' . FOA_CLEANER_OPTION_KEY, 'foa_cleaner_maybe_flush_portfolio_rewrites', 10, 2 );

/**
 * Flush rewrite rules once after the Jetpack Portfolio toggle changes.
 *
 * @since 1.1.0
 */
function foa_cleaner_handle_deferred_rewrite_flush(): void {
	if ( get_transient( 'foa_cleaner_flush_rewrites' ) ) {
		delete_transient( 'foa_cleaner_flush_rewrites' );
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'foa_cleaner_handle_deferred_rewrite_flush', 99 );

/**
 * Register the FoA Cleaner settings, section, and fields.
 *
 * @since 0.1.0
 */
function foa_cleaner_register_settings(): void {
	register_setting(
		'foa_cleaner_settings_group',
		FOA_CLEANER_OPTION_KEY,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'foa_cleaner_sanitize_options',
			'default'           => foa_cleaner_option_defaults(),
		)
	);

	add_settings_section(
		'foa_cleaner_general_section',
		__( 'Appearance & Experience', 'foa-cleaner' ),
		'foa_cleaner_render_general_section_intro',
		'foa-cleaner-options'
	);

	add_settings_field(
		'foa_cleaner_default_color_mode',
		__( 'Default Color Mode', 'foa-cleaner' ),
		'foa_cleaner_render_color_mode_field',
		'foa-cleaner-options',
		'foa_cleaner_general_section',
		array( 'label_for' => 'foa-cleaner-default-color-mode' )
	);

	add_settings_field(
		'foa_cleaner_enable_motion',
		__( 'Micro-Animations', 'foa-cleaner' ),
		'foa_cleaner_render_motion_field',
		'foa-cleaner-options',
		'foa_cleaner_general_section',
		array( 'label_for' => 'foa-cleaner-enable-motion' )
	);

	add_settings_section(
		'foa_cleaner_integrations_section',
		__( 'Optional Integrations', 'foa-cleaner' ),
		'foa_cleaner_render_integrations_section_intro',
		'foa-cleaner-options'
	);

	add_settings_field(
		'foa_cleaner_enable_jetpack_portfolio',
		__( 'Jetpack Portfolio', 'foa-cleaner' ),
		'foa_cleaner_render_jetpack_portfolio_field',
		'foa-cleaner-options',
		'foa_cleaner_integrations_section',
		array( 'label_for' => 'foa-cleaner-enable-jetpack-portfolio' )
	);
}
add_action( 'admin_init', 'foa_cleaner_register_settings' );

/**
 * Add the Appearance → FoA Cleaner submenu page.
 *
 * @since 0.1.0
 */
function foa_cleaner_add_options_page(): void {
	add_theme_page(
		__( 'FoA Cleaner Settings', 'foa-cleaner' ),
		__( 'FoA Cleaner', 'foa-cleaner' ),
		'edit_theme_options',
		'foa-cleaner-options',
		'foa_cleaner_render_options_page'
	);
}
add_action( 'admin_menu', 'foa_cleaner_add_options_page' );

/**
 * Render the settings section description.
 *
 * @since 0.1.0
 */
function foa_cleaner_render_general_section_intro(): void {
	echo '<p>' . esc_html__( 'Configure standalone appearance defaults and motion preferences. Typography, colors, and layouts are managed directly in the Site Editor.', 'foa-cleaner' ) . '</p>';
}

/**
 * Render the Default Color Mode select control.
 *
 * @since 0.1.0
 */
function foa_cleaner_render_color_mode_field(): void {
	$current = foa_cleaner_get_default_color_mode();
	$choices = array(
		'light'  => __( 'Light (Clean Design default)', 'foa-cleaner' ),
		'system' => __( 'System (follow visitor OS preference)', 'foa-cleaner' ),
		'dark'   => __( 'Dark', 'foa-cleaner' ),
	);

	echo '<select id="foa-cleaner-default-color-mode" name="' . esc_attr( FOA_CLEANER_OPTION_KEY ) . '[default_color_mode]">';
	foreach ( $choices as $value => $label ) {
		printf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $value ),
			selected( $current, $value, false ),
			esc_html( $label )
		);
	}
	echo '</select>';

	if ( foa_cleaner_vibetiles_active() ) {
		echo '<p class="description">' . esc_html__( 'Vibetiles is currently active and manages live light/dark switching on the frontend.', 'foa-cleaner' ) . '</p>';
	} else {
		echo '<p class="description">' . esc_html__( 'Applies to first-time visitors before they use the header light/dark switcher.', 'foa-cleaner' ) . '</p>';
	}
}

/**
 * Render the Micro-Animations checkbox control.
 *
 * @since 0.1.0
 */
function foa_cleaner_render_motion_field(): void {
	$options = foa_cleaner_get_options();
	$checked = ! empty( $options['enable_motion'] );

	printf(
		'<label for="foa-cleaner-enable-motion"><input type="checkbox" id="foa-cleaner-enable-motion" name="%1$s[enable_motion]" value="1"%2$s /> %3$s</label>',
		esc_attr( FOA_CLEANER_OPTION_KEY ),
		checked( $checked, true, false ),
		esc_html__( 'Enable subtle scroll-reveal and interaction micro-animations', 'foa-cleaner' )
	);
	echo '<p class="description">' . esc_html__( 'Always disabled automatically for visitors who prefer reduced motion in their OS settings.', 'foa-cleaner' ) . '</p>';
}

/**
 * Render the Optional Integrations section description.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_integrations_section_intro(): void {
	echo '<p>' . esc_html__( 'FoA Cleaner has zero required plugins. Enable optional integrations below only if you use them on your site.', 'foa-cleaner' ) . '</p>';
}

/**
 * Render the Jetpack Portfolio checkbox control.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_jetpack_portfolio_field(): void {
	$options        = foa_cleaner_get_options();
	$checked        = ! empty( $options['enable_jetpack_portfolio'] );
	$jetpack_active = defined( 'JETPACK__VERSION' ) || class_exists( 'Automattic\Jetpack\Classic_Theme_Helper\Jetpack_Portfolio' );

	printf(
		'<label for="foa-cleaner-enable-jetpack-portfolio"><input type="checkbox" id="foa-cleaner-enable-jetpack-portfolio" name="%1$s[enable_jetpack_portfolio]" value="1"%2$s /> %3$s</label>',
		esc_attr( FOA_CLEANER_OPTION_KEY ),
		checked( $checked, true, false ),
		esc_html__( 'Enable Jetpack Portfolio theme support (jetpack-portfolio custom post type)', 'foa-cleaner' )
	);

	if ( $jetpack_active ) {
		echo '<p class="description">' . esc_html__( 'Jetpack is active. Enabling this restores Portfolio Projects in block themes and activates FoA Cleaner portfolio archive and single project templates.', 'foa-cleaner' ) . '</p>';
	} else {
		echo '<p class="description">' . esc_html__( 'Jetpack is not currently active. This setting has no effect without Jetpack; you can also build portfolios natively using Pages and FoA Cleaner portfolio patterns.', 'foa-cleaner' ) . '</p>';
	}
}

/**
 * Render the Appearance → FoA Cleaner settings page.
 *
 * @since 0.1.0
 */
function foa_cleaner_render_options_page(): void {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'FoA Cleaner Settings', 'foa-cleaner' ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'foa_cleaner_settings_group' );
			do_settings_sections( 'foa-cleaner-options' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}
