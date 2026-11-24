/**
 * FoA Cleaner — Copy-to-Clipboard Button for core/code Blocks.
 *
 * Conditionally loaded only on singular views containing a core/code block.
 *
 * @package FoA_Cleaner
 * @since   0.1.0
 */
( function () {
	'use strict';

	const labels = Object.assign(
		{
			copy: 'Copy',
			copied: 'Copied',
			failed: 'Failed',
		},
		window.foaCleanerCopyCode || {}
	);

	const ICON_COPY =
		'<svg class="foa-icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>';

	const ICON_CHECK =
		'<svg class="foa-icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M20 6 9 17l-5-5"/></svg>';

	function copyText( text ) {
		if ( navigator.clipboard && typeof navigator.clipboard.writeText === 'function' ) {
			return navigator.clipboard.writeText( text );
		}

		return new Promise( function ( resolve, reject ) {
			const textarea = document.createElement( 'textarea' );
			textarea.value = text;
			textarea.setAttribute( 'readonly', '' );
			textarea.style.position = 'fixed';
			textarea.style.opacity = '0';
			document.body.appendChild( textarea );
			textarea.select();

			try {
				const ok = document.execCommand( 'copy' );
				document.body.removeChild( textarea );
				if ( ok ) {
					resolve();
				} else {
					reject( new Error( 'Copy failed' ) );
				}
			} catch ( err ) {
				document.body.removeChild( textarea );
				reject( err );
			}
		} );
	}

	function attachCopyButtons() {
		const blocks = document.querySelectorAll( 'pre.wp-block-code' );
		if ( ! blocks.length ) {
			return;
		}

		blocks.forEach( function ( pre ) {
			if ( pre.querySelector( '.foa-copy-code-btn' ) ) {
				return;
			}

			const code = pre.querySelector( 'code' );
			if ( ! code ) {
				return;
			}

			pre.classList.add( 'foa-has-copy-btn' );

			const button = document.createElement( 'button' );
			button.type = 'button';
			button.className = 'foa-copy-code-btn';
			button.setAttribute( 'aria-label', labels.copy );
			button.innerHTML = ICON_COPY + '<span class="foa-copy-code-label"></span>';
			const labelSpan = button.querySelector( '.foa-copy-code-label' );
			labelSpan.textContent = labels.copy;

			let resetTimer = null;

			button.addEventListener( 'click', function () {
				const text = code.innerText || code.textContent || '';

				copyText( text )
					.then( function () {
						button.classList.add( 'is-copied' );
						button.innerHTML = ICON_CHECK + '<span class="foa-copy-code-label"></span>';
						button.querySelector( '.foa-copy-code-label' ).textContent = labels.copied;
						button.setAttribute( 'aria-label', labels.copied );
					} )
					.catch( function () {
						button.querySelector( '.foa-copy-code-label' ).textContent = labels.failed;
					} )
					.finally( function () {
						if ( resetTimer ) {
							window.clearTimeout( resetTimer );
						}
						resetTimer = window.setTimeout( function () {
							button.classList.remove( 'is-copied' );
							button.innerHTML = ICON_COPY + '<span class="foa-copy-code-label"></span>';
							button.querySelector( '.foa-copy-code-label' ).textContent = labels.copy;
							button.setAttribute( 'aria-label', labels.copy );
						}, 1800 );
					} );
			} );

			pre.appendChild( button );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', attachCopyButtons );
	} else {
		attachCopyButtons();
	}
} )();
