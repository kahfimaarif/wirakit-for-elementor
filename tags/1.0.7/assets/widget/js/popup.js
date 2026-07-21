(function () {
    "use strict";

    if (window.WKIT_Popup_Bound) {
        return;
    }
    window.WKIT_Popup_Bound = true;

    var modal = null;
    var contentEl = null;
    var closeBtn = null;
    var overlay = null;
    var inlineSource = null;
    var inlinePlaceholder = null;

    function buildModal() {
        if (modal) return;

        modal = document.createElement("div");
        modal.className = "wkit-popup-modal";

        overlay = document.createElement("div");
        overlay.className = "wkit-popup-overlay";

        contentEl = document.createElement("div");
        contentEl.className = "wkit-popup-content";

        closeBtn = document.createElement("button");
        closeBtn.type = "button";
        closeBtn.className = "wkit-popup-close";
        closeBtn.setAttribute("aria-label", "Close");
        closeBtn.innerHTML = "&times;";

        contentEl.appendChild(closeBtn);
        modal.appendChild(overlay);
        modal.appendChild(contentEl);
        document.body.appendChild(modal);

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") closePopup();
        });
    }

    function closePopup() {
        if (!modal) return;
        modal.classList.remove("is-open");
        modal.classList.add("is-closing");
        document.body.classList.remove("wkit-popup-open");

        // Restore inline content to its original place if it was moved.
        if (inlineSource && inlinePlaceholder && inlinePlaceholder.parentNode) {
            inlineSource.classList.add("wkit-popup-hide");
            inlinePlaceholder.parentNode.insertBefore(inlineSource, inlinePlaceholder);
            inlinePlaceholder.parentNode.removeChild(inlinePlaceholder);
        }
        inlineSource = null;
        inlinePlaceholder = null;

        // Remove modal from DOM after close animation
        setTimeout(function () {
            if (modal && modal.parentNode) {
                modal.parentNode.removeChild(modal);
            }
            modal = null;
            contentEl = null;
            closeBtn = null;
            overlay = null;
        }, 320);
    }

    function openPopup(options) {
        buildModal();
        var animClass = options.animClass || "wkit-slide-down";
        var dataId = options.dataId || "";

        modal.className = "wkit-popup-modal " + animClass + (dataId ? " " + dataId : "");
        document.body.classList.add("wkit-popup-open");

        // Force reflow so animation restarts on repeated opens
        void modal.offsetHeight;

        // Let the browser paint initial state before toggling is-open (for transitions)
        requestAnimationFrame(function () {
            modal.classList.add("is-open");
        });

        while (contentEl.childNodes.length > 1) {
            contentEl.removeChild(contentEl.lastChild);
        }

        if (options.type === "inline") {
            var target = options.target || "";
            var hashIndex = target.indexOf("#");
            if (hashIndex !== -1) {
                target = target.slice(hashIndex);
            }
            if (target && target.charAt(0) !== "#") {
                target = "#" + target;
            }
            var source = target ? document.querySelector(target) : null;
            if (!source && target) {
                source = document.getElementById(target.replace("#", ""));
            }
            if (source) {
                inlineSource = source;
                inlinePlaceholder = document.createElement("span");
                inlinePlaceholder.style.display = "none";
                source.parentNode.insertBefore(inlinePlaceholder, source);
                source.classList.remove("wkit-popup-hide");
                contentEl.appendChild(source);
            } else {
                var missing = document.createElement("div");
                missing.className = "wkit-popup-empty";
                missing.textContent = "Popup content not found.";
                contentEl.appendChild(missing);
            }
        } else if (options.type === "iframe") {
            var iframe = document.createElement("iframe");
            iframe.src = normalizeIframeUrl(options.url);
            iframe.setAttribute("allowfullscreen", "");
            iframe.setAttribute("loading", "lazy");
            contentEl.appendChild(iframe);
        }
    }

    function normalizeIframeUrl(url) {
        if (!url) return "";

        // YouTube
        var ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtube\.com\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]+)/);
        if (ytMatch && ytMatch[1]) {
            return "https://www.youtube.com/embed/" + ytMatch[1] + "?autoplay=1";
        }

        // Vimeo
        var vimeoMatch = url.match(/vimeo\.com\/([0-9]+)/);
        if (vimeoMatch && vimeoMatch[1]) {
            return "https://player.vimeo.com/video/" + vimeoMatch[1] + "?autoplay=1";
        }

        // Google Maps embed
        if (url.indexOf("google.com/maps") !== -1 && url.indexOf("/embed?") === -1) {
            return url;
        }

        return url;
    }

    function handleClick(e) {
        var closeTarget = e.target.closest(".wkit-popup-close, .wkit-popup-overlay");
        if (closeTarget) {
            e.preventDefault();
            closePopup();
            return;
        }

        var btn = e.target.closest(".wkit-popup-btn");
        if (btn) {
            e.preventDefault();
            var target = btn.getAttribute("href");
            var animClass = btn.getAttribute("data-anim") || "wkit-slide-down";
            var dataId = btn.getAttribute("data-id") || "";
            if (!target) return;
            openPopup({
                type: "inline",
                target: target,
                animClass: animClass,
                dataId: dataId
            });
            return;
        }

        var iframeBtn = e.target.closest(".wkit-popup-video");
        if (iframeBtn) {
            e.preventDefault();
            var url = iframeBtn.getAttribute("href");
            var animClassIframe = iframeBtn.getAttribute("data-anim") || "wkit-fade";
            var dataIdIframe = iframeBtn.getAttribute("data-id") || "";
            if (!url) return;
            openPopup({
                type: "iframe",
                url: url,
                animClass: animClassIframe,
                dataId: dataIdIframe
            });
        }
    }

    document.addEventListener("click", handleClick, true);

    if (window.elementorFrontend && window.elementorFrontend.hooks) {
        window.elementorFrontend.hooks.addAction(
            "frontend/element_ready/wira_elementor_kit_popup.default",
            function () {
                // no-op: delegation handles dynamic content
            }
        );
        window.elementorFrontend.hooks.addAction(
            "frontend/element_ready/wira_elementor_kit_cmb2_video.default",
            function () {
                // no-op: delegation handles dynamic content
            }
        );
    }
})();
