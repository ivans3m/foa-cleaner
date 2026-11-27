<?php
/**
 * Title: Portfolio Image Series (Photo Essay)
 * Slug: foa-cleaner/portfolio-image-series
 * Categories: foa-cleaner-portfolio, gallery
 * Keywords: portfolio, photo essay, image series, photography, filmstrip, diptych, lightbox, plates
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"wide","className":"foa-case-study-meta-grid foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide foa-case-study-meta-grid foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|md","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Series', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Northern Light Studies', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Location', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Reykjavik & Vik', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Format', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( 'Medium Format · 50mm', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"foa-spec-key"} -->
			<p class="foa-spec-key"><?php esc_html_e( 'Sequence', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"foa-spec-value"} -->
			<p class="foa-spec-value"><?php esc_html_e( '07 Plates · 2026', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"},"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"default"}} -->
<div class="wp-block-group foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:paragraph {"className":"is-style-overline"} -->
	<p class="is-style-overline"><?php esc_html_e( '01 · Sequence Notes', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"textColor":"contrast-secondary"} -->
	<p class="has-contrast-secondary-color has-text-color"><?php esc_html_e( 'Photographed over four winter mornings along the southern basalt coast. Each plate is sequenced from first light to overcast noon to preserve the tonal shift between sea mist, volcanic stone, and wet timber. Replace any frame below with a native Image block and enable Expand on click for built-in lightbox viewing.', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"foa-series-plate foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide foa-series-plate foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:group {"className":"foa-gallery-frame is-aspect-wide","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
	<div class="wp-block-group foa-gallery-frame is-aspect-wide">
		<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
		<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 01 · 16:10 Lead Image (Enable Lightbox)', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
	<!-- wp:group {"className":"foa-series-plate-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group foa-series-plate-caption">
		<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
		<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '01 / 07 · Basalt Sea Stack, First Light', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
		<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '50mm · f/4 · 1/125s · ISO 200', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"foa-series-diptych foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|lg"},"margin":{"bottom":"var:preset|spacing|2-xl"}}}} -->
<div class="wp-block-columns alignwide foa-series-diptych foa-reveal-stagger" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:group {"className":"foa-series-plate","layout":{"type":"default"}} -->
		<div class="wp-block-group foa-series-plate">
			<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
			<div class="wp-block-group foa-gallery-frame is-aspect-portrait">
				<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
				<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 02 · 4:5 Diptych Left', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:group {"className":"foa-series-plate-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
			<div class="wp-block-group foa-series-plate-caption">
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '02 / 07 · Harbor Wall Study', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '50mm · f/2.8', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:group {"className":"foa-series-plate","layout":{"type":"default"}} -->
		<div class="wp-block-group foa-series-plate">
			<!-- wp:group {"className":"foa-gallery-frame is-aspect-portrait","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
			<div class="wp-block-group foa-gallery-frame is-aspect-portrait">
				<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
				<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Plate 03 · 4:5 Diptych Right', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:group {"className":"foa-series-plate-caption","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
			<div class="wp-block-group foa-series-plate-caption">
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '03 / 07 · Driftwood & Salt Frost', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '80mm · f/4', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:group {"align":"wide","className":"foa-series-filmstrip-section foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide foa-series-filmstrip-section foa-reveal" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:group {"className":"foa-series-filmstrip-header","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|md"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap","verticalAlignment":"baseline"}} -->
	<div class="wp-block-group foa-series-filmstrip-header" style="margin-bottom:var(--wp--preset--spacing--md)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( '02 · Contact Filmstrip', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
		<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Frames 04–07 · Chronological Progression', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"foa-series-filmstrip foa-reveal-stagger","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|md","left":"var:preset|spacing|sm"}}}} -->
	<div class="wp-block-columns foa-series-filmstrip foa-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-series-plate","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-series-plate">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Frame 04 · 4:3', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:paragraph {"className":"foa-series-frame-index","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="foa-series-frame-index has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '04 · Tide Line', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-series-plate","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-series-plate">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Frame 05 · 4:3', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:paragraph {"className":"foa-series-frame-index","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="foa-series-frame-index has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '05 · Fog Bank', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-series-plate","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-series-plate">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Frame 06 · 4:3', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:paragraph {"className":"foa-series-frame-index","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="foa-series-frame-index has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '06 · Boat Shed', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"foa-series-plate","layout":{"type":"default"}} -->
			<div class="wp-block-group foa-series-plate">
				<!-- wp:group {"className":"foa-gallery-frame is-aspect-classic","layout":{"type":"flex","justifyContent":"center","verticalAlignment":"center"}} -->
				<div class="wp-block-group foa-gallery-frame is-aspect-classic">
					<!-- wp:paragraph {"className":"foa-portfolio-placeholder"} -->
					<p class="foa-portfolio-placeholder"><?php esc_html_e( 'Frame 07 · 4:3', 'foa-cleaner' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:paragraph {"className":"foa-series-frame-index","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="foa-series-frame-index has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '07 · Horizon Break', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"is-style-hairline-top foa-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide is-style-hairline-top foa-reveal" style="padding-top:var(--wp--preset--spacing--lg)">
	<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
	<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Photography & Sequencing · Archival Pigment Prints Available', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
	<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( 'Edition of 15 · Signed & Numbered', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
