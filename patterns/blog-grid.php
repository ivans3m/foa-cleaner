<?php
/**
 * Title: Latest Posts Grid
 * Slug: foa-cleaner/blog-grid
 * Categories: foa-cleaner-editorial
 * Keywords: blog, posts, articles, grid, writing
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"is-style-overline"} -->
			<p class="is-style-overline"><?php esc_html_e( 'Latest Writing', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Notes from the journal.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-ghost"} -->
			<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'All articles', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":10,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide","className":"foa-blog-grid foa-reveal-stagger"} -->
	<div class="wp-block-query alignwide foa-blog-grid foa-reveal-stagger">
		<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/10"} /-->
			<!-- wp:post-date /-->
			<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"lg","style":{"spacing":{"margin":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs"}}}} /-->
			<!-- wp:post-excerpt {"excerptLength":18,"className":"foa-post-excerpt","fontSize":"sm"} /-->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Publish your first post to populate this writing grid.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
