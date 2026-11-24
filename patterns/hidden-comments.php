<?php
/**
 * Title: Comments Section (Internal)
 * Slug: foa-cleaner/hidden-comments
 * Inserter: no
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"className":"foa-comments-section","style":{"spacing":{"margin":{"top":"var:preset|spacing|2-xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group foa-comments-section" style="margin-top:var(--wp--preset--spacing--2-xl)">
	<!-- wp:comments -->
	<div class="wp-block-comments">
		<!-- wp:comments-title {"level":2,"showPostTitle":false,"fontSize":"xl"} /-->

		<!-- wp:comment-template -->
			<!-- wp:group {"className":"foa-comment-item","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group foa-comment-item">
				<!-- wp:avatar {"size":40,"style":{"border":{"radius":"9999px"}}} /-->

				<!-- wp:group {"style":{"spacing":{"blockGap":"0.375rem"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"baseline"}} -->
					<div class="wp-block-group">
						<!-- wp:comment-author-name {"style":{"typography":{"fontWeight":"600"}},"fontSize":"sm"} /-->
						<!-- wp:comment-date {"fontFamily":"mono","fontSize":"xs","textColor":"contrast-muted"} /-->
						<!-- wp:comment-edit-link {"fontSize":"xs"} /-->
					</div>
					<!-- /wp:group -->

					<!-- wp:comment-content /-->
					<!-- wp:comment-reply-link {"fontSize":"xs"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:comment-template -->

		<!-- wp:comments-pagination {"className":"foa-pagination","layout":{"type":"flex","justifyContent":"space-between"}} -->
			<!-- wp:comments-pagination-previous /-->
			<!-- wp:comments-pagination-numbers /-->
			<!-- wp:comments-pagination-next /-->
		<!-- /wp:comments-pagination -->

		<!-- wp:post-comments-form /-->
	</div>
	<!-- /wp:comments -->
</div>
<!-- /wp:group -->
