<?php
/**
 * Elementor Custom Widgets and Category Register.
 *
 * Registers custom Elementor widgets and widget categories
 * for the Wira Kit for Elementor plugin.
 *
 * @package    Wira Kit for Elementor
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Wirakit_Custom_Widgets' ) ) {

	/**
	 * Handles registration of custom Elementor widgets and categories.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Custom_Widgets {

		/**
		 * Constructor.
		 *
		 * Initializes hooks to register widgets and categories.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->load_hooks();
		}

		/**
		 * Load WordPress hooks for Elementor.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function load_hooks() {
			// Register custom widgets.
			add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

			// Register custom categories.
			add_action( 'elementor/elements/categories_registered', array( $this, 'add_widget_categories' ) );
		}

		/**
		 * Register custom widgets with Elementor.
		 *
		 * Loads widget files and registers them with Elementor's widget manager.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
		 * @return void
		 */
		public function register_widgets( $widgets_manager ) {
			if ( ! class_exists( 'Wirakit_Functions' ) || ! method_exists( 'Wirakit_Functions', 'get_widget_definitions' ) ) {
				return;
			}

			$widget_definitions = Wirakit_Functions::get_widget_definitions();

			foreach ( $widget_definitions as $widget ) {
				if ( empty( $widget['id'] ) || empty( $widget['file'] ) || empty( $widget['class'] ) ) {
					continue;
				}

				if ( ! Wirakit_Functions::is_widget_enabled( $widget['id'] ) ) {
					continue;
				}

				$widget_file = __DIR__ . '/' . $widget['file'];
				if ( ! file_exists( $widget_file ) ) {
					continue;
				}

				require_once $widget_file;

				if ( class_exists( $widget['class'] ) ) {
					$widgets_manager->register( new $widget['class']() );
				}
			}
		}

		/**
		 * Add custom widget categories in Elementor.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
		 * @return void
		 */
		public function add_widget_categories( $elements_manager ) {
			$elements_manager->add_category(
				'wira-kit-for-elementor',
				array(
					'title' => esc_html__( 'Wira Kit - General', 'wira-kit-for-elementor' ),
					'icon'  => 'fas fa-plug',
				),
				1
			);

			$elements_manager->add_category(
				'wira-kit-for-elementor-dynamic',
				array(
					'title' => esc_html__( 'Wira Kit - Dynamic', 'wira-kit-for-elementor' ),
					'icon'  => 'fas fa-plug',
				),
				2
			);

			$elements_manager->add_category(
				'wira-kit-for-elementor-single',
				array(
					'title' => esc_html__( 'Wira Kit - Single', 'wira-kit-for-elementor' ),
					'icon'  => 'fas fa-plug',
				),
				2
			);

		}
	}

	// Initialize the Elementor extension.
	new Wirakit_Custom_Widgets();
}



