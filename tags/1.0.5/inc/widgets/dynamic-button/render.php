<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Dynamic Button Elementor Custom Widget.
 *
 * Dynamically outputs a button that links to the current post,
 * or to preview posts when editing a template in Elementor.
 * Supports elementor_library post type with include_posts preview.
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

// Default link (frontend will use current post permalink).
$default_link = get_permalink();


if ( ! function_exists( 'Wirakit_render_dynamic_button' ) ) {
	/**
	 * Helper: render button markup with attributes.
	 *
	 * @param \Elementor\Widget_Base $widget   Widget instance ($this).
	 * @param array                  $settings Widget settings.
	 * @param string                 $link     URL for the button href.
	 * @param string                 $attr     Attribute key used by add_render_attribute.
	 * @return void
	 */
	function Wirakit_render_dynamic_button( $widget, $settings, $link = '', $attr = 'button' ) {
		$button_trigger_type = ! empty( $settings['button_trigger_type'] ) ? $settings['button_trigger_type'] : 'button';

		// Ensure no leftover attributes for this key.
		if ( method_exists( $widget, 'remove_render_attribute' ) ) {
			$widget->remove_render_attribute( $attr );
		}

		// Href.
		$widget->add_render_attribute( $attr, 'href', esc_url( $link ) );

		// Base classes.
		$classes = array();
		if ( 'icon' === $button_trigger_type ) {
			$classes = array(
				'icon-button',
				'd-inline-flex',
				'align-items-center',
				'justify-content-center',
				'position-relative',
			);
		} else {
			$classes = array( 'wkit-btn', 'wkit-btn-main' );
		}
		$widget->add_render_attribute( $attr, 'class', $classes );

		// Hover animation.
		if ( ! empty( $settings['hover_animation'] ) ) {
			$widget->add_render_attribute( $attr, 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		// Output markup.
		echo '<div class="wkit-button-wrapper d-flex">';
			echo '<a ' . $widget->get_render_attribute_string( $attr ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor escapes internally.
			if ( 'icon' === $button_trigger_type ) {
				if ( ! empty( $settings['button_icon']['value'] ) ) {
					echo '<i class="' . esc_attr( $settings['button_icon']['value'] ) . '" aria-hidden="true"></i>';
				} else {
					echo '<span class="wkit-btn-text">' . esc_html( isset( $settings['button_text'] ) ? $settings['button_text'] : '' ) . '</span>';
				}
			} else {
				echo '<span class="wkit-btn-wrapper d-flex">';

					// Icon before text.
		if ( ! empty( $settings['button_icon']['value'] ) && ( ! empty( $settings['icon_position'] ) && 'before' === $settings['icon_position'] ) ) {
			echo '<span class="wkit-btn-icon">';
				echo '<i class="' . esc_attr( $settings['button_icon']['value'] ) . '"></i>';
			echo '</span>';
		}

					// Text.
					echo '<div class="wkit-btn-text-wrapper">';
					echo '<span class="wkit-btn-text">';
						echo esc_html( isset( $settings['button_text'] ) ? $settings['button_text'] : '' );
					echo '</span>';
					echo '<span class="wkit-btn-text">';
						echo esc_html( isset( $settings['button_text'] ) ? $settings['button_text'] : '' );
					echo '</span>';
					echo '</div>';

					// Icon after text.
		if ( ! empty( $settings['button_icon']['value'] ) && ( ! empty( $settings['icon_position'] ) && 'after' === $settings['icon_position'] ) ) {
			echo '<span class="wkit-btn-icon icon-right">';
				echo '<i class="' . esc_attr( $settings['button_icon']['value'] ) . '"></i>';
			echo '</span>';
		}

				echo '</span>'; // .wkit-btn-wrapper
			}
			echo '</a>';
		echo '</div>'; // .button-wrapper
	}
}

// ======================
// Render logic
// ======================

// Elementor Editor Mode.
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

	$template_post_id = get_the_ID();

	// If editing a supported template builder document, attempt preview via include_posts.
	if ( in_array( get_post_type( $template_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {

		$require_terms = ( 'elementor_library' === get_post_type( $template_post_id ) );
		$terms         = $require_terms ? wp_get_object_terms( $template_post_id, 'elementor_library_type', array( 'fields' => 'slugs' ) ) : array( 'builder' );

		// Run preview query when terms requirement is satisfied.
		if ( ! empty( $terms ) ) {

			$document      = \Elementor\Plugin::$instance->documents->get( $template_post_id );
			$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

			$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
			$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

			$args = array(
				'post_type'      => $post_types,
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			);

			// Restrict preview to specific posts if defined.
			if ( ! empty( $include_posts ) ) {
				$template_post_ids         = is_array( $include_posts ) ? $include_posts : array( $include_posts );
				$args['post__in'] = array_map( 'absint', $template_post_ids );
				$args['orderby']  = 'post__in';
			}

			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					// Use queried post permalink for preview.
					$link_query = get_permalink( get_the_ID() );

					// Render button with queried link.
					Wirakit_render_dynamic_button( $this, $settings, $link_query, 'button_query' );
				}
				wp_reset_postdata();
			} else {
				// Fallback: button points to default link.
				Wirakit_render_dynamic_button( $this, $settings, $default_link, 'button' );
			}
		} else {
			// No template library type terms: fallback to default link.
			Wirakit_render_dynamic_button( $this, $settings, $default_link, 'button' );
		}
	} else {
		// Editing a normal post: link to current post.
		Wirakit_render_dynamic_button( $this, $settings, $default_link, 'button' );
	}
} else {
	// Frontend: always link to current post context.
	Wirakit_render_dynamic_button( $this, $settings, $default_link, 'button' );
}
