(function () {
    "use strict";

    function initCountdown(wrap) {
        if (!wrap) return;

        var endTs = parseInt(wrap.getAttribute("data-end"), 10);
        if (!endTs) return;

        var countdown = wrap.querySelector(".wkit-countdown");
        var expired = wrap.querySelector(".wkit-countdown-expired");

        var elements = {
            days: wrap.querySelector('[data-unit="days"] .wkit-countdown-number'),
            hours: wrap.querySelector('[data-unit="hours"] .wkit-countdown-number'),
            minutes: wrap.querySelector('[data-unit="minutes"] .wkit-countdown-number'),
            seconds: wrap.querySelector('[data-unit="seconds"] .wkit-countdown-number'),
        };

        function pad(num) {
            return String(num).padStart(2, "0");
        }

        function render() {
            var now = Math.floor(Date.now() / 1000);
            var diff = endTs - now;

            if (diff <= 0) {
                if (countdown) countdown.style.display = "none";
                if (expired) expired.style.display = "block";
                return false;
            }

            var days = Math.floor(diff / 86400);
            var hours = Math.floor((diff % 86400) / 3600);
            var minutes = Math.floor((diff % 3600) / 60);
            var seconds = diff % 60;

            if (elements.days) elements.days.textContent = pad(days);
            if (elements.hours) elements.hours.textContent = pad(hours);
            if (elements.minutes) elements.minutes.textContent = pad(minutes);
            if (elements.seconds) elements.seconds.textContent = pad(seconds);

            return true;
        }

        if (!render()) return;

        var timer = setInterval(function () {
            if (!render()) {
                clearInterval(timer);
            }
        }, 1000);
    }

    function initAllCountdowns(root) {
        var scope = root || document;
        var nodes = scope.querySelectorAll(".wkit-countdown-wrap");
        nodes.forEach(initCountdown);
    }

    document.addEventListener("DOMContentLoaded", function () {
        initAllCountdowns(document);
    });

    if (window.jQuery) {
        jQuery(window).on("elementor/frontend/init", function () {
            if (window.elementorFrontend && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction(
                    "frontend/element_ready/wira_elementor_kit_countdown.default",
                    function ($scope) {
                        initAllCountdowns($scope[0]);
                    }
                );
            }
        });
    }
})();
