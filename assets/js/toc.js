/**
 * FoA Cleaner — Auto-Generated Table of Contents scroll-spy & responsive state.
 */
(function () {
	'use strict';

	var toc = document.querySelector('[data-foa-toc]');
	if (!toc) {
		return;
	}

	var details = toc.querySelector('.foa-toc__details');
	var links = Array.prototype.slice.call(toc.querySelectorAll('[data-foa-toc-link]'));
	if (!links.length) {
		return;
	}

	var desktopQuery = window.matchMedia ? window.matchMedia('(min-width: 1280px)') : null;

	function syncDetailsOpen() {
		if (!details || !desktopQuery) {
			return;
		}
		if (desktopQuery.matches) {
			details.setAttribute('open', '');
		} else {
			details.removeAttribute('open');
		}
	}

	syncDetailsOpen();
	if (desktopQuery && typeof desktopQuery.addEventListener === 'function') {
		desktopQuery.addEventListener('change', syncDetailsOpen);
	}

	var targets = [];
	var linkById = Object.create(null);

	links.forEach(function (link) {
		var id = link.getAttribute('data-foa-toc-link');
		if (!id) {
			return;
		}
		var el = document.getElementById(id);
		if (el) {
			targets.push(el);
			linkById[id] = link;
		}
	});

	if (!targets.length) {
		return;
	}

	var activeId = '';

	function setActive(id) {
		if (!id || id === activeId || !linkById[id]) {
			return;
		}
		activeId = id;
		links.forEach(function (link) {
			var isCurrent = link.getAttribute('data-foa-toc-link') === id;
			link.classList.toggle('is-active', isCurrent);
			if (isCurrent) {
				link.setAttribute('aria-current', 'location');
			} else {
				link.removeAttribute('aria-current');
			}
		});
	}

	// Highlight first section initially.
	setActive(targets[0].id);

	if ('IntersectionObserver' in window) {
		var visible = Object.create(null);
		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					visible[entry.target.id] = entry.isIntersecting;
				});

				for (var i = 0; i < targets.length; i++) {
					if (visible[targets[i].id]) {
						setActive(targets[i].id);
						return;
					}
				}

				// Fallback to the last heading scrolled past the top offset.
				var current = targets[0].id;
				for (var j = 0; j < targets.length; j++) {
					if (targets[j].getBoundingClientRect().top <= 140) {
						current = targets[j].id;
					} else {
						break;
					}
				}
				setActive(current);
			},
			{
				rootMargin: '-96px 0px -65% 0px',
				threshold: 0
			}
		);

		targets.forEach(function (el) {
			observer.observe(el);
		});
	}
})();
