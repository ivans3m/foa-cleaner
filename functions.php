<?php
/**
 * FoA Cleaner theme functions and definitions.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FOA_CLEANER_VERSION', '1.0.0' );

/**
 * Return a cache-busting version string for a theme-relative asset.
 *
 * @since 0.1.0
 *
 * @param string $relative_path Path relative to the theme root.
 * @return string File modification timestamp or theme version fallback.
 */
function foa_cleaner_asset_version( string $relative_path ): string {
	$path = get_theme_file_path( $relative_path );
	if ( file_exists( $path ) ) {
		return (string) filemtime( $path );
	}
	return FOA_CLEANER_VERSION;
}

/**
 * Load modular theme components.
 */
$foa_cleaner_includes = array(
	'inc/options.php',
	'inc/recommended-plugins.php',
	'inc/icons.php',
	'inc/vibetiles.php',
	'inc/block-styles.php',
	'inc/pattern-categories.php',
	'inc/reading-features.php',
	'inc/toc.php',
	'inc/cv.php',
	'inc/cv-importer.php',
);

foreach ( $foa_cleaner_includes as $foa_cleaner_file ) {
	require_once get_theme_file_path( $foa_cleaner_file );
}

/**
 * Set up theme defaults and register support for WordPress features.
 *
 * @since 0.1.0
 */
function foa_cleaner_setup(): void {
	load_theme_textdomain( 'foa-cleaner', get_template_directory() . '/languages' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'post-formats',
		array( 'aside', 'quote', 'link', 'status' )
	);

	if ( foa_cleaner_is_jetpack_portfolio_enabled() ) {
		add_theme_support( 'jetpack-portfolio' );
	}

	add_editor_style(
		array(
			'editor-style.css',
			'assets/css/blocks.css',
			'assets/css/patterns.css',
			'assets/css/cv.css',
		)
	);
}
add_action( 'after_setup_theme', 'foa_cleaner_setup' );

/**
 * Print an early inline script in <head> to apply the light/dark theme attribute
 * and motion preference before first paint (FOUC-free).
 *
 * Yields color-mode control automatically when Vibetiles is active.
 *
 * @since 0.1.0
 */
function foa_cleaner_early_head_script(): void {
	$vibetiles_active  = foa_cleaner_vibetiles_active();
	$default_mode      = foa_cleaner_get_default_color_mode();
	$motion_enabled    = foa_cleaner_is_motion_enabled();
	$variation_is_dark = foa_cleaner_active_variation_is_dark();

	$lines = array(
		'(function(){',
		'var root=document.documentElement;',
	);

	if ( ! $motion_enabled ) {
		$lines[] = 'root.setAttribute("data-foa-motion","off");';
	} else {
		$lines[] = 'if(!(window.matchMedia&&window.matchMedia("(prefers-reduced-motion: reduce)").matches)){root.classList.add("foa-js-motion");}';
	}

	if ( $variation_is_dark ) {
		$lines[] = 'root.setAttribute("data-foa-variation-scheme","dark");';
	}

	if ( ! $vibetiles_active ) {
		$lines[] = 'var def=' . wp_json_encode( $default_mode ) . ';';
		$lines[] = 'root.setAttribute("data-foa-default-theme",def);';
		$lines[] = 'var saved=null;try{saved=localStorage.getItem("foa-cleaner-theme");}catch(e){}';
		$lines[] = 'var mode=(saved==="dark"||saved==="light")?saved:(def==="system"?(window.matchMedia&&window.matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light"):def);';
		$lines[] = 'root.setAttribute("data-foa-theme",mode);';
	}

	$lines[] = '})();';

	wp_print_inline_script_tag(
		implode( '', $lines ),
		array( 'id' => 'foa-cleaner-early-mode' )
	);
}
add_action( 'wp_head', 'foa_cleaner_early_head_script', 1 );

/**
 * Enqueue frontend stylesheets and deferred vanilla JS scripts.
 *
 * @since 0.1.0
 */
function foa_cleaner_enqueue_assets(): void {
	wp_enqueue_style(
		'foa-cleaner-style',
		get_stylesheet_uri(),
		array(),
		foa_cleaner_asset_version( 'style.css' )
	);

	// Optional modular stylesheets (loaded as later phases populate them).
	$optional_styles = array(
		'foa-cleaner-blocks'   => 'assets/css/blocks.css',
		'foa-cleaner-patterns' => 'assets/css/patterns.css',
	);

	foreach ( $optional_styles as $handle => $rel ) {
		if ( file_exists( get_theme_file_path( $rel ) ) ) {
			wp_enqueue_style(
				$handle,
				get_theme_file_uri( $rel ),
				array( 'foa-cleaner-style' ),
				foa_cleaner_asset_version( $rel )
			);
		}
	}

	// Standalone Light/Dark switcher (omitted when Vibetiles owns color modes).
	if ( ! foa_cleaner_vibetiles_active() && file_exists( get_theme_file_path( 'assets/js/theme-mode.js' ) ) ) {
		wp_enqueue_script(
			'foa-cleaner-theme-mode',
			get_theme_file_uri( 'assets/js/theme-mode.js' ),
			array(),
			foa_cleaner_asset_version( 'assets/js/theme-mode.js' ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_add_inline_script(
			'foa-cleaner-theme-mode',
			'window.foaCleanerThemeMode = ' . wp_json_encode(
				array(
					'defaultMode' => foa_cleaner_get_default_color_mode(),
					'labels'      => array(
						'switchToDark'  => __( 'Switch to dark mode', 'foa-cleaner' ),
						'switchToLight' => __( 'Switch to light mode', 'foa-cleaner' ),
					),
				)
			) . ';',
			'before'
		);
	}

	// Micro-animations assets (Phase 3 — only loaded when motion is enabled).
	if ( foa_cleaner_is_motion_enabled() ) {
		if ( file_exists( get_theme_file_path( 'assets/css/motion.css' ) ) ) {
			wp_enqueue_style(
				'foa-cleaner-motion',
				get_theme_file_uri( 'assets/css/motion.css' ),
				array( 'foa-cleaner-style' ),
				foa_cleaner_asset_version( 'assets/css/motion.css' )
			);
		}

		if ( file_exists( get_theme_file_path( 'assets/js/reveal.js' ) ) ) {
			wp_enqueue_script(
				'foa-cleaner-reveal',
				get_theme_file_uri( 'assets/js/reveal.js' ),
				array(),
				foa_cleaner_asset_version( 'assets/js/reveal.js' ),
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'foa_cleaner_enqueue_assets' );

/**
 * Append semantic state classes to the <body> element.
 *
 * @since 0.1.0
 *
 * @param string[] $classes Existing body classes.
 * @return string[] Modified body classes.
 */
function foa_cleaner_body_classes( array $classes ): array {
	$classes[] = foa_cleaner_is_motion_enabled() ? 'foa-motion-enabled' : 'foa-motion-disabled';

	if ( foa_cleaner_vibetiles_active() ) {
		$classes[] = 'foa-vibetiles-active';
	}

	return $classes;
}
add_filter( 'body_class', 'foa_cleaner_body_classes' );
