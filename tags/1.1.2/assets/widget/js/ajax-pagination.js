jQuery(function ($) {
    "use strict";

    if (typeof wiraElementorKitAjax === "undefined") return;

    function parseJson(value) {
        if (!value) return null;
        try {
            return JSON.parse(value);
        } catch (e) {
            return null;
        }
    }

    function initPagination($wrapper) {
        if (!$wrapper || !$wrapper.length) return;
        if ($wrapper.data("wkitPaginationInit")) return;
        $wrapper.data("wkitPaginationInit", true);

        const type = $wrapper.data("paginationType");
        if (!type) return;

        const $items = $wrapper.find(".wkit-dynamic-items").first();
        const $button = $wrapper.find(".wkit-load-more");
        const $sentinel = $wrapper.find(".wkit-load-more-sentinel");

        let currentPage = parseInt($wrapper.data("currentPage"), 10) || 1;
        let maxPages = parseInt($wrapper.data("maxPages"), 10) || 1;
        let isLoading = false;

        // Infinite scroll state.
        let infiniteEntryIsIntersecting = false;
        let infiniteArmed = false;
        let lastInfiniteLoadScrollTop = -1;

        const widget = $wrapper.data("widget");
        const query = parseJson($wrapper.attr("data-query")) || {};
        const settings = parseJson($wrapper.attr("data-settings")) || {};

        function ensureSpinner() {
            if (!$button.length) return;
            if ($button.find(".wkit-btn-spinner").length) return;
            $button.append('<span class="wkit-btn-spinner" aria-hidden="true"></span>');
        }

        function setBusy(busy) {
            if (!$button.length) return;
            $button.prop("disabled", !!busy);
            $button.toggleClass("is-loading", !!busy);
            $button.attr("aria-busy", busy ? "true" : "false");
            ensureSpinner();
        }

        function updateState() {
            $wrapper.attr("data-current-page", currentPage);

            if (currentPage >= maxPages) {
                $wrapper.addClass("is-end");
                $button.hide();
            } else {
                $wrapper.removeClass("is-end");
                if (type === "ajax_load_more") {
                    $button.show();
                }
            }
        }

        function loadNextPage() {
            if (isLoading || currentPage >= maxPages) return;

            isLoading = true;
            $wrapper.addClass("is-loading");
            setBusy(true);

            $.ajax({
                url: wiraElementorKitAjax.ajaxUrl,
                method: "POST",
                data: {
                    action: "Wirakit_load_more",
                    nonce: wiraElementorKitAjax.nonce,
                    page: currentPage + 1,
                    widget: widget,
                    query: JSON.stringify(query),
                    settings: JSON.stringify(settings),
                },
            }).done(function (resp) {
                if (resp && resp.success && resp.data && resp.data.html) {
                    const html = (resp.data.html || "").toString();
                    if (html.trim().length > 0) {
                        $items.append(html);
                    }
                    currentPage = resp.data.current_page || (currentPage + 1);
                    maxPages = resp.data.max_pages || maxPages;
                } else if (resp && resp.success && resp.data) {
                    // Prevent repeated infinite requests if API responds without HTML for any reason.
                    currentPage = maxPages;
                }
            }).always(function () {
                isLoading = false;
                $wrapper.removeClass("is-loading");
                setBusy(false);
                updateState();
            });
        }

        function maybeInfiniteLoad() {
            if (type !== "infinite_scroll") return;
            if (!infiniteArmed) return;
            if (!infiniteEntryIsIntersecting) return;
            if (isLoading || currentPage >= maxPages) return;

            // Load at most once per scroll position (prevents "load all" on initial render).
            const st = $(window).scrollTop() || 0;
            if (st === lastInfiniteLoadScrollTop) return;
            lastInfiniteLoadScrollTop = st;

            loadNextPage();
        }

        if (type === "ajax_load_more") {
            ensureSpinner();
            $button.on("click", function (e) {
                e.preventDefault();
                loadNextPage();
            });
        }

        if (type === "infinite_scroll") {
            $button.hide();

            // Arm only after the user scrolls (prevents auto-load on initial render).
            $(window).on("scroll.wkitPaginationInfinite", function () {
                infiniteArmed = true;
                maybeInfiniteLoad();
            });

            if ("IntersectionObserver" in window && $sentinel.length) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        infiniteEntryIsIntersecting = !!entry.isIntersecting;
                        if (entry.isIntersecting) {
                            maybeInfiniteLoad();
                        }
                    });
                }, { rootMargin: "200px 0px" });

                observer.observe($sentinel[0]);
            } else {
                $(window).on("scroll.wira_elementor_kitPagination", function () {
                    infiniteArmed = true;
                    if (isLoading || currentPage >= maxPages) return;
                    const triggerPoint = $wrapper.offset().top + $wrapper.outerHeight() - 300;
                    if ($(window).scrollTop() + $(window).height() >= triggerPoint) {
                        loadNextPage();
                    }
                });
            }
        }

        updateState();
    }

    function initAll(root) {
        const $root = root ? $(root) : $(document);
        $root.find(".wkit-dynamic-pagination").each(function () {
            initPagination($(this));
        });
    }

    // Normal page load.
    initAll(document);

    // Elementor frontend/editor can inject widgets after DOM ready.
    $(window).on("elementor/frontend/init", function () {
        if (typeof elementorFrontend === "undefined" || !elementorFrontend.hooks) return;
        elementorFrontend.hooks.addAction("frontend/element_ready/global", function ($scope) {
            initAll($scope);
        });
    });
});
