/**
 * FoA Cleaner — Clean Design Micro-Animations Engine.
 *
 * Handles:
 * 1. Hero headline masked line-by-line rise (lineUp, matching clean-design.html).
 * 2. IntersectionObserver scroll reveals & staggered card grids.
 * 3. Smooth easeOutCubic metric counter animation on .foa-stat-number.
 * 4. Smooth Web Animations API open/close transitions on native FAQ <details>.
 * 5. Subtle GPU-composited ambient cursor glow on desktop fine-pointer devices.
 *
 * @package FoA_Cleaner
 * @since   1.0.0
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

	root.classList.add( 'foa-js-motion' );

	/* ----------------------------------------------------------------------
	 * 1. Hero Display Masked Line-Up Reveal
	 * ---------------------------------------------------------------------- */

	function splitHeroLines( heading ) {
		if ( ! heading || heading.classList.contains( 'foa-lines-ready' ) || heading.classList.contains( 'foa-lines-fallback' ) ) {
			return;
		}

		if ( heading.offsetWidth === 0 ) {
			heading.classList.add( 'foa-lines-fallback' );
			return;
		}

		// Preserve complex markup (e.g. links/spans inside heading) with graceful fallback.
		const hasComplexChildren = Array.prototype.some.call( heading.children, function ( child ) {
			return child.tagName !== 'BR';
		} );
		if ( hasComplexChildren ) {
			heading.classList.add( 'foa-lines-fallback' );
			return;
		}

		const originalText = ( heading.textContent || '' ).trim();
		if ( ! originalText ) {
			heading.classList.add( 'foa-lines-fallback' );
			return;
		}

		let lines = [];

		// If the author used explicit <br> breaks, honor them directly.
		if ( heading.querySelector( 'br' ) ) {
			lines = heading.innerHTML
				.split( /<br\s*\/?>/i )
				.map( function ( part ) {
					const tmp = document.createElement( 'span' );
					tmp.innerHTML = part;
					return ( tmp.textContent || '' ).trim();
				} )
				.filter( Boolean );
		} else {
			// Measure exact visual wrapped lines using Range word rects.
			const words = originalText.split( /\s+/ );
			if ( words.length > 1 && document.createRange ) {
				const measurer = document.createElement( 'span' );
				const wordSpans = words.map( function ( w, idx ) {
					const s = document.createElement( 'span' );
					s.textContent = idx < words.length - 1 ? w + ' ' : w;
					measurer.appendChild( s );
					return s;
				} );

				heading.textContent = '';
				heading.appendChild( measurer );

				let currentTop = null;
				let bucket = [];
				wordSpans.forEach( function ( span ) {
					const top = Math.round( span.getBoundingClientRect().top );
					if ( currentTop === null || Math.abs( top - currentTop ) <= 6 ) {
						currentTop = currentTop === null ? top : currentTop;
						bucket.push( span.textContent );
					} else {
						lines.push( bucket.join( '' ).trim() );
						currentTop = top;
						bucket = [ span.textContent ];
					}
				} );
				if ( bucket.length ) {
					lines.push( bucket.join( '' ).trim() );
				}
			} else {
				lines = [ originalText ];
			}
		}

		if ( ! lines.length ) {
			heading.textContent = originalText;
			heading.classList.add( 'foa-lines-fallback' );
			return;
		}

		heading.textContent = '';
		heading.setAttribute( 'aria-label', originalText );

		lines.forEach( function ( lineText, index ) {
			const wrap = document.createElement( 'span' );
			wrap.className = 'foa-line-wrap';
			wrap.setAttribute( 'aria-hidden', 'true' );

			const inner = document.createElement( 'span' );
			inner.className = 'foa-line-inner';
			inner.style.setProperty( '--foa-line-delay', ( 0.12 + index * 0.14 ).toFixed( 2 ) + 's' );
			inner.textContent = lineText;

			wrap.appendChild( inner );
			heading.appendChild( wrap );
		} );

		heading.classList.add( 'foa-lines-ready' );
	}

	function initHeroLines() {
		const heroHeadings = document.querySelectorAll( '.foa-hero-enter h1' );
		if ( ! heroHeadings.length ) {
			return;
		}

		const run = function () {
			heroHeadings.forEach( splitHeroLines );
		};

		if ( document.fonts && document.fonts.status !== 'loaded' && document.fonts.ready ) {
			// Ensure lines split as soon as fonts settle (with fast 120ms ceiling).
			let done = false;
			const once = function () {
				if ( done ) {
					return;
				}
				done = true;
				run();
			};
			document.fonts.ready.then( once );
			window.setTimeout( once, 120 );
		} else {
			run();
		}
	}

	/* ----------------------------------------------------------------------
	 * 2. Scroll Reveal & Stagger Observer
	 * ---------------------------------------------------------------------- */

	function initScrollReveals() {
		const targets = document.querySelectorAll(
			'.foa-reveal, .foa-reveal-stagger, .foa-reveal-left, .foa-reveal-right'
		);
		if ( ! targets.length ) {
			return;
		}

		if ( typeof window.IntersectionObserver !== 'function' ) {
			targets.forEach( function ( el ) {
				el.classList.add( 'is-visible' );
			} );
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
				threshold: 0.12,
				rootMargin: '0px 0px -32px 0px',
			}
		);

		window.requestAnimationFrame( function () {
			targets.forEach( function ( el ) {
				observer.observe( el );
			} );
		} );
	}

	/* ----------------------------------------------------------------------
	 * 3. Smooth Metric Counter Animation (.foa-stat-number)
	 * ---------------------------------------------------------------------- */

	function easeOutCubic( t ) {
		return 1 - Math.pow( 1 - t, 3 );
	}

	function initStatCounters() {
		const stats = document.querySelectorAll( '.foa-stat-number' );
		if ( ! stats.length || typeof window.IntersectionObserver !== 'function' ) {
			return;
		}

		const counterObserver = new window.IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					const el = entry.target;
					counterObserver.unobserve( el );

					const raw = ( el.textContent || '' ).trim();
					const match = raw.match( /^([^\d-]*)(\d+(?:\.\d+)?)(.*)$/ );
					if ( ! match ) {
						return;
					}

					const prefix = match[ 1 ];
					const target = parseFloat( match[ 2 ] );
					const suffix = match[ 3 ];
					const decimals = match[ 2 ].indexOf( '.' ) !== -1 ? match[ 2 ].split( '.' )[ 1 ].length : 0;

					if ( ! target || target <= 0 ) {
						return;
					}

					const duration = 1100;
					const start = window.performance.now();

					function tick( now ) {
						const progress = Math.min( ( now - start ) / duration, 1 );
						const value = easeOutCubic( progress ) * target;
						el.textContent =
							prefix +
							( decimals > 0 ? value.toFixed( decimals ) : String( Math.round( value ) ) ) +
							suffix;
						if ( progress < 1 ) {
							window.requestAnimationFrame( tick );
						} else {
							el.textContent = raw;
						}
					}

					window.requestAnimationFrame( tick );
				} );
			},
			{ threshold: 0.45 }
		);

		stats.forEach( function ( el ) {
			counterObserver.observe( el );
		} );
	}

	/* ----------------------------------------------------------------------
	 * 4. Smooth Native FAQ Accordion (<details.is-style-clean-accordion>)
	 * ---------------------------------------------------------------------- */

	function initAccordions() {
		const items = document.querySelectorAll( 'details.is-style-clean-accordion' );
		if ( ! items.length || typeof Element.prototype.animate !== 'function' ) {
			return;
		}

		items.forEach( function ( details ) {
			const summary = details.querySelector( 'summary' );
			if ( ! summary ) {
				return;
			}

			let animation = null;
			let isClosing = false;
			let isExpanding = false;

			summary.addEventListener( 'click', function ( event ) {
				event.preventDefault();

				if ( isClosing || ! details.open ) {
					isExpanding = true;
					isClosing = false;
					if ( animation ) {
						animation.cancel();
					}

					const startHeight = details.offsetHeight + 'px';
					details.open = true;
					window.requestAnimationFrame( function () {
						const endHeight = details.offsetHeight + 'px';
						animation = details.animate(
							{ height: [ startHeight, endHeight ] },
							{ duration: 320, easing: 'cubic-bezier(0.16, 1, 0.3, 1)' }
						);
						animation.onfinish = function () {
							animation = null;
							isExpanding = false;
						};
					} );
				} else if ( isExpanding || details.open ) {
					isClosing = true;
					isExpanding = false;
					if ( animation ) {
						animation.cancel();
					}

					const startHeight = details.offsetHeight + 'px';
					const styles = window.getComputedStyle( details );
					const chromeY =
						parseFloat( styles.paddingTop || '0' ) +
						parseFloat( styles.paddingBottom || '0' ) +
						parseFloat( styles.borderTopWidth || '0' ) +
						parseFloat( styles.borderBottomWidth || '0' );
					const endHeight = Math.ceil( summary.offsetHeight + chromeY ) + 'px';

					animation = details.animate(
						{ height: [ startHeight, endHeight ] },
						{ duration: 260, easing: 'cubic-bezier(0.16, 1, 0.3, 1)' }
					);
					animation.onfinish = function () {
						details.open = false;
						animation = null;
						isClosing = false;
					};
				}
			} );
		} );
	}

	/* ----------------------------------------------------------------------
	 * 5. Subtle Ambient Cursor Glow (fine pointer desktop only)
	 * ---------------------------------------------------------------------- */

	function initCursorGlow() {
		if ( ! window.matchMedia || ! window.matchMedia( '(pointer: fine)' ).matches ) {
			return;
		}
		if ( ! document.body || document.querySelector( '.foa-cursor-glow' ) ) {
			return;
		}

		const glow = document.createElement( 'div' );
		glow.className = 'foa-cursor-glow';
		glow.setAttribute( 'aria-hidden', 'true' );
		document.body.appendChild( glow );

		let rafId = 0;
		let x = -999;
		let y = -999;
		let visible = false;

		function paint() {
			rafId = 0;
			glow.style.transform = 'translate3d(' + x + 'px, ' + y + 'px, 0)';
		}

		document.addEventListener(
			'mousemove',
			function ( event ) {
				x = event.clientX;
				y = event.clientY;
				if ( ! visible ) {
					visible = true;
					glow.style.opacity = '1';
				}
				if ( ! rafId ) {
					rafId = window.requestAnimationFrame( paint );
				}
			},
			{ passive: true }
		);

		document.addEventListener(
			'mouseleave',
			function () {
				visible = false;
				glow.style.opacity = '0';
			},
			{ passive: true }
		);
	}

	function init() {
		initHeroLines();
		initScrollReveals();
		initStatCounters();
		initAccordions();
		initCursorGlow();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
