<?php
/**
 * Title: Bold Display Hero
 * Slug: foa-cleaner/hero-display
 * Categories: foa-cleaner-heroes
 * Keywords: hero, display, landing, saas
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|4-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--4-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-hero-enter","style":{"spacing":{"blockGap":"var:preset|spacing|lg"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide foa-hero-enter">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Design System · WordPress Block Theme', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"className":"foa-hero-display-title","fontSize":"display"} -->
		<h1 class="wp-block-heading foa-hero-display-title has-display-font-size"><?php esc_html_e( 'Clarity scales. Clutter does not.', 'foa-cleaner' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:columns {"verticalAlignment":"bottom","style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"},"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|xl"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-bottom" style="margin-top:var(--wp--preset--spacing--xl)">
			<!-- wp:column {"verticalAlignment":"bottom","width":"58%"} -->
			<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:58%">
				<!-- wp:paragraph {"className":"is-style-lead"} -->
				<p class="is-style-lead"><?php esc_html_e( 'A quiet, typographically sharp foundation for product pages, editorial writing, and studio portfolios — engineered with zero runtime bloat.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"bottom","width":"42%"} -->
			<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:42%">
				<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"}} -->
				<div class="wp-block-buttons">
					<!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Download Free', 'foa-cleaner' ); ?></a></div>
					<!-- /wp:button -->

					<!-- wp:button {"className":"is-style-ghost"} -->
					<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Explore Patterns', 'foa-cleaner' ); ?></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
