<?php
/**
 * Helper render functions for Loop widget.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'Wirakit_render_loop_item' ) ) {
	/**
	 * Render a single loop item using Elementor template.
	 *
	 * @param array $settings Widget settings.
	 * @return void
	 */
	function Wirakit_render_loop_item( $settings ) {
		echo '<div class="wkit-loop-item">';

		if ( ! empty( $settings['loop_template'] ) && class_exists( '\Elementor\Plugin' ) ) {
			$template_id = absint( $settings['loop_template'] );
			$content     = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );

			if ( ! empty( trim( $content ) ) ) {
				echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor builder content is intended HTML output.
			} else {
				echo '<p>' . esc_html__( 'Loop template is empty, please edit it in Elementor.', 'wira-kit-for-elementor' ) . '</p>';
			}
		} else {
			echo '<p>' . esc_html__( 'Choose loop template.', 'wira-kit-for-elementor' ) . '</p>';
		}

		echo '</div>'; // .wkit-loop-item.
	}
}
