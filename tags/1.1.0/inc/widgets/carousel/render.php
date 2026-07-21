<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Carousel Elementor Custom Widget.
 *
 * Outputs a Swiper carousel where each slide can contain an Elementor block template.
 * Supports autoplay, pagination, arrows, and other configurable options.
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

// Bail early if no slides are defined.
if ( empty( $settings['slides'] ) ) {
	return;
}

/**
 * Carousel configuration values.
 */
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

$arrows_show        = ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] );
$pagination_type    = ! empty( $settings['pagination_type_slider'] ) ? $settings['pagination_type_slider'] : 'none';
$gap_between_slides = ! empty( $settings['gap_between_slides']['size'] ) ? $settings['gap_between_slides']['size'] : 10;
$effect             = ! empty( $settings['transition_effect'] ) ? $settings['transition_effect'] : 'slide';

/**
 * Main carousel wrapper.
 * Data attributes are safe (escaped with esc_attr).
 */
echo '<div class="wkit-carousel swiper"
	data-slides-per-view="' . esc_attr( $slides_per_view ) . '"
	data-slides-per-view-tablet="' . esc_attr( $slides_per_view_tablet ) . '"
	data-slides-per-view-mobile="' . esc_attr( $slides_per_view_mobile ) . '"
	data-slides-per-group="' . esc_attr( $slides_per_group ) . '"
	data-slides-per-group-tablet="' . esc_attr( $slides_per_group_tablet ) . '"
	data-slides-per-group-mobile="' . esc_attr( $slides_per_group_mobile ) . '"
	data-equal-height="' . esc_attr( $equal_height ) . '"
	data-autoplay="' . esc_attr( $autoplay ) . '"
	data-scroll-speed="' . esc_attr( $scroll_speed ) . '"
	data-pause-on-hover="' . esc_attr( $pause_on_hover ) . '"
	data-pause-on-interaction="' . esc_attr( $pause_on_interaction ) . '"
	data-infinite-scroll="' . esc_attr( $infinite_scroll ) . '"
	data-transition-duration="' . esc_attr( $transition_duration ) . '"
	data-pagination="' . esc_attr( $pagination_type ) . '"
	data-gap="' . esc_attr( $gap_between_slides ) . '"
	data-effect="' . esc_attr( $effect ) . '">';

	// Slides wrapper.
	echo '<div class="swiper-wrapper">';

foreach ( $settings['slides'] as $item ) {
	echo '<div class="swiper-slide">';

	// If block template is selected and Elementor is active.
	if ( ! empty( $item['blocks_template'] ) && class_exists( '\Elementor\Plugin' ) ) {
		$template_id = absint( $item['blocks_template'] );
		$content     = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );

		if ( ! empty( trim( $content ) ) ) {
			// Safe: Elementor already escapes builder content.
			echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor builder content is intended HTML output.
		} else {
			// Fallback to raw post content.
			$post_obj = get_post( $template_id );
			if ( $post_obj ) {
				global $post;
				$backup = $post;
				$post   = $post_obj;
				setup_postdata( $post );

				// Safe: filtered through 'the_content'.
				echo apply_filters( 'the_content', $post_obj->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Safe: 'the_content' filter outputs formatted post HTML.

				wp_reset_postdata();
				$post = $backup;
			} else {
				echo '<p>' . esc_html__( 'No content found for this template.', 'wira-kit-for-elementor' ) . '</p>';
			}
		}
	} else {
		// Fallback if no template chosen.
		echo '<p>' . esc_html__( 'Choose block template', 'wira-kit-for-elementor' ) . '</p>';
	}

	echo '</div>'; // end .swiper-slide.
}

	echo '</div>'; // end .swiper-wrapper.

// Pagination dots.
if ( 'dots' === $pagination_type ) {
	echo '<div class="swiper-pagination wkit-swiper-pagination"></div>';
}

// Navigation arrows.
if ( $arrows_show ) {
	// Prev arrow.
	echo '<div class="swiper-button-prev">';
	if ( ! empty( $settings['prev_arrow_icon']['value'] ) ) {
		echo '<i class="' . esc_attr( $settings['prev_arrow_icon']['value'] ) . '"></i>';
	}
	echo '</div>';

	// Next arrow.
	echo '<div class="swiper-button-next">';
	if ( ! empty( $settings['next_arrow_icon']['value'] ) ) {
		echo '<i class="' . esc_attr( $settings['next_arrow_icon']['value'] ) . '"></i>';
	}
	echo '</div>';
}

echo '</div>'; // end .wkit-carousel.
