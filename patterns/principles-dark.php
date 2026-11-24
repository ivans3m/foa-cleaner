<?php
/**
 * Title: Dark Principles Band
 * Slug: foa-cleaner/principles-dark
 * Categories: foa-cleaner-sections
 * Keywords: principles, steps, dark, numbered
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","className":"is-style-dark-band","style":{"spacing":{"padding":{"top":"var:preset|spacing|4-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|4-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-dark-band" style="padding-top:var(--wp--preset--spacing--4-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--4-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Design Principles', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Three rules that hold the layout together.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-dark-card","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group foa-dark-card">
				<!-- wp:paragraph {"className":"foa-step-index"} -->
				<p class="foa-step-index"><?php esc_html_e( '01', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":3,"fontSize":"xl"} -->
				<h3 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Whitespace is structural', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"fontSize":"sm","style":{"color":{"text":"#A8A49F"}}} -->
				<p class="has-text-color has-sm-font-size" style="color:#A8A49F"><?php esc_html_e( 'Generous vertical rhythm and calm margins replace heavy borders, gradients, and decorative boxes.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-dark-card","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group foa-dark-card">
				<!-- wp:paragraph {"className":"foa-step-index"} -->
				<p class="foa-step-index"><?php esc_html_e( '02', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":3,"fontSize":"xl"} -->
				<h3 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Type does the heavy lifting', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"fontSize":"sm","style":{"color":{"text":"#A8A49F"}}} -->
				<p class="has-text-color has-sm-font-size" style="color:#A8A49F"><?php esc_html_e( 'Crisp scale contrast between Geist headings, DM Sans prose, and Geist Mono labels establishes clear hierarchy.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-dark-card","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group foa-dark-card">
				<!-- wp:paragraph {"className":"foa-step-index"} -->
				<p class="foa-step-index"><?php esc_html_e( '03', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":3,"fontSize":"xl"} -->
				<h3 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Content stays portable', 'foa-cleaner' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"fontSize":"sm","style":{"color":{"text":"#A8A49F"}}} -->
				<p class="has-text-color has-sm-font-size" style="color:#A8A49F"><?php esc_html_e( 'Pure WordPress core blocks guarantee your pages remain clean, fast, and intact across future updates.', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
