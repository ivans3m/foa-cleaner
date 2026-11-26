<?php
/**
 * Auto-Generated Table of Contents (TOC) for single blog posts.
 *
 * Parses `<h2>` and `<h3>` headings in `core/post-content`, injects stable
 * anchor IDs where missing, and prepends a semantic `<aside class="foa-toc">`
 * navigation landmark (sticky right-margin rail on 1280px+ desktops, collapsible
 * Clean Design `<details>` card on smaller screens).
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether the current request is eligible for the Auto-Generated TOC.
 *
 * @since 1.1.0
 *
 * @return bool True on single blog posts when TOC mode is not 'off'.
 */
function foa_cleaner_should_load_toc(): bool {
	return ! is_admin()
		&& is_singular( 'post' )
		&& 'off' !== foa_cleaner_get_toc_mode();
}

/**
 * Conditionally enqueue TOC stylesheet and scroll-spy script on single posts.
 *
 * @since 1.1.0
 */
function foa_cleaner_enqueue_toc_assets(): void {
	if ( ! foa_cleaner_should_load_toc() ) {
		return;
	}

	$css_rel = 'assets/css/toc.css';
	if ( file_exists( get_theme_file_path( $css_rel ) ) ) {
		wp_enqueue_style(
			'foa-cleaner-toc',
			get_theme_file_uri( $css_rel ),
			array( 'foa-cleaner-style' ),
			foa_cleaner_asset_version( $css_rel )
		);
	}

	$js_rel = 'assets/js/toc.js';
	if ( file_exists( get_theme_file_path( $js_rel ) ) ) {
		wp_enqueue_script(
			'foa-cleaner-toc',
			get_theme_file_uri( $js_rel ),
			array(),
			foa_cleaner_asset_version( $js_rel ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'foa_cleaner_enqueue_toc_assets' );

/**
 * Extract `<h2>` and `<h3>` headings, inject unique anchor IDs where missing,
 * and prepend the Table of Contents markup to single blog post content.
 *
 * @since 1.1.0
 *
 * @param string $block_content Rendered `core/post-content` block HTML.
 * @return string Filtered block HTML with anchor IDs and TOC markup when applicable.
 */
function foa_cleaner_inject_post_toc( string $block_content ): string {
	if ( ! foa_cleaner_should_load_toc() || '' === $block_content || get_the_ID() !== get_queried_object_id() ) {
		return $block_content;
	}

	if ( false === stripos( $block_content, '<h2' ) && false === stripos( $block_content, '<h3' ) ) {
		return $block_content;
	}

	$headings  = array();
	$used_ids  = array();
	$index     = 0;

	$tagged_content = preg_replace_callback(
		'/<(h[23])(\b[^>]*)>(.*?)<\/\1>/is',
		static function ( array $matches ) use ( &$headings, &$used_ids, &$index ): string {
			$tag   = strtolower( $matches[1] );
			$attrs = $matches[2];
			$inner = $matches[3];
			$label = trim( html_entity_decode( wp_strip_all_tags( $inner ), ENT_QUOTES, 'UTF-8' ) );

			if ( '' === $label ) {
				return $matches[0];
			}

			++$index;
			$level = 'h3' === $tag ? 3 : 2;
			$id    = '';

			if ( preg_match( '/\bid=(["\'])([^"\']+)\1/i', $attrs, $id_match ) ) {
				$id = $id_match[2];
			} else {
				$base = sanitize_title( $label );
				if ( '' === $base ) {
					$base = 'section-' . $index;
				}
				$id     = $base;
				$suffix = 2;
				while ( isset( $used_ids[ $id ] ) ) {
					$id = $base . '-' . $suffix;
					++$suffix;
				}
				$attrs .= ' id="' . esc_attr( $id ) . '"';
			}

			$used_ids[ $id ] = true;
			$headings[]      = array(
				'id'    => $id,
				'label' => $label,
				'level' => $level,
			);

			return '<' . $tag . $attrs . '>' . $inner . '</' . $tag . '>';
		},
		$block_content
	);

	if ( ! is_string( $tagged_content ) || count( $headings ) < 2 ) {
		return $block_content;
	}

	$mode = foa_cleaner_get_toc_mode();
	if ( 'long' === $mode ) {
		/**
		 * Filter the minimum heading count that triggers the TOC in "Long posts only" mode.
		 *
		 * @since 1.1.0
		 *
		 * @param int $min_headings Default 4 headings.
		 */
		$min_headings = max( 2, (int) apply_filters( 'foa_cleaner_toc_min_headings', 4 ) );

		/**
		 * Filter the minimum character length that triggers the TOC in "Long posts only" mode.
		 *
		 * @since 1.1.0
		 *
		 * @param int $min_chars Default 2500 characters.
		 */
		$min_chars  = max( 500, (int) apply_filters( 'foa_cleaner_toc_min_chars', 2500 ) );
		$plain_text = trim( wp_strip_all_tags( $block_content ) );
		$char_count = function_exists( 'mb_strlen' ) ? mb_strlen( $plain_text, 'UTF-8' ) : strlen( $plain_text );

		if ( count( $headings ) < $min_headings && $char_count < $min_chars ) {
			return $block_content;
		}
	}

	$count_label = sprintf(
		/* translators: %d: number of headings in the table of contents */
		_n( '%d section', '%d sections', count( $headings ), 'foa-cleaner' ),
		count( $headings )
	);

	$items_html = '';
	foreach ( $headings as $item ) {
		$item_class = 3 === $item['level'] ? 'foa-toc__item is-level-3' : 'foa-toc__item is-level-2';
		$items_html .= sprintf(
			'<li class="%1$s"><a class="foa-toc__link" href="#%2$s" data-foa-toc-link="%2$s">%3$s</a></li>',
			esc_attr( $item_class ),
			esc_attr( $item['id'] ),
			esc_html( $item['label'] )
		);
	}

	$toc_html = sprintf(
		'<aside class="foa-toc" data-foa-toc aria-label="%1$s">'
		. '<details class="foa-toc__details">'
		. '<summary class="foa-toc__summary">'
		. '<span class="foa-toc__title">%2$s</span>'
		. '<span class="foa-toc__count">%3$s</span>'
		. '<span class="foa-toc__chevron" aria-hidden="true"></span>'
		. '</summary>'
		. '<ol class="foa-toc__list">%4$s</ol>'
		. '</details>'
		. '</aside>',
		esc_attr__( 'Table of contents', 'foa-cleaner' ),
		esc_html__( 'On this page', 'foa-cleaner' ),
		esc_html( $count_label ),
		$items_html
	);

	// Insert inside the outer .wp-block-post-content wrapper so it stays scoped cleanly.
	if ( preg_match( '/^(<div\b[^>]*>)/i', $tagged_content, $open_tag ) ) {
		return $open_tag[1] . $toc_html . substr( $tagged_content, strlen( $open_tag[1] ) );
	}

	return $toc_html . $tagged_content;
}
add_filter( 'render_block_core/post-content', 'foa_cleaner_inject_post_toc', 9, 1 );
