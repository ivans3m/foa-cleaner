<?php
/**
 * Title: CV Header & Contact Strip
 * Slug: foa-cleaner/cv-header
 * Categories: foa-cleaner-editorial, text
 * Keywords: cv, resume, header, contact, profile, markdown
 * Viewport Width: 900
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"tagName":"header","className":"foa-cv-header","layout":{"type":"default"}} -->
<header class="wp-block-group foa-cv-header">
	<!-- wp:group {"className":"foa-cv-header__top","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
	<div class="wp-block-group foa-cv-header__top">
		<!-- wp:group {"style":{"spacing":{"blockGap":"0.25rem"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:heading {"level":1,"className":"foa-cv-header__name","fontSize":"2-xl"} -->
			<h1 class="wp-block-heading foa-cv-header__name has-2-xl-font-size"><?php esc_html_e( 'Jane Doe', 'foa-cleaner' ); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"foa-cv-header__headline is-style-lead"} -->
			<p class="foa-cv-header__headline is-style-lead"><?php esc_html_e( 'Senior Backend Engineer', 'foa-cleaner' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"foa-cv-header__actions foa-cv-no-print","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group foa-cv-header__actions foa-cv-no-print">
			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-ghost"} -->
				<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Download PDF', 'foa-cleaner' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

			<!-- wp:paragraph {"align":"center","className":"foa-cv-header__md-link"} -->
			<p class="has-text-align-center foa-cv-header__md-link"><a href="#"><?php esc_html_e( 'Download CV.md', 'foa-cleaner' ); ?></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"className":"foa-cv-header__meta"} -->
	<p class="foa-cv-header__meta"><?php esc_html_e( 'Amsterdam, Netherlands · EU Citizen · 1 month notice · ', 'foa-cleaner' ); ?><a href="mailto:jane@example.com">jane@example.com</a> · <a href="https://github.com/janedoe">GitHub</a> · <a href="https://linkedin.com/in/janedoe">LinkedIn</a></p>
	<!-- /wp:paragraph -->
</header>
<!-- /wp:group -->
