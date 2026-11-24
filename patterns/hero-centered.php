<?php
/**
 * Title: Centered SaaS Hero
 * Slug: foa-cleaner/hero-centered
 * Categories: foa-cleaner-heroes
 * Keywords: hero, centered, saas, product
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
	<!-- wp:group {"align":"wide","className":"foa-hero-centered-inner foa-hero-enter","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
	<div class="wp-block-group alignwide foa-hero-centered-inner foa-hero-enter">
		<!-- wp:paragraph {"align":"center","className":"is-style-pill"} -->
		<p class="has-text-align-center is-style-pill"><?php esc_html_e( 'Version 1.0 · WordPress 6.6+ Block Theme', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"3-xl"} -->
		<h1 class="wp-block-heading has-text-align-center has-3-xl-font-size"><?php esc_html_e( 'Software crafted for teams that read between the lines.', 'foa-cleaner' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"is-style-lead"} -->
		<p class="has-text-align-center is-style-lead"><?php esc_html_e( 'Replace bloated page builders with a restrained system of core block patterns, self-hosted variable fonts, and instant light and dark modes.', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|sm"}}},"layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--sm)">
			<!-- wp:button {"className":"is-style-accent"} -->
			<div class="wp-block-button is-style-accent"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Start building', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-ghost"} -->
			<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Read documentation', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

		<!-- wp:group {"className":"foa-hero-proof","style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|lg"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
		<div class="wp-block-group foa-hero-proof" style="margin-top:var(--wp--preset--spacing--xl)">
			<!-- wp:paragraph {"fontSize":"xs","fontFamily":"mono","textColor":"contrast-muted"} -->
			<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '100% Core Blocks', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"fontSize":"xs","fontFamily":"mono","textColor":"contrast-muted"} -->
			<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Self-Hosted OFL Fonts', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"fontSize":"xs","fontFamily":"mono","textColor":"contrast-muted"} -->
			<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Zero External Requests', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
