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
 * @return array{default_color_mode: string, enable_motion: bool, enable_jetpack_portfolio: bool, enable_jetpack_markdown: bool}
 */
function foa_cleaner_option_defaults(): array {
	return array(
		'default_color_mode'       => 'light',
		'enable_motion'            => true,
		'toc_mode'                 => 'long',
		'enable_jetpack_portfolio' => false,
		'enable_jetpack_markdown'  => false,
	);
}

/**
 * Return merged FoA Cleaner theme options.
 *
 * @since 0.1.0
 *
 * @return array{default_color_mode: string, enable_motion: bool, enable_jetpack_portfolio: bool, enable_jetpack_markdown: bool}
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
 * Get the configured Auto-Generated TOC mode ('off', 'long', or 'always').
 *
 * @since 1.1.0
 *
 * @return string Validated TOC mode.
 */
function foa_cleaner_get_toc_mode(): string {
	$options = foa_cleaner_get_options();
	$allowed = array( 'off', 'long', 'always' );
	$mode    = in_array( $options['toc_mode'], $allowed, true ) ? $options['toc_mode'] : 'long';

	/**
	 * Filter the Auto-Generated Table of Contents mode on single posts.
	 *
	 * @since 1.1.0
	 *
	 * @param string $mode One of 'off', 'long', or 'always'.
	 */
	$filtered = (string) apply_filters( 'foa_cleaner_toc_mode', $mode );

	return in_array( $filtered, $allowed, true ) ? $filtered : $mode;
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

	if ( foa_cleaner_is_jetpack_active() ) {
		$jp_value = get_option( 'jetpack_portfolio', null );
		if ( null !== $jp_value ) {
			$enabled = '1' === (string) $jp_value || true === $jp_value;
		}
	}

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
 * Check whether Jetpack Markdown is currently enabled (mirrored from Jetpack).
 *
 * @since 1.1.0
 *
 * @return bool True when Jetpack Markdown is active.
 */
function foa_cleaner_is_jetpack_markdown_enabled(): bool {
	$enabled = false;

	if ( foa_cleaner_is_jetpack_active() ) {
		if ( class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'is_module_active' ) ) {
			$enabled = (bool) Jetpack::is_module_active( 'markdown' );
		} else {
			$enabled = '1' === (string) get_option( 'wpcom_publish_posts_with_markdown', '' );
		}
	}

	/**
	 * Filter whether Jetpack Markdown is treated as enabled.
	 *
	 * @since 1.1.0
	 *
	 * @param bool $enabled True when Jetpack Markdown is active.
	 */
	return (bool) apply_filters( 'foa_cleaner_enable_jetpack_markdown', $enabled );
}

/**
 * Sanitize theme options before saving to the database.
 *
 * Preserves Jetpack integration preferences when Jetpack is inactive so
 * disabled checkboxes are not inadvertently cleared on unrelated saves.
 *
 * @since 0.1.0
 *
 * @param mixed $input Raw submitted form values.
 * @return array{default_color_mode: string, enable_motion: bool, enable_jetpack_portfolio: bool, enable_jetpack_markdown: bool} Sanitized option array.
 */
function foa_cleaner_sanitize_options( $input ): array {
	$defaults       = foa_cleaner_option_defaults();
	$existing       = foa_cleaner_get_options();
	$jetpack_active = foa_cleaner_is_jetpack_active();

	if ( ! is_array( $input ) ) {
		return $defaults;
	}

	$allowed_modes = array( 'system', 'light', 'dark' );
	$mode          = isset( $input['default_color_mode'] ) ? sanitize_key( (string) $input['default_color_mode'] ) : $defaults['default_color_mode'];

	$allowed_toc = array( 'off', 'long', 'always' );
	$toc_mode    = isset( $input['toc_mode'] ) ? sanitize_key( (string) $input['toc_mode'] ) : $defaults['toc_mode'];

	return array(
		'default_color_mode'       => in_array( $mode, $allowed_modes, true ) ? $mode : $defaults['default_color_mode'],
		'enable_motion'            => ! empty( $input['enable_motion'] ),
		'toc_mode'                 => in_array( $toc_mode, $allowed_toc, true ) ? $toc_mode : $defaults['toc_mode'],
		'enable_jetpack_portfolio' => $jetpack_active ? ! empty( $input['enable_jetpack_portfolio'] ) : ! empty( $existing['enable_jetpack_portfolio'] ),
		'enable_jetpack_markdown'  => $jetpack_active ? ! empty( $input['enable_jetpack_markdown'] ) : ! empty( $existing['enable_jetpack_markdown'] ),
	);
}

/**
 * Mirror Jetpack Portfolio & Markdown settings whenever FoA Cleaner options are saved.
 *
 * Hooked to `pre_update_option_` so syncing runs even when the stored
 * `foa_cleaner_options` array matches the submitted value (for example, when a
 * Jetpack setting was changed directly in Jetpack Settings → Writing first).
 *
 * @since 1.1.0
 *
 * @param mixed $new_value Newly sanitized option value.
 * @param mixed $old_value Previous option value.
 * @return mixed Unmodified `$new_value`.
 */
