<?php
/**
 * Title: Single Post Navigation (Internal)
 * Slug: foa-cleaner/hidden-post-navigation
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"tagName":"nav","className":"foa-post-nav","style":{"spacing":{"margin":{"top":"var:preset|spacing|2-xl"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<nav class="wp-block-group foa-post-nav" style="margin-top:var(--wp--preset--spacing--2-xl)">
	<!-- wp:post-navigation-link {"type":"previous","showTitle":true,"linkLabel":true,"label":<?php echo wp_json_encode( __( '← Previous', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
	<!-- wp:post-navigation-link {"textAlign":"right","showTitle":true,"linkLabel":true,"label":<?php echo wp_json_encode( __( 'Next →', 'foa-cleaner' ), JSON_UNESCAPED_UNICODE ); ?>} /-->
</nav>
<!-- /wp:group -->
