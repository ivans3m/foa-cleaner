<?php
/**
 * Title: Portfolio & Case Study Grid
 * Slug: foa-cleaner/portfolio-grid
 * Categories: foa-cleaner-portfolio
 * Keywords: portfolio, work, case studies, projects
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
			<p class="is-style-overline"><?php esc_html_e( 'Selected Work', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Recent projects & systems.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-ghost"} -->
			<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'View all work', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|2-xl","left":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-portfolio-card","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-portfolio-card">
				<!-- wp:group {"className":"foa-portfolio-media","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-portfolio-media">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '16:10 Project Preview', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Product Design · Systems', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '2026', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:heading {"level":3,"fontSize":"xl"} -->
				<h3 class="wp-block-heading has-xl-font-size"><a href="#"><?php esc_html_e( 'Northwind Analytics Platform', 'foa-cleaner' ); ?></a></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Unified design tokens and documentation architecture across web, marketing, and telemetry dashboards.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-portfolio-card","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-portfolio-card">
				<!-- wp:group {"className":"foa-portfolio-media","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-portfolio-media">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '16:10 Project Preview', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Editorial · WordPress', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '2026', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:heading {"level":3,"fontSize":"xl"} -->
				<h3 class="wp-block-heading has-xl-font-size"><a href="#"><?php esc_html_e( 'Monograph Publishing House', 'foa-cleaner' ); ?></a></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'A distraction-free long-form journal with chronological archives, Focus Mode, and zero third-party scripts.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
