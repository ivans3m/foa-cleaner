<?php
/**
 * Editorial & reading features foundation.
 *
 * Provides conditional asset loading for single-post Focus Mode, reading
 * progress bar, and copy-code buttons (populated in Phase 3), plus helper
 * utilities for reading time, yearly post archives, and post format classes.
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
						'focusLabel' => __( 'Focus', 'foa-cleaner' ),
						'exitLabel'  => __( 'Exit focus', 'foa-cleaner' ),
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
 * Uses Unicode-aware splitting so non-ASCII languages calculate accurately.
 *
 * @since 0.1.0
 *
 * @param int|null $post_id Optional post ID. Defaults to current post.
 * @return int Estimated reading time in minutes (minimum 1).
 */
function foa_cleaner_reading_time( ?int $post_id = null ): int {
	if ( null === $post_id && is_singular() ) {
		$post_id = get_queried_object_id();
	}

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
 * Render the chronological Yearly Archive HTML grouped by publication year.
 *
 * @since 0.1.0
 *
 * @return string Archive HTML markup.
 */
function foa_cleaner_render_yearly_archive(): string {
	$max_posts = (int) apply_filters( 'foa_cleaner_yearly_archive_limit', 500 );

	$query = new WP_Query(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => max( 1, min( 2000, $max_posts ) ),
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	if ( ! $query->have_posts() ) {
		return '<p class="foa-yearly-archive-empty">' . esc_html__( 'No posts published yet.', 'foa-cleaner' ) . '</p>';
	}

	$grouped = array();
	foreach ( $query->posts as $archive_post ) {
		$year = get_the_date( 'Y', $archive_post );
		if ( ! isset( $grouped[ $year ] ) ) {
			$grouped[ $year ] = array();
		}
		$grouped[ $year ][] = $archive_post;
	}

	$output = '<div class="foa-yearly-archive">';

	foreach ( $grouped as $year => $posts ) {
		$count       = count( $posts );
		$count_label = sprintf(
			/* translators: %s: number of posts in a given year. */
			_n( '%s post', '%s posts', $count, 'foa-cleaner' ),
			number_format_i18n( $count )
		);

		$output .= '<section class="foa-archive-year-group" aria-labelledby="foa-year-' . esc_attr( $year ) . '">';
		$output .= '<div class="foa-archive-year-heading">';
		$output .= '<h2 id="foa-year-' . esc_attr( $year ) . '" class="foa-archive-year-title">' . esc_html( $year ) . '</h2>';
		$output .= '<span class="foa-archive-year-count">' . esc_html( $count_label ) . '</span>';
		$output .= '</div>';
		$output .= '<ol class="foa-archive-year-list">';

		$item_date_format = _x( 'M j', 'yearly archive item date format', 'foa-cleaner' );

		foreach ( $posts as $archive_post ) {
			$title = get_the_title( $archive_post );
			if ( '' === trim( $title ) ) {
				$title = __( '(Untitled)', 'foa-cleaner' );
			}

			$output .= '<li class="foa-archive-year-item">';
			$output .= '<time class="foa-archive-item-date" datetime="' . esc_attr( get_the_date( DATE_W3C, $archive_post ) ) . '">' . esc_html( get_the_date( $item_date_format, $archive_post ) ) . '</time>';
			$output .= '<a class="foa-archive-item-link" href="' . esc_url( get_permalink( $archive_post ) ) . '">' . esc_html( $title ) . '</a>';
			$output .= '</li>';
		}

		$output .= '</ol>';
		$output .= '</section>';
	}

	$output .= '</div>';

	return $output;
}

/**
 * Return the accessible single-post Focus Mode toggle button markup.
 *
 * @since 0.1.0
 *
 * @return string Button HTML markup, or empty string outside single posts.
 */
function foa_cleaner_focus_toggle_markup(): string {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	return sprintf(
		'<button type="button" class="foa-focus-toggle" data-foa-focus-toggle aria-pressed="false" aria-label="%1$s">%2$s%3$s<span class="foa-focus-toggle-text">%4$s</span></button>',
		esc_attr__( 'Enter focus mode', 'foa-cleaner' ),
		foa_cleaner_icon( 'maximize-2', array( 'width' => '14', 'height' => '14' ) ),
		foa_cleaner_icon( 'minimize-2', array( 'width' => '14', 'height' => '14' ) ),
		esc_html__( 'Focus', 'foa-cleaner' )
	);
}

/**
 * Print the 1px reading progress bar and Focus Mode exit pill on single posts.
 *
 * @since 0.1.0
 */
function foa_cleaner_single_post_reading_chrome(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	echo '<div class="foa-reading-progress" aria-hidden="true"><div class="foa-reading-progress__bar"></div></div>';
	echo '<button type="button" class="foa-focus-exit" data-foa-focus-exit aria-label="' . esc_attr__( 'Exit focus mode', 'foa-cleaner' ) . '">'
		. foa_cleaner_icon( 'minimize-2', array( 'width' => '14', 'height' => '14' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped SVG helper.
		. '<span>' . esc_html__( 'Exit focus', 'foa-cleaner' ) . '</span></button>';
}
add_action( 'wp_body_open', 'foa_cleaner_single_post_reading_chrome' );

/**
 * Populate reading-time, focus-toggle, and yearly-archive slots inside rendered block HTML.
 *
 * @since 0.1.0
 *
 * @param string $block_content Rendered block HTML.
 * @return string Filtered block HTML.
 */
function foa_cleaner_render_reading_slots( string $block_content ): string {
	if ( false !== strpos( $block_content, 'data-foa-reading-time' ) ) {
		$block_content = (string) preg_replace_callback(
			'/<span\s+data-foa-reading-time(?:="")?\s*><\/span>/',
			static function (): string {
				$minutes = foa_cleaner_reading_time();
				$label   = sprintf(
					/* translators: %d: estimated reading time in minutes. */
					_n( '%d min read', '%d min read', $minutes, 'foa-cleaner' ),
					$minutes
				);
				return '<span class="foa-reading-time">' . esc_html( $label ) . '</span>';
			},
			$block_content
		);
	}

	if ( false !== strpos( $block_content, 'data-foa-focus-toggle-slot' ) ) {
		$block_content = (string) preg_replace_callback(
			'/<span\s+data-foa-focus-toggle-slot(?:="")?\s*><\/span>/',
			static function (): string {
				return foa_cleaner_focus_toggle_markup();
			},
			$block_content
		);
	}

	if ( false !== strpos( $block_content, 'foa-yearly-archive-slot' ) ) {
		$block_content = (string) preg_replace_callback(
			'/<div\s+class="foa-yearly-archive-slot"\s*><\/div>/',
			static function (): string {
				return foa_cleaner_render_yearly_archive();
			},
			$block_content
		);
	}

	return $block_content;
}
add_filter( 'render_block', 'foa_cleaner_render_reading_slots', 8 );

/**
 * Add an accessible aria-label to the single-post navigation <nav> landmark
 * on frontend render without affecting Site Editor block serialization.
 *
 * @since 0.1.0
 *
 * @param string $block_content Rendered block HTML.
 * @return string Filtered block HTML.
 */
function foa_cleaner_post_nav_aria_label( string $block_content ): string {
	if ( false === strpos( $block_content, 'foa-post-nav' ) || false !== strpos( $block_content, 'aria-label=' ) ) {
		return $block_content;
	}

	return (string) preg_replace(
		'/<nav\b/',
		'<nav aria-label="' . esc_attr__( 'Post navigation', 'foa-cleaner' ) . '"',
		$block_content,
		1
	);
}
add_filter( 'render_block_core/group', 'foa_cleaner_post_nav_aria_label', 10 );

/**
 * Add an explicit post-format semantic class for archive/stream styling.
 *
 * @since 0.1.0
 *
 * @param string[] $classes   Existing post classes.
 * @param string[] $css_class Additional classes passed to post_class().
 * @param int      $post_id   Post ID.
 * @return string[] Modified post classes.
 */
function foa_cleaner_post_format_classes( array $classes, array $css_class, int $post_id ): array {
	unset( $css_class );

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

/**
 * Append `wp_link_pages()` pagination links to `core/post-content` on
 * multi-page singular posts and pages (`<!--nextpage-->`).
 *
 * Ensures WordPress Theme Unit Test Data paginated posts render accessible
 * page links without duplicating core block markup.
 *
 * @since 1.1.0
 *
 * @param string $block_content Rendered `core/post-content` block HTML.
 * @return string Block HTML with `.post-nav-links` appended when paginated.
 */
function foa_cleaner_append_post_link_pages( string $block_content ): string {
	if ( is_admin() || ! is_singular() || get_the_ID() !== get_queried_object_id() ) {
		return $block_content;
	}

	global $multipage;
	if ( empty( $multipage ) ) {
		return $block_content;
	}

	$links = wp_link_pages(
		array(
			'before' => '<nav class="post-nav-links" aria-label="' . esc_attr__( 'Page navigation', 'foa-cleaner' ) . '"><span class="post-nav-links-label">' . esc_html__( 'Pages:', 'foa-cleaner' ) . '</span>',
			'after'  => '</nav>',
			'echo'   => false,
		)
	);

	if ( '' === $links ) {
		return $block_content;
	}

	return $block_content . $links;
}
add_filter( 'render_block_core/post-content', 'foa_cleaner_append_post_link_pages', 10, 1 );
