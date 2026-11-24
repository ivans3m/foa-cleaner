/**
 * FoA Cleaner — Lightweight IntersectionObserver Scroll Reveal.
 *
 * Progressive enhancement: adds .foa-js-motion on <html> only when motion is
 * allowed and IntersectionObserver is supported, preventing invisible content.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */
( function () {
	'use strict';

	const root = document.documentElement;

	if ( root.getAttribute( 'data-foa-motion' ) === 'off' ) {
		return;
	}

	if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	if ( typeof window.IntersectionObserver !== 'function' ) {
		return;
	}

	function init() {
		const hasHero = document.querySelector( '.foa-hero-enter' );
		const targets = document.querySelectorAll( '.foa-reveal, .foa-reveal-stagger' );
		if ( ! targets.length && ! hasHero ) {
			return;
		}

		root.classList.add( 'foa-js-motion' );

		if ( ! targets.length ) {
			return;
		}

		const observer = new window.IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{
				threshold: 0.1,
				rootMargin: '0px 0px -36px 0px',
			}
		);

		targets.forEach( function ( el ) {
			const rect = el.getBoundingClientRect();
			if ( rect.top < window.innerHeight * 0.92 ) {
				el.classList.add( 'is-visible' );
			} else {
				observer.observe( el );
			}
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
