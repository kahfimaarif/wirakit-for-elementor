(function () {
    "use strict";

    function cleanInvisible(root) {
        if (!root || !root.querySelectorAll) return;
        var nodes = root.querySelectorAll(".elementor-invisible");
        if (!nodes.length) return;
        nodes.forEach(function (node) {
            node.classList.remove("elementor-invisible");
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (!document.body || !document.body.classList.contains("elementor-editor-active")) {
            return;
        }
        var blocks = document.querySelectorAll(".wkit-block-template-content");
        blocks.forEach(cleanInvisible);
    });
})();
