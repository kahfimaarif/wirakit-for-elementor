<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Post Title Elementor Custom Widget.
 *
 * Outputs the post title with optional link, supporting both frontend and editor preview
 * (including handling for elementor_library post type).
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get widget settings.
$settings = $this->get_settings_for_display();

// Define heading tag, default to h1.
$heading_tag  = ! empty( $settings['heading_tag'] ) ? $settings['heading_tag'] : 'h1';
$content      = '';
$heading_link = '';
$trim_enabled = ! empty( $settings['trim_title'] ) && 'yes' === $settings['trim_title'];
$trim_words   = isset( $settings['trim_words'] ) ? max( 1, (int) $settings['trim_words'] ) : 6;
$trim_more    = isset( $settings['trim_more'] ) ? (string) $settings['trim_more'] : '...';

// Current template post ID.
$template_post_id = get_the_ID();

// Fallback for content/title + link.
if ( $template_post_id && get_post_status( $template_post_id ) ) {
	$content = get_the_title( $template_post_id );
	if ( $trim_enabled && ! empty( $content ) ) {
		$content = wp_trim_words( $content, $trim_words, $trim_more );
	}

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_permalink( $template_post_id );
	}
} elseif ( is_singular() ) {
	$content = get_the_title();
	if ( $trim_enabled && ! empty( $content ) ) {
		$content = wp_trim_words( $content, $trim_words, $trim_more );
	}

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_permalink();
	}
}

// Elementor editor preview mode.
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

	// Only run query for supported template builder post types.
	if ( in_array( get_post_type( $template_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {

		$require_terms = ( 'elementor_library' === get_post_type( $template_post_id ) );
		$terms         = $require_terms ? wp_get_object_terms( $template_post_id, 'elementor_library_type', array( 'fields' => 'slugs' ) ) : array( 'builder' );

		if ( ! empty( $terms ) ) {

			// Get included posts.
			$document      = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
			$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

			// Exclude certain post types.
			$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
			$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

			$args = array(
				'post_type'      => $post_types,
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			);

			// Override query if include_posts is defined.
			if ( ! empty( $include_posts ) ) {
				$template_post_ids = is_array( $include_posts ) ? $include_posts : array( $include_posts );
				$args['post__in']  = array_map( 'absint', $template_post_ids );
				$args['orderby']   = 'post__in';
			}

			// Run query.
			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					// Get title & optional link.
					$content      = get_the_title();
					if ( $trim_enabled && ! empty( $content ) ) {
						$content = wp_trim_words( $content, $trim_words, $trim_more );
					}
					$heading_link = ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) ? get_permalink() : '';

					// Handle size class.
					$size_class = ! empty( $settings['size'] ) ? 'elementor-size-' . $settings['size'] : 'elementor-size-default';

					// Render heading.
					echo '<' . esc_attr( $heading_tag ) . ' class="wkit-dynamic-heading elementor-heading-title ' . esc_attr( $size_class ) . '">';

					if ( ! empty( $heading_link ) ) {
						$this->add_render_attribute( 'heading_link', 'href', esc_url( $heading_link ) );

						if ( ! empty( $settings['heading_link']['is_external'] ) && true === $settings['heading_link']['is_external'] ) {
							$this->add_render_attribute( 'heading_link', 'target', '_blank' );
						}

						if ( ! empty( $settings['heading_link']['nofollow'] ) && true === $settings['heading_link']['nofollow'] ) {
							$this->add_render_attribute( 'heading_link', 'rel', 'nofollow noopener noreferrer' );
						}

						// Safe: Elementor escapes attributes internally.
						echo '<a ' . $this->get_render_attribute_string( 'heading_link' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders escaped attributes.
						echo esc_html( $content );
						echo '</a>';
					} else {
						echo esc_html( $content );
					}

					echo '</' . esc_attr( $heading_tag ) . '>';
				}
				wp_reset_postdata();
			}
		}
	} else {
		// For other post types, just show the post title.
		if ( ! empty( $content ) ) :

			$size_class = ! empty( $settings['size'] ) ? 'elementor-size-' . $settings['size'] : 'elementor-size-default';

			echo '<' . esc_attr( $heading_tag ) . ' class="wkit-dynamic-heading elementor-heading-title ' . esc_attr( $size_class ) . '">';

			if ( ! empty( $heading_link ) ) {
				$this->add_render_attribute( 'heading_link', 'href', esc_url( $heading_link ) );

				if ( ! empty( $settings['heading_link']['is_external'] ) && true === $settings['heading_link']['is_external'] ) {
					$this->add_render_attribute( 'heading_link', 'target', '_blank' );
				}

				if ( ! empty( $settings['heading_link']['nofollow'] ) && true === $settings['heading_link']['nofollow'] ) {
					$this->add_render_attribute( 'heading_link', 'rel', 'nofollow noopener noreferrer' );
				}

				// Safe: Elementor escapes attributes internally.
				echo '<a ' . $this->get_render_attribute_string( 'heading_link' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders escaped attributes.
				echo esc_html( $content );
				echo '</a>';
			} else {
				echo esc_html( $content );
			}

			echo '</' . esc_attr( $heading_tag ) . '>';

		endif; // ! empty( $content )
	}
} else {
	// Frontend render for normal posts/pages.
	if ( ! empty( $content ) ) :

		$size_class = ! empty( $settings['size'] ) ? 'elementor-size-' . $settings['size'] : 'elementor-size-default';

		echo '<' . esc_attr( $heading_tag ) . ' class="wkit-dynamic-heading elementor-heading-title ' . esc_attr( $size_class ) . '">';

		if ( ! empty( $heading_link ) ) {
			$this->add_render_attribute( 'heading_link', 'href', esc_url( $heading_link ) );

			if ( ! empty( $settings['heading_link']['is_external'] ) && true === $settings['heading_link']['is_external'] ) {
				$this->add_render_attribute( 'heading_link', 'target', '_blank' );
			}

			if ( ! empty( $settings['heading_link']['nofollow'] ) && true === $settings['heading_link']['nofollow'] ) {
				$this->add_render_attribute( 'heading_link', 'rel', 'nofollow noopener noreferrer' );
			}

			// Safe: Elementor escapes attributes internally.
			echo '<a ' . $this->get_render_attribute_string( 'heading_link' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders escaped attributes.
			echo esc_html( $content );
			echo '</a>';
		} else {
			echo esc_html( $content );
		}

		echo '</' . esc_attr( $heading_tag ) . '>';

	endif; // ! empty( $content )
}
