/* global elementorFrontend */
(function () {
	'use strict';

	function initPortfolio(root) {
		if (!root || root.dataset.portfolioReady === 'yes') {
			return;
		}
		root.dataset.portfolioReady = 'yes';

		var tabs = Array.prototype.slice.call(root.querySelectorAll('.wkit-portfolio-tab'));
		var items = Array.prototype.slice.call(root.querySelectorAll('.wkit-portfolio-item'));

		if (!tabs.length || !items.length) {
			return;
		}

		function activateTab(tabEl) {
			var activeCategory = tabEl.getAttribute('data-category') || 'all';

			tabs.forEach(function (tab) {
				var isActive = tab === tabEl;
				tab.classList.toggle('is-active', isActive);
				tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
			});

			items.forEach(function (item) {
				var itemCategory = item.getAttribute('data-category') || '';
				var shouldShow = activeCategory === 'all' || itemCategory === activeCategory;
				item.classList.toggle('is-hidden', !shouldShow);
			});
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				activateTab(tab);
			});
		});

		activateTab(tabs[0]);
	}

	function initAll(scope) {
		var container = scope || document;
		var portfolios = container.querySelectorAll('.wkit-portfolio-gallery-wrap');
		portfolios.forEach(initPortfolio);
	}

	document.addEventListener('DOMContentLoaded', function () {
		initAll(document);
	});

	function registerElementorHook() {
		if (window.elementorFrontend && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/wira_elementor_kit_portfolio_gallery.default',
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
