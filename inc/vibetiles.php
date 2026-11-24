<?php
/**
 * Optional Vibetiles Guest Mode compatibility layer.
 *
 * FoA Cleaner has zero hard dependency on Vibetiles. When Vibetiles is active,
 * this module ensures graceful coexistence:
 * - Yields standalone light/dark mode controls so Vibetiles owns color switching.
 * - Keeps semantic --foa-* CSS variables aligned with Vibetiles Guest Mode palettes
 *   and OKLab light/dark opposite-side switching.
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
 * Keep FoA Cleaner's accent & elevated surface custom properties synchronized
 * when Vibetiles Guest Mode remaps the theme palette.
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
		. "}\n"
		. ":root[data-theme$=\"-dark\"][data-chosen] :is(.has-contrast-background-color, .is-style-dark-band) {\n"
		. "\tbackground-color: color-mix(in srgb, var(--surface-base, #171613) 90%, #FFFFFF) !important;\n"
		. "\tcolor: var(--text-primary, #F6F4EE);\n"
		. "\tborder-color: var(--line, #262420);\n"
		. "}\n";

	return $css . $sync;
}
add_filter( 'live_design_panel_guest_palette_css', 'foa_cleaner_vibetiles_palette_sync', 10, 2 );

/**
 * Keep dark sections cohesive when Vibetiles toggles a guest theme to its
 * opposite light/dark side without selecting a custom colour tile.
 *
 * @since 0.1.0
 *
 * @param string $css     Generated opposite-side CSS from Vibetiles.
 * @param array  $palette Theme color palette map.
 * @param string $side    Detected native theme side ('light' or 'dark').
 * @return string Extended opposite-side CSS.
 */
function foa_cleaner_vibetiles_other_side_sync( string $css, array $palette, string $side ): string {
	unset( $palette );

	if ( 'light' === $side ) {
		$gate  = ':root[data-theme$="-dark"]:not([data-chosen]):not([data-colours])';
		$css  .= "\n" . $gate . " :is(.has-contrast-background-color, .is-style-dark-band) {\n"
			. "\tbackground-color: color-mix(in srgb, var(--wp--preset--color--surface, #171613) 90%, #FFFFFF) !important;\n"
			. "\tcolor: var(--wp--preset--color--surface-dark-text, #F6F4EE);\n"
			. "\tborder-color: var(--wp--preset--color--border, #262420);\n"
			. "}\n";
	}

	return $css;
}
add_filter( 'live_design_panel_guest_other_side_css', 'foa_cleaner_vibetiles_other_side_sync', 10, 3 );
