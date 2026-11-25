<?php
/**
 * Title: Post Loop (Internal)
 * Slug: foa-cleaner/hidden-post-loop
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:query {"queryId":1,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"foa-post-stream","layout":{"type":"constrained"}} -->
<div class="wp-block-query foa-post-stream">
	<!-- wp:post-template {"style":{"spacing":{"blockGap":"0px"}}} -->
		<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"constrained"}} -->
		<article class="wp-block-group">
			<!-- wp:group {"className":"foa-post-meta-row","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group foa-post-meta-row">
				<!-- wp:post-date {"isLink":true} /-->
				<!-- wp:post-terms {"term":"category","separator":" / "} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xl"} /-->

			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"spacing":{"margin":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|xs"}}}} /-->

			<!-- wp:post-excerpt {"moreText":<?php echo wp_json_encode( __( 'Read article →', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"className":"foa-post-excerpt"} /-->
		</article>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"className":"foa-pagination","layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous {"label":<?php echo wp_json_encode( __( '← Newer', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next {"label":<?php echo wp_json_encode( __( 'Older →', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)">
			<!-- wp:heading {"level":2,"fontSize":"xl"} -->
			<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Nothing published here yet.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Check back soon or try searching for another topic.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
