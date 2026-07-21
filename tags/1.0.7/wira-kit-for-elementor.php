<?php
/**
 * Plugin Name: WiraKit For Elementor – Theme Builder, Widgets & Template Library
 * Plugin URI:  https://wiratheme.com/wirakit/
 * Description: Wira Kit for Elementor provides Elementor widgets, template builder functionality and Elementor Template Library.
 * Version:     1.0.7
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 * Author:      Wiratheme
 * Author URI:  https://wiratheme.com/wirakit/
 * Text Domain: wira-kit-for-elementor
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /languages
 *
 * @package Wira Kit for Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access to the file.
}

if ( ! class_exists( 'Wirakit_Plugin' ) ) {

	/**
	 * Main plugin bootstrap class.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Plugin {
		/**
		 * Option key to trigger one-time rewrite flush.
		 *
		 * @var string
		 */
		const REWRITE_FLUSH_OPTION = 'wirakit_flush_rewrite';

		/**
		 * Option key to store the last rewrite setup version.
		 *
		 * @var string
		 */
		const REWRITE_VERSION_OPTION = 'wirakit_rewrite_version';

		/**
		 * Holds the singleton instance of this class.
		 *
		 * @var Wirakit_Plugin|null
		 */
		private static $instance;

		/**
		 * Get the singleton instance.
		 *
		 * @since  1.0.0
		 * @return Wirakit_Plugin
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->maybe_schedule_rewrite_flush();

			if ( ! $this->is_elementor_available() ) {
				add_action( 'admin_notices', array( $this, 'render_elementor_required_notice' ) );
				return;
			}

			$this->includes();
		}

		/**
		 * Schedule one-time rewrite flush when plugin version changes.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function maybe_schedule_rewrite_flush() {
			$installed_version = (string) get_option( self::REWRITE_VERSION_OPTION, '' );
			$current_version   = defined( 'WIRAKIT_VERSION' ) ? (string) WIRAKIT_VERSION : '';

			if ( $current_version === $installed_version ) {
				return;
			}

			update_option( self::REWRITE_FLUSH_OPTION, '1', false );
			update_option( self::REWRITE_VERSION_OPTION, $current_version, false );
		}

		/**
		 * Run on plugin activation.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public static function on_activate() {
			update_option( self::REWRITE_FLUSH_OPTION, '1', false );
			update_option( self::REWRITE_VERSION_OPTION, defined( 'WIRAKIT_VERSION' ) ? (string) WIRAKIT_VERSION : '', false );
		}

		/**
		 * Run on plugin deactivation.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public static function on_deactivate() {
			delete_option( self::REWRITE_FLUSH_OPTION );
			delete_option( self::REWRITE_VERSION_OPTION );
			flush_rewrite_rules( false );
		}

		/**
		 * Define plugin constants.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		private function define_constants() {
			$header  = get_file_data( __FILE__, array( 'Version' => 'Version' ), 'plugin' );
			$version = ! empty( $header['Version'] ) ? $header['Version'] : '1.0.0';

			define( 'WIRAKIT_VERSION', $version );
			define( 'WIRAKIT_PATH', plugin_dir_path( __FILE__ ) );
			define( 'WIRAKIT_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Include required files.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		private function includes() {
			include_once WIRAKIT_PATH . 'inc/class-wirakit-functions.php';
		}

		/**
		 * Check whether Elementor is available.
		 *
		 * @since  1.0.0
		 * @return bool
		 */
		private function is_elementor_available() {
			return did_action( 'elementor/loaded' ) || class_exists( '\\Elementor\\Plugin' );
		}

		/**
		 * Render admin notice when Elementor is missing.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function render_elementor_required_notice() {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			echo '<div class="notice notice-error"><p>' .
				esc_html__( 'Wira Kit for Elementor requires Elementor to be installed and activated.', 'wira-kit-for-elementor' ) .
				'</p></div>';
		}
	}

	register_activation_hook( __FILE__, array( 'Wirakit_Plugin', 'on_activate' ) );
	register_deactivation_hook( __FILE__, array( 'Wirakit_Plugin', 'on_deactivate' ) );
	Wirakit_Plugin::get_instance();
}
