<?php
/**
 * Register custom block pattern categories for FoA Cleaner.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register organized FoA Cleaner pattern categories.
 *
 * @since 0.1.0
 */
function foa_cleaner_register_pattern_categories(): void {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	$categories = array(
		'foa-cleaner-heroes'       => array(
			'label'       => __( 'FoA Cleaner: Heroes', 'foa-cleaner' ),
			'description' => __( 'Bold display and centered SaaS hero sections.', 'foa-cleaner' ),
		),
		'foa-cleaner-sections'     => array(
			'label'       => __( 'FoA Cleaner: Sections', 'foa-cleaner' ),
			'description' => __( 'Feature grids, spec strips, metrics, comparison tables, pricing, and FAQs.', 'foa-cleaner' ),
		),
		'foa-cleaner-portfolio'    => array(
			'label'       => __( 'FoA Cleaner: Portfolio', 'foa-cleaner' ),
			'description' => __( 'Minimal project grids, galleries, photo essays, video reels, and case-study showcases.', 'foa-cleaner' ),
		),
		'foa-cleaner-social-proof' => array(
			'label'       => __( 'FoA Cleaner: Social Proof', 'foa-cleaner' ),
			'description' => __( 'Pull quotes and clean editorial testimonial cards.', 'foa-cleaner' ),
		),
		'foa-cleaner-editorial'    => array(
			'label'       => __( 'FoA Cleaner: Editorial', 'foa-cleaner' ),
			'description' => __( 'Blog streams, post grids, and chronological yearly archives.', 'foa-cleaner' ),
		),
		'foa-cleaner-cta'          => array(
			'label'       => __( 'FoA Cleaner: Call to Action', 'foa-cleaner' ),
			'description' => __( 'High-impact closing bands and newsletter prompts.', 'foa-cleaner' ),
		),
	);

	foreach ( $categories as $slug => $properties ) {
		register_block_pattern_category( $slug, $properties );
	}
}
add_action( 'init', 'foa_cleaner_register_pattern_categories' );
