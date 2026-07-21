(function () {
    "use strict";

    function initBackToTop(wrap) {
        if (!wrap) return;
        if (wrap.dataset && wrap.dataset.wkitInit === "1") return;
        if (wrap.dataset) wrap.dataset.wkitInit = "1";

        var button = wrap.querySelector(".wkit-back-to-top-btn");
        if (!button) return;

        var isAutoHide = wrap.classList.contains("is-auto-hide");
        var offset = parseInt(wrap.getAttribute("data-offset"), 10);
        if (Number.isNaN(offset)) offset = 200;

        function toggleVisibility() {
            if (!isAutoHide) return;
            if (window.pageYOffset > offset) {
                wrap.classList.add("is-visible");
            } else {
                wrap.classList.remove("is-visible");
            }
        }

        button.addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });

        if (isAutoHide) {
            toggleVisibility();
            window.addEventListener("scroll", toggleVisibility, { passive: true });
        }
    }

    function initBackToTopInScope(scope) {
        var root = scope || document;
        var nodes = root.querySelectorAll(".wkit-back-to-top-wrap");
        nodes.forEach(initBackToTop);
    }

    document.addEventListener("DOMContentLoaded", function () {
        initBackToTopInScope(document);
    });

    if (window.elementorFrontend && window.elementorFrontend.hooks) {
        window.elementorFrontend.hooks.addAction(
            "frontend/element_ready/wira_elementor_kit_back_to_top.default",
            function ($scope) {
                initBackToTopInScope($scope[0]);
            }
        );
    }
})();