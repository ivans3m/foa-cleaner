<?php
/**
 * Title: Dark Closing CTA
 * Slug: foa-cleaner/cta-dark
 * Categories: foa-cleaner-cta
 * Keywords: cta, call to action, dark, closing
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","className":"is-style-dark-band foa-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|4-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|4-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-dark-band foa-reveal" style="padding-top:var(--wp--preset--spacing--4-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--4-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"constrained","contentSize":"46rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Ready When You Are', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"fontSize":"3-xl"} -->
		<h2 class="wp-block-heading has-3-xl-font-size"><?php esc_html_e( 'Publish cleaner pages without the overhead.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"lg","style":{"color":{"text":"#A8A49F"}}} -->
		<p class="has-text-color has-lg-font-size" style="color:#A8A49F"><?php esc_html_e( 'Install FoA Cleaner in under a minute. Free, open-source GPLv2+, and built for WordPress Site Editor.', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|md"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--md)">
			<!-- wp:button {"className":"is-style-light"} -->
			<div class="wp-block-button is-style-light"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Download FoA Cleaner', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-ghost"} -->
			<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'View on GitHub', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
