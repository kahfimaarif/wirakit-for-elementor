<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Post Excerpt Elementor Custom Widget.
 *
 * Displays a trimmed excerpt of the current post, with length
 * configurable via Elementor widget settings. Supports dynamic preview
 * in Elementor editor for `elementor_library` post types.
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
$length   = ! empty( $settings['excerpt_length'] ) ? absint( $settings['excerpt_length'] ) : 20;

if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

	$template_post_id = get_the_ID();

	// Only run the preview query for supported template builder post types.
	if ( in_array( get_post_type( $template_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {

		$require_terms = ( 'elementor_library' === get_post_type( $template_post_id ) );
		$terms         = $require_terms ? wp_get_object_terms( $template_post_id, 'elementor_library_type', array( 'fields' => 'slugs' ) ) : array( 'builder' );
		if ( ! empty( $terms ) ) {

			// Get include_posts setting from Elementor document.
			$document      = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
			$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

			// Exclude template-only post types.
			$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
			$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

			// Build query args.
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

					// Trim excerpt to requested length.
					$excerpt = wp_trim_words( get_the_excerpt(), $length, '...' );

					echo '<div class="wkit-post-excerpt">' . wp_kses_post( $excerpt ) . '</div>';
				}
				wp_reset_postdata();
			} else {
				// Fallback if no valid posts found.
				echo '<div class="wkit-post-excerpt"><em>' . esc_html__( 'No valid excerpt available.', 'wira-kit-for-elementor' ) . '</em></div>';
			}
		}
	} else {
		// Normal edit mode (not template library).
		$excerpt = wp_trim_words( get_the_excerpt(), $length, '...' );
		echo '<div class="wkit-post-excerpt">' . wp_kses_post( $excerpt ) . '</div>';
	}
} else {
	// Frontend render.
	$excerpt = wp_trim_words( get_the_excerpt(), $length, '...' );
	echo '<div class="wkit-post-excerpt">' . wp_kses_post( $excerpt ) . '</div>';
}



