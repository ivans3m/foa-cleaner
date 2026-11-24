<?php
/**
 * Title: Front Page Content (Internal)
 * Slug: foa-cleaner/hidden-front-page
 * Inserter: no
 *
 * Dynamically adapts to WordPress's Reading Settings:
 * - Static Front Page: renders full-bleed post content for SaaS/portfolio canvases.
 * - Latest Posts: renders a clean editorial intro and post stream.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) > 0 ) :
	?>
<!-- wp:post-content {"align":"full","layout":{"type":"constrained"}} /-->
<?php else : ?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","bottom":"var:preset|spacing|3-xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--3-xl);padding-bottom:var(--wp--preset--spacing--3-xl)">
	<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"},"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Journal', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:site-title {"level":1,"isLink":false,"fontSize":"3-xl"} /-->
		<!-- wp:site-tagline {"className":"is-style-lead"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"foa-cleaner/hidden-post-loop"} /-->
</div>
<!-- /wp:group -->
<?php endif; ?>
