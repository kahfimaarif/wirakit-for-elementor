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
        const type = $wrapper.data("paginationType");
        if (!type) return;

        const $items = $wrapper.find(".wkit-dynamic-items").first();
        const $button = $wrapper.find(".wkit-load-more");
        const $sentinel = $wrapper.find(".wkit-load-more-sentinel");

        let currentPage = parseInt($wrapper.data("currentPage"), 10) || 1;
        let maxPages = parseInt($wrapper.data("maxPages"), 10) || 1;
        let isLoading = false;

        const widget = $wrapper.data("widget");
        const query = parseJson($wrapper.attr("data-query")) || {};
        const settings = parseJson($wrapper.attr("data-settings")) || {};

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
                    $items.append(resp.data.html);
                    currentPage = resp.data.current_page || (currentPage + 1);
                    maxPages = resp.data.max_pages || maxPages;
                }
            }).always(function () {
                isLoading = false;
                $wrapper.removeClass("is-loading");
                updateState();
            });
        }

        if (type === "ajax_load_more") {
            $button.on("click", function (e) {
                e.preventDefault();
                loadNextPage();
            });
        }

        if (type === "infinite_scroll") {
            $button.hide();

            if ("IntersectionObserver" in window && $sentinel.length) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            loadNextPage();
                        }
                    });
                }, { rootMargin: "200px 0px" });

                observer.observe($sentinel[0]);
            } else {
                $(window).on("scroll.wira_elementor_kitPagination", function () {
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

    $(".wkit-dynamic-pagination").each(function () {
        initPagination($(this));
    });
});

