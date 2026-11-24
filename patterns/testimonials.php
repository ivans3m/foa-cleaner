<?php
/**
 * Title: Testimonials Grid
 * Slug: foa-cleaner/testimonials
 * Categories: foa-cleaner-social-proof
 * Keywords: testimonials, reviews, social proof, quotes
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
		<p class="is-style-overline"><?php esc_html_e( 'Testimonials', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Trusted by studios and writers.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:paragraph {"className":"foa-testimonial-quote"} -->
				<p class="foa-testimonial-quote"><?php esc_html_e( '“We migrated our entire product site off a heavy page builder in an afternoon. Lighthouse jumped to 100 and our editorial team loves the Site Editor.”', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"className":"foa-testimonial-author","style":{"spacing":{"blockGap":"0.125rem"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group foa-testimonial-author">
					<!-- wp:paragraph {"fontSize":"sm","style":{"typography":{"fontWeight":"600"}}} -->
					<p class="has-sm-font-size" style="font-weight:600"><?php esc_html_e( 'Marek Nowak', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'CTO · Relay Systems', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:paragraph {"className":"foa-testimonial-quote"} -->
				<p class="foa-testimonial-quote"><?php esc_html_e( '“Finally a WordPress theme that treats long-form reading and SaaS landing pages with the same level of typographic restraint.”', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"className":"foa-testimonial-author","style":{"spacing":{"blockGap":"0.125rem"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group foa-testimonial-author">
					<!-- wp:paragraph {"fontSize":"sm","style":{"typography":{"fontWeight":"600"}}} -->
					<p class="has-sm-font-size" style="font-weight:600"><?php esc_html_e( 'Hannah Lindqvist', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Independent Writer', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-card">
				<!-- wp:paragraph {"className":"foa-testimonial-quote"} -->
				<p class="foa-testimonial-quote"><?php esc_html_e( '“The dark mode is cohesive, the yearly archive is effortless, and pairing it with Vibetiles made client approvals ten times faster.”', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"className":"foa-testimonial-author","style":{"spacing":{"blockGap":"0.125rem"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group foa-testimonial-author">
					<!-- wp:paragraph {"fontSize":"sm","style":{"typography":{"fontWeight":"600"}}} -->
					<p class="has-sm-font-size" style="font-weight:600"><?php esc_html_e( 'David Chen', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Founder · Studio Kestrel', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
