/**
 * FoA Cleaner — Standalone Light/Dark Mode Switcher.
 *
 * Works with zero dependencies when Vibetiles is not active, and yields
 * gracefully if Vibetiles controls the document color mode.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */
( function () {
	'use strict';

	const STORAGE_KEY = 'foa-cleaner-theme';
	const root = document.documentElement;

	// Yield gracefully if Vibetiles is controlling the color mode.
	if ( root.hasAttribute( 'data-theme' ) || ( document.body && document.body.classList.contains( 'foa-vibetiles-active' ) ) ) {
		return;
	}

	const config = window.foaCleanerThemeMode || {};
	const defaultMode = config.defaultMode || root.getAttribute( 'data-foa-default-theme' ) || 'system';
	const labels = Object.assign(
		{
			switchToDark: 'Switch to dark mode',
			switchToLight: 'Switch to light mode',
		},
		config.labels || {}
	);

	const mediaQuery = window.matchMedia ? window.matchMedia( '(prefers-color-scheme: dark)' ) : null;

	function readStoredTheme() {
		try {
			const value = window.localStorage.getItem( STORAGE_KEY );
			return value === 'dark' || value === 'light' ? value : null;
		} catch ( err ) {
			return null;
		}
	}

	function writeStoredTheme( mode ) {
		try {
			window.localStorage.setItem( STORAGE_KEY, mode );
		} catch ( err ) {
			// Storage unavailable (e.g. private mode); keep runtime state only.
		}
	}

	function resolveMode( stored ) {
		if ( stored === 'dark' || stored === 'light' ) {
			return stored;
		}
		if ( defaultMode === 'dark' || defaultMode === 'light' ) {
			return defaultMode;
		}
		return mediaQuery && mediaQuery.matches ? 'dark' : 'light';
	}

	function syncButtons( mode ) {
		const isDark = mode === 'dark';
		const buttons = document.querySelectorAll( '[data-foa-theme-toggle]' );
		const nextLabel = isDark ? labels.switchToLight : labels.switchToDark;

		buttons.forEach( function ( button ) {
			button.setAttribute( 'aria-pressed', isDark ? 'true' : 'false' );
			button.setAttribute( 'aria-label', nextLabel );
			button.setAttribute( 'title', nextLabel );
		} );
	}

	function applyMode( mode ) {
		root.setAttribute( 'data-foa-theme', mode );
		syncButtons( mode );
	}

	function toggleMode() {
		if ( root.hasAttribute( 'data-theme' ) ) {
			return;
		}
		const current = root.getAttribute( 'data-foa-theme' ) === 'dark' ? 'dark' : 'light';
		const next = current === 'dark' ? 'light' : 'dark';
		writeStoredTheme( next );
		applyMode( next );
	}

	function init() {
		const initialMode = resolveMode( readStoredTheme() );
		applyMode( initialMode );

		document.addEventListener( 'click', function ( event ) {
			const trigger = event.target.closest( '[data-foa-theme-toggle]' );
			if ( ! trigger ) {
				return;
			}
			event.preventDefault();
			toggleMode();
		} );

		if ( mediaQuery ) {
			const handleSystemChange = function () {
				if ( readStoredTheme() === null && defaultMode === 'system' ) {
					applyMode( mediaQuery.matches ? 'dark' : 'light' );
				}
			};

			if ( typeof mediaQuery.addEventListener === 'function' ) {
				mediaQuery.addEventListener( 'change', handleSystemChange );
			}
		}

		window.addEventListener( 'storage', function ( event ) {
			if ( event.key === STORAGE_KEY ) {
				applyMode( resolveMode( readStoredTheme() ) );
			}
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
