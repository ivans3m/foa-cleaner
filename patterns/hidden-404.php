<?php
/**
 * Title: 404 Not Found (Internal)
 * Slug: foa-cleaner/hidden-404
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|4-xl","bottom":"var:preset|spacing|4-xl"},"blockGap":"var:preset|spacing|md"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--4-xl);padding-bottom:var(--wp--preset--spacing--4-xl)">
	<!-- wp:paragraph {"className":"is-style-overline"} -->
	<p class="is-style-overline"><?php esc_html_e( 'Error 404', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"fontSize":"3-xl"} -->
	<h1 class="wp-block-heading has-3-xl-font-size"><?php esc_html_e( 'This page could not be found.', 'foa-cleaner' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"is-style-lead"} -->
	<p class="is-style-lead"><?php esc_html_e( 'The address may have moved, or the link might be outdated. Search the site or head back to the homepage.', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|md"}}},"layout":{"type":"constrained","contentSize":"480px","justifyContent":"left"}} -->
	<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--md)">
		<!-- wp:search {"label":<?php echo wp_json_encode( __( 'Search', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"showLabel":false,"placeholder":<?php echo wp_json_encode( __( 'Search the site…', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>,"buttonText":<?php echo wp_json_encode( __( 'Search', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|md"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--md)">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'foa-cleaner' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
