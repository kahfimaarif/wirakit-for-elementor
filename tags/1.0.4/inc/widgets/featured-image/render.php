<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Featured Image Elementor Custom Widget.
 *
 * Dynamically displays the post featured image, with optional link.
 * Supports previewing inside Elementor editor with elementor_library templates.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

// Bail if no global $post.
if ( ! $post ) {
	return;
}

$settings = $this->get_settings_for_display();

// =======================================
// Elementor Editor Mode (preview handling)
// =======================================
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

	$template_post_id = get_the_ID();

	// Preview when editing supported template builder post types.
	if ( in_array( get_post_type( $template_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {

		$require_terms = ( 'elementor_library' === get_post_type( $template_post_id ) );
		$terms         = $require_terms ? wp_get_object_terms( $template_post_id, 'elementor_library_type', array( 'fields' => 'slugs' ) ) : array( 'builder' );

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

			// Force include specific posts if defined.
			if ( ! empty( $include_posts ) ) {
				$template_post_ids = is_array( $include_posts ) ? $include_posts : array( $include_posts );
				$args['post__in']  = array_map( 'absint', $template_post_ids );
				$args['orderby']   = 'post__in';
			}

			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					// Render featured image if exists.
					if ( has_post_thumbnail() ) {
						$image_id  = get_post_thumbnail_id();
						$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
							$image_id,
							'thumbnail',
							$settings
						);

						if ( $image_url ) {
							$image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title() ) . '">';

							// Wrap with link if enabled.
							if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
								$image_html = '<a href="' . esc_url( get_permalink() ) . '">' . $image_html . '</a>';
							}

							echo '<div class="wkit-featured-image">' . wp_kses_post( $image_html ) . '</div>';
						}
					}
				}
				wp_reset_postdata();
			} else {
				// Fallback message inside editor.
				echo '<p>' . esc_html__( 'This is just content preview for dynamic content post.', 'wira-kit-for-elementor' ) . '</p>';
			}
		}
	} elseif ( has_post_thumbnail( $post->ID ) ) {
		// Regular post when editing.
		$image_id  = get_post_thumbnail_id( $post->ID );
		$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
			$image_id,
			'thumbnail',
			$settings
		);

		if ( $image_url ) {
			$image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title( $post->ID ) ) . '">';

			if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
				$image_html = '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . $image_html . '</a>';
			}

			echo '<div class="wkit-featured-image">' . wp_kses_post( $image_html ) . '</div>';
		}
	}
} elseif ( has_post_thumbnail( $post->ID ) ) {
	// ==========================
	// Frontend render (non-edit)
	// ==========================
	$image_id  = get_post_thumbnail_id( $post->ID );
	$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
		$image_id,
		'thumbnail',
		$settings
	);

	if ( $image_url ) {
		$image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title( $post->ID ) ) . '">';

		if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
			$image_html = '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . $image_html . '</a>';
		}

		echo '<div class="wkit-featured-image">' . wp_kses_post( $image_html ) . '</div>';
	}
}
