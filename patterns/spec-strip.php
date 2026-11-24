<?php
/**
 * Title: Spec & Metadata Strip
 * Slug: foa-cleaner/spec-strip
 * Categories: foa-cleaner-sections
 * Keywords: specs, metadata, strip, grid
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","className":"foa-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|md","right":"var:preset|spacing|md","bottom":"var:preset|spacing|xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull foa-reveal" style="padding-top:var(--wp--preset--spacing--md);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:columns {"align":"wide","className":"is-style-hairline-grid"} -->
	<div class="wp-block-columns alignwide is-style-hairline-grid">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Architecture', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'theme.json v3', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Typography', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Geist & DM Sans', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Color Modes', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Light & Dark Native', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Dependencies', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Zero Frameworks', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
