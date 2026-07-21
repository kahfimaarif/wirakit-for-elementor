/* global elementorFrontend */
(function () {
	'use strict';

	function initProgress(wrap) {
		if (!wrap || wrap.dataset.progressReady === 'yes') {
			return;
		}
		wrap.dataset.progressReady = 'yes';

		var fill = wrap.querySelector('.wkit-progressbar-fill');
		var percentageEl = wrap.querySelector('[data-progress-percentage]');
		var target = parseInt(wrap.getAttribute('data-target') || '0', 10);
		var duration = parseInt(wrap.getAttribute('data-duration') || '1200', 10);
		var easing = String(wrap.getAttribute('data-easing') || 'easeoutcubic').toLowerCase();

		if (isNaN(target) || target < 0) {
			target = 0;
		}
		if (target > 100) {
			target = 100;
		}
		if (isNaN(duration) || duration < 0) {
			duration = 1200;
		}

		function getEasedProgress(t) {
			var c1 = 1.70158;
			var c2 = c1 * 1.525;
			var c3 = c1 + 1;

			switch (easing) {
				case 'linear':
					return t;
				case 'ease':
					return t < 0.25 ? 8 * t * t * t * t : 1 - Math.pow(-2 * t + 2, 4) / 2;
				case 'easein':
					return t * t;
				case 'easeout':
					return 1 - (1 - t) * (1 - t);
				case 'easeinout':
					return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
				case 'easeinsine':
					return 1 - Math.cos((t * Math.PI) / 2);
				case 'easeoutsine':
					return Math.sin((t * Math.PI) / 2);
				case 'easeinoutsine':
					return -(Math.cos(Math.PI * t) - 1) / 2;
				case 'easeinquad':
					return t * t;
				case 'easeoutquad':
					return 1 - (1 - t) * (1 - t);
				case 'easeinoutquad':
					return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
				case 'easeincubic':
					return t * t * t;
				case 'easeoutcubic':
					return 1 - Math.pow(1 - t, 3);
				case 'easeinoutcubic':
					return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
				case 'easeinquart':
					return t * t * t * t;
				case 'easeoutquart':
					return 1 - Math.pow(1 - t, 4);
				case 'easeinoutquart':
					return t < 0.5 ? 8 * t * t * t * t : 1 - Math.pow(-2 * t + 2, 4) / 2;
				case 'easeinquint':
					return t * t * t * t * t;
				case 'easeoutquint':
					return 1 - Math.pow(1 - t, 5);
				case 'easeinoutquint':
					return t < 0.5 ? 16 * t * t * t * t * t : 1 - Math.pow(-2 * t + 2, 5) / 2;
				case 'easeinexpo':
					return t === 0 ? 0 : Math.pow(2, 10 * t - 10);
				case 'easeoutexpo':
					return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
				case 'easeinoutexpo':
					if (t === 0) {
						return 0;
					}
					if (t === 1) {
						return 1;
					}
					return t < 0.5 ? Math.pow(2, 20 * t - 10) / 2 : (2 - Math.pow(2, -20 * t + 10)) / 2;
				case 'easeincirc':
					return 1 - Math.sqrt(1 - Math.pow(t, 2));
				case 'easeoutcirc':
					return Math.sqrt(1 - Math.pow(t - 1, 2));
				case 'easeinoutcirc':
					return t < 0.5
						? (1 - Math.sqrt(1 - Math.pow(2 * t, 2))) / 2
						: (Math.sqrt(1 - Math.pow(-2 * t + 2, 2)) + 1) / 2;
				case 'easeinback':
					return c3 * t * t * t - c1 * t * t;
				case 'easeoutback':
					return 1 + c3 * Math.pow(t - 1, 3) + c1 * Math.pow(t - 1, 2);
				case 'easeinoutback':
					return t < 0.5
						? (Math.pow(2 * t, 2) * ((c2 + 1) * 2 * t - c2)) / 2
						: (Math.pow(2 * t - 2, 2) * ((c2 + 1) * (t * 2 - 2) + c2) + 2) / 2;
				default:
					return 1 - Math.pow(1 - t, 3);
			}
		}

		function animateProgress() {
			if (wrap.dataset.animated === 'yes') {
				return;
			}
			wrap.dataset.animated = 'yes';
			var start = null;
			if (duration === 0) {
				if (fill) {
					fill.style.width = target + '%';
				}
				if (percentageEl) {
					percentageEl.textContent = target + '%';
				}
				wrap.setAttribute('aria-valuenow', String(target));
				return;
			}

			function step(ts) {
				if (start === null) {
					start = ts;
				}
				var progress = Math.min((ts - start) / duration, 1);
				var eased = getEasedProgress(progress);
				var current = Math.round(target * eased);

				if (fill) {
					fill.style.width = current + '%';
				}
				if (percentageEl) {
					percentageEl.textContent = current + '%';
				}
				wrap.setAttribute('aria-valuenow', String(current));

				if (progress < 1) {
					window.requestAnimationFrame(step);
				}
			}

			window.requestAnimationFrame(step);
		}

		if ('IntersectionObserver' in window) {
			var observer = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						animateProgress();
						observer.disconnect();
					}
				});
			}, { threshold: 0.2 });

			observer.observe(wrap);
		} else {
			animateProgress();
		}
	}

	function initAll(scope) {
		var container = scope || document;
		var bars = container.querySelectorAll('.wkit-progressbar-wrap');
		bars.forEach(initProgress);
	}

	document.addEventListener('DOMContentLoaded', function () {
		initAll(document);
	});

	function registerElementorHook() {
		if (window.elementorFrontend && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/wira_elementor_kit_progress_bar.default',
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
