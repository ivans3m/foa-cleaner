<?php
/**
 * Title: Search Results (Internal)
 * Slug: foa-cleaner/hidden-search-results
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--xl)">
	<!-- wp:search {"label":<?php echo wp_json_encode( __( 'Search', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"showLabel":false,"placeholder":<?php echo wp_json_encode( __( 'Search posts and pages…', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"buttonText":<?php echo wp_json_encode( __( 'Search', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":2,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"foa-post-stream","layout":{"type":"constrained"}} -->
<div class="wp-block-query foa-post-stream">
	<!-- wp:post-template {"style":{"spacing":{"blockGap":"0px"}}} -->
		<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"constrained"}} -->
		<article class="wp-block-group">
			<!-- wp:group {"className":"foa-post-meta-row","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group foa-post-meta-row">
				<!-- wp:post-date /-->
				<!-- wp:post-terms {"term":"category","separator":" / "} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xl"} /-->
			<!-- wp:post-excerpt {"moreText":<?php echo wp_json_encode( __( 'Read more →', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"className":"foa-post-excerpt"} /-->
		</article>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"className":"foa-pagination","layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous {"label":<?php echo wp_json_encode( __( '← Previous', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next {"label":<?php echo wp_json_encode( __( 'Next →', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)">
			<!-- wp:heading {"level":2,"fontSize":"xl"} -->
			<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'No results found.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Try a different keyword or return to the homepage to browse recent writing.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|md"}}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--md)">
				<!-- wp:button {"className":"is-style-ghost"} -->
				<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'foa-cleaner' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
