<?php
/**
 * Template Library Helper.
 *
 * Provides helper methods to query and render Elementor Template Library items.
 *
 * @package    Wira Kit for Elementor
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Library_Helper' ) ) {

	/**
	 * Helper for Elementor Template Library integration.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Template_Library_Helper {

		/**
		 * Get all templates from Elementor Template Library.
		 *
		 * @since 1.0.0
		 * @return array<int,string>
		 */
		public static function get_templates_options() {
			$options = array();
			$args    = array(
				'post_type'      => 'elementor_library',
				'post_status'    => array( 'publish', 'draft', 'private' ),
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			);

			$templates = get_posts( $args );
			if ( ! empty( $templates ) ) {
				foreach ( $templates as $template ) {
					$options[ $template->ID ] = $template->post_title;
				}
			}

			return $options;
		}

		/**
		 * Render Elementor template content by template ID.
		 *
		 * @since 1.0.0
		 * @param int $template_id Elementor template post ID.
		 * @return string
		 */
		public static function render_elementor_template( $template_id ) {
			$template_id = absint( $template_id );
			if ( ! $template_id || ! class_exists( '\Elementor\Plugin' ) ) {
				return '';
			}

			return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
		}
	}
}

