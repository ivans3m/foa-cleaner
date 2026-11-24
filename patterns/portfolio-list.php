<?php
/**
 * Title: Portfolio Index List
 * Slug: foa-cleaner/portfolio-list
 * Categories: foa-cleaner-portfolio
 * Keywords: portfolio, index, list, archive, work, projects
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
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Work Index', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'Complete project archive.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"foa-reveal-stagger","style":{"spacing":{"blockGap":"0px"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide foa-reveal-stagger">
		<!-- wp:columns {"verticalAlignment":"center","className":"foa-portfolio-index-row","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xs","left":"var:preset|spacing|md"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-center foa-portfolio-index-row">
			<!-- wp:column {"verticalAlignment":"center","width":"12%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:12%">
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '2026', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%">
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><a href="#"><?php esc_html_e( 'Northwind Analytics Platform', 'foa-cleaner' ); ?></a></h3>
				<!-- /wp:heading -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"34%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:34%">
				<!-- wp:paragraph {"fontSize":"sm","textColor":"contrast-secondary"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Design Systems · Product UI', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"10%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:10%">
				<!-- wp:paragraph {"align":"right","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-text-align-right has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><a href="#"><?php esc_html_e( 'View →', 'foa-cleaner' ); ?></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->

		<!-- wp:columns {"verticalAlignment":"center","className":"foa-portfolio-index-row","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xs","left":"var:preset|spacing|md"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-center foa-portfolio-index-row">
			<!-- wp:column {"verticalAlignment":"center","width":"12%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:12%">
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '2026', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%">
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><a href="#"><?php esc_html_e( 'Monograph Publishing House', 'foa-cleaner' ); ?></a></h3>
				<!-- /wp:heading -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"34%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:34%">
				<!-- wp:paragraph {"fontSize":"sm","textColor":"contrast-secondary"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Editorial · WordPress Architecture', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"10%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:10%">
				<!-- wp:paragraph {"align":"right","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-text-align-right has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><a href="#"><?php esc_html_e( 'View →', 'foa-cleaner' ); ?></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->

		<!-- wp:columns {"verticalAlignment":"center","className":"foa-portfolio-index-row","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xs","left":"var:preset|spacing|md"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-center foa-portfolio-index-row">
			<!-- wp:column {"verticalAlignment":"center","width":"12%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:12%">
				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><?php esc_html_e( '2025', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%">
				<!-- wp:heading {"level":3,"fontSize":"lg"} -->
				<h3 class="wp-block-heading has-lg-font-size"><a href="#"><?php esc_html_e( 'Helios Telemetry CLI', 'foa-cleaner' ); ?></a></h3>
				<!-- /wp:heading -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"34%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:34%">
				<!-- wp:paragraph {"fontSize":"sm","textColor":"contrast-secondary"} -->
				<p class="has-contrast-secondary-color has-text-color has-sm-font-size"><?php esc_html_e( 'Developer Tools · Brand Identity', 'foa-cleaner' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"10%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:10%">
				<!-- wp:paragraph {"align":"right","fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} -->
				<p class="has-text-align-right has-contrast-muted-color has-text-color has-mono-font-family has-xs-font-size"><a href="#"><?php esc_html_e( 'View →', 'foa-cleaner' ); ?></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
