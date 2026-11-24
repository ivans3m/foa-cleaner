<?php
/**
 * CV Page Template support (`page-cv`) and `cv-md/1.1` Markdown helpers.
 *
 * - Conditionally enqueues `assets/css/cv.css` only on the `page-cv` template
 *   or when a post/page uses the `.is-style-cv` block style.
 * - Tags trailing `<h2>Facts</h2>` headings (plus localized `cv-md/1.1`
 *   equivalents: Feiten, Fakten, Faits) on the frontend so CSS cleanly hides
 *   the Markdown-only Facts archive without altering stored post content.
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether the current frontend request should load CV styles/tagging.
 *
 * @since 1.1.0
 *
 * @return bool True on `page-cv` template or when `.is-style-cv` is present.
 */
function foa_cleaner_is_cv_context(): bool {
	if ( is_page_template( 'page-cv' ) ) {
		return true;
	}

	if ( is_singular() ) {
		$post = get_post();
		if ( $post instanceof WP_Post && false !== strpos( $post->post_content, 'is-style-cv' ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Conditionally enqueue `assets/css/cv.css` on CV pages only.
 *
 * @since 1.1.0
 */
function foa_cleaner_enqueue_cv_assets(): void {
	if ( ! foa_cleaner_is_cv_context() ) {
		return;
	}

	$rel = 'assets/css/cv.css';
	if ( ! file_exists( get_theme_file_path( $rel ) ) ) {
		return;
	}

	wp_enqueue_style(
		'foa-cleaner-cv',
		get_theme_file_uri( $rel ),
		array( 'foa-cleaner-style' ),
		foa_cleaner_asset_version( $rel )
	);
}
add_action( 'wp_enqueue_scripts', 'foa_cleaner_enqueue_cv_assets' );

/**
 * Tag `<h2>Facts</h2>` (and localized `cv-md/1.1` equivalents) with
 * `.foa-cv-facts-heading` on the frontend so CSS hides the Markdown-only
 * Facts section and its trailing siblings.
 *
 * Applies to `jetpack/markdown` and `core/heading` blocks inside CV contexts.
 *
 * @since 1.1.0
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block array.
 * @return string Possibly tagged block HTML.
 */
function foa_cleaner_tag_cv_facts_heading( string $block_content, array $block ): string {
	if ( is_admin() || '' === $block_content || ! foa_cleaner_is_cv_context() ) {
		return $block_content;
	}

	$block_name = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
	if ( ! in_array( $block_name, array( 'jetpack/markdown', 'core/heading' ), true ) ) {
		return $block_content;
	}

	if ( false === stripos( $block_content, '<h2' ) ) {
		return $block_content;
	}

	$facts_labels = array( 'facts', 'feiten', 'fakten', 'faits' );

	$updated = preg_replace_callback(
		'/<h2(\b[^>]*)>(.*?)<\/h2>/is',
		static function ( array $matches ) use ( $facts_labels ): string {
			$attrs = $matches[1];
			$inner = $matches[2];
			$label = strtolower( trim( wp_strip_all_tags( $inner ) ) );

			if ( ! in_array( $label, $facts_labels, true ) ) {
				return $matches[0];
			}

			if ( preg_match( '/\bclass=(["\'])(.*?)\1/i', $attrs ) ) {
				$attrs = preg_replace(
					'/\bclass=(["\'])(.*?)\1/i',
					'class=$1$2 foa-cv-facts-heading$1',
					$attrs,
					1
				);
			} else {
				$attrs .= ' class="foa-cv-facts-heading"';
			}

			return '<h2' . $attrs . '>' . $inner . '</h2>';
		},
		$block_content
	);

	return is_string( $updated ) ? $updated : $block_content;
}
add_filter( 'render_block', 'foa_cleaner_tag_cv_facts_heading', 12, 2 );
