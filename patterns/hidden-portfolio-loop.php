<?php
/**
 * Title: Portfolio Archive Loop (Internal)
 * Slug: foa-cleaner/hidden-portfolio-loop
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:query {"queryId":2,"query":{"perPage":12,"pages":0,"offset":0,"postType":"jetpack-portfolio","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","className":"foa-portfolio-query-grid","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide foa-portfolio-query-grid">
	<!-- wp:post-template {"layout":{"type":"grid","columnCount":2}} -->
		<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/10"} /-->

		<!-- wp:group {"className":"foa-portfolio-meta","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
		<div class="wp-block-group foa-portfolio-meta">
			<!-- wp:post-terms {"term":"jetpack-portfolio-type","separator":" · "} /-->
			<!-- wp:post-date {"format":"Y"} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xl"} /-->

		<!-- wp:post-excerpt {"excerptLength":24,"fontSize":"sm","textColor":"contrast-secondary"} /-->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"className":"foa-pagination","style":{"spacing":{"margin":{"top":"var:preset|spacing|2-xl"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous {"label":<?php echo wp_json_encode( __( '← Newer Projects', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next {"label":<?php echo wp_json_encode( __( 'Older Projects →', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
		<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)">
			<!-- wp:heading {"level":2,"fontSize":"xl"} -->
			<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'No portfolio projects published yet.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Publish your first project to populate this showcase grid automatically.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
