<?php
/**
 * Title: Portfolio Full-Bleed Showcase Strip
 * Slug: foa-cleaner/portfolio-gallery-strip
 * Categories: foa-cleaner-portfolio, gallery
 * Keywords: portfolio, gallery, full-bleed, strip, showcase, exhibition, visual
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","backgroundColor":"surface","className":"foa-gallery-strip-band","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull foa-gallery-strip-band has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"is-style-overline"} -->
			<p class="is-style-overline"><?php esc_html_e( 'Visual Showcase', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Selected frames & artifacts.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
		<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '04 Featured Plates · 2025–2026', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"full","className":"foa-gallery-strip foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|sm"}}}} -->
	<div class="wp-block-columns alignfull foa-gallery-strip foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait is-surface-base","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-portrait is-surface-base">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 01 · 4:5', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"sm","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-sm-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Forma Type Specimen', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Typography', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait is-surface-base","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-portrait is-surface-base">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 02 · 4:5', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"sm","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-sm-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Kuro Hardware Packaging', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Industrial', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait is-surface-base","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-portrait is-surface-base">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 03 · 4:5', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"sm","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-sm-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Lumen Exhibition Catalog', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Print', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait is-surface-base","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-portrait is-surface-base">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 04 · 4:5', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"sm","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-sm-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Sora Spatial Interface', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Digital', 'foa-cleaner' ); ?></p>
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
