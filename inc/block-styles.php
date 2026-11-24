<?php
/**
 * Register core block styles for FoA Cleaner.
 *
 * Keeps 100% WordPress.org compliance by extending native WordPress blocks
 * instead of registering custom theme-locked blocks.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register FoA Cleaner block styles on init.
 *
 * @since 0.1.0
 */
function foa_cleaner_register_block_styles(): void {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	$styles = array(
		'core/button'    => array(
			array(
				'name'  => 'accent',
				'label' => __( 'FoA Blue', 'foa-cleaner' ),
			),
			array(
				'name'  => 'ghost',
				'label' => __( 'Ghost', 'foa-cleaner' ),
			),
			array(
				'name'  => 'light',
				'label' => __( 'Light (On Dark)', 'foa-cleaner' ),
			),
		),
		'core/paragraph' => array(
			array(
				'name'  => 'overline',
				'label' => __( 'Overline', 'foa-cleaner' ),
			),
			array(
				'name'  => 'pill',
				'label' => __( 'Pill Badge', 'foa-cleaner' ),
			),
			array(
				'name'  => 'lead',
				'label' => __( 'Lead Text', 'foa-cleaner' ),
			),
		),
		'core/group'     => array(
			array(
				'name'  => 'card',
				'label' => __( 'Clean Card', 'foa-cleaner' ),
			),
			array(
				'name'  => 'card-elevated',
				'label' => __( 'Elevated Card', 'foa-cleaner' ),
			),
			array(
				'name'  => 'dark-band',
				'label' => __( 'Dark Band', 'foa-cleaner' ),
			),
			array(
				'name'  => 'hairline-top',
				'label' => __( 'Hairline Top', 'foa-cleaner' ),
			),
			array(
				'name'  => 'cv',
				'label' => __( 'CV Document', 'foa-cleaner' ),
			),
		),
		'core/columns'   => array(
			array(
				'name'  => 'hairline-grid',
				'label' => __( 'Hairline Grid', 'foa-cleaner' ),
			),
		),
		'core/list'      => array(
			array(
				'name'  => 'checklist',
				'label' => __( 'Checklist', 'foa-cleaner' ),
			),
		),
		'core/details'   => array(
			array(
				'name'  => 'clean-accordion',
				'label' => __( 'Clean Accordion', 'foa-cleaner' ),
			),
		),
		'core/table'     => array(
			array(
				'name'  => 'comparison',
				'label' => __( 'Comparison Table', 'foa-cleaner' ),
			),
		),
	);

	foreach ( $styles as $block_name => $block_styles ) {
		foreach ( $block_styles as $style_properties ) {
			register_block_style( $block_name, $style_properties );
		}
	}
}
add_action( 'init', 'foa_cleaner_register_block_styles' );
