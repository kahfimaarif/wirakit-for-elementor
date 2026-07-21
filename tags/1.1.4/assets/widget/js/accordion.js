/* global elementorFrontend */
(function () {
	'use strict';

	function initAccordion(root) {
		if (!root || root.dataset.accordionReady === 'yes') {
			return;
		}
		root.dataset.accordionReady = 'yes';

		var schemaEl = root.querySelector('.wkit-accordion-schema');
		if (schemaEl && !root.dataset.schemaReady) {
			var schemaRaw = schemaEl.getAttribute('data-schema');
			if (schemaRaw) {
				try {
					JSON.parse(schemaRaw);
					var scriptEl = document.createElement('script');
					scriptEl.type = 'application/ld+json';
					scriptEl.textContent = schemaRaw;
					document.head.appendChild(scriptEl);
					root.dataset.schemaReady = 'yes';
				} catch (e) {
					// Ignore invalid schema.
				}
			}
		}

		var items = Array.prototype.slice.call(root.querySelectorAll('.wkit-accordion-item'));
		if (!items.length) {
			return;
		}

		function openItem(item) {
			var header = item.querySelector('.wkit-accordion-header');
			var panel = item.querySelector('.wkit-accordion-body');
			if (!header || !panel) {
				return;
			}
			var content = panel.querySelector('.wkit-accordion-body-inner');
			var targetHeight = content ? content.scrollHeight : panel.scrollHeight;

			item.classList.add('is-active');
			header.setAttribute('aria-expanded', 'true');
			panel.dataset.open = 'true';
			panel.style.maxHeight = targetHeight + 'px';
			panel.style.opacity = '1';
		}

		function closeItem(item) {
			var header = item.querySelector('.wkit-accordion-header');
			var panel = item.querySelector('.wkit-accordion-body');
			if (!header || !panel) {
				return;
			}
			var content = panel.querySelector('.wkit-accordion-body-inner');
			var currentHeight = content ? content.scrollHeight : panel.scrollHeight;

			item.classList.remove('is-active');
			header.setAttribute('aria-expanded', 'false');
			panel.dataset.open = 'false';
			panel.style.maxHeight = currentHeight + 'px';
			panel.style.opacity = '1';
			panel.offsetHeight;
			panel.style.maxHeight = '0px';
			panel.style.opacity = '0';
		}

		function syncPanelHeight(item) {
			if (!item.classList.contains('is-active')) {
				return;
			}
			var panel = item.querySelector('.wkit-accordion-body');
			var content = panel ? panel.querySelector('.wkit-accordion-body-inner') : null;
			if (!panel || !content) {
				return;
			}
			panel.style.maxHeight = content.scrollHeight + 'px';
		}

		items.forEach(function (item) {
			var header = item.querySelector('.wkit-accordion-header');
			if (!header) {
				return;
			}

			header.addEventListener('click', function () {
				var isActive = item.classList.contains('is-active');
				items.forEach(function (otherItem) {
					if (otherItem !== item) {
						closeItem(otherItem);
					}
				});

				if (isActive) {
					closeItem(item);
				} else {
					openItem(item);
				}
			});
		});

		items.forEach(function (item) {
			if (item.classList.contains('is-active')) {
				openItem(item);
			} else {
				closeItem(item);
			}
		});

		window.addEventListener('resize', function () {
			items.forEach(syncPanelHeight);
		});
	}

	function initAll(scope) {
		var container = scope || document;
		var accordions = container.querySelectorAll('.wkit-accordion');
		accordions.forEach(initAccordion);
	}

	document.addEventListener('DOMContentLoaded', function () {
		initAll(document);
	});

	function registerElementorHook() {
		if (window.elementorFrontend && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/wira_elementor_kit_accordion.default',
				function ($scope) {
					if ($scope && $scope[0]) {
						initAll($scope[0]);
					}
				}
			);
		}
	}

	registerElementorHook();
	window.addEventListener('elementor/frontend/init', registerElementorHook);
})();
