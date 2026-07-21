<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render template for Block Template Elementor Custom Widget.
 *
 * This file renders selected Elementor templates inside
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

$settings = $this->get_settings_for_display();

// Ensure template is selected and Elementor is active.
if ( isset( $settings['blocks_template'] ) && ! empty( $settings['blocks_template'] ) && class_exists( '\Elementor\Plugin' ) ) {

	$template_id = absint( $settings['blocks_template'] );

	// Ensure template CSS/JS assets are loaded for nested Elementor content.
	$elementor = \Elementor\Plugin::instance();
	$elementor->frontend->enqueue_styles();
	$elementor->frontend->enqueue_scripts();
	if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
		$css_file = new \Elementor\Core\Files\CSS\Post( $template_id );
		$css_file->enqueue();
	}

	// Try rendering via Elementor frontend.
	$content = \Elementor\Plugin::instance()
		->frontend
		->get_builder_content_for_display( $template_id );

	if ( ! empty( trim( $content ) ) ) {
		// Elementor already escapes output internally.
		$wrapper_id = 'wkit-block-template-' . $template_id . '-' . uniqid();
		printf( '<div id="%s" class="wkit-block-template-content">', esc_attr( $wrapper_id ) );
		echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor builder content is intended HTML output.
		echo '</div>';

		// In Elementor editor, remove elementor-invisible inside this block template
		// to avoid motion effects keeping elements hidden.
		if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			wp_enqueue_script( 'wkit-block-template-frontend-js' );
		}

	} else {
		// === Fallback: render WordPress post content ===
		$post_obj = get_post( $template_id );

		if ( $post_obj ) {
			global $post;

			// Backup current post to restore later.
			$backup = $post;
			$post   = $post_obj;
			setup_postdata( $post );

			// 'the_content' filter applies sanitization (kses, embeds, shortcodes).
			echo apply_filters( 'the_content', $post_obj->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Safe: 'the_content' filter outputs formatted post HTML.

			// Restore global $post.
			wp_reset_postdata();
			$post = $backup;

		} else {
			// Fallback if post object not found.
			echo '<p>' . esc_html__( 'No content found for this template.', 'wira-kit-for-elementor' ) . '</p>';
		}
	}
} else {
	// Fallback if no template selected.
	echo '<p>' . esc_html__( 'Choose block template', 'wira-kit-for-elementor' ) . '</p>';
}