function foa_cleaner_sync_jetpack_on_save( $new_value, $old_value ) {
	foa_cleaner_maybe_flush_portfolio_rewrites( $old_value, $new_value );
	return $new_value;
}
add_filter( 'pre_update_option_' . FOA_CLEANER_OPTION_KEY, 'foa_cleaner_sync_jetpack_on_save', 10, 2 );

/**
 * Mirror Jetpack Portfolio & Markdown settings when FoA Cleaner options are first saved.
 *
 * WordPress fires `add_option_{$option}` rather than `update_option_{$option}`
 * when the option row does not yet exist in the database.
 *
 * @since 1.1.0
 *
 * @param string $option Option name.
 * @param mixed  $value  Newly added option value.
 */
function foa_cleaner_maybe_flush_portfolio_rewrites_on_add( string $option, $value ): void {
	unset( $option );
	foa_cleaner_maybe_flush_portfolio_rewrites( array(), $value );
}
add_action( 'add_option_' . FOA_CLEANER_OPTION_KEY, 'foa_cleaner_maybe_flush_portfolio_rewrites_on_add', 10, 2 );

/**
 * Mirror Jetpack Portfolio & Markdown settings and schedule rewrite flush when toggled.
 *
 * @since 1.1.0
 *
 * @param mixed $old_value Previous option value.
 * @param mixed $new_value Updated option value.
 */
function foa_cleaner_maybe_flush_portfolio_rewrites( $old_value, $new_value ): void {
	static $syncing = false;

	if ( $syncing || ! foa_cleaner_is_jetpack_active() || ! is_array( $new_value ) ) {
		return;
	}

	$syncing = true;

	$was_portfolio    = is_array( $old_value ) && ! empty( $old_value['enable_jetpack_portfolio'] );
	$is_portfolio     = ! empty( $new_value['enable_jetpack_portfolio'] );
	$live_jp_portf    = '1' === (string) get_option( 'jetpack_portfolio', '' );

	if ( $was_portfolio !== $is_portfolio || $live_jp_portf !== $is_portfolio ) {
		update_option( 'jetpack_portfolio', $is_portfolio ? '1' : '0' );
		set_transient( 'foa_cleaner_flush_rewrites', 1, MINUTE_IN_SECONDS );
	}

	$is_markdown     = ! empty( $new_value['enable_jetpack_markdown'] );
	$was_jp_markdown = foa_cleaner_is_jetpack_markdown_enabled();

	if ( $is_markdown !== $was_jp_markdown ) {
		if ( class_exists( 'Jetpack' ) ) {
			if ( $is_markdown && method_exists( 'Jetpack', 'activate_module' ) ) {
				Jetpack::activate_module( 'markdown', false, false );
			} elseif ( ! $is_markdown && method_exists( 'Jetpack', 'deactivate_module' ) ) {
				Jetpack::deactivate_module( 'markdown' );
			}
		}
		update_option( 'wpcom_publish_posts_with_markdown', $is_markdown ? '1' : '0' );
	}

	$syncing = false;
}

/**
 * Keep FoA Cleaner's Portfolio option mirrored if `jetpack_portfolio` is toggled
 * directly inside Jetpack Settings → Writing.
 *
 * @since 1.1.0
 *
 * @param mixed $old_value Previous `jetpack_portfolio` value.
 * @param mixed $new_value Updated `jetpack_portfolio` value.
 */
