<?php
/**
 * Inline Lucide SVG icon registry and block placeholder resolver.
 *
 * Icons are derived from Lucide (https://lucide.dev, ISC License), rendered
 * inline with stroke="currentColor" and stroke-width="1.5" so they inherit
 * color cleanly across light/dark modes and Vibetiles palettes without icon fonts.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the map of registered Lucide SVG inner markup strings.
 *
 * @since 0.1.0
 *
 * @return array<string, string> Map of icon slug => SVG inner elements.
 */
function foa_cleaner_icons(): array {
	static $icons = null;

	if ( null !== $icons ) {
		return $icons;
	}

	$icons = array(
		'arrow-left'         => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
		'arrow-right'        => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'arrow-up-right'     => '<path d="M7 7h10v10"/><path d="M7 17 17 7"/>',
		'book-open'          => '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
		'calendar'           => '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
		'check'              => '<path d="M20 6 9 17l-5-5"/>',
		'chevron-down'       => '<path d="m6 9 6 6 6-6"/>',
		'chevron-left'       => '<path d="m15 18-6-6 6-6"/>',
		'chevron-right'      => '<path d="m9 18 6-6-6-6"/>',
		'chevron-up'         => '<path d="m18 15-6-6-6 6"/>',
		'clock'              => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
		'code'               => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
		'copy'               => '<rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>',
		'download'           => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/><path d="M12 15V3"/>',
		'external-link'      => '<path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>',
		'eye'                => '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>',
		'file-text'          => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
		'globe'              => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
		'layers'             => '<path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/>',
		'link'               => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
		'mail'               => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'maximize-2'         => '<polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" x2="14" y1="3" y2="10"/><line x1="3" x2="10" y1="21" y2="14"/>',
		'menu'               => '<line x1="4" x2="20" y1="8" y2="8"/><line x1="4" x2="20" y1="16" y2="16"/>',
		'message-circle'     => '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>',
		'minimize-2'         => '<polyline points="4 14 10 14 10 20"/><polyline points="20 10 14 10 14 4"/><line x1="14" x2="21" y1="10" y2="3"/><line x1="3" x2="10" y1="21" y2="14"/>',
		'moon'               => '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>',
		'plus'               => '<path d="M5 12h14"/><path d="M12 5v14"/>',
		'quote'              => '<path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/>',
		'search'             => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
		'shield-check'       => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
		'sliders-horizontal' => '<path d="M10 5H3"/><path d="M12 19H3"/><path d="M14 3v4"/><path d="M16 17v4"/><path d="M21 12h-9"/><path d="M21 19h-5"/><path d="M21 5h-7"/><path d="M8 10v4"/><path d="M8 12H3"/>',
		'sparkles'           => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
		'sun'                => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>',
		'sun-moon'           => '<path d="M12 8a2.83 2.83 0 0 0 4 4 4 4 0 1 1-4-4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.9 4.9 1.4 1.4"/><path d="m17.7 17.7 1.4 1.4"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.3 17.7-1.4 1.4"/><path d="m19.1 4.9-1.4 1.4"/>',
		'x'                  => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
		'zap'                => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>',
	);

	return $icons;
}

/**
 * Render an inline Lucide SVG icon.
 *
 * @since 0.1.0
 *
 * @param string $name  Registered icon slug.
 * @param array  $attrs Optional HTML attributes (e.g. 'class', 'width', 'height').
 * @return string Inline SVG markup, or empty string if unknown.
 */
function foa_cleaner_icon( string $name, array $attrs = array() ): string {
	$icons = foa_cleaner_icons();
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	$classes = 'foa-icon foa-icon-' . sanitize_html_class( $name );
	if ( ! empty( $attrs['class'] ) ) {
		$classes .= ' ' . (string) $attrs['class'];
	}

	$defaults = array(
		'class'           => $classes,
		'viewBox'         => '0 0 24 24',
		'width'           => '20',
		'height'          => '20',
		'fill'            => 'none',
		'stroke'          => 'currentColor',
		'stroke-width'    => '1.5',
		'stroke-linecap'  => 'round',
		'stroke-linejoin' => 'round',
		'aria-hidden'     => 'true',
		'focusable'       => 'false',
	);

	unset( $attrs['class'] );
	$merged = array_merge( $defaults, $attrs );

	$attr_html = '';
	foreach ( $merged as $key => $value ) {
		$clean_key = preg_replace( '/[^a-zA-Z0-9:-]/', '', (string) $key );
		if ( '' === $clean_key ) {
			continue;
		}
		$attr_html .= sprintf( ' %s="%s"', $clean_key, esc_attr( (string) $value ) );
	}

	return '<svg' . $attr_html . '>' . $icons[ $name ] . '</svg>';
}

/**
 * Return the accessible standalone Light/Dark theme switcher button markup.
 *
 * Returns an empty string when Vibetiles is active so duplicate controls never appear.
 *
 * @since 0.1.0
 *
 * @return string Button HTML markup or empty string.
 */
function foa_cleaner_theme_toggle_markup(): string {
	if ( foa_cleaner_vibetiles_active() ) {
		return '';
	}

	return sprintf(
		'<button type="button" class="foa-theme-toggle" data-foa-theme-toggle aria-pressed="false" aria-label="%1$s" title="%1$s">%2$s%3$s</button>',
		esc_attr__( 'Switch color mode', 'foa-cleaner' ),
		foa_cleaner_icon( 'sun', array( 'width' => '17', 'height' => '17' ) ),
		foa_cleaner_icon( 'moon', array( 'width' => '17', 'height' => '17' ) )
	);
}

/**
 * Replace icon and theme-toggle placeholders inside rendered block HTML.
 *
 * Supports:
 * - <span data-foa-icon="arrow-right"></span>
 * - <span data-foa-icon="sparkles" data-foa-icon-class="feature-icon"></span>
 * - <span data-foa-theme-toggle-slot></span>
 *
 * @since 0.1.0
 *
 * @param string $block_content Rendered block HTML.
 * @return string Filtered block HTML.
 */
function foa_cleaner_render_block_placeholders( string $block_content ): string {
	if ( false !== strpos( $block_content, 'data-foa-theme-toggle-slot' ) ) {
		$block_content = (string) preg_replace_callback(
			'/<span\s+data-foa-theme-toggle-slot(?:="")?\s*><\/span>/',
			static function (): string {
				return foa_cleaner_theme_toggle_markup();
			},
			$block_content
		);
	}

	if ( false === strpos( $block_content, 'data-foa-icon' ) ) {
		return $block_content;
	}

	return (string) preg_replace_callback(
		'/<span\s+data-foa-icon="([a-z0-9-]+)"(?:\s+data-foa-icon-class="([a-zA-Z0-9_\-\s]+)")?\s*><\/span>/',
		static function ( array $matches ): string {
			$attrs = array();
			if ( ! empty( $matches[2] ) ) {
				$tokens = preg_split( '/\s+/', trim( $matches[2] ), -1, PREG_SPLIT_NO_EMPTY );
				if ( is_array( $tokens ) ) {
					$attrs['class'] = implode( ' ', array_map( 'sanitize_html_class', $tokens ) );
				}
			}
			return foa_cleaner_icon( $matches[1], $attrs );
		},
		$block_content
	);
}
add_filter( 'render_block', 'foa_cleaner_render_block_placeholders', 5 );
