<?php
/**
 * Widget Functions Loader.
 *
 * @package    Wira Kit for Elementor
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Widgets_Loader' ) ) {

	/**
	 * Loader for widget-related files.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Widgets_Loader {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->load_widget_files();
		}

		/**
		 * Load all widget-related files.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function load_widget_files() {
			require_once WIRAKIT_PATH . 'inc/widgets/class-wirakit-custom-widgets.php';
			require_once WIRAKIT_PATH . 'inc/widgets/class-wirakit-custom-widget-assets.php';
			require_once WIRAKIT_PATH . 'inc/widgets/class-wirakit-widget-helper.php';
			require_once WIRAKIT_PATH . 'inc/widgets/class-wirakit-template-library-helper.php';
			require_once WIRAKIT_PATH . 'inc/widgets/class-wirakit-widget-ajax.php';
			require_once WIRAKIT_PATH . 'inc/widgets/nav-menu/class-bootstrap-navwalker.php';
		}
	}

	new Wirakit_Widgets_Loader();
}
