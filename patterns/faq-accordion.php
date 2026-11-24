<?php
/**
 * Title: FAQ Accordion
 * Slug: foa-cleaner/faq-accordion
 * Categories: foa-cleaner-sections
 * Keywords: faq, accordion, questions, details
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
	<!-- wp:columns {"align":"wide","className":"foa-reveal","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|2-xl"}}}} -->
	<div class="wp-block-columns alignwide foa-reveal">
		<!-- wp:column {"width":"34%"} -->
		<div class="wp-block-column" style="flex-basis:34%">
			<!-- wp:paragraph {"className":"is-style-overline"} -->
			<p class="is-style-overline"><?php esc_html_e( 'FAQ', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Common questions.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"contrast-secondary","fontSize":"sm"} -->
			<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Built with native HTML details blocks so every answer is accessible without extra JavaScript.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"66%","className":"foa-reveal-stagger"} -->
		<div class="wp-block-column foa-reveal-stagger" style="flex-basis:66%">
			<!-- wp:details {"className":"is-style-clean-accordion"} -->
			<details class="wp-block-details is-style-clean-accordion"><summary><?php esc_html_e( 'Does FoA Cleaner require any third-party plugins?', 'foa-cleaner' ); ?></summary><!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'No. Every template, pattern, dark-mode control, and editorial feature works completely standalone on WordPress 6.6+. Optional Vibetiles integration activates automatically if you install the plugin.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph --></details>
			<!-- /wp:details -->

			<!-- wp:details {"className":"is-style-clean-accordion"} -->
			<details class="wp-block-details is-style-clean-accordion"><summary><?php esc_html_e( 'Are the bundled fonts self-hosted and GDPR friendly?', 'foa-cleaner' ); ?></summary><!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Yes. Geist, DM Sans, and Geist Mono are served directly from the theme folder as SIL OFL 1.1 variable .woff2 files with zero external CDN requests.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph --></details>
			<!-- /wp:details -->

			<!-- wp:details {"className":"is-style-clean-accordion"} -->
			<details class="wp-block-details is-style-clean-accordion"><summary><?php esc_html_e( 'Can I turn off scroll-reveal animations?', 'foa-cleaner' ); ?></summary><!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Yes. Toggle micro-animations off anytime under Appearance → FoA Cleaner, or via the foa_cleaner_enable_motion PHP filter. Visitors with OS reduced-motion enabled always get static rendering automatically.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph --></details>
			<!-- /wp:details -->

			<!-- wp:details {"className":"is-style-clean-accordion"} -->
			<details class="wp-block-details is-style-clean-accordion"><summary><?php esc_html_e( 'What happens to my content if I switch themes later?', 'foa-cleaner' ); ?></summary><!-- wp:paragraph {"textColor":"contrast-secondary"} -->
			<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Every pattern uses standard WordPress core blocks with zero custom theme-locked blocks or shortcodes, so your pages remain intact wherever you move.', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph --></details>
			<!-- /wp:details -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
