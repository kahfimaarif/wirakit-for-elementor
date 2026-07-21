<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Testimonials Elementor Custom Widget.
 *
 * Displays client testimonials with optional star rating, image, name,
 * position, and link. Supports carousel slider.
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

if ( empty( $settings['testimonials'] ) ) {
	echo '<p>' . esc_html__( 'No Testimonial List', 'wira-kit-for-elementor' ) . '</p>';
}

// ==== Slider setup ====
$enable_slider = ( 'yes' === $settings['enable_slider'] ) ? 'wkit-carousel swiper' : '';

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

$arrows_show     = ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] );
$pagination_type = ! empty( $settings['pagination_type_slider'] ) ? $settings['pagination_type_slider'] : 'none';

$gap_between_slides = ! empty( $settings['gap_between_slides']['size'] ) ? $settings['gap_between_slides']['size'] : 10;
$effect             = ! empty( $settings['transition_effect'] ) ? $settings['transition_effect'] : 'slide';
$enable_marquee     = ( ! empty( $settings['enable_marquee_style'] ) && 'yes' === $settings['enable_marquee_style'] );
$marquee_axis       = ! empty( $settings['marquee_scroll_axis'] ) ? $settings['marquee_scroll_axis'] : 'horizontal';
$marquee_direction_h = ! empty( $settings['marquee_direction_horizontal'] ) ? $settings['marquee_direction_horizontal'] : 'left';
$marquee_direction_v = ! empty( $settings['marquee_direction_vertical'] ) ? $settings['marquee_direction_vertical'] : 'up';
$marquee_pause_on_hover = ( ! empty( $settings['marquee_pause_on_hover'] ) && 'yes' === $settings['marquee_pause_on_hover'] ) ? 'yes' : 'no';
$marquee_duration   = ! empty( $settings['marquee_duration']['size'] ) ? $settings['marquee_duration']['size'] : 30;
$marquee_direction  = ( 'vertical' === $marquee_axis ) ? $marquee_direction_v : $marquee_direction_h;

// (Output is rendered inline at echo-time to satisfy escaping rules.)

if ( ! function_exists( 'Wirakit_render_static_testimonials_item' ) ) {
	/**
	 * Render single testimonial item.
	 *
	 * @param array $item Testimonial item data.
	 */
	function Wirakit_render_static_testimonials_item( $item ) {
		$client_name     = ! empty( $item['client_name'] ) ? $item['client_name'] : '';
		$client_position = ! empty( $item['client_position'] ) ? $item['client_position'] : '';
		$content         = ! empty( $item['testimonial_content'] ) ? $item['testimonial_content'] : '';
		$client_image    = ! empty( $item['client_image']['url'] ) ? $item['client_image']['url'] : '';
		$link            = ! empty( $item['testimonial_button_link']['url'] ) ? $item['testimonial_button_link']['url'] : '';

		$hover_class           = ! empty( $item['hover_animation_container'] ) ? ' elementor-animation-' . $item['hover_animation_container'] : '';
		$hover_class_learnmore = ! empty( $item['hover_animation_learnmore'] ) ? ' elementor-animation-' . $item['hover_animation_learnmore'] : '';

		echo '<div class="wkit-testimonial-item-wrapper' . esc_attr( $hover_class ) . '">';

		// Wrap with global link.
		if ( ! empty( $link ) ) {
			echo '<a class="wkit-testimonial-item-global-link wkit-use-global-link" href="' . esc_url( $link ) . '">';
		}

		echo '<div class="wkit-testimonial-item">';

		// Star rating.
		if ( isset( $item['show_star_rating'] ) && 'yes' === $item['show_star_rating'] && ! empty( $item['star_rating'] ) ) {
			$star_rating = intval( $item['star_rating'] );
			echo '<div class="star-rating-icon-wrapper d-flex"><div class="star-rating-icon d-flex">';
			for ( $i = 1; $i <= 5; $i++ ) {
				echo ( $i <= $star_rating )
					? '<i class="fas fa-star" aria-hidden="true"></i>'
					: '<i class="far fa-star" aria-hidden="true"></i>';
			}
			echo '</div></div>';
		}

		// Testimonial content.
		if ( ! empty( $content ) ) {
			echo '<div class="wkit-testimonial-content-wrapper">';
			echo '<p class="testimonial-content">' . esc_html( $content ) . '</p>';
			echo '</div>';
		}

		// Client info.
		echo '<div class="wkit-testimonial-client-info-wrapper d-flex">';

		if ( $client_image ) {
			$alt = $client_name ? $client_name : __( 'Client photo', 'wira-kit-for-elementor' );
			echo '<div class="client-image-wrapper d-flex">';
			echo '<img class="client-image" src="' . esc_url( $client_image ) . '" alt="' . esc_attr( $alt ) . '">';
			echo '</div>';
		}

		echo '<div class="client-info">';
		if ( $client_name ) {
			echo '<h4 class="client-name">' . esc_html( $client_name ) . '</h4>';
		}
		if ( $client_position ) {
			echo '<h5 class="client-position wkit-accent-text">' . esc_html( $client_position ) . '</h5>';
		}
		echo '</div>'; // .client-info

		echo '</div>'; // .client-info-wrapper
		echo '</div>'; // .testimonial-item

		if ( ! empty( $link ) ) {
			echo '</a>';
		}

		echo '</div>'; // .testimonial-item-wrapper
	}
}

// ==== Render wrapper ====
$wrapper_classes = 'wkit-testimonial ' . trim( $enable_slider );
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

foreach ( $settings['testimonials'] as $item ) {
	if ( 'yes' === $settings['enable_slider'] ) {
		echo '<div class="swiper-slide">';
	}

	Wirakit_render_static_testimonials_item( $item, $settings );

	if ( 'yes' === $settings['enable_slider'] ) {
		echo '</div>';
	}
}

if ( 'yes' === $settings['enable_slider'] ) {
	echo '</div>'; // .swiper-wrapper
}

// Swiper pagination + nav.
if ( 'yes' === $settings['enable_slider'] ) {
	if ( 'dots' === $pagination_type ) {
		echo '<div class="swiper-pagination wkit-swiper-pagination"></div>';
	}
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

echo '</div>'; // .wkit-testimonial
