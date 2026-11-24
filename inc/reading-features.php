<?php
/**
 * Editorial & reading features foundation.
 *
 * Provides conditional asset loading for single-post Focus Mode, reading
 * progress bar, and copy-code buttons (populated in Phase 3), plus helper
 * utilities for reading time and yearly post archives.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Conditionally enqueue reading & editorial enhancement assets.
 *
 * Each script/stylesheet is loaded only on views where the relevant feature
 * or block is actually present.
 *
 * @since 0.1.0
 */
function foa_cleaner_enqueue_reading_assets(): void {
	// Copy-to-clipboard button: load only on singular views containing a core/code block.
	if ( is_singular() && has_block( 'core/code' ) && file_exists( get_theme_file_path( 'assets/js/copy-code.js' ) ) ) {
		wp_enqueue_script(
			'foa-cleaner-copy-code',
			get_theme_file_uri( 'assets/js/copy-code.js' ),
			array(),
			foa_cleaner_asset_version( 'assets/js/copy-code.js' ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_add_inline_script(
			'foa-cleaner-copy-code',
			'window.foaCleanerCopyCode = ' . wp_json_encode(
				array(
					'copy'   => __( 'Copy', 'foa-cleaner' ),
					'copied' => __( 'Copied', 'foa-cleaner' ),
					'failed' => __( 'Failed', 'foa-cleaner' ),
				)
			) . ';',
			'before'
		);
	}

	// Single-post Focus Mode + 1px reading progress bar.
	if ( is_singular( 'post' ) ) {
		if ( file_exists( get_theme_file_path( 'assets/css/focus-mode.css' ) ) ) {
			wp_enqueue_style(
				'foa-cleaner-focus-mode',
				get_theme_file_uri( 'assets/css/focus-mode.css' ),
				array( 'foa-cleaner-style' ),
				foa_cleaner_asset_version( 'assets/css/focus-mode.css' )
			);
		}

		if ( file_exists( get_theme_file_path( 'assets/js/focus-mode.js' ) ) ) {
			wp_enqueue_script(
				'foa-cleaner-focus-mode',
				get_theme_file_uri( 'assets/js/focus-mode.js' ),
				array(),
				foa_cleaner_asset_version( 'assets/js/focus-mode.js' ),
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);

			wp_add_inline_script(
				'foa-cleaner-focus-mode',
				'window.foaCleanerFocusMode = ' . wp_json_encode(
					array(
						'enterFocus' => __( 'Enter focus mode', 'foa-cleaner' ),
						'exitFocus'  => __( 'Exit focus mode', 'foa-cleaner' ),
					)
				) . ';',
				'before'
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'foa_cleaner_enqueue_reading_assets' );

/**
 * Estimate reading time in minutes for a given post.
 *
 * @since 0.1.0
 *
 * @param int|null $post_id Optional post ID. Defaults to current post.
 * @return int Estimated reading time in minutes (minimum 1).
 */
function foa_cleaner_reading_time( ?int $post_id = null ): int {
	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post ) {
		return 1;
	}

	$text       = trim( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );
	$words      = '' === $text ? array() : preg_split( '/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY );
	$word_count = is_array( $words ) ? count( $words ) : 0;

	return max( 1, (int) ceil( $word_count / 220 ) );
}

/**
 * Add an explicit post-format semantic class for archive/stream styling.
 *
 * @since 0.1.0
 *
 * @param string[] $classes Existing post classes.
 * @param string[] $css_class Additional classes passed to post_class().
 * @param int      $post_id Post ID.
 * @return string[] Modified post classes.
 */
function foa_cleaner_post_format_classes( array $classes, array $css_class, int $post_id ): array {
	if ( 'post' !== get_post_type( $post_id ) ) {
		return $classes;
	}

	$format = get_post_format( $post_id );
	if ( $format ) {
		$classes[] = 'foa-format-card';
		$classes[] = 'foa-format-' . sanitize_html_class( $format );
	}

	return $classes;
}
add_filter( 'post_class', 'foa_cleaner_post_format_classes', 10, 3 );
