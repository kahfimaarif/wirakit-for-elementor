<?php
/**
 * Template Importer Module Loader.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Importer_Loader' ) ) {

	/**
	 * Bootstraps Template Importer module.
	 */
	class Wirakit_Template_Importer_Loader {

		/**
		 * Constructor.
		 */
		public function __construct() {
			if ( defined( 'WIRA_EXTENDED_VERSION' ) || class_exists( 'WiraExtend_Template_Importer' ) ) {
				if ( function_exists( 'we_fs' ) && we_fs()->has_any_active_valid_license() ) {
					return;
				}
			}

			require_once WIRAKIT_PATH . 'inc/modul/template-importer/class-wirakit-template-importer.php';
			new Wirakit_Template_Importer();
		}
	}

	new Wirakit_Template_Importer_Loader();
}
