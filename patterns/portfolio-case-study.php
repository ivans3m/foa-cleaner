<?php
/**
 * Title: Case Study Layout
 * Slug: foa-cleaner/portfolio-case-study
 * Categories: foa-cleaner-portfolio
 * Keywords: portfolio, case study, project, showcase, overview
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"wide","className":"foa-case-study-meta-grid foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide foa-case-study-meta-grid foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|md","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Client', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Northwind Labs', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Role', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Lead Product & Systems', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Timeline', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Q1 – Q2 2026', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Deliverables', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Tokens · UI · Docs', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"},"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|2-xl"}}}} -->
<div class="wp-block-columns alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( '01 · Context & Problem', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Unifying three fragmented product surfaces.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
		<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Marketing pages, telemetry dashboards, and developer documentation had drifted into separate stylesheets, slowing releases and creating inconsistent reading hierarchy across devices.', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( '02 · Approach', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'One restrained token system, zero lock-in.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
		<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'We audited every typography role and surface contrast ratio, consolidated into a single semantic palette, and shipped reusable editorial patterns built strictly on native primitives.', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:group {"align":"wide","className":"foa-portfolio-media foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"}}},"layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide foa-portfolio-media foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
	<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Replace with wide project visual or gallery', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"is-style-card foa-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","right":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide is-style-card foa-reveal" style="padding-top:var(--wp--preset--spacing--xl);padding-right:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl);padding-left:var(--wp--preset--spacing--xl)">
	<!-- wp:paragraph {"className":"is-style-overline"} -->
	<p class="is-style-overline"><?php esc_html_e( '03 · Outcomes', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|md"},"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--md)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-stat-number"} -->
			<p class="foa-stat-number"><?php esc_html_e( '−62%', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"fontSize":"sm","textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'CSS payload reduction after token consolidation', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-stat-number"} -->
			<p class="foa-stat-number"><?php esc_html_e( '100', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"fontSize":"sm","textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Lighthouse Performance & Accessibility score', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-stat-number"} -->
			<p class="foa-stat-number"><?php esc_html_e( '3×', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"fontSize":"sm","textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Faster page authoring using core block patterns', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