function foa_cleaner_mirror_jetpack_portfolio_option( $old_value, $new_value ): void {
	static $mirroring = false;

	unset( $old_value );

	if ( $mirroring ) {
		return;
	}

	$enabled = '1' === (string) $new_value || true === $new_value;
	$options = foa_cleaner_get_options();

	if ( (bool) $options['enable_jetpack_portfolio'] === $enabled ) {
		return;
	}

	$mirroring                           = true;
	$options['enable_jetpack_portfolio'] = $enabled;
	update_option( FOA_CLEANER_OPTION_KEY, $options );
	$mirroring                           = false;
}
add_action( 'update_option_jetpack_portfolio', 'foa_cleaner_mirror_jetpack_portfolio_option', 10, 2 );

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

	add_settings_field(
		'foa_cleaner_toc_mode',
		__( 'Table of Contents', 'foa-cleaner' ),
		'foa_cleaner_render_toc_mode_field',
		'foa-cleaner-options',
		'foa_cleaner_general_section',
		array( 'label_for' => 'foa-cleaner-toc-mode' )
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

	add_settings_field(
		'foa_cleaner_enable_jetpack_markdown',
		__( 'Jetpack Markdown (for CV)', 'foa-cleaner' ),
		'foa_cleaner_render_jetpack_markdown_field',
		'foa-cleaner-options',
		'foa_cleaner_integrations_section',
		array( 'label_for' => 'foa-cleaner-enable-jetpack-markdown' )
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
 * Render the Auto-Generated Table of Contents mode select control.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_toc_mode_field(): void {
	$current = foa_cleaner_get_toc_mode();
	$choices = array(
		'long'   => __( 'Long posts only (4+ headings or 2,500+ characters)', 'foa-cleaner' ),
		'always' => __( 'Always on (any post with 2+ headings)', 'foa-cleaner' ),
		'off'    => __( 'Off', 'foa-cleaner' ),
	);

	echo '<select id="foa-cleaner-toc-mode" name="' . esc_attr( FOA_CLEANER_OPTION_KEY ) . '[toc_mode]">';
	foreach ( $choices as $value => $label ) {
		printf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $value ),
			selected( $current, $value, false ),
			esc_html( $label )
		);
	}
	echo '</select>';
	echo '<p class="description">' . esc_html__( 'Automatically generates an H2/H3 Table of Contents on single blog posts: sticky margin rail on wide desktops (1280px+) and collapsible card on smaller screens.', 'foa-cleaner' ) . '</p>';
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
 * Render the Jetpack Portfolio checkbox control (mirrored with Jetpack).
 *
 * @since 1.1.0
 */
function foa_cleaner_render_jetpack_portfolio_field(): void {
	$jetpack_active = foa_cleaner_is_jetpack_active();
	$checked        = $jetpack_active && foa_cleaner_is_jetpack_portfolio_enabled();
	$label_class    = $jetpack_active ? '' : ' class="foa-field-disabled"';

	printf(
		'<label for="foa-cleaner-enable-jetpack-portfolio"%1$s><input type="checkbox" id="foa-cleaner-enable-jetpack-portfolio" name="%2$s[enable_jetpack_portfolio]" value="1"%3$s%4$s /> %5$s</label>',
		$label_class, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static attribute string.
		esc_attr( FOA_CLEANER_OPTION_KEY ),
		checked( $checked, true, false ),
		disabled( ! $jetpack_active, true, false ),
		esc_html__( 'Enable Jetpack Portfolio projects (jetpack-portfolio custom post type)', 'foa-cleaner' )
	);

	if ( ! $jetpack_active ) {
		foa_cleaner_render_jetpack_inline_action();
		echo '<p class="description">' . esc_html__( 'Install and activate Jetpack to enable Portfolio Projects here, or build portfolios natively using Pages and FoA Cleaner portfolio patterns.', 'foa-cleaner' ) . '</p>';
	} else {
		echo '<p class="description">' . esc_html__( 'Mirrored with Jetpack Settings → Writing. Restores Portfolio Projects in block themes and activates FoA Cleaner portfolio archive and single project templates.', 'foa-cleaner' ) . '</p>';
	}
}

/**
 * Render the Jetpack Markdown (for CV) checkbox control (mirrored with Jetpack).
 *
 * @since 1.1.0
 */
function foa_cleaner_render_jetpack_markdown_field(): void {
	$jetpack_active = foa_cleaner_is_jetpack_active();
	$checked        = $jetpack_active && foa_cleaner_is_jetpack_markdown_enabled();
	$label_class    = $jetpack_active ? '' : ' class="foa-field-disabled"';

	printf(
		'<label for="foa-cleaner-enable-jetpack-markdown"%1$s><input type="checkbox" id="foa-cleaner-enable-jetpack-markdown" name="%2$s[enable_jetpack_markdown]" value="1"%3$s%4$s /> %5$s</label>',
		$label_class, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static attribute string.
		esc_attr( FOA_CLEANER_OPTION_KEY ),
		checked( $checked, true, false ),
		disabled( ! $jetpack_active, true, false ),
		esc_html__( 'Enable Jetpack Markdown block & Markdown writing support (for CV pages)', 'foa-cleaner' )
	);

	$ref_url  = function_exists( 'foa_cleaner_get_cv_format_reference_url' ) ? foa_cleaner_get_cv_format_reference_url() : 'https://github.com/ivans3m/cv-formatter';
	$ref_link = sprintf(
		' <a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>',
		esc_url( $ref_url ),
		esc_html__( 'Canonical cv-md/1.1 format on GitHub →', 'foa-cleaner' )
	);

	if ( ! $jetpack_active ) {
		foa_cleaner_render_jetpack_inline_action();
		echo '<p class="description">' . esc_html__( 'Install and activate Jetpack to mirror Markdown support for CV and documentation pages.', 'foa-cleaner' ) . $ref_link . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	} else {
		echo '<p class="description">' . esc_html__( 'Mirrored with Jetpack Settings → Writing (Markdown module). Enables the Jetpack Markdown block for pasting structured CV Markdown directly in the Block Editor.', 'foa-cleaner' ) . $ref_link . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	}

	foa_cleaner_render_cv_builder_panel();
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
		<?php foa_cleaner_render_recommended_plugins_panel(); ?>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'foa_cleaner_settings_group' );
			do_settings_sections( 'foa-cleaner-options' );
			submit_button();
			?>
		</form>
		<?php foa_cleaner_render_cv_upload_modal(); ?>
	</div>
	<?php
}
