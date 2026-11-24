<?php
/**
 * Title: Portfolio Query Grid (Dynamic)
 * Slug: foa-cleaner/portfolio-query-grid
 * Categories: foa-cleaner-portfolio
 * Keywords: portfolio, projects, query, jetpack, case studies, grid
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foa_portfolio_cpt = post_type_exists( 'jetpack-portfolio' ) ? 'jetpack-portfolio' : 'post';
$foa_portfolio_tax = 'jetpack-portfolio' === $foa_portfolio_cpt ? 'jetpack-portfolio-type' : 'category';
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"is-style-overline"} -->
			<p class="is-style-overline"><?php esc_html_e( 'Portfolio', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Selected projects.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-ghost"} -->
			<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'All projects', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":3,"query":{"perPage":6,"pages":0,"offset":0,"postType":<?php echo wp_json_encode( $foa_portfolio_cpt ); ?>,"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","className":"foa-portfolio-query-grid foa-reveal-stagger","layout":{"type":"default"}} -->
	<div class="wp-block-query alignwide foa-portfolio-query-grid foa-reveal-stagger">
		<!-- wp:post-template {"layout":{"type":"grid","columnCount":2}} -->
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/10"} /-->

			<!-- wp:group {"className":"foa-portfolio-meta","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
			<div class="wp-block-group foa-portfolio-meta">
				<!-- wp:post-terms {"term":<?php echo wp_json_encode( $foa_portfolio_tax ); ?>,"separator":" · "} /-->
				<!-- wp:post-date {"format":"Y"} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"xl"} /-->

			<!-- wp:post-excerpt {"excerptLength":22,"fontSize":"sm","textColor":"contrast-secondary"} /-->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'No projects found yet. Adjust the Query Loop post type or publish a project to display items here.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
