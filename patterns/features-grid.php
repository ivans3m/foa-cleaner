<?php
/**
 * Title: Feature Cards Grid
 * Slug: foa-cleaner/features-grid
 * Categories: foa-cleaner-sections
 * Keywords: features, cards, grid, benefits
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
		<p class="is-style-overline"><?php esc_html_e( 'Capabilities', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Everything essential, nothing extraneous.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:html -->
				<div class="foa-feature-icon-wrap"><span data-foa-icon="layers"></span></div>
				<!-- /wp:html -->
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Full Site Editing', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Edit headers, footers, templates, and typography visually without touching PHP.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:html -->
				<div class="foa-feature-icon-wrap"><span data-foa-icon="sun-moon"></span></div>
				<!-- /wp:html -->
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Built-In Dark Mode', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Flash-free light and dark switching out of the box, with graceful Vibetiles handoff.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:html -->
				<div class="foa-feature-icon-wrap"><span data-foa-icon="zap"></span></div>
				<!-- /wp:html -->
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Conditional Assets', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Copy-code, Focus Mode, and motion scripts load only where they are actually used.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"},"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger" style="margin-top:var(--wp--preset--spacing--lg)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:html -->
				<div class="foa-feature-icon-wrap"><span data-foa-icon="book-open"></span></div>
				<!-- /wp:html -->
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Editorial Focus Mode', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Readers can step chrome back with one click while tracking progress via a 1px top bar.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:html -->
				<div class="foa-feature-icon-wrap"><span data-foa-icon="sliders-horizontal"></span></div>
				<!-- /wp:html -->
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Vibetiles Harmony', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Concrete hex tokens and standard landmarks let Vibetiles dial colors and fonts seamlessly.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:html -->
				<div class="foa-feature-icon-wrap"><span data-foa-icon="shield-check"></span></div>
				<!-- /wp:html -->
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Accessible by Default', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Semantic landmarks, crisp focus rings, keyboard flows, and reduced-motion safeguards.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
