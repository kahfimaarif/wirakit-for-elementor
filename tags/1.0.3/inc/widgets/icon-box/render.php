<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Icon Box Elementor Custom Widget.
 *
 * Displays a customizable icon box with optional background,
 * icon/image, excerpt, and learn more link.
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

if ( ! function_exists( 'Wirakit_render_icon_box_item' ) ) {
	/**
	 * Render single Icon Box item for Elementor widget.
	 *
	 * @since 1.0.0
	 * @param array $settings Elementor widget settings untuk Icon Box.
	 * @return void
	 */
	function Wirakit_render_icon_box_item( $settings ) {
		$icon         = ! empty( $settings['icon_box_icon']['value'] ) ? $settings['icon_box_icon']['value'] : '';
		$icon_image   = ! empty( $settings['icon_image']['url'] ) ? $settings['icon_image']['url'] : '';
		$image_custom = ! empty( $settings['background_image']['url'] ) ? $settings['background_image']['url'] : '';
		$title        = ! empty( $settings['icon_box_title'] ) ? $settings['icon_box_title'] : '';
		$excerpt      = ! empty( $settings['icon_box_content_excerpt'] ) ? $settings['icon_box_content_excerpt'] : '';
		$link         = ! empty( $settings['icon_box_button_link']['url'] ) ? $settings['icon_box_button_link']['url'] : '';

		// Optional background image.
		$bg_value = '';
		if ( ! empty( $settings['show_background_image'] ) && 'yes' === $settings['show_background_image'] ) {
			$bg_value = 'background-image:url(' . esc_url( $image_custom ) . ');';
		}

		// Hover animations.
		$hover_class           = ! empty( $settings['hover_animation_container'] ) ? ' elementor-animation-' . $settings['hover_animation_container'] : '';
		$hover_class_learnmore = ! empty( $settings['hover_animation_learnmore'] ) ? ' elementor-animation-' . $settings['hover_animation_learnmore'] : '';

		// Wrapper start.
		printf(
			'<div class="wkit-icon-box-item-wrapper %1$s"%2$s>',
			esc_attr( $hover_class ),
			$bg_value ? ' style="' . esc_attr( $bg_value ) . '"' : ''
		);

		// Global link wrapper if Learn More is disabled.
		if ( ( empty( $settings['show_learnmore'] ) || 'yes' !== $settings['show_learnmore'] ) && $link ) {
			echo '<a class="wkit-icon-box-item-global-link wkit-use-global-link" href="' . esc_url( $link ) . '">';
		}

		echo '<div class="wkit-icon-box-item d-flex">';

		// Render icon (icon font or image).
		if ( ! empty( $settings['show_icon_box_icon'] ) && ! empty( $settings['icon_type'] ) && 'yes' === $settings['show_icon_box_icon'] ) {
			echo '<div class="icon-box-icon-wrapper d-flex">';
			if ( 'icon' === $settings['icon_type'] && $icon ) {
				echo '<div class="icon-box-icon"><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i></div>';
			} elseif ( 'image' === $settings['icon_type'] && $icon_image ) {
				echo '<img class="icon-box-image" src="' . esc_url( $icon_image ) . '" alt="">';
			}
			echo '</div>';
		}

		// Content wrapper start.
		echo '<div class="wkit-icon-box-content-wrapper">';
		echo '<h4 class="icon-box-title">' . esc_html( $title ) . '</h4>';

		// Excerpt.
		if ( $excerpt ) {
			echo '<p class="icon-box-excerpt">' . esc_html( $excerpt ) . '</p>';
		}

		// Learn More button.
		if ( ! empty( $settings['show_learnmore'] ) && 'yes' === $settings['show_learnmore'] ) {
			echo '<div class="learnmore-wrapper d-flex">';
			echo '<a href="' . esc_url( $link ) . '" class="wkit-learnmore wkit-btn-text-two' . esc_attr( $hover_class_learnmore ) . '">';
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

		echo '</div>'; // .wkit-icon-box-content-wrapper.
		echo '</div>'; // .wkit-icon-box-item.

		// Close global link if opened.
		if ( ( empty( $settings['show_learnmore'] ) || 'yes' !== $settings['show_learnmore'] ) && $link ) {
			echo '</a>';
		}

		echo '</div>'; // .wkit-icon-box-item-wrapper.
	}
}

// Render the item.
Wirakit_render_icon_box_item( $settings );


