<?php
/**
 * Title: Footer (Internal)
 * Slug: foa-cleaner/hidden-footer
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foa_cleaner_year = wp_date( 'Y' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"},"margin":{"bottom":"var:preset|spacing|2-xl"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:site-title {"level":0,"style":{"typography":{"fontSize":"1.375rem","letterSpacing":"-0.03em"}}} /-->
			<!-- wp:site-tagline {"style":{"spacing":{"margin":{"top":"var:preset|spacing|xs"}}},"textColor":"contrast-secondary","fontSize":"sm"} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"29%"} -->
		<div class="wp-block-column" style="flex-basis:29%">
			<!-- wp:paragraph {"className":"is-style-overline","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|sm"}}}} -->
			<p class="is-style-overline" style="margin-bottom:var(--wp--preset--spacing--sm)"><?php esc_html_e( 'Navigation', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:navigation {"overlayMenu":"never","className":"foa-footer-nav","layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"0.5rem"}}} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"29%"} -->
		<div class="wp-block-column" style="flex-basis:29%">
			<!-- wp:paragraph {"className":"is-style-overline","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|sm"}}}} -->
			<p class="is-style-overline" style="margin-bottom:var(--wp--preset--spacing--sm)"><?php esc_html_e( 'Search', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:search {"label":<?php echo wp_json_encode( __( 'Search', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"showLabel":false,"placeholder":<?php echo wp_json_encode( __( 'Search articles…', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"buttonText":<?php echo wp_json_encode( __( 'Search', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"buttonPosition":"button-inside","buttonUseIcon":true} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"align":"wide","className":"foa-footer-bottom","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide foa-footer-bottom">
		<!-- wp:paragraph {"className":"foa-footer-meta","fontSize":"xs"} -->
		<p class="foa-footer-meta has-xs-font-size">
			<?php
			printf(
				/* translators: 1: current year, 2: site name. */
				esc_html__( '© %1$s %2$s. All rights reserved.', 'foa-cleaner' ),
				esc_html( $foa_cleaner_year ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"foa-footer-meta","fontSize":"xs"} -->
		<p class="foa-footer-meta has-xs-font-size">
			<?php
			printf(
				/* translators: %s: theme name link. */
				esc_html__( 'Built with %s', 'foa-cleaner' ),
				'<a href="https://cleaner.diuldia.com" rel="noopener">FoA Cleaner</a>'
			);
			?>
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
