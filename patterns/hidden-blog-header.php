<?php
/**
 * Title: Blog Header (Internal)
 * Slug: foa-cleaner/hidden-blog-header
 * Inserter: no
 *
 * Uses the configured Posts Page title when available, otherwise falls back
 * to a translatable editorial heading.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foa_cleaner_posts_page_id = (int) get_option( 'page_for_posts' );
$foa_cleaner_blog_title    = $foa_cleaner_posts_page_id > 0
	? get_the_title( $foa_cleaner_posts_page_id )
	: __( 'Writing', 'foa-cleaner' );
?>
<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|2-xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--2-xl)">
	<!-- wp:paragraph {"className":"is-style-overline"} -->
	<p class="is-style-overline"><?php esc_html_e( 'Journal', 'foa-cleaner' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"fontSize":"3-xl"} -->
	<h1 class="wp-block-heading has-3-xl-font-size"><?php echo esc_html( $foa_cleaner_blog_title ); ?></h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->
