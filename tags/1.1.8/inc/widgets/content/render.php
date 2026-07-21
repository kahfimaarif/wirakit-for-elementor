<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Content Dynamic Elementor Custom Widget.
 *
 * Displays dynamic post content when editing in Elementor or
 * outputs the current post content on the frontend.
 * Supports template previews for `elementor_library` post type.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wkit-content-widget">
	<?php
	// Check if Elementor editor is active.
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

		$template_post_id = get_the_ID();

		// Only run preview query for supported template builder post types.
		if ( in_array( get_post_type( $template_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {

			// Retrieve document settings for preview posts.
			$document      = \Elementor\Plugin::$instance->documents->get( $template_post_id );
			$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

			$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
			$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

			$args = array(
				'post_type'      => $post_types,
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			);

			// Restrict to specific posts if provided.
			if ( ! empty( $include_posts ) ) {
				$template_post_ids = is_array( $include_posts ) ? $include_posts : array( $include_posts );
				$args['post__in']  = array_map( 'absint', $template_post_ids );
				$args['orderby']   = 'post__in';
			}

			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$content = get_the_content();

					if ( ! empty( $content ) ) {
						// Safe: post content is passed through 'the_content' filter which applies WP core sanitization (kses, embeds, shortcodes).
						echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Safe: 'the_content' filter outputs formatted post HTML.
					} else {
						echo '<em>' . esc_html__( 'No valid content available.', 'wira-kit-for-elementor' ) . '</em>';
					}
				}
				wp_reset_postdata();
			} else {
				// Fallback if no posts found for preview.
				echo '<p>' . esc_html__( 'This is just content preview for dynamic content post.', 'wira-kit-for-elementor' ) . '</p>';
			}
		} else {
			// Non-template library posts: render their content normally.
			echo apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Safe: 'the_content' filter outputs formatted post HTML.
		}
	} else {
		// Frontend rendering outside editor: output post content.
		echo apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Safe: 'the_content' filter outputs formatted post HTML.
	}
	?>
</div>

