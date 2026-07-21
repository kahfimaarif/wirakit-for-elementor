<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Team Repeater Elementor Custom Widget.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();

if ( empty( $settings['team_members'] ) || ! is_array( $settings['team_members'] ) ) {
	echo '<p>' . esc_html__( 'No team member found.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$enable_slider           = ( ! empty( $settings['enable_slider'] ) && 'yes' === $settings['enable_slider'] ) ? 'wkit-carousel swiper' : '';
$slides_per_view         = ! empty( $settings['slides_per_view'] ) ? $settings['slides_per_view'] : 1;
$slides_per_group        = ! empty( $settings['slides_per_group'] ) ? $settings['slides_per_group'] : 1;
$slides_per_view_tablet  = ( ! empty( $settings['slides_per_view_tablet'] ) && 'default' !== $settings['slides_per_view_tablet'] ) ? $settings['slides_per_view_tablet'] : $slides_per_view;
$slides_per_view_mobile  = ( ! empty( $settings['slides_per_view_mobile'] ) && 'default' !== $settings['slides_per_view_mobile'] ) ? $settings['slides_per_view_mobile'] : $slides_per_view_tablet;
$slides_per_group_tablet = ( ! empty( $settings['slides_per_group_tablet'] ) && 'default' !== $settings['slides_per_group_tablet'] ) ? $settings['slides_per_group_tablet'] : $slides_per_group;
$slides_per_group_mobile = ( ! empty( $settings['slides_per_group_mobile'] ) && 'default' !== $settings['slides_per_group_mobile'] ) ? $settings['slides_per_group_mobile'] : $slides_per_group_tablet;
$equal_height            = ( ! empty( $settings['equal_height'] ) && 'yes' === $settings['equal_height'] ) ? 'yes' : 'no';
$autoplay                = ( ! empty( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ) ? 'yes' : 'no';
$scroll_speed            = ! empty( $settings['scroll_speed'] ) ? $settings['scroll_speed'] : 5000;
$pause_on_hover          = ( ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ) ? 'yes' : 'no';
$pause_on_interaction    = ( ! empty( $settings['pause_on_interaction'] ) && 'yes' === $settings['pause_on_interaction'] ) ? 'yes' : 'no';
$infinite_scroll         = ( ! empty( $settings['infinite_scroll'] ) && 'yes' === $settings['infinite_scroll'] ) ? 'yes' : 'no';
$transition_duration     = ! empty( $settings['transition_duration'] ) ? $settings['transition_duration'] : 500;
$arrows_show             = ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] );
$pagination_type         = ! empty( $settings['pagination_type_slider'] ) ? $settings['pagination_type_slider'] : 'none';
$gap_between_slides      = ! empty( $settings['gap_between_slides']['size'] ) ? $settings['gap_between_slides']['size'] : 10;
$effect                  = ! empty( $settings['transition_effect'] ) ? $settings['transition_effect'] : 'slide';
$enable_marquee          = ( ! empty( $settings['enable_marquee_style'] ) && 'yes' === $settings['enable_marquee_style'] );
$marquee_axis            = ! empty( $settings['marquee_scroll_axis'] ) ? $settings['marquee_scroll_axis'] : 'horizontal';
$marquee_direction_h     = ! empty( $settings['marquee_direction_horizontal'] ) ? $settings['marquee_direction_horizontal'] : 'left';
$marquee_direction_v     = ! empty( $settings['marquee_direction_vertical'] ) ? $settings['marquee_direction_vertical'] : 'up';
$marquee_pause_on_hover  = ( ! empty( $settings['marquee_pause_on_hover'] ) && 'yes' === $settings['marquee_pause_on_hover'] ) ? 'yes' : 'no';
$marquee_duration        = ! empty( $settings['marquee_duration']['size'] ) ? $settings['marquee_duration']['size'] : 30;
$marquee_direction       = ( 'vertical' === $marquee_axis ) ? $marquee_direction_v : $marquee_direction_h;

// (Output is rendered inline at echo-time to satisfy escaping rules.)

$layout_class         = ( ! empty( $settings['layout_style'] ) && 'hover-overlay' === $settings['layout_style'] ) ? ' has-team-hover-overlay' : '';
$hover_class          = ! empty( $settings['hover_animation_container'] ) ? ' elementor-animation-' . $settings['hover_animation_container'] : '';
$hover_wrapper_class  = ! empty( $settings['hover_animation_wrapper_container'] ) ? ' elementor-animation-' . $settings['hover_animation_wrapper_container'] : '';
$hover_social_class   = ! empty( $settings['hover_animation_social_icon'] ) ? ' elementor-animation-' . $settings['hover_animation_social_icon'] : '';

$wrapper_classes = 'wkit-team-repeater ' . trim( $enable_slider );
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

foreach ( $settings['team_members'] as $item ) {
	$team_name     = ! empty( $item['team_name'] ) ? $item['team_name'] : '';
	$team_position = ! empty( $item['team_position'] ) ? $item['team_position'] : '';
	$image_id      = ! empty( $item['team_image']['id'] ) ? $item['team_image']['id'] : '';
	$image_url     = '';

	if ( $image_id ) {
		$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $image_id, 'thumbnail', $settings );
	} elseif ( ! empty( $item['team_image']['url'] ) ) {
		$image_url = $item['team_image']['url'];
	}

	$bg_value = $image_url ? 'background-image:url(' . esc_url( $image_url ) . ');' : '';

	if ( 'yes' === $settings['enable_slider'] ) {
		echo '<div class="swiper-slide">';
	}

	printf(
		'<div class="wkit-team-wrapper %1$s%2$s"%3$s>',
		esc_attr( $hover_class ),
		esc_attr( $layout_class ),
		$bg_value ? ' style="' . esc_attr( $bg_value ) . '"' : ''
	);

	echo '<div class="wkit-team d-flex flex-column justify-content-end">';
	echo '<div class="wkit-team-content-wrapper' . esc_attr( $hover_wrapper_class ) . '">';

	if ( $team_position ) {
		echo '<p class="team-position">' . esc_html( $team_position ) . '</p>';
	}

	if ( $team_name ) {
		echo '<h4 class="team-name">' . esc_html( $team_name ) . '</h4>';
	}

	if ( ! empty( $item['show_social_profiles'] ) && 'yes' === $item['show_social_profiles'] ) {
		echo '<div class="team-social-profiles d-flex">';

		for ( $i = 1; $i <= 4; $i++ ) {
			$enabled_key = 'social_' . $i . '_enable';
			$icon_key    = 'social_' . $i . '_icon';
			$link_key    = 'social_' . $i . '_link';
			$label_key   = 'social_' . $i . '_label';

			if ( empty( $item[ $enabled_key ] ) || 'yes' !== $item[ $enabled_key ] ) {
				continue;
			}

			$link_data = ! empty( $item[ $link_key ] ) && is_array( $item[ $link_key ] ) ? $item[ $link_key ] : array();
			$link      = ! empty( $link_data['url'] ) ? $link_data['url'] : '#';
			$target    = ! empty( $link_data['is_external'] ) ? '_blank' : '';
			$rel_parts = array();
			if ( ! empty( $link_data['nofollow'] ) ) {
				$rel_parts[] = 'nofollow';
			}
			if ( ! empty( $link_data['is_external'] ) ) {
				$rel_parts[] = 'noopener';
				$rel_parts[] = 'noreferrer';
			}
			$rel_attr  = implode( ' ', array_unique( $rel_parts ) );
			$label     = ! empty( $item[ $label_key ] ) ? $item[ $label_key ] : '';
			$icon      = ! empty( $item[ $icon_key ] ) && is_array( $item[ $icon_key ] ) ? $item[ $icon_key ] : array();

			printf(
				'<a class="team-social-link d-flex justify-content-center align-items-center%1$s" href="%2$s"%3$s%4$s>',
				esc_attr( $hover_social_class ),
				esc_url( $link ),
				$target ? ' target="' . esc_attr( $target ) . '"' : '',
				$rel_attr ? ' rel="' . esc_attr( $rel_attr ) . '"' : ''
			);

			if ( ! empty( $icon['value'] ) ) {
				\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
			}

			if ( $label ) {
				echo '<span class="sr-only">' . esc_html( $label ) . '</span>';
			}

			echo '</a>';
		}

		echo '</div>';
	}

	echo '</div>';
	echo '</div>';
	echo '</div>';

	if ( 'yes' === $settings['enable_slider'] ) {
		echo '</div>';
	}
}

if ( 'yes' === $settings['enable_slider'] ) {
	echo '</div>';
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

echo '</div>';
