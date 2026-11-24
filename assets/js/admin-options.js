/**
 * FoA Cleaner — Recommended Plugins progressive Install → Activate → Active UI.
 *
 * Uses WordPress core `wp.updates.installPlugin` for installation and the
 * theme's nonce-protected `foa_cleaner_activate_plugin` AJAX endpoint for
 * activation. Falls back cleanly to standard WordPress admin URLs if JS fails.
 */
(function () {
	'use strict';

	var config = window.foaCleanerAdmin || {};
	var labels = config.labels || {};

	function setCardState(slug, state, message, isError) {
		var card = document.querySelector('[data-foa-plugin-card="' + slug + '"]');
		if (!card) {
			return;
		}

		var badge = card.querySelector('[data-foa-plugin-badge]');
		var msgEl = card.querySelector('[data-foa-plugin-message]');

		if (badge) {
			badge.classList.remove('is-active', 'is-installed', 'is-optional');
			if (state === 'active') {
				badge.classList.add('is-active');
				badge.textContent = labels.active || 'Active';
			} else if (state === 'installed') {
				badge.classList.add('is-installed');
				badge.textContent = labels.installed || 'Installed';
			} else {
				badge.classList.add('is-optional');
			}
		}

		if (msgEl) {
			msgEl.textContent = message || '';
			msgEl.classList.toggle('is-error', Boolean(isError));
		}
	}

	function syncButtonsForSlug(slug, nextAction, activateUrl) {
		var triggers = document.querySelectorAll('[data-foa-plugin-action][data-slug="' + slug + '"]');
		triggers.forEach(function (el) {
			el.classList.remove('is-busy', 'updating-message');
			el.removeAttribute('aria-disabled');

			if (nextAction === 'activate') {
				el.setAttribute('data-foa-plugin-action', 'activate');
				if (activateUrl) {
					el.setAttribute('href', activateUrl);
				}
				if (el.classList.contains('foa-inline-plugin-action')) {
					el.textContent = labels.activateJp || 'Activate Jetpack';
				} else {
					el.classList.remove('button-secondary');
					el.classList.add('button-primary');
					el.textContent = labels.activate || 'Activate';
				}
			} else if (nextAction === 'active') {
				if (el.classList.contains('foa-inline-plugin-action')) {
					el.remove();
				} else {
					var note = document.createElement('span');
					note.className = 'foa-plugin-active-note';
					note.textContent = labels.activeNote || 'Installed and active.';
					el.replaceWith(note);
				}
			}
		});
	}

	function setBusy(slug, busyText) {
		var triggers = document.querySelectorAll('[data-foa-plugin-action][data-slug="' + slug + '"]');
		triggers.forEach(function (el) {
			el.classList.add('is-busy');
			el.setAttribute('aria-disabled', 'true');
			if (!el.classList.contains('foa-inline-plugin-action')) {
				el.classList.add('updating-message');
			}
			el.textContent = busyText;
		});
	}

	function clearBusy(slug, fallbackText) {
		var triggers = document.querySelectorAll('[data-foa-plugin-action][data-slug="' + slug + '"]');
		triggers.forEach(function (el) {
			el.classList.remove('is-busy', 'updating-message');
			el.removeAttribute('aria-disabled');
			if (fallbackText) {
				el.textContent = fallbackText;
			}
		});
	}

	function handleInstall(trigger, slug) {
		if (!window.wp || !window.wp.updates || typeof window.wp.updates.installPlugin !== 'function') {
			return false;
		}

		var originalText = trigger.textContent;
		setBusy(slug, labels.installing || 'Installing…');
		setCardState(slug, 'optional', '', false);

		window.wp.updates.installPlugin({
			slug: slug,
			success: function (response) {
				setCardState(slug, 'installed', '', false);
				syncButtonsForSlug(slug, 'activate', response && response.activateUrl ? response.activateUrl : '');
			},
			error: function (response) {
				var errMsg = (response && response.errorMessage) ? response.errorMessage : (labels.installError || 'Installation failed.');
				clearBusy(slug, originalText);
				setCardState(slug, 'optional', errMsg, true);
			}
		});

		return true;
	}

	function handleActivate(trigger, slug) {
		if (!config.ajaxUrl || !config.nonce) {
			return false;
		}

		var shouldReload = trigger.getAttribute('data-reload-on-activate') === '1';
		var originalText = trigger.textContent;

		setBusy(slug, labels.activating || 'Activating…');
		setCardState(slug, 'installed', '', false);

		var body = new URLSearchParams();
		body.set('action', 'foa_cleaner_activate_plugin');
		body.set('nonce', config.nonce);
		body.set('slug', slug);

		fetch(config.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: body.toString()
		})
			.then(function (res) {
				return res.json();
			})
			.then(function (json) {
				if (json && json.success) {
					setCardState(slug, 'active', shouldReload ? (labels.reloading || 'Activated. Reloading settings…') : '', false);
					syncButtonsForSlug(slug, 'active');
					if (shouldReload) {
						window.location.reload();
					}
					return;
				}
				var msg = (json && json.data && json.data.message) ? json.data.message : (labels.activateError || 'Activation failed.');
				clearBusy(slug, originalText);
				setCardState(slug, 'installed', msg, true);
			})
			.catch(function () {
				clearBusy(slug, originalText);
				setCardState(slug, 'installed', labels.activateError || 'Activation failed.', true);
			});

		return true;
	}

	document.addEventListener('click', function (event) {
		var trigger = event.target.closest('[data-foa-plugin-action]');
		if (!trigger) {
			return;
		}

		if (trigger.getAttribute('aria-disabled') === 'true') {
			event.preventDefault();
			return;
		}

		var action = trigger.getAttribute('data-foa-plugin-action');
		var slug = trigger.getAttribute('data-slug');
		if (!slug) {
			return;
		}

		var handled = false;
		if (action === 'install') {
			handled = handleInstall(trigger, slug);
		} else if (action === 'activate') {
			handled = handleActivate(trigger, slug);
		}

		if (handled) {
			event.preventDefault();
		}
	});
})();
