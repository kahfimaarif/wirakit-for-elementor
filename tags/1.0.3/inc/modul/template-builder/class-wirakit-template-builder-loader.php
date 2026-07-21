<?php
/**
 * Template Builder Module Loader.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Builder_Loader' ) ) {

	/**
	 * Bootstraps Template Builder module.
	 */
	class Wirakit_Template_Builder_Loader {

		/**
		 * Constructor.
		 */
		public function __construct() {
			require_once WIRAKIT_PATH . 'inc/modul/template-builder/class-wirakit-template-builder-post-type.php';
			require_once WIRAKIT_PATH . 'inc/modul/template-builder/class-wirakit-template-builder-admin.php';
			require_once WIRAKIT_PATH . 'inc/modul/template-builder/class-wirakit-template-builder-frontend.php';

			new Wirakit_Template_Builder_Post_Type();
			new Wirakit_Template_Builder_Admin();

			// Keep admin management available; only frontend replacement follows module toggle.
			if ( ! class_exists( 'Wirakit_Functions' ) || Wirakit_Functions::is_module_enabled( 'template-builder' ) ) {
				new Wirakit_Template_Builder_Frontend();
			}
		}
	}

	new Wirakit_Template_Builder_Loader();
}
