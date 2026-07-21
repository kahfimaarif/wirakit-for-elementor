<?php
/**
 * Template Importer Module Loader.
 *
 * @package Wira Kit for Elementor
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
			if ( $this->is_wira_templates_active() ) {
				return;
			}

			if ( defined( 'WIRA_EXTENDED_VERSION' ) || class_exists( 'WiraExtend_Template_Importer' ) ) {
				if ( function_exists( 'we_fs' ) && we_fs()->has_any_active_valid_license() ) {
					return;
				}
			}

			require_once WIRAKIT_PATH . 'inc/modul/template-importer/class-wirakit-template-importer.php';
			new Wirakit_Template_Importer();
		}

		/**
		 * Check whether Wira Templates is active.
		 *
		 * @return bool
		 */
		private function is_wira_templates_active() {
			if ( class_exists( 'Wirat_Templates_Plugin' ) || defined( 'WIRAT_VERSION' ) || defined( 'WIRAT_PATH' ) ) {
				return true;
			}

			$active_plugins = (array) get_option( 'active_plugins', array() );
			if ( in_array( 'wira-templates/wira-templates.php', $active_plugins, true ) ) {
				return true;
			}

			$network_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
			return isset( $network_plugins['wira-templates/wira-templates.php'] );
		}
	}

	new Wirakit_Template_Importer_Loader();
}
