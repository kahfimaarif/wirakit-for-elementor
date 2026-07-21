<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Post Meta Elementor Custom Widget.
 *
 * Displays post meta information such as date, author, category, and comments.
 * Icons can optionally be shown before or after each meta item.
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

if ( ! function_exists( 'Wirakit_render_post_meta' ) ) {
	/**
	 * Render post meta items.
	 *
	 * @param array $settings Widget settings from Elementor.
	 */
	function Wirakit_render_post_meta( $settings ) {
		if ( empty( $settings['meta_data'] ) || ! is_array( $settings['meta_data'] ) ) {
			return;
		}

		echo '<div class="wkit-post-meta d-flex">';

		foreach ( $settings['meta_data'] as $meta ) {
			switch ( $meta ) {
				// === Date meta ===
				case 'date':
					echo '<span class="wkit-text-small wkit-color-placeholder">';
					if ( 'before' === $settings['meta_icon_position'] && ! empty( $settings['date_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['date_icon']['value'] ) . ' wkit-color-secondary me-1"></i>';
					}
					echo esc_html( get_the_date() );
					if ( 'after' === $settings['meta_icon_position'] && ! empty( $settings['date_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['date_icon']['value'] ) . ' wkit-color-secondary ms-1"></i>';
					}
					echo '</span>';
					break;

				// === Author meta ===
				case 'author':
					echo '<span class="wkit-text-small wkit-color-placeholder">';
					if ( 'before' === $settings['meta_icon_position'] && ! empty( $settings['author_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['author_icon']['value'] ) . ' wkit-color-secondary me-1"></i>';
					}
					echo esc_html( get_the_author() );
					if ( 'after' === $settings['meta_icon_position'] && ! empty( $settings['author_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['author_icon']['value'] ) . ' wkit-color-secondary ms-1"></i>';
					}
					echo '</span>';
					break;

				// === Category meta ===
				case 'category':
					echo '<span class="wkit-text-small wkit-post-meta-category wkit-color-placeholder">';
					if ( 'before' === $settings['meta_icon_position'] && ! empty( $settings['category_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['category_icon']['value'] ) . ' wkit-color-secondary me-1"></i>';
					}
					echo wp_kses_post( get_the_category_list( ', ' ) );
					if ( 'after' === $settings['meta_icon_position'] && ! empty( $settings['category_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['category_icon']['value'] ) . ' wkit-color-secondary ms-1"></i>';
					}
					echo '</span>';
					break;

				// === Comment count meta ===
				case 'comment':
					echo '<span class="wkit-text-small wkit-color-placeholder">';
					if ( 'before' === $settings['meta_icon_position'] && ! empty( $settings['comment_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['comment_icon']['value'] ) . ' wkit-color-secondary me-1"></i>';
					}
					echo esc_html( get_comments_number_text() );
					if ( 'after' === $settings['meta_icon_position'] && ! empty( $settings['comment_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['comment_icon']['value'] ) . ' wkit-color-secondary ms-1"></i>';
					}
					echo '</span>';
					break;
			}
		}

		echo '</div>';
	}
}

if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

	$template_post_id = get_the_ID();

	// Only run the preview query for supported template builder post types.
	if ( in_array( get_post_type( $template_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {

		$require_terms = ( 'elementor_library' === get_post_type( $template_post_id ) );
		$terms         = $require_terms ? wp_get_object_terms( $template_post_id, 'elementor_library_type', array( 'fields' => 'slugs' ) ) : array( 'builder' );
		if ( ! empty( $terms ) ) {

			$document      = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
			$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

			// Exclude template-only post types.
			$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
			$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

			$args = array(
				'post_type'      => $post_types,
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			);

			if ( ! empty( $include_posts ) ) {
				$template_post_ids = is_array( $include_posts ) ? $include_posts : array( $include_posts );
				$args['post__in']  = array_map( 'absint', $template_post_ids );
				$args['orderby']   = 'post__in';
			}

			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					// Render post meta for preview.
					Wirakit_render_post_meta( $settings );
				}
				wp_reset_postdata();
			} else {
				// Fallback message if no posts found.
				echo '<em>' . esc_html__( 'No valid Post Meta available.', 'wira-kit-for-elementor' ) . '</em>';
			}
		}
	} else {
		// Not a template library template, render normally in editor.
		Wirakit_render_post_meta( $settings );
	}
} else {
	// Frontend render.
	Wirakit_render_post_meta( $settings );
}


