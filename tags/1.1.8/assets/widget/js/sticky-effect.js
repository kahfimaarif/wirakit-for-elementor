jQuery(function($) {
    var $elements = $('.has-wkit-sticky');
    if (!$elements.length) return;

    $elements.each(function() {
        var $item = $(this);
        var itemEl = this;

        // Get parent element
        var parent = $item.parent()[0];

        var parent_container = $item.parent().closest('[data-element_type="container"]');

        var ticking = false;

        function updateSticky() {

            var scrollTop    = $(window).scrollTop();
            var rect         = parent ? parent.getBoundingClientRect() : null;
            var parentRect = parent.getBoundingClientRect();
            var style = getComputedStyle(parent);

            var parentBottom = rect ? rect.bottom + window.scrollY : 0;
            var style = getComputedStyle(parent_container.length ? parent_container[0] : parent);
            var paddingLeft = parseFloat(style.paddingLeft) || 0;
            var paddingRight = parseFloat(style.paddingRight) || 0;
            var elWidth = parentRect.width - paddingLeft - paddingRight;

            var elHeight     = $item.outerHeight();

            var spacer = $item.next('.wkit-sticky-spacer');

            if (spacer.length) {
                var rectSpacer = spacer[0].getBoundingClientRect();
                var itemTop = rectSpacer.top + window.scrollY;
            } else {
                var rectItem = $item[0].getBoundingClientRect();
                var itemTop  = rectItem.top + window.scrollY;
            }

            // --- read data-* reliably
            var dataBgChange         = ($item.attr('data-bg-change') || $item.data('bg-change')) === 'yes';
            var stickyHeaderAnimated = ($item.attr('data-header-animated') || $item.data('header-animated')) === 'yes';
            var stickyHeaderDesktop  = ($item.attr('data-on-desktop') || $item.data('on-desktop')) === 'yes';
            var stickyHeaderTablet   = ($item.attr('data-on-tablet') || $item.data('on-tablet')) === 'yes';
            var stickyHeaderMobile   = ($item.attr('data-on-mobile') || $item.data('on-mobile')) === 'yes';
            var stayInParent         = ($item.attr('data-sticky-parent') || $item.data('sticky-parent')) === 'yes';
            var position             = ($item.attr('data-sticky-position') || $item.data('sticky-position') || 'top');
            var offset               = parseInt($item.attr('data-sticky-offset') || $item.data('sticky-offset') || 0, 10);

            // --- determine current device
            var isDesktop = window.matchMedia('(min-width: 1025px)').matches;
            var isTablet  = window.matchMedia('(min-width: 768px) and (max-width: 1024px)').matches;
            var isMobile  = window.matchMedia('(max-width: 767px)').matches;

            // --- is sticky allowed on this device?
            var deviceAllowed = (isDesktop && stickyHeaderDesktop) || (isTablet  && stickyHeaderTablet) || (isMobile  && stickyHeaderMobile);

            // If sticky is NOT allowed on current device -> reset and stop
            if (!deviceAllowed) {
                $item.css({ position: '', top: '', bottom: '', width: '', maxWidth: '' });

                if (dataBgChange) {
                    $item.removeClass('sticky-bg-active');
                }
                if (stickyHeaderAnimated) {
                    $item.removeClass('wkit-sticky-header-animated');
                }

                removeStickySpacer($item, 'after');

                return; // important: do not continue with sticky logic
            }

            function addStickySpacer($item, position = 'after') {

                var selector = '.wkit-sticky-spacer';
                var exists   = (position === 'after') 
                    ? $item.next(selector).length 
                    : $item.prev(selector).length;

                if (!exists) {
                    var spacer = $item.clone()
                        .removeClass('has-wkit-sticky')
                        .addClass('wkit-sticky-spacer')
                        .css({
                            visibility: 'hidden',
                            position: 'relative',
                            display: 'flex',
                            height: $item.outerHeight(),
                            width: '100%'
                        });

                    if (position === 'after') {
                        $item.after(spacer);
                    } else {
                        $item.before(spacer);
                    }
                }
            }

            function removeStickySpacer($item, position = 'after') {
                var selector = '.wkit-sticky-spacer';
                if (position === 'after') {
                    $item.next(selector).remove();
                } else {
                    $item.prev(selector).remove();
                }
            }

            // Case: Sticky should stay on column and inside parent
            if (stayInParent && parent_container.length) {
                // TOP sticky behavior
                if (position === 'top') {
                    if (scrollTop < itemTop - offset) {

                        if ($item.next('.wkit-sticky-spacer').length) {
                            removeStickySpacer($item, 'after');
                        }

                        // Before reaching parent
                        $item.css({ position: '', top: '', bottom: '', width: '', maxWidth: '' });

                        parent_container.css({
                            position: ''
                        });

                    } else if (scrollTop >= itemTop - offset && scrollTop < parentBottom - elHeight) {

                        if (!$item.next('.wkit-sticky-spacer').length) {
                            addStickySpacer($item, 'after');
                        }

                        // While inside parent
                        $item.css({
                            position: 'fixed',
                            top: offset + 'px',
                            bottom: '',
                            width: elWidth + 'px',
                            maxWidth: '100%',
                        });

                        parent_container.css({
                            position: 'relative'
                        });



                    } else if (scrollTop > parentBottom - elHeight) {

                        if ($item.next('.wkit-sticky-spacer').length) {
                            removeStickySpacer($item, 'after');
                        }

                        // After parent bottom
                        $item.css({
                            position: 'absolute',
                            top: '',
                            bottom: '0px',
                            width: elWidth + 'px',
                            maxWidth: '100%',
                            zIndex: ''
                        });

                        parent_container.css({
                            position: ''
                        });

                    }
                }

                // BOTTOM sticky behavior
                if (position === 'bottom') {
                    if (scrollTop + window.innerHeight < parentBottom + offset) {
                        // Still inside parent → fixed at bottom
                        $item.css({
                            position: 'fixed',
                            top: '',
                            bottom: offset + 'px',
                            width: elWidth + 'px',
                            maxWidth: '100%'
                        });
                    } else {
                        // After parent → absolute at bottom of parent
                        $item.css({
                            position: 'absolute',
                            top: '',
                            bottom: '0px',
                            width: elWidth + 'px',
                            maxWidth: '100%',
                            zIndex: ''
                        });
                    }
                }

            }

            // Case: Sticky should inside parent
            if (!stayInParent && parent_container.length) {
                // TOP sticky behavior
                if (position === 'top') {
                    if (scrollTop < itemTop - offset) {

                        if ($item.next('.wkit-sticky-spacer').length) {
                            removeStickySpacer($item, 'after');
                        }

                        // Before reaching parent
                        $item.css({ position: '', top: '', bottom: '', width: '', maxWidth: '' });
                        
                        parent_container.css({
                            position: ''
                        });

                    } else if (scrollTop >= itemTop - offset) {

                        if (!$item.next('.wkit-sticky-spacer').length) {
                            addStickySpacer($item, 'after');
                        }

                        // While inside parent
                        $item.css({
                            position: 'fixed',
                            top: offset + 'px',
                            bottom: '',
                            width: elWidth + 'px',
                            maxWidth: '100%'
                        });

                        parent_container.css({
                            position: 'relative'
                        });
                    }
                }

                // BOTTOM sticky behavior
                if (position === 'bottom') {
                    if (scrollTop + window.innerHeight < parentBottom + offset) {
                        // Still inside parent → fixed at bottom
                        $item.css({
                            position: 'fixed',
                            top: '',
                            bottom: offset + 'px',
                            width: elWidth + 'px',
                            maxWidth: '100%'
                        });
                    } else {
                        // After parent → absolute at bottom of parent
                        $item.css({
                            position: 'absolute',
                            top: '',
                            bottom: '0px',
                            width: elWidth + 'px',
                            maxWidth: '100%',
                            zIndex: ''
                        });
                    }
                }
            } 
            
            // Case: Sticky outside parent
            if (!parent_container.length) {
                if (position === 'top') {
                    if (scrollTop <= itemTop - offset) {

                        if ($item.next('.wkit-sticky-spacer').length) {
                            removeStickySpacer($item, 'after');
                        }
                        
                        $item.css({ position: '', top: '', bottom: '', width: '', maxWidth: ''});
                    } else if (scrollTop > itemTop - offset) {

                        if (!$item.next('.wkit-sticky-spacer').length) {
                            addStickySpacer($item, 'after');
                        }

                        $item.css({
                            position: 'fixed',
                            top: offset + 'px',
                            bottom: '',
                            maxWidth: '100%'
                        });
                    }

                } else if (position === 'bottom') {
                    // Always fixed at bottom of viewport
                    $item.css({
                        position: 'fixed',
                        bottom: offset + 'px',
                        top: '',
                        width: '',
                        maxWidth: ''
                    });
                }
            } 

            // Header Background change on scroll
            if (dataBgChange) {
                if (scrollTop > itemTop - offset) {
                    $item.addClass('sticky-bg-active');
                } else if (scrollTop <= itemTop - offset) {
                    $item.removeClass('sticky-bg-active');
                }
            }

            // Header Animated on scroll
            if (stickyHeaderAnimated) {
                if (scrollTop > itemTop - offset) {
                    $item.addClass('wkit-sticky-header-animated');
                } else if (scrollTop <= itemTop - offset) {
                    $item.removeClass('wkit-sticky-header-animated');
                }
            }

        }

        // Attach scroll listener with requestAnimationFrame throttle
        $(window).on('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateSticky();
                    ticking = false;
                });
                ticking = true;
            }
        });

        $(window).on('resize', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateSticky();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Run once on load
        updateSticky();

    });
});