<?php
/**
 * Title: Chronological Yearly Archive
 * Slug: foa-cleaner/yearly-archive
 * Categories: foa-cleaner-editorial
 * Keywords: archive, yearly, timeline, posts, index
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","className":"foa-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|2-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull foa-reveal" style="padding-top:var(--wp--preset--spacing--2-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Index', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'All writing by year.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="foa-yearly-archive-slot"></div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
