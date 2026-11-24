/**
 * FoA Cleaner — Single-Post Focus Mode & 1px Reading Progress Bar.
 *
 * Conditionally loaded only on single posts (is_singular( 'post' )).
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */
( function () {
	'use strict';

	const SESSION_KEY = 'foa-cleaner-focus-mode';
	const root = document.documentElement;
	const labels = Object.assign(
		{
			enterFocus: 'Enter focus mode',
			exitFocus: 'Exit focus mode',
			focusLabel: 'Focus',
			exitLabel: 'Exit focus',
		},
		window.foaCleanerFocusMode || {}
	);

	function readFocusState() {
		try {
			return window.sessionStorage.getItem( SESSION_KEY ) === 'on';
		} catch ( err ) {
			return false;
		}
	}

	function writeFocusState( active ) {
		try {
			if ( active ) {
				window.sessionStorage.setItem( SESSION_KEY, 'on' );
			} else {
				window.sessionStorage.removeItem( SESSION_KEY );
			}
		} catch ( err ) {
			// Ignore sessionStorage restrictions.
		}
	}

	function applyFocusMode( active ) {
		if ( active ) {
			root.setAttribute( 'data-foa-focus', 'on' );
		} else {
			root.removeAttribute( 'data-foa-focus' );
		}

		const toggles = document.querySelectorAll( '[data-foa-focus-toggle]' );
		toggles.forEach( function ( button ) {
			const nextLabel = active ? labels.exitFocus : labels.enterFocus;
			button.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
			button.setAttribute( 'aria-label', nextLabel );
			const textEl = button.querySelector( '.foa-focus-toggle-text' );
			if ( textEl ) {
				textEl.textContent = active ? labels.exitLabel : labels.focusLabel;
			}
		} );
	}

	function initFocusMode() {
		const hasToggle = document.querySelector( '[data-foa-focus-toggle]' );
		if ( ! hasToggle ) {
			return;
		}

		if ( readFocusState() ) {
			applyFocusMode( true );
		}

		document.addEventListener( 'click', function ( event ) {
			const trigger = event.target.closest( '[data-foa-focus-toggle], [data-foa-focus-exit]' );
			if ( ! trigger ) {
				return;
			}
			event.preventDefault();
			const isExit = trigger.hasAttribute( 'data-foa-focus-exit' );
			const next = isExit ? false : root.getAttribute( 'data-foa-focus' ) !== 'on';
			writeFocusState( next );
			applyFocusMode( next );
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && root.getAttribute( 'data-foa-focus' ) === 'on' ) {
				writeFocusState( false );
				applyFocusMode( false );
			}
		} );
	}

	function initProgressBar() {
		const bar = document.querySelector( '.foa-reading-progress__bar' );
		const article = document.querySelector( '.foa-single-article' ) || document.querySelector( 'main' );
		if ( ! bar || ! article ) {
			return;
		}

		let ticking = false;

		function update() {
			ticking = false;
			const rect = article.getBoundingClientRect();
			const articleTop = rect.top + window.scrollY;
			const scrollable = Math.max( 1, article.offsetHeight - window.innerHeight * 0.7 );
			const progress = Math.min( 1, Math.max( 0, ( window.scrollY - articleTop ) / scrollable ) );
			bar.style.transform = 'scaleX(' + progress.toFixed( 4 ) + ')';
		}

		function onScroll() {
			if ( ! ticking ) {
				ticking = true;
				window.requestAnimationFrame( update );
			}
		}

		window.addEventListener( 'scroll', onScroll, { passive: true } );
		window.addEventListener( 'resize', onScroll, { passive: true } );
		update();
	}

	function init() {
		initFocusMode();
		initProgressBar();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
