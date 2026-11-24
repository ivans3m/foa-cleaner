<?php
/**
 * Title: Side-by-Side Comparison Table
 * Slug: foa-cleaner/comparison-table
 * Categories: foa-cleaner-sections
 * Keywords: comparison, table, contrast, vs
 * Viewport Width: 1280
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|3-xl","right":"var:preset|spacing|md","bottom":"var:preset|spacing|3-xl","left":"var:preset|spacing|md"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--3-xl);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--3-xl);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"align":"wide","className":"foa-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xl"},"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide foa-reveal" style="margin-bottom:var(--wp--preset--spacing--xl)">
		<!-- wp:paragraph {"className":"is-style-overline"} -->
		<p class="is-style-overline"><?php esc_html_e( 'Comparison', 'foa-cleaner' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":2,"fontSize":"2-xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'How FoA Cleaner compares.', 'foa-cleaner' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:table {"align":"wide","className":"is-style-comparison foa-reveal"} -->
	<figure class="wp-block-table alignwide is-style-comparison foa-reveal">
		<table>
			<thead>
				<tr>
					<th><?php esc_html_e( 'Dimension', 'foa-cleaner' ); ?></th>
					<th><?php esc_html_e( 'Heavy Multipurpose Themes', 'foa-cleaner' ); ?></th>
					<th><?php esc_html_e( 'FoA Cleaner', 'foa-cleaner' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong><?php esc_html_e( 'Block Portability', 'foa-cleaner' ); ?></strong></td>
					<td><?php esc_html_e( 'Proprietary widgets & shortcodes', 'foa-cleaner' ); ?></td>
					<td><?php esc_html_e( '100% native WordPress core blocks', 'foa-cleaner' ); ?></td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Typography & Privacy', 'foa-cleaner' ); ?></strong></td>
					<td><?php esc_html_e( 'External CDN font requests', 'foa-cleaner' ); ?></td>
					<td><?php esc_html_e( 'Self-hosted SIL OFL variable .woff2 trio', 'foa-cleaner' ); ?></td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Light & Dark Modes', 'foa-cleaner' ); ?></strong></td>
					<td><?php esc_html_e( 'Extra plugin or flash on load', 'foa-cleaner' ); ?></td>
					<td><?php esc_html_e( 'Built-in FOUC-free switcher + Vibetiles ready', 'foa-cleaner' ); ?></td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Frontend Footprint', 'foa-cleaner' ); ?></strong></td>
					<td><?php esc_html_e( 'Bundled CSS/JS loaded globally', 'foa-cleaner' ); ?></td>
					<td><?php esc_html_e( 'Zero jQuery; scripts load conditionally only when needed', 'foa-cleaner' ); ?></td>
				</tr>
			</tbody>
		</table>
	</figure>
	<!-- /wp:table -->
</div>
<!-- /wp:group -->
