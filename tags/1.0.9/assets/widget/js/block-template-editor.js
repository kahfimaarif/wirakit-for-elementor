jQuery(function ($) {
    "use strict";

    if (typeof elementor === "undefined" || !elementor.hooks) return;

    let currentElementModel = null;
    let currentControlView = null;

    function ensureOverlayStyles(rootDoc) {
        if (!rootDoc) return;
        if (rootDoc.getElementById("wkit-block-template-overlay-style")) return;
        const style = rootDoc.createElement("style");
        style.id = "wkit-block-template-overlay-style";
        style.textContent = [
            ".wkit-block-template-overlay{position:fixed;padding:20px;inset:0;z-index:999999;background:rgba(0,0,0,.6);display:flex;align-items:stretch;justify-content:stretch;}",
            ".wkit-block-template-overlay.is-hidden{display:none;}",
            ".wkit-block-template-overlay__panel{position:relative;width:100%;height:100%;background:#111;}",
            ".wkit-block-template-overlay__iframe{width:100%;height:100%;border:0;background:#fff;}",
            ".elementor-device-desktop #elementor-preview-responsive-wrapper{min-width: auto !important;}",
        ].join("");
        if (rootDoc.head) {
            rootDoc.head.appendChild(style);
        } else if (rootDoc.documentElement) {
            rootDoc.documentElement.appendChild(style);
        }
    }

    function getOverlay() {
        let rootDoc = document;
        try {
            if (window.top && window.top.document) {
                rootDoc = window.top.document;
            }
        } catch (e) {
            rootDoc = document;
        }

        let overlay = rootDoc.querySelector(".wkit-block-template-overlay");
        if (!overlay) {
            ensureOverlayStyles(rootDoc);
            overlay = rootDoc.createElement("div");
            overlay.className = "wkit-block-template-overlay is-hidden";
            overlay.innerHTML =
                '<div class="wkit-block-template-overlay__panel">' +
                '<div class="dialog-header dialog-lightbox-header">' +
                '<div class="elementor-templates-modal__header">' +
                '<div class="elementor-templates-modal__header__logo-area">' +
                '<div class="elementor-templates-modal__header__logo">' +
                '<span class="elementor-templates-modal__header__logo__icon-wrapper">' +
                '<i class="eicon-elementor"></i>' +
                "</span>" +
                '<span class="elementor-templates-modal__header__logo__title">Block Component</span>' +
                "</div>" +
                "</div>" +
                '<div class="elementor-templates-modal__header__items-area">' +
                '<div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--normal elementor-templates-modal__header__item wkit-block-template-overlay__close" role="button" tabindex="0">' +
                '<i class="eicon-close" aria-hidden="true" title="Close"></i>' +
                '<span class="elementor-screen-only">Close</span>' +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                '<iframe class="wkit-block-template-overlay__iframe" src="about:blank"></iframe>' +
                "</div>";
            const insertOverlayAsFirstChild = function () {
                if (!rootDoc.body) return;
                if (rootDoc.body.firstChild) {
                    rootDoc.body.insertBefore(overlay, rootDoc.body.firstChild);
                } else {
                    rootDoc.body.appendChild(overlay);
                }
            };

            if (rootDoc.body && rootDoc.body.classList.contains("elementor-editor-active")) {
                insertOverlayAsFirstChild();
            } else if (rootDoc.body) {
                const observer = new MutationObserver(function (mutations) {
                    for (const mutation of mutations) {
                        if (
                            mutation.type === "attributes" &&
                            mutation.attributeName === "class" &&
                            rootDoc.body.classList.contains("elementor-editor-active")
                        ) {
                            insertOverlayAsFirstChild();
                            observer.disconnect();
                            break;
                        }
                    }
                });
                observer.observe(rootDoc.body, { attributes: true, attributeFilter: ["class"] });
            }
        }
        return overlay;
    }

    function openEditorModal(url) {
        const overlay = getOverlay();
        const iframe = overlay.querySelector(".wkit-block-template-overlay__iframe");
        const closeBtn = overlay.querySelector(".wkit-block-template-overlay__close");

        function injectIframeStyles() {
            try {
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                if (!doc || doc.getElementById("wkit-block-template-iframe-style")) return;
                const style = doc.createElement("style");
                style.id = "wkit-block-template-iframe-style";
                style.textContent =
                    ".elementor-device-desktop #elementor-preview-responsive-wrapper{min-width:auto !important;}";
                if (doc.head) {
                    doc.head.appendChild(style);
                } else if (doc.documentElement) {
                    doc.documentElement.appendChild(style);
                }
            } catch (e) {}
        }

        function refreshBlockTemplateWidget() {
            try {
                const key = "blocks_template";
                if (currentControlView && typeof currentControlView.setValue === "function") {
                    const value = currentControlView.getControlValue
                        ? currentControlView.getControlValue()
                        : currentElementModel && currentElementModel.get
                        ? currentElementModel.get("settings").get(key)
                        : "";
                    const tempValue = value ? "" : "0";
                    currentControlView.setValue(tempValue);
                    currentControlView.setValue(value);
                    if (typeof currentControlView.render === "function") {
                        currentControlView.render();
                    }
                    return;
                }

                if (!currentElementModel || typeof currentElementModel.get !== "function") return;
                const settings = currentElementModel.get("settings");
                if (!settings || typeof settings.get !== "function" || typeof settings.set !== "function") return;

                const value = settings.get(key);
                const tempValue = value ? "" : "0";
                settings.set(key, tempValue);
                settings.set(key, value);
                if (typeof settings.trigger === "function") {
                    settings.trigger("change:" + key);
                    settings.trigger("change");
                }
            } catch (e) {}
        }

        iframe.addEventListener("load", injectIframeStyles);
        iframe.src = url;
        overlay.classList.remove("is-hidden");

        function closeOverlay() {
            overlay.classList.add("is-hidden");
            iframe.src = "about:blank";
            refreshBlockTemplateWidget();
        }

        closeBtn.onclick = closeOverlay;
        overlay.onclick = function (e) {
            if (e.target === overlay) closeOverlay();
        };

        document.addEventListener(
            "keydown",
            function onKey(e) {
                if (e.key === "Escape") {
                    closeOverlay();
                    document.removeEventListener("keydown", onKey);
                }
            }
        );
    }

    function initPanel($panel, panelView) {
        const $wrap = $panel.find(".wkit-edit-block-template-wrap");
        if (!$wrap.length) return;

        if (panelView && panelView.model) {
            currentElementModel = panelView.model;
        }
        if (panelView && typeof panelView.getCurrentPageView === "function") {
            const pageView = panelView.getCurrentPageView();
            if (pageView && typeof pageView.getControlViewByName === "function") {
                currentControlView = pageView.getControlViewByName("blocks_template");
            }
        }

        const editBase = $wrap.data("editBase");
        const $control = $panel.find('[data-setting="blocks_template"]');
        const $select = $control.find("select");
        const $button = $wrap.find(".wkit-edit-block-template");

        function getSelectedId() {
            return ($control.val && $control.val()) || $select.val();
        }

        function updateState() {
            const id = getSelectedId();
            $button.prop("disabled", !id);
        }

        $button.off("click.wira_elementor_kit").on("click.wira_elementor_kit", function (e) {
            e.preventDefault();
            const id = getSelectedId();
            if (!id) return;
            openEditorModal(editBase + id);
        });

        $control.off("change.wira_elementor_kit").on("change.wira_elementor_kit", updateState);
        $select.off("change.wira_elementor_kit").on("change.wira_elementor_kit", updateState);
        updateState();
        setTimeout(updateState, 100);
    }

    elementor.hooks.addAction("panel/open_editor/widget/wira_elementor_kit_block_template", function (panel) {
        initPanel(panel.$el, panel);
    });
});

