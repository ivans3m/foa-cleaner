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

	/* ----------------------------------------------------------------------
	 * Create CV Page Modal, Upload, Publish & Delete Actions
	 * ---------------------------------------------------------------------- */
	var cvModal = document.getElementById('foa-cv-upload-modal');
	var cvForm = document.querySelector('[data-foa-cv-upload-form]');
	var cvModalMsg = document.querySelector('[data-foa-cv-modal-message]');
	var cvPanelMsg = document.querySelector('[data-foa-cv-panel-message]');

	function setCvMsg(el, text, isError) {
		if (!el) {
			return;
		}
		el.textContent = text || '';
		el.classList.toggle('is-error', Boolean(isError));
	}

	if (cvModal) {
		// Close when clicking the native <dialog> backdrop.
		cvModal.addEventListener('click', function (event) {
			if (event.target === cvModal) {
				cvModal.close();
			}
		});
	}

	document.addEventListener('click', function (event) {
		if (event.target.closest('[data-foa-cv-open-modal]') && cvModal) {
			setCvMsg(cvModalMsg, '', false);
			if (cvForm) {
				cvForm.reset();
			}
			cvModal.showModal();
			return;
		}

		if (event.target.closest('[data-foa-cv-close-modal]') && cvModal) {
			cvModal.close();
			return;
		}

		var publishBtn = event.target.closest('[data-foa-cv-publish]');
		if (publishBtn) {
			var pubId = publishBtn.getAttribute('data-page-id');
			if (!pubId || !config.ajaxUrl || !config.cvNonce) {
				return;
			}
			publishBtn.disabled = true;
			publishBtn.textContent = labels.cvPublishing || 'Publishing…';
			setCvMsg(cvPanelMsg, '', false);

			var pubBody = new URLSearchParams();
			pubBody.set('action', 'foa_cleaner_publish_cv_page');
			pubBody.set('nonce', config.cvNonce);
			pubBody.set('page_id', pubId);

			fetch(config.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: pubBody.toString()
			})
				.then(function (res) { return res.json(); })
				.then(function (json) {
					if (json && json.success) {
						var badge = document.querySelector('[data-foa-cv-status-badge]');
						if (badge) {
							badge.classList.remove('is-draft');
							badge.classList.add('is-active');
							badge.textContent = labels.cvPublished || 'Published';
						}
						var viewLink = document.querySelector('[data-foa-cv-view-link]');
						if (viewLink && json.data && json.data.viewUrl) {
							viewLink.setAttribute('href', json.data.viewUrl);
							viewLink.textContent = labels.cvView || 'View';
						}
						publishBtn.remove();
						return;
					}
					publishBtn.disabled = false;
					publishBtn.textContent = labels.cvPublish || 'Publish';
					setCvMsg(cvPanelMsg, (json && json.data && json.data.message) || labels.cvPublishError || 'Could not publish.', true);
				})
				.catch(function () {
					publishBtn.disabled = false;
					publishBtn.textContent = labels.cvPublish || 'Publish';
					setCvMsg(cvPanelMsg, labels.cvPublishError || 'Could not publish.', true);
				});
			return;
		}

		var deleteBtn = event.target.closest('[data-foa-cv-delete]');
		if (deleteBtn) {
			var delId = deleteBtn.getAttribute('data-page-id');
			if (!delId || !config.ajaxUrl || !config.cvNonce) {
				return;
			}
			if (!window.confirm(labels.cvDeleteConfirm || 'Move this CV page to Trash?')) {
				return;
			}

			deleteBtn.disabled = true;
			deleteBtn.textContent = labels.cvDeleting || 'Moving to Trash…';
			setCvMsg(cvPanelMsg, '', false);

			var delBody = new URLSearchParams();
			delBody.set('action', 'foa_cleaner_delete_cv_page');
			delBody.set('nonce', config.cvNonce);
			delBody.set('page_id', delId);

			fetch(config.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: delBody.toString()
			})
				.then(function (res) { return res.json(); })
				.then(function (json) {
					if (json && json.success) {
						window.location.reload();
						return;
					}
					deleteBtn.disabled = false;
					deleteBtn.textContent = labels.cvDelete || 'Delete';
					setCvMsg(cvPanelMsg, (json && json.data && json.data.message) || labels.cvDeleteError || 'Could not delete.', true);
				})
				.catch(function () {
					deleteBtn.disabled = false;
					deleteBtn.textContent = labels.cvDelete || 'Delete';
					setCvMsg(cvPanelMsg, labels.cvDeleteError || 'Could not delete.', true);
				});
		}
	});

	if (cvForm) {
		cvForm.addEventListener('submit', function (event) {
			event.preventDefault();
			if (!config.ajaxUrl || !config.cvNonce) {
				return;
			}

			var submitBtn = cvForm.querySelector('[data-foa-cv-submit]');
			var formData = new FormData(cvForm);
			formData.append('action', 'foa_cleaner_create_cv_page');
			formData.append('nonce', config.cvNonce);

			if (submitBtn) {
				submitBtn.disabled = true;
				submitBtn.textContent = labels.cvCreating || 'Creating Draft…';
			}
			setCvMsg(cvModalMsg, '', false);

			fetch(config.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: formData
			})
				.then(function (res) { return res.json(); })
				.then(function (json) {
					if (json && json.success) {
						if (cvModal) {
							cvModal.close();
						}
						window.location.reload();
						return;
					}
					if (submitBtn) {
						submitBtn.disabled = false;
						submitBtn.textContent = labels.cvCreateSubmit || 'Create Draft CV Page';
					}
					setCvMsg(cvModalMsg, (json && json.data && json.data.message) || labels.cvCreateError || 'Upload failed.', true);
				})
				.catch(function () {
					if (submitBtn) {
						submitBtn.disabled = false;
						submitBtn.textContent = labels.cvCreateSubmit || 'Create Draft CV Page';
					}
					setCvMsg(cvModalMsg, labels.cvCreateError || 'Upload failed.', true);
				});
		});
	}
})();
