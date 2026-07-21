<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Info Box Repeater Elementor Custom Widget.
 *
 * Outputs info box repeater items (with optional slider, background, icon, excerpt, and learn more button).
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();

// Bail early if no services provided.
if ( empty( $settings['services'] ) ) {
	echo '<p>' . esc_html__( 'No info box item found.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

// ==============================
// Slider settings
// ==============================
$enable_slider        = ( 'yes' === $settings['enable_slider'] ) ? 'wkit-carousel swiper' : '';
$slides_per_view      = ! empty( $settings['slides_per_view'] ) ? $settings['slides_per_view'] : 1;
$slides_per_group     = ! empty( $settings['slides_per_group'] ) ? $settings['slides_per_group'] : 1;
$slides_per_view_tablet = ( ! empty( $settings['slides_per_view_tablet'] ) && 'default' !== $settings['slides_per_view_tablet'] )
	? $settings['slides_per_view_tablet']
	: $slides_per_view;
$slides_per_view_mobile = ( ! empty( $settings['slides_per_view_mobile'] ) && 'default' !== $settings['slides_per_view_mobile'] )
	? $settings['slides_per_view_mobile']
	: $slides_per_view_tablet;
$slides_per_group_tablet = ( ! empty( $settings['slides_per_group_tablet'] ) && 'default' !== $settings['slides_per_group_tablet'] )
	? $settings['slides_per_group_tablet']
	: $slides_per_group;
$slides_per_group_mobile = ( ! empty( $settings['slides_per_group_mobile'] ) && 'default' !== $settings['slides_per_group_mobile'] )
	? $settings['slides_per_group_mobile']
	: $slides_per_group_tablet;
$equal_height         = ( ! empty( $settings['equal_height'] ) && 'yes' === $settings['equal_height'] ) ? 'yes' : 'no';
$autoplay             = ( ! empty( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ) ? 'yes' : 'no';
$scroll_speed         = ! empty( $settings['scroll_speed'] ) ? $settings['scroll_speed'] : 5000;
$pause_on_hover       = ( ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ) ? 'yes' : 'no';
$pause_on_interaction = ( ! empty( $settings['pause_on_interaction'] ) && 'yes' === $settings['pause_on_interaction'] ) ? 'yes' : 'no';
$infinite_scroll      = ( ! empty( $settings['infinite_scroll'] ) && 'yes' === $settings['infinite_scroll'] ) ? 'yes' : 'no';
$transition_duration  = ! empty( $settings['transition_duration'] ) ? $settings['transition_duration'] : 500;
$arrows_show          = ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] );
$pagination_type      = ! empty( $settings['pagination_type_slider'] ) ? $settings['pagination_type_slider'] : 'none';
$gap_between_slides   = ! empty( $settings['gap_between_slides']['size'] ) ? $settings['gap_between_slides']['size'] : 10;
$effect               = ! empty( $settings['transition_effect'] ) ? $settings['transition_effect'] : 'slide';
$enable_marquee       = ( ! empty( $settings['enable_marquee_style'] ) && 'yes' === $settings['enable_marquee_style'] );
$marquee_axis         = ! empty( $settings['marquee_scroll_axis'] ) ? $settings['marquee_scroll_axis'] : 'horizontal';
$marquee_direction_h  = ! empty( $settings['marquee_direction_horizontal'] ) ? $settings['marquee_direction_horizontal'] : 'left';
$marquee_direction_v  = ! empty( $settings['marquee_direction_vertical'] ) ? $settings['marquee_direction_vertical'] : 'up';
$marquee_pause_on_hover = ( ! empty( $settings['marquee_pause_on_hover'] ) && 'yes' === $settings['marquee_pause_on_hover'] ) ? 'yes' : 'no';
$marquee_duration     = ! empty( $settings['marquee_duration']['size'] ) ? $settings['marquee_duration']['size'] : 30;
$marquee_direction    = ( 'vertical' === $marquee_axis ) ? $marquee_direction_v : $marquee_direction_h;

// (Output is rendered inline at echo-time to satisfy escaping rules.)

if ( ! function_exists( 'Wirakit_render_info_box_repeater_item' ) ) {
	/**
	 * Render a single info box repeater item.
	 *
	 * @param array $item     Service item data from repeater settings.
	 * @param array $settings Widget settings.
	 */
	function Wirakit_render_info_box_repeater_item( $item, $settings ) {
		$icon         = ! empty( $item['service_icon']['value'] ) ? $item['service_icon']['value'] : '';
		$image_custom = ! empty( $item['background_image']['url'] ) ? $item['background_image']['url'] : '';
		$title        = ! empty( $item['service_title'] ) ? $item['service_title'] : '';
		$excerpt      = ! empty( $item['service_content_excerpt'] ) ? $item['service_content_excerpt'] : '';
		$link         = ! empty( $item['service_button_link']['url'] ) ? $item['service_button_link']['url'] : '';

		// Background style if enabled.
		$bg_value = ( ! empty( $item['show_background_image'] ) && 'yes' === $item['show_background_image'] )
			? 'background-image:url(' . esc_url( $image_custom ) . ');'
			: '';

		// Hover classes.
		$hover_class           = ! empty( $item['hover_animation_container'] ) ? ' elementor-animation-' . $item['hover_animation_container'] : '';
		$hover_class_learnmore = ! empty( $item['hover_animation_learnmore'] ) ? ' elementor-animation-' . $item['hover_animation_learnmore'] : '';

		// Wrapper start.
		printf(
			'<div class="wkit-info-box-repeater-item-wrapper %1$s"%2$s>',
			esc_attr( $hover_class ),
			$bg_value ? ' style="' . esc_attr( $bg_value ) . '"' : ''
		);

		// Global link wrapper if Learn More is disabled.
		if ( ( empty( $settings['show_learnmore'] ) || 'yes' !== $settings['show_learnmore'] ) && $link ) {
			echo '<a class="wkit-info-box-repeater-item-global-link wkit-use-global-link" href="' . esc_url( $link ) . '">';
		}

		echo '<div class="wkit-info-box-repeater-item d-flex">';

		// Icon.
		if ( ! empty( $item['show_service_icon'] ) && 'yes' === $item['show_service_icon'] && $icon ) {
			echo '<div class="info-box-repeater-icon-wrapper d-flex">';
			echo '<div class="info-box-repeater-icon"><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i></div>';
			echo '</div>';
		}

		// Content wrapper.
		echo '<div class="wkit-info-box-repeater-content-wrapper">';
		echo '<h4 class="info-box-repeater-title">' . esc_html( $title ) . '</h4>';

		// Excerpt.
		if ( $excerpt ) {
			echo '<p class="info-box-repeater-excerpt">' . esc_html( $excerpt ) . '</p>';
		}

		// Learn More button.
		if ( ! empty( $settings['show_learnmore'] ) && 'yes' === $settings['show_learnmore'] ) {
			echo '<div class="learnmore-wrapper d-flex">';
			echo '<a href="' . esc_url( $link ) . '" class="wkit-info-box-repeater-learnmore wkit-btn-text-two' . esc_attr( $hover_class_learnmore ) . '">';
			echo '<span class="learnmore-wrapper d-flex">';

			if ( ! empty( $settings['learnmore_icon']['value'] ) && ! empty( $settings['icon_position'] ) && 'before' === $settings['icon_position'] ) {
				echo '<span class="learnmore-icon"><i class="' . esc_attr( $settings['learnmore_icon']['value'] ) . '" aria-hidden="true"></i></span>';
			}

			echo '<span class="learnmore-text">' . esc_html( $settings['learnmore_text'] ?? '' ) . '</span>';

			if ( ! empty( $settings['learnmore_icon']['value'] ) && ! empty( $settings['icon_position'] ) && 'after' === $settings['icon_position'] ) {
				echo '<span class="learnmore-icon"><i class="' . esc_attr( $settings['learnmore_icon']['value'] ) . '" aria-hidden="true"></i></span>';
			}

			echo '</span>';
			echo '</a>';
			echo '</div>';
		}

		echo '</div>'; // .wkit-info-box-repeater-content-wrapper
		echo '</div>'; // .wkit-info-box-repeater-item

		// Close global link if opened.
		if ( ( empty( $settings['show_learnmore'] ) || 'yes' !== $settings['show_learnmore'] ) && $link ) {
			echo '</a>';
		}

		echo '</div>'; // .wkit-info-box-repeater-item-wrapper
	}
}

// ==============================
// Render services
// ==============================
$wrapper_classes = 'wkit-info-box-repeater ' . trim( $enable_slider );
echo '<div class="' . esc_attr( trim( $wrapper_classes ) ) . '"';

if ( 'yes' === $settings['enable_slider'] ) {
	printf( ' data-slides-per-view="%s"', esc_attr( $slides_per_view ) );
	printf( ' data-slides-per-view-tablet="%s"', esc_attr( $slides_per_view_tablet ) );
	printf( ' data-slides-per-view-mobile="%s"', esc_attr( $slides_per_view_mobile ) );
	printf( ' data-slides-per-group="%s"', esc_attr( $slides_per_group ) );
	printf( ' data-slides-per-group-tablet="%s"', esc_attr( $slides_per_group_tablet ) );
	printf( ' data-slides-per-group-mobile="%s"', esc_attr( $slides_per_group_mobile ) );
	printf( ' data-equal-height="%s"', esc_attr( $equal_height ) );
	printf( ' data-autoplay="%s"', esc_attr( $autoplay ) );
	printf( ' data-scroll-speed="%s"', esc_attr( $scroll_speed ) );
	printf( ' data-pause-on-hover="%s"', esc_attr( $pause_on_hover ) );
	printf( ' data-pause-on-interaction="%s"', esc_attr( $pause_on_interaction ) );
	printf( ' data-infinite-scroll="%s"', esc_attr( $infinite_scroll ) );
	printf( ' data-transition-duration="%s"', esc_attr( $transition_duration ) );
	printf( ' data-pagination="%s"', esc_attr( $pagination_type ) );
	printf( ' data-gap="%s"', esc_attr( $gap_between_slides ) );
	printf( ' data-effect="%s"', esc_attr( $effect ) );

	if ( $enable_marquee ) {
		echo ' data-marquee="yes"';
		printf( ' data-marquee-axis="%s"', esc_attr( $marquee_axis ) );
		printf( ' data-marquee-direction="%s"', esc_attr( $marquee_direction ) );
		printf( ' data-marquee-pause-on-hover="%s"', esc_attr( $marquee_pause_on_hover ) );
		printf( ' data-marquee-duration="%s"', esc_attr( $marquee_duration ) );
	}
}

echo '>';

if ( 'yes' === $settings['enable_slider'] ) {
	echo '<div class="swiper-wrapper">';
}

foreach ( $settings['services'] as $item ) {
	if ( 'yes' === $settings['enable_slider'] ) {
		echo '<div class="swiper-slide">';
	}

	Wirakit_render_info_box_repeater_item( $item, $settings );

	if ( 'yes' === $settings['enable_slider'] ) {
		echo '</div>';
	}
}

if ( 'yes' === $settings['enable_slider'] ) {
	echo '</div>'; // .swiper-wrapper

	// Pagination.
	if ( 'dots' === $pagination_type ) {
		echo '<div class="swiper-pagination wkit-swiper-pagination"></div>';
	}

	// Navigation arrows.
	if ( $arrows_show ) {
		echo '<div class="swiper-button-prev">';
		if ( ! empty( $settings['prev_arrow_icon']['value'] ) ) {
			echo '<i class="' . esc_attr( $settings['prev_arrow_icon']['value'] ) . '"></i>';
		}
		echo '</div>';

		echo '<div class="swiper-button-next">';
		if ( ! empty( $settings['next_arrow_icon']['value'] ) ) {
			echo '<i class="' . esc_attr( $settings['next_arrow_icon']['value'] ) . '"></i>';
		}
		echo '</div>';
	}
}

echo '</div>'; // .wkit-info-box-repeater
