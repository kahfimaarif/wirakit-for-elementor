(function($) {
    $(window).on('elementor:init', function() {
        elementor.on('panel:init', function() {
            
            function addWiraElementorKitClass() {
                $('.elementor-element-wrapper').each(function() {
                    const $wrapper = $(this);
                    const title = $wrapper.find('.title').text();

                    if (title.startsWith('Wkit -')) {
                        $wrapper.addClass('wira-kit-for-elementor');

                        if ($wrapper.find('.wkit-badge-wkit').length === 0) {
                            const badge = $('<span class="wkit-badge wkit-badge-wkit">wkit</span>');
                            $wrapper.css('position', 'relative');
                            $wrapper.append(badge);
                        }
                    }
                });
            }

            addWiraElementorKitClass();

            const panel = document.getElementById('elementor-panel');
            if (panel) {
                const observer = new MutationObserver(() => {
                    addWiraElementorKitClass();
                });

                observer.observe(panel, {
                    childList: true,
                    subtree: true
                });
            }

            $(window).on('elementor-panel-elements-search', function() {
                addWiraElementorKitClass();
            });
        });
    });
})(jQuery);

