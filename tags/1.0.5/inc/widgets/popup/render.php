<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render template for Popup Elementor Custom Widget.
 *
 * This file renders iframe or selected Elementor templates inside
 * the widget. It attempts to render via Elementor frontend,
 * and falls back to WordPress post content if Elementor
 * output is empty.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings    = $this->get_settings_for_display();
$template_id = absint( $settings['popup_template'] );
$popup_id    = 'wkit-popup-' . $this->get_id(); // unique ID per widget instance.
$icon        = ! empty( $settings['icon_button']['value'] ) ? $settings['icon_button']['value'] : '';
$popup_type  = isset( $settings['popup_type'] ) ? $settings['popup_type'] : 'inline';
$popup_href  = ( 'iframe' === $popup_type && ! empty( $settings['iframe_url'] ) ) ? esc_url( $settings['iframe_url'] ) : '#' . esc_attr( $popup_id );
$popup_class = ( 'iframe' === $popup_type ) ? 'wkit-popup-video' : 'wkit-popup-btn';
$popup_trigger = isset( $settings['popup_trigger'] ) ? $settings['popup_trigger'] : 'button';
$button_glow = isset( $settings['enable_btn_glow'] ) ? $settings['enable_btn_glow'] : '';

/**
 * Base button classes.
 */
$this->add_render_attribute(
	'button',
	'class',
	( 'button' === $popup_trigger ) ? array( $popup_class, 'wkit-btn', 'wkit-btn-main' ) : array( $popup_class )
);

/**
 * Elementor hover animation class.
 */
if ( ! empty( $settings['hover_animation'] ) ) {
	$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
}

/**
 * Base Wrapper Classes.
 */
$this->add_render_attribute(
	'wrapper',
	'class',
	array(
		'wkit-popup-wrapper',
		'wkit-popup-hide',
	)
);

$this->add_render_attribute( 'btn_icon', 'class', 'icon-button position-relative' );

if ( 'yes' === $button_glow ) {
	$this->add_render_attribute( 'btn_icon', 'class', 'button-glow' );
}

/**
 * Data attributes.
 */
$this->add_render_attribute( 'wrapper', 'data-anim', $settings['popup_animation'] );
$this->add_render_attribute( 'wrapper', 'data-id', $popup_id );
$this->add_render_attribute( 'button', 'data-anim', $settings['popup_animation'] );
$this->add_render_attribute( 'button', 'data-id', $popup_id );

/**
 * === MAIN RENDER ===
 */
if ( ( 'iframe' === $popup_type && ! empty( $settings['iframe_url'] ) ) || ( 'inline' === $popup_type && ! empty( $settings['popup_template'] ) ) ) {

	// === Universal Button / Icon Trigger ===
	echo '<div class="wkit-button-wrapper d-flex">';
	echo '<a href="' . esc_url( $popup_href ) . '" ' . $this->get_render_attribute_string( 'button' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: already escaped by Elementor

	if ( 'button' === $popup_trigger ) {
		echo '<span class="wkit-btn-wrapper d-flex">';

		// Icon before text.
		if ( ! empty( $settings['button_icon']['value'] ) && 'before' === $settings['icon_position'] ) {
			echo '<span class="wkit-btn-icon"><i class="' . esc_attr( $settings['button_icon']['value'] ) . '"></i></span>';
		}

		// Button text.
		if ( ! empty( $settings['button_text'] ) ) {

			echo '<div class="wkit-btn-text-wrapper">';
			echo '<span class="wkit-btn-text">' . esc_html( $settings['button_text'] ) . '</span>';
			echo '<span class="wkit-btn-text">' . esc_html( $settings['button_text'] ) . '</span>';
			echo '</div>';
		}

		// Icon after text.
		if ( ! empty( $settings['button_icon']['value'] ) && 'after' === $settings['icon_position'] ) {
			echo '<span class="wkit-btn-icon icon-right"><i class="' . esc_attr( $settings['button_icon']['value'] ) . '"></i></span>';
		}

		echo '</span>'; // .wkit-btn-wrapper

	} elseif ( 'icon' === $popup_trigger ) {
		echo '<div ' . $this->get_render_attribute_string( 'btn_icon' ) . '><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: already escaped by Elementor
	}

	echo '</a>';
	echo '</div>';



	// === Inline popup content ===
	if ( 'inline' === $popup_type && ! empty( $settings['popup_template'] ) && class_exists( '\Elementor\Plugin' ) ) {

		echo '<div id="' . esc_attr( $popup_id ) . '" ' . $this->get_render_attribute_string( 'wrapper' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: already escaped by Elementor

		// Render Elementor template content.
		$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );

		if ( ! empty( trim( $content ) ) ) {
			echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: already escaped by Elementor
		} else {
			// Fallback to post content.
			$post_obj = get_post( $template_id );
			if ( $post_obj ) {
				global $post;
				$backup = $post;
				$post   = $post_obj;
				setup_postdata( $post );

				echo apply_filters( 'the_content', $post_obj->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Safe: 'the_content' filter outputs formatted post HTML.

				wp_reset_postdata();
				$post = $backup;
			} else {
				echo '<p>' . esc_html__( 'No content found for this template.', 'wira-kit-for-elementor' ) . '</p>';
			}
		}

		echo '</div>'; // close wkit-popup-hide.
	}
} else {
	echo '<p>' . esc_html__( 'Please choose a popup template or iframe URL.', 'wira-kit-for-elementor' ) . '</p>';
}
