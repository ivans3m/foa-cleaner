<?php
/**
 * Title: Three-Tier Pricing Table
 * Slug: foa-cleaner/pricing
 * Categories: foa-cleaner-sections
 * Keywords: pricing, plans, tiers, saas
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
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Pricing', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Simple, transparent plans.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card foa-pricing-card","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card foa-pricing-card">
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"className":"is-style-overline"} -->
					<p class="is-style-overline"><?php esc_html_e( 'Starter', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"className":"foa-pricing-amount"} -->
					<p class="foa-pricing-amount"><?php esc_html_e( '$0', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
					<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'For personal blogs, journals, and open-source documentation.', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:list {"className":"is-style-checklist","fontSize":"sm"} -->
				<ul class="wp-block-list is-style-checklist has-sm-font-size">
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'All 10 core templates & 15 patterns', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Built-in light & dark switcher', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Self-hosted Geist & DM Sans fonts', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
				</ul>
				<!-- /wp:list -->

				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"width":100,"className":"is-style-ghost"} -->
					<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Choose Starter', 'foa-cleaner' ); ?></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card-elevated foa-pricing-card foa-pricing-featured","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card-elevated foa-pricing-card foa-pricing-featured">
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">
					<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","verticalAlignment":"center","flexWrap":"wrap"}} -->
					<div class="wp-block-group">
						<!-- wp:paragraph {"className":"is-style-overline"} -->
						<p class="is-style-overline"><?php esc_html_e( 'Studio', 'foa-cleaner' ); ?></p>
						<!-- /wp:paragraph -->
						<!-- wp:paragraph {"className":"is-style-pill foa-pricing-badge"} -->
						<p class="is-style-pill foa-pricing-badge"><?php esc_html_e( 'Most Popular', 'foa-cleaner' ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
					<!-- wp:paragraph {"className":"foa-pricing-amount"} -->
					<p class="foa-pricing-amount"><?php esc_html_e( '$49', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
					<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'For growing SaaS teams and independent product studios.', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:list {"className":"is-style-checklist","fontSize":"sm"} -->
				<ul class="wp-block-list is-style-checklist has-sm-font-size">
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Everything in Starter', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Curated Global Style Variations', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Priority setup & migration guidance', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
				</ul>
				<!-- /wp:list -->

				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"width":100,"className":"is-style-accent"} -->
					<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-accent"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Choose Studio', 'foa-cleaner' ); ?></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card foa-pricing-card","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card foa-pricing-card">
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"className":"is-style-overline"} -->
					<p class="is-style-overline"><?php esc_html_e( 'Enterprise', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"className":"foa-pricing-amount"} -->
					<p class="foa-pricing-amount"><?php esc_html_e( 'Custom', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
					<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'For multi-brand publishing networks and bespoke design systems.', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:list {"className":"is-style-checklist","fontSize":"sm"} -->
				<ul class="wp-block-list is-style-checklist has-sm-font-size">
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Unlimited multisite deployments', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Custom pattern library workshops', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
					<!-- wp:list-item -->
					<li><?php esc_html_e( 'Dedicated performance & WCAG audits', 'foa-cleaner' ); ?></li>
					<!-- /wp:list-item -->
				</ul>
				<!-- /wp:list -->

				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"width":100,"className":"is-style-ghost"} -->
					<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Contact sales', 'foa-cleaner' ); ?></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
