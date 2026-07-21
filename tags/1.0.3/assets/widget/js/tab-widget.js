/* global elementorFrontend */
(function () {
	'use strict';

	function initTabs(root) {
		if (!root || root.dataset.tabReady === 'yes') {
			return;
		}
		root.dataset.tabReady = 'yes';

		var tabs = Array.prototype.slice.call(root.querySelectorAll('.wkit-tab-nav-item'));
		var panels = Array.prototype.slice.call(root.querySelectorAll('.wkit-tab-panel'));
		var layout = root.querySelector('.wkit-tab-layout');
		var contentWrap = root.querySelector('.wkit-tab-content');
		var descOnly = root.classList.contains('show-desc-active-only');

		if (!tabs.length || !panels.length) {
			return;
		}

		function shouldInlineActivePanel() {
			if (!layout || !contentWrap) {
				return false;
			}
			var isTabletOrMobile = window.matchMedia('(max-width: 1024px)').matches;
			var layoutDirection = window.getComputedStyle(layout).flexDirection;
			return isTabletOrMobile && layoutDirection === 'column';
		}

		function isAnimationDisabled() {
			return window.matchMedia('(max-width: 1024px)').matches;
		}

		function syncPanelPlacement(activeIndex) {
			var inlineMode = shouldInlineActivePanel();
			if (!contentWrap) {
				return;
			}

			contentWrap.style.display = inlineMode ? 'none' : '';

			panels.forEach(function (panel, i) {
				var active = i === activeIndex;
				var tab = tabs[i];

				if (!tab) {
					return;
				}

				if (inlineMode) {
					if (active) {
						tab.insertAdjacentElement('afterend', panel);
					} else if (panel.parentNode !== contentWrap) {
						contentWrap.appendChild(panel);
					}
				} else if (panel.parentNode !== contentWrap) {
					contentWrap.appendChild(panel);
				}
			});
		}

		function activateTab(index) {
			var disableAnim = isAnimationDisabled();
			tabs.forEach(function (tab, i) {
				var active = i === index;
				tab.classList.toggle('is-active', active);
				tab.setAttribute('aria-selected', active ? 'true' : 'false');
			});

			syncPanelPlacement(index);

			panels.forEach(function (panel, i) {
				var active = i === index;
				panel.classList.toggle('is-active', active);
				if (disableAnim) {
					if (active) {
						panel.removeAttribute('hidden');
					} else {
						panel.setAttribute('hidden', '');
					}
					panel.style.maxHeight = '';
					panel.style.opacity = '';
					return;
				}
				panel.removeAttribute('hidden');
				panel.classList.toggle('is-active', active);
				panel.style.maxHeight = active ? panel.scrollHeight + 'px' : '0px';
				panel.style.opacity = active ? '1' : '0';
			});

			if (descOnly) {
				tabs.forEach(function (tab, i) {
					var desc = tab.querySelector('.wkit-tab-nav-desc');
					if (!desc) {
						return;
					}
					var active = i === index;
					desc.style.maxHeight = active ? desc.scrollHeight + 'px' : '0px';
					desc.style.opacity = active ? '1' : '0';
				});
			}
		}

		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () {
				activateTab(i);
			});
		});

		panels.forEach(function (panel) {
			if (isAnimationDisabled()) {
				panel.setAttribute('hidden', '');
				panel.style.maxHeight = '';
				panel.style.opacity = '';
				return;
			}
			panel.removeAttribute('hidden');
			panel.style.maxHeight = '0px';
			panel.style.opacity = '0';
		});

		if (descOnly) {
			tabs.forEach(function (tab) {
				var desc = tab.querySelector('.wkit-tab-nav-desc');
				if (!desc) {
					return;
				}
				desc.style.maxHeight = '0px';
				desc.style.opacity = '0';
			});
		}

		var defaultIndex = 0;
		tabs.forEach(function (tab, i) {
			if (tab.classList.contains('is-active')) {
				defaultIndex = i;
			}
		});
		activateTab(defaultIndex);

		window.addEventListener('resize', function () {
			var currentIndex = 0;
			tabs.forEach(function (tab, i) {
				if (tab.classList.contains('is-active')) {
					currentIndex = i;
				}
			});
			syncPanelPlacement(currentIndex);
			if (!isAnimationDisabled()) {
				panels.forEach(function (panel, i) {
					if (i === currentIndex) {
						panel.style.maxHeight = panel.scrollHeight + 'px';
					}
				});
			} else {
				panels.forEach(function (panel, i) {
					panel.style.maxHeight = '';
					panel.style.opacity = '';
					if (i === currentIndex) {
						panel.removeAttribute('hidden');
					} else {
						panel.setAttribute('hidden', '');
					}
				});
			}
		});
	}

	function initAll(scope) {
		var container = scope || document;
		var widgets = container.querySelectorAll('.wkit-tab-widget');
		widgets.forEach(initTabs);
	}

	document.addEventListener('DOMContentLoaded', function () {
		initAll(document);
	});

	function registerElementorHook() {
		if (window.elementorFrontend && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/wira_elementor_kit_tab_widget.default',
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
