<?php
/**
 * Optional Vibetiles Guest Mode compatibility layer.
 *
 * FoA Cleaner has zero hard dependency on Vibetiles. When Vibetiles is active,
 * this module ensures graceful coexistence:
 * - Yields standalone light/dark mode controls so Vibetiles owns color switching.
 * - Keeps semantic --foa-* CSS variables aligned with Vibetiles Guest Mode palettes.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether the Vibetiles plugin is active and running.
 *
 * @since 0.1.0
 *
 * @return bool True when Vibetiles is active on the current request.
 */
function foa_cleaner_vibetiles_active(): bool {
	$active = defined( 'ARCHITRAVE_PANEL_VERSION' )
		&& ( ! function_exists( 'architrave_panel_runs' ) || architrave_panel_runs() );

	/**
	 * Filter whether FoA Cleaner treats Vibetiles as active.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $active Detection result.
	 */
	return (bool) apply_filters( 'foa_cleaner_vibetiles_active', $active );
}

/**
 * Keep FoA Cleaner's accent & border custom properties synchronized when
 * Vibetiles Guest Mode remaps the theme palette.
 *
 * @since 0.1.0
 *
 * @param string $css     Generated Guest Mode palette CSS from Vibetiles.
 * @param array  $palette Theme color palette map.
 * @return string Extended Guest Mode palette CSS.
 */
function foa_cleaner_vibetiles_palette_sync( string $css, array $palette ): string {
	unset( $palette );

	$sync = "\n:root[data-chosen] {\n"
		. "\t--foa-accent-solid: var(--accent, var(--wp--preset--color--foa-blue, #2E70FF));\n"
		. "\t--foa-accent-solid-hover: color-mix(in srgb, var(--foa-accent-solid) 86%, #000000);\n"
		. "}\n";

	return $css . $sync;
}
add_filter( 'live_design_panel_guest_palette_css', 'foa_cleaner_vibetiles_palette_sync', 10, 2 );
