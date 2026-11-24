<?php
/**
 * Title: Header (Internal)
 * Slug: foa-cleaner/hidden-header
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0px","right":"var:preset|spacing|md","bottom":"0px","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:0px;padding-right:var(--wp--preset--spacing--md);padding-bottom:0px;padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-header-inner","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide foa-header-inner">
		<!-- wp:group {"className":"foa-header-brand","style":{"spacing":{"blockGap":"0.625rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group foa-header-brand">
			<!-- wp:site-logo {"width":28,"shouldSyncIcon":true} /-->
			<!-- wp:site-title {"level":0} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:navigation {"overlayMenu":"mobile","icon":"menu","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"center","orientation":"horizontal"},"style":{"spacing":{"blockGap":"var:preset|spacing|lg"}}} /-->

		<!-- wp:group {"className":"foa-header-actions","style":{"spacing":{"blockGap":"0.625rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group foa-header-actions">
			<!-- wp:html -->
			<span data-foa-theme-toggle-slot></span>
			<!-- /wp:html -->

			<!-- wp:buttons {"className":"foa-header-cta","style":{"spacing":{"blockGap":"0.5rem"}}} -->
			<div class="wp-block-buttons foa-header-cta">
				<!-- wp:button {"style":{"spacing":{"padding":{"top":"0.5rem","right":"1rem","bottom":"0.5rem","left":"1rem"}}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#" style="padding-top:0.5rem;padding-right:1rem;padding-bottom:0.5rem;padding-left:1rem"><?php esc_html_e( 'Get in touch', 'foa-cleaner' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
