<?php
/**
 * Title: Portfolio Editorial Gallery
 * Slug: foa-cleaner/portfolio-gallery-masonry
 * Categories: foa-cleaner-portfolio, gallery
 * Keywords: portfolio, gallery, masonry, visual, photography, lookbook, studio
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"is-style-overline"} -->
			<p class="is-style-overline"><?php esc_html_e( 'Visual Gallery', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Editorial work & studies.', 'foa-cleaner' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-ghost"} -->
			<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Explore archive', 'foa-cleaner' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"foa-gallery-row foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|lg"},"margin":{"bottom":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns alignwide foa-gallery-row foa-reveal-stagger" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:column {"width":"62%"} -->
		<div class="wp-block-column" style="flex-basis:62%">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-wide","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-wide">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '16:10 Feature Frame', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"base","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-base-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Kestrel Architectural Pavilion', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '01 · Architecture · 2026', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"38%"} -->
		<div class="wp-block-column" style="flex-basis:38%">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-portrait">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '4:5 Portrait Frame', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"base","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-base-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Atelier Solis Print Series', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '02 · Editorial · 2026', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"align":"wide","className":"foa-gallery-row foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns alignwide foa-gallery-row foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-gallery-tile","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-gallery-tile">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '4:3 Gallery Frame', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"base","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-base-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Vespera Brand System', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '03 · Identity', 'foa-cleaner' ); ?></p>
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
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '4:3 Gallery Frame', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"base","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-base-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Meridian Audio Interface', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '04 · Product UI', 'foa-cleaner' ); ?></p>
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
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( '4:3 Gallery Frame', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"foa-gallery-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
				<div class="wp-block-group foa-gallery-caption">
					<!-- wp:paragraph {"fontFamily":"display","fontSize":"base","style":{"typography":{"fontWeight":"500"}}} -->
					<p class="has-display-font-family has-base-font-size" style="font-weight:500"><a href="#"><?php esc_html_e( 'Nordic Ceramic Archive', 'foa-cleaner' ); ?></a></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
					<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '05 · Photography', 'foa-cleaner' ); ?></p>
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
