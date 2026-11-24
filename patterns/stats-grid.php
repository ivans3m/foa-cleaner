<?php
/**
 * Title: Big Stats Grid
 * Slug: foa-cleaner/stats-grid
 * Categories: foa-cleaner-sections
 * Keywords: stats, metrics, numbers, kpi
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'By the Numbers', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Engineered for speed and longevity.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:paragraph {"className":"foa-stat-number"} -->
				<p class="foa-stat-number"><?php esc_html_e( '100', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"is-style-overline"} -->
				<p class="is-style-overline"><?php esc_html_e( 'Lighthouse Performance', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Conditional vanilla scripts and self-hosted variable fonts keep payloads razor thin.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:paragraph {"className":"foa-stat-number"} -->
				<p class="foa-stat-number"><?php esc_html_e( '0 KB', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"is-style-overline"} -->
				<p class="is-style-overline"><?php esc_html_e( 'Third-Party Trackers', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'No Google Fonts CDN calls, no icon fonts, and no external JavaScript frameworks.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:paragraph {"className":"foa-stat-number"} -->
				<p class="foa-stat-number"><?php esc_html_e( '15+', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"is-style-overline"} -->
				<p class="is-style-overline"><?php esc_html_e( 'Core Block Patterns', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Every layout is built exclusively from native WordPress blocks with zero lock-in.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
