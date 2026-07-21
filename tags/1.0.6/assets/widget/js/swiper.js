"use strict";

function initWira_Elementor_KitCarousel($scope) {
    const carousels = $scope.find('.wkit-carousel.swiper');

    carousels.each(function () {
        const carousel = this;

        const toInt = (value, fallback) => {
            const num = parseInt(value, 10);
            return Number.isFinite(num) ? num : fallback;
        };

        const slidesPerViewDesktop  = toInt(carousel.dataset.slidesPerView, 1);
        const slidesPerGroupDesktop = toInt(carousel.dataset.slidesPerGroup, 1);
        const slidesPerViewTablet   = toInt(carousel.dataset.slidesPerViewTablet, slidesPerViewDesktop);
        const slidesPerGroupTablet  = toInt(carousel.dataset.slidesPerGroupTablet, slidesPerGroupDesktop);
        const slidesPerViewMobile   = toInt(carousel.dataset.slidesPerViewMobile, slidesPerViewTablet);
        const slidesPerGroupMobile  = toInt(carousel.dataset.slidesPerGroupMobile, slidesPerGroupTablet);

        const spaceBetween = toInt(carousel.dataset.gap, 10);
        const equalHeight        = carousel.dataset.equalHeight === 'yes';
        const autoplayEnabled    = carousel.dataset.autoplay === 'yes';
        const autoplayDelay      = toInt(carousel.dataset.scrollSpeed, 5000);
        const pauseOnHover       = carousel.dataset.pauseOnHover === 'yes';
        const pauseOnInteraction = carousel.dataset.pauseOnInteraction === 'yes';
        const infiniteScroll     = carousel.dataset.infiniteScroll === 'yes';
        const transitionDuration = toInt(carousel.dataset.transitionDuration, 500);
        const paginationType     = carousel.dataset.pagination || 'none';
        const effect             = carousel.dataset.effect || 'slide';

        const marqueeEnabled      = carousel.dataset.marquee === 'yes';
        const marqueeAxis         = carousel.dataset.marqueeAxis || 'horizontal';
        const marqueeDirection    = carousel.dataset.marqueeDirection || 'left';
        const marqueePauseOnHover = carousel.dataset.marqueePauseOnHover === 'yes';
        const marqueeDuration     = toInt(carousel.dataset.marqueeDuration, 30);

        let elementorBreakpoints = {};
        if (
            typeof elementorFrontend !== 'undefined' &&
            elementorFrontend.config &&
            elementorFrontend.config.responsive &&
            elementorFrontend.config.responsive.breakpoints
        ) {
            elementorBreakpoints = elementorFrontend.config.responsive.breakpoints;
        }
        const mobileMax = toInt(elementorBreakpoints.mobile, 767);
        const tabletMax = toInt(elementorBreakpoints.tablet, 1024);
        const tabletMin = mobileMax + 1;
        const desktopMin = tabletMax + 1;

        const responsiveBreakpoints = {
            0: {
                slidesPerView: slidesPerViewMobile,
                slidesPerGroup: slidesPerGroupMobile,
            },
            [tabletMin]: {
                slidesPerView: slidesPerViewTablet,
                slidesPerGroup: slidesPerGroupTablet,
            },
            [desktopMin]: {
                slidesPerView: slidesPerViewDesktop,
                slidesPerGroup: slidesPerGroupDesktop,
            },
        };

        // Base options
        let swiperOptions = {
            loop: infiniteScroll,
            slidesPerView: slidesPerViewDesktop,
            slidesPerGroup: slidesPerGroupDesktop,
            spaceBetween: spaceBetween,
            speed: transitionDuration,
            effect: effect,
            fadeEffect: {
                crossFade: true,
            },
            direction: 'horizontal',
            breakpoints: responsiveBreakpoints,
            pagination: paginationType === 'dots' ? {
                el: carousel.querySelector('.swiper-pagination'),
                clickable: true,
            } : false,
            navigation: {
                nextEl: carousel.querySelector('.swiper-button-next'),
                prevEl: carousel.querySelector('.swiper-button-prev'),
            },
            autoplay: autoplayEnabled ? {
                delay: autoplayDelay,
                disableOnInteraction: pauseOnInteraction,
                pauseOnMouseEnter: pauseOnHover,
            } : false,
            on: {
                init: function () {
                    if (equalHeight) {
                        setEqualHeight(carousel);
                    }
                },
                resize: function () {
                    if (equalHeight) {
                        setEqualHeight(carousel);
                    }
                }
            }
        };

        if (paginationType === 'dots') {
            swiperOptions.pagination = {
                el: carousel.querySelector('.swiper-pagination'),
                clickable: true,
            };
        }

        if (marqueeEnabled) {
            if (marqueeAxis === 'vertical') {
                carousel.classList.add('wkit-marquee-vertical');
            } else {
                carousel.classList.remove('wkit-marquee-vertical');
            }
            const reverseDirection = marqueeDirection === 'right' || marqueeDirection === 'down';

            swiperOptions.direction = marqueeAxis === 'vertical' ? 'vertical' : 'horizontal';
            swiperOptions.loop = true;
            swiperOptions.effect = 'slide';
            swiperOptions.speed = marqueeDuration * 1000;
            swiperOptions.allowTouchMove = false;
            swiperOptions.freeMode = true;
            swiperOptions.freeModeMomentum = false;
            swiperOptions.freeModeMomentumBounce = false;
            swiperOptions.autoplay = {
                delay: 0,
                disableOnInteraction: false,
                pauseOnMouseEnter: marqueePauseOnHover,
                reverseDirection: reverseDirection,
            };
        }

        const swiper = new Swiper(carousel, swiperOptions);

        function setVerticalMarqueeHeight() {
            if (!marqueeEnabled || marqueeAxis !== 'vertical') {
                return;
            }

            const slides = swiper.slides || [];
            if (!slides.length) {
                return;
            }

            let visibleCount = swiper.params.slidesPerView;
            if (visibleCount === 'auto' || !Number.isFinite(visibleCount)) {
                visibleCount = 1;
            }
            visibleCount = Math.max(1, Math.min(slides.length, visibleCount));

            let totalHeight = 0;
            for (let i = 0; i < visibleCount; i += 1) {
                totalHeight += slides[i].offsetHeight;
            }
            if (visibleCount > 1) {
                totalHeight += spaceBetween * (visibleCount - 1);
            }

            if (totalHeight > 0) {
                carousel.style.height = totalHeight + 'px';
            }
        }

        if (marqueeEnabled && marqueeAxis === 'vertical') {
            setVerticalMarqueeHeight();
            swiper.on('resize', setVerticalMarqueeHeight);
            swiper.on('imagesReady', setVerticalMarqueeHeight);
        }

        function setEqualHeight(carouselEl) {
            const slides = carouselEl.querySelectorAll('.swiper-slide');
            let maxHeight = 0;

            slides.forEach(slide => {
                slide.style.height = 'auto'; // reset dulu
                if (slide.offsetHeight > maxHeight) {
                    maxHeight = slide.offsetHeight;
                }
            });

            slides.forEach(slide => {
                slide.style.height = maxHeight + 'px';
            });
        }
    });
}

jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
        initWira_Elementor_KitCarousel($scope);
    });
});

