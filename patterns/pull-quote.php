<?php
/**
 * Title: Editorial Pull Quote
 * Slug: foa-cleaner/pull-quote
 * Categories: foa-cleaner-social-proof
 * Keywords: quote, pullquote, editorial, statement
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","backgroundColor":"surface","className":"foa-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background foa-reveal" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:pullquote {"textAlign":"left","align":"wide"} -->
	<figure class="wp-block-pullquote alignwide has-text-align-left"><blockquote><p><?php esc_html_e( 'Good typography is invisible until you remove the noise around it — then the writing carries the entire page.', 'foa-cleaner' ); ?></p><cite><?php esc_html_e( 'Elena Kovacs, Principal Designer at Northwind', 'foa-cleaner' ); ?></cite></blockquote></figure>
	<!-- /wp:pullquote -->
</div>
<!-- /wp:group -->
