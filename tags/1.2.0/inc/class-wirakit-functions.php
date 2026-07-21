<?php
/**
 * Plugin Main Functions.
 *
 * Handles core initialization for the Wira Kit for Elementor plugin,
 * including loading dependencies, setting up hooks, and enqueuing admin assets.
 *
 * @package    Wira Kit for Elementor
 * @subpackage Core
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Wirakit_Functions' ) ) {

	/**
	 * Main Functions class for the Wira Kit for Elementor plugin.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Functions {

		/**
		 * Option key for widget/module settings.
		 *
		 * @since 1.0.0
		 * @var string
		 */
		const SETTINGS_OPTION_KEY = 'wira_elementor_kit_settings';

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->load_hooks();
			if ( self::is_elementor_available() ) {
				$this->load_dependencies();
			}
		}

		/**
		 * Register WordPress hooks for the plugin.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		private function load_hooks() {
			add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			add_action( 'wp_ajax_Wirakit_save_settings', array( $this, 'ajax_save_settings' ) );
			add_action( 'wp_ajax_Wirakit_install_activate_wira_templates', array( $this, 'ajax_install_activate_wira_templates' ) );
			add_filter( 'Wirakit_template_importer_enable_auto_install_required_plugins', array( $this, 'filter_enable_template_importer_auto_install' ) );
		}

		/**
		 * Enable template importer required plugins auto-install via saved module setting.
		 *
		 * @param bool $enabled Current enabled state from other filters.
		 * @return bool
		 */
		public function filter_enable_template_importer_auto_install( $enabled ) {
			if ( (bool) $enabled ) {
				return true;
			}

			if ( ! self::is_module_enabled( 'starter-templates' ) ) {
				return false;
			}

			return (bool) self::is_module_enabled( 'template-importer-auto-install' );
		}

		/**
		 * Load all plugin dependencies.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		private function load_dependencies() {
			include_once WIRAKIT_PATH . 'inc/modul/template-builder/class-wirakit-template-builder-loader.php';
			include_once WIRAKIT_PATH . 'inc/modul/template-importer/class-wirakit-template-importer-loader.php';
			include_once WIRAKIT_PATH . 'inc/widgets/class-wirakit-widgets-loader.php';
		}

		/**
		 * Register plugin admin menu and submenus.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function register_admin_menu() {
			$capability = 'manage_options';

			add_menu_page(
				__( 'WiraKit', 'wira-kit-for-elementor' ),
				__( 'WiraKit', 'wira-kit-for-elementor' ),
				$capability,
				'wira-kit-for-elementor',
				array( $this, 'render_dashboard_page' ),
				WIRAKIT_URL . 'assets/img/wkit-icon.svg',
				58
			);

			add_submenu_page(
				'wira-kit-for-elementor',
				__( 'Dashboard', 'wira-kit-for-elementor' ),
				__( 'Dashboard', 'wira-kit-for-elementor' ),
				$capability,
				'wira-kit-for-elementor',
				array( $this, 'render_dashboard_page' )
			);

			add_submenu_page(
				'wira-kit-for-elementor',
				__( 'Starter Templates', 'wira-kit-for-elementor' ),
				__( 'Starter Templates', 'wira-kit-for-elementor' ),
				$capability,
				'wira-kit-for-elementor&path=starter-template',
				array( $this, 'render_dashboard_page' )
			);
			if ( ! self::is_module_enabled( 'starter-templates' ) ) {
				remove_submenu_page( 'wira-kit-for-elementor', 'wira-kit-for-elementor&path=starter-template' );
			}

			add_submenu_page(
				'wira-kit-for-elementor',
				__( 'Modul Settings', 'wira-kit-for-elementor' ),
				__( 'Modul Settings', 'wira-kit-for-elementor' ),
				$capability,
				'wira-kit-for-elementor&path=widgets',
				array( $this, 'render_dashboard_page' )
			);

			add_submenu_page(
				'wira-kit-for-elementor',
				__( 'Template Builder', 'wira-kit-for-elementor' ),
				__( 'Template Builder', 'wira-kit-for-elementor' ),
				$capability,
				'wira-kit-for-elementor&path=template-builder',
				array( $this, 'render_dashboard_page' )
			);
		}

		/**
		 * Render dashboard page root node for the React admin app.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function render_dashboard_page() {
			$this->render_admin_app( 'dashboard' );
		}

		/**
		 * Shared render callback for React mount point.
		 *
		 * @param string $default_path Default path identifier.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		private function render_admin_app( $default_path ) {
			if ( ! self::is_elementor_available() ) {
				echo '<div class="notice notice-error"><p>' .
					esc_html__( 'Wira Kit for Elementor requires Elementor to be installed and activated.', 'wira-kit-for-elementor' ) .
					'</p></div>';
				return;
			}

			$path = isset( $_GET['path'] ) ? sanitize_key( wp_unslash( $_GET['path'] ) ) : $default_path; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( 'template-kit' === $path || 'template-importer' === $path ) {
				$path = 'starter-template';
			}
			if ( 'starter-template' === $path && ! self::is_module_enabled( 'starter-templates' ) ) {
				$path = 'dashboard';
			}

			echo '<div class="wrap"><div id="wkit-admin-app" data-path="' . esc_attr( $path ) . '"></div></div>';
		}

		/**
		 * Enqueue admin assets (CSS and JS).
		 *
		 * @param string $hook_suffix The current admin page hook suffix.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function enqueue_admin_assets( $hook_suffix ) {
			if ( ! self::is_elementor_available() ) {
				return;
			}

			$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			if ( ! in_array( $page, array( 'wira-kit-for-elementor', 'wira-kit-for-elementor-template-builder' ), true ) ) {
				return;
			}

			$path = isset( $_GET['path'] ) ? sanitize_key( wp_unslash( $_GET['path'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( empty( $path ) ) {
				$path = ( 'wira-kit-for-elementor-template-builder' === $page ) ? 'template-builder' : 'dashboard';
			}

			$display_options = array(
				'all'        => __( 'All Pages', 'wira-kit-for-elementor' ),
				'front-page' => __( 'Front Page', 'wira-kit-for-elementor' ),
				'singular'   => __( 'Singular', 'wira-kit-for-elementor' ),
				'archive'    => __( 'Archive', 'wira-kit-for-elementor' ),
				'blog'       => __( 'Blog Home', 'wira-kit-for-elementor' ),
				'404'        => __( '404 Page', 'wira-kit-for-elementor' ),
				'shop'       => __( 'Shop Page', 'wira-kit-for-elementor' ),
			);

			$display_options_by_type = array(
				'default'      => $display_options,
				'wkit-header'  => $display_options,
				'wkit-footer'  => $display_options,
				'wkit-single'  => array(
					'singular' => __( 'All Singular', 'wira-kit-for-elementor' ),
				),
				'wkit-archive' => array(
					'archive' => __( 'All Archives', 'wira-kit-for-elementor' ),
				),
				'wkit-search'  => array(
					'search' => __( 'Search Results', 'wira-kit-for-elementor' ),
				),
				'wkit-404'     => array(
					'404' => __( '404 Page', 'wira-kit-for-elementor' ),
				),
			);

			if ( class_exists( 'Wirakit_Template_Builder_Admin' ) && method_exists( 'Wirakit_Template_Builder_Admin', 'get_display_options' ) ) {
				$display_options_by_type = array(
					'default'      => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE ),
					'wkit-header'  => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE ),
					'wkit-footer'  => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE ),
					'wkit-single'  => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE ),
					'wkit-archive' => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE ),
					'wkit-search'  => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ),
					'wkit-404'     => Wirakit_Template_Builder_Admin::get_display_options( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE ),
				);
			}

			wp_enqueue_style(
				'wira-kit-for-elementor-admin',
				WIRAKIT_URL . 'assets/css/admin-style.css',
				array(),
				WIRAKIT_VERSION
			);

			wp_enqueue_script(
				'wira-kit-for-elementor-admin-app',
				WIRAKIT_URL . 'assets/js/admin-app.js',
				array( 'wp-element' ),
				WIRAKIT_VERSION,
				true
			);

			wp_localize_script(
				'wira-kit-for-elementor-admin-app',
				'WiraElementorKitAdmin',
				array(
					'path'          => $path,
					'dashboardUrl'  => admin_url( 'admin.php?page=wira-kit-for-elementor' ),
					'widgetsUrl'    => admin_url( 'admin.php?page=wira-kit-for-elementor&path=widgets' ),
					'templateBuilderUrl' => admin_url( 'admin.php?page=wira-kit-for-elementor&path=template-builder' ),
					'templateKitUrl' => admin_url( 'admin.php?page=wira-kit-for-elementor&path=starter-template' ),
					'templateImporterUrl' => admin_url( 'admin.php?page=wira-kit-for-elementor&path=starter-template' ),
					'logoUrl'       => WIRAKIT_URL . 'assets/widget/img/wira-kit-for-elementor-light.png',
					'logoWidth'     => 190,
					'dashboardImageUrl' => WIRAKIT_URL . 'assets/img/plugin-image.png',
					'pluginName'    => __( 'Wira Kit for Elementor', 'wira-kit-for-elementor' ),
					'pluginVersion' => defined( 'WIRAKIT_VERSION' ) ? (string) WIRAKIT_VERSION : '',
					'hookSuffix'    => $hook_suffix,
					'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
					'homeUrl'       => home_url( '/' ),
					'settingsNonce' => wp_create_nonce( 'Wirakit_save_settings' ),
					'templateBuilderNonce' => wp_create_nonce( 'Wirakit_template_builder' ),
					'templateKitNonce' => wp_create_nonce( 'Wirakit_template_importer' ),
					'templateImporterNonce' => wp_create_nonce( 'Wirakit_template_importer' ),
					'wiraTemplatesNonce' => wp_create_nonce( 'Wirakit_install_activate_wira_templates' ),
					'templateImporterAutoInstallEnabled' => (bool) apply_filters( 'Wirakit_template_importer_enable_auto_install_required_plugins', false ),
					'extendedLicenseActive' => ( function_exists( 'we_fs' ) && we_fs()->has_any_active_valid_license() ),
					'getAllAccessUrl' => defined( 'WIRAKIT_TEMPLATE_IMPORTER_GET_ALL_ACCESS_URL' )
						? WIRAKIT_TEMPLATE_IMPORTER_GET_ALL_ACCESS_URL
						: ( class_exists( 'Wirakit_Template_Importer' ) ? Wirakit_Template_Importer::GET_ALL_ACCESS_URL : 'https://wiratheme.com/contact-us/' ),
					'wiraTemplates' => self::get_wira_templates_dependency_data(),
					'templateBuilderDisplayOptions' => $display_options_by_type,
					'settings'      => self::get_settings(),
					'widgetItems'   => array_values( self::get_widget_items_for_admin() ),
					'moduleItems'   => array_values( self::get_module_definitions() ),
				)
			);
		}

		/**
		 * AJAX install/activate Wira Templates, then return redirect target.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function ajax_install_activate_wira_templates() {
			check_ajax_referer( 'Wirakit_install_activate_wira_templates', 'nonce' );

			$result = self::install_or_activate_wira_templates();
			if ( is_wp_error( $result ) ) {
				wp_send_json_error(
					array(
						'message' => $result->get_error_message(),
					),
					400
				);
			}

			wp_send_json_success(
				array(
					'message'       => __( 'Wira Templates is ready.', 'wira-kit-for-elementor' ),
					'wiraTemplates' => self::get_wira_templates_dependency_data(),
					'redirectUrl'   => admin_url( 'admin.php?page=wira-templates&path=starter-template' ),
				)
			);
		}

		/**
		 * AJAX handler for saving widget/module settings.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function ajax_save_settings() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'wira-kit-for-elementor' ) ), 403 );
			}

			check_ajax_referer( 'Wirakit_save_settings', 'nonce' );

			$raw_payload = isset( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

			if ( is_string( $raw_payload ) ) {
				$decoded     = json_decode( $raw_payload, true );
				$raw_payload = is_array( $decoded ) ? $decoded : array();
			}

			if ( ! is_array( $raw_payload ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid settings payload.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$sanitized = self::sanitize_settings_payload( $raw_payload );
			update_option( self::SETTINGS_OPTION_KEY, $sanitized, false );

			wp_send_json_success(
				array(
					'message'  => __( 'Settings saved.', 'wira-kit-for-elementor' ),
					'settings' => self::get_settings(),
				)
			);
		}

		/**
		 * Get full widget/module settings merged with defaults.
		 *
		 * @since 1.0.0
		 * @return array<string,array<string,bool>>
		 */
		public static function get_settings() {
			$saved = get_option( self::SETTINGS_OPTION_KEY, array() );
			$saved = is_array( $saved ) ? $saved : array();

			$defaults = self::get_default_settings();
			return self::sanitize_settings_payload( array_merge( $defaults, $saved ) );
		}

		/**
		 * Get Wira Templates install/activation status for admin app buttons.
		 *
		 * @since 1.0.0
		 * @return array<string,mixed>
		 */
		private static function get_wira_templates_dependency_data() {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugin_file = 'wira-templates/wira-templates.php';
			$all_plugins = get_plugins();
			$installed   = isset( $all_plugins[ $plugin_file ] );
			$active      = $installed && ( is_plugin_active( $plugin_file ) || is_plugin_active_for_network( $plugin_file ) );

			$install_url         = '';
			$install_screen_url  = '';
			$activate_url        = '';
			$activate_screen_url = '';

			if ( ! $installed && current_user_can( 'install_plugins' ) ) {
				$install_url = add_query_arg(
					array(
						'action'   => 'install-plugin',
						'plugin'   => 'wira-templates',
						'_wpnonce' => wp_create_nonce( 'install-plugin_wira-templates' ),
					),
					self_admin_url( 'update.php' )
				);

				$install_screen_url = add_query_arg(
					array(
						'tab' => 'search',
						's'   => 'Wira Templates',
					),
					self_admin_url( 'plugin-install.php' )
				);
			}

			if ( $installed && ! $active && current_user_can( 'activate_plugins' ) ) {
				$activate_url = add_query_arg(
					array(
						'action'   => 'activate',
						'plugin'   => $plugin_file,
						'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $plugin_file ),
					),
					self_admin_url( 'plugins.php' )
				);

				$activate_screen_url = add_query_arg(
					array(
						'plugin_status' => 'inactive',
						's'             => 'Wira Templates',
					),
					self_admin_url( 'plugins.php' )
				);
			}

			return array(
				'installed'         => $installed,
				'active'            => $active,
				'installUrl'        => $install_url,
				'installScreenUrl'  => $install_screen_url,
				'activateUrl'       => $activate_url,
				'activateScreenUrl' => $activate_screen_url,
				'adminUrl'          => admin_url( 'admin.php?page=wira-templates&path=starter-template' ),
			);
		}

		/**
		 * Install Wira Templates from wp.org when missing and activate it.
		 *
		 * @since 1.0.0
		 * @return true|WP_Error
		 */
		private static function install_or_activate_wira_templates() {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$slug        = 'wira-templates';
			$plugin_file = 'wira-templates/wira-templates.php';
			$all_plugins = get_plugins();
			$installed   = isset( $all_plugins[ $plugin_file ] );

			if ( $installed && ( is_plugin_active( $plugin_file ) || is_plugin_active_for_network( $plugin_file ) ) ) {
				return true;
			}

			if ( ! $installed ) {
				if ( ! current_user_can( 'install_plugins' ) ) {
					return new WP_Error( 'wirakit_permission_denied', __( 'Permission denied to install Wira Templates.', 'wira-kit-for-elementor' ) );
				}

				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

				$api = plugins_api(
					'plugin_information',
					array(
						'slug'   => $slug,
						'fields' => array(
							'sections' => false,
						),
					)
				);

				if ( is_wp_error( $api ) ) {
					return new WP_Error( 'wirakit_install_failed', $api->get_error_message() );
				}

				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$install  = $upgrader->install( $api->download_link );

				if ( is_wp_error( $install ) ) {
					return new WP_Error( 'wirakit_install_failed', $install->get_error_message() );
				}
				if ( is_wp_error( $skin->result ) ) {
					return new WP_Error( 'wirakit_install_failed', $skin->result->get_error_message() );
				}
				if ( $skin->get_errors()->has_errors() ) {
					return new WP_Error( 'wirakit_install_failed', $skin->get_error_messages() );
				}
				if ( null === $install ) {
					return new WP_Error( 'wirakit_install_failed', __( 'Unable to connect to filesystem.', 'wira-kit-for-elementor' ) );
				}

				$all_plugins = get_plugins();
				$installed   = isset( $all_plugins[ $plugin_file ] );
			}

			if ( ! $installed ) {
				return new WP_Error( 'wirakit_install_failed', __( 'Wira Templates installed, but plugin file was not found.', 'wira-kit-for-elementor' ) );
			}

			if ( ! current_user_can( 'activate_plugins' ) ) {
				return new WP_Error( 'wirakit_permission_denied', __( 'Permission denied to activate Wira Templates.', 'wira-kit-for-elementor' ) );
			}

			if ( is_plugin_inactive( $plugin_file ) ) {
				$activation = activate_plugin( $plugin_file, '', false, false );
				if ( is_wp_error( $activation ) ) {
					return new WP_Error( 'wirakit_activation_failed', $activation->get_error_message() );
				}
			}

			return true;
		}

		/**
		 * Get default settings with all items enabled.
		 *
		 * @since 1.0.0
		 * @return array<string,array<string,bool>>
		 */
		public static function get_default_settings() {
			$widgets = array();
			foreach ( self::get_widget_definitions() as $widget ) {
				$widgets[ $widget['id'] ] = true;
			}

			$modules = array();
			foreach ( self::get_module_definitions() as $module ) {
				$module_id = $module['id'];

				// Default OFF modules.
				if ( in_array(
					$module_id,
					array(
						'starter-templates',
						'advanced-template-import',
						'template-importer-auto-install',
						'template-builder-single',
						'template-builder-archive',
						'template-builder-search',
						'template-builder-404',
					),
					true
				) ) {
					$modules[ $module_id ] = false;
					continue;
				}

				// Default ON modules.
				if ( in_array( $module_id, array( 'template-builder-header', 'template-builder-footer' ), true ) ) {
					$modules[ $module_id ] = true;
					continue;
				}

				$modules[ $module_id ] = true;
			}

			return array(
				'widgets' => $widgets,
				'modules' => $modules,
			);
		}

		/**
		 * Sanitize incoming settings payload.
		 *
		 * @param array $payload Raw payload.
		 *
		 * @since 1.0.0
		 * @return array<string,array<string,bool>>
		 */
		public static function sanitize_settings_payload( $payload ) {
			$payload  = is_array( $payload ) ? $payload : array();
			$defaults = self::get_default_settings();
			$output   = $defaults;

			$allowed_groups = array( 'widgets', 'modules' );
			foreach ( $allowed_groups as $group ) {
				if ( ! isset( $payload[ $group ] ) || ! is_array( $payload[ $group ] ) ) {
					continue;
				}

				foreach ( $output[ $group ] as $item_id => $default_value ) {
					if ( ! array_key_exists( $item_id, $payload[ $group ] ) ) {
						continue;
					}

					$value                     = $payload[ $group ][ $item_id ];
					$output[ $group ][ $item_id ] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
				}
			}

			// Safety fallback: never disable Template Builder types that already have content,
			// to prevent sites from breaking after plugin updates.
			if ( isset( $output['modules'] ) && is_array( $output['modules'] ) ) {
				$output['modules']['advanced-template-import'] = false;
				$output['modules']['template-importer-auto-install'] = false;
				foreach ( array_keys( $output['modules'] ) as $module_id ) {
					if ( self::should_force_enable_module( $module_id ) ) {
						$output['modules'][ $module_id ] = true;
					}
				}
			}

			return $output;
		}

		/**
		 * Check whether a widget is enabled.
		 *
		 * @param string $widget_id Widget identifier.
		 *
		 * @since 1.0.0
		 * @return bool
		 */
		public static function is_widget_enabled( $widget_id ) {
			$settings = self::get_settings();
			return isset( $settings['widgets'][ $widget_id ] ) ? (bool) $settings['widgets'][ $widget_id ] : true;
		}

		/**
		 * Check whether a module is enabled.
		 *
		 * @param string $module_id Module identifier.
		 *
		 * @since 1.0.0
		 * @return bool
		 */
		public static function is_module_enabled( $module_id ) {
			if ( 'template-kit' === $module_id || 'template-importer' === $module_id ) {
				return true;
			}

			if ( self::should_force_enable_module( $module_id ) ) {
				return true;
			}

			$settings = self::get_settings();
			if ( isset( $settings['modules'][ $module_id ] ) ) {
				return (bool) $settings['modules'][ $module_id ];
			}

			// Backward compatibility for renamed module slug.
			if ( 'template-kit' === $module_id && isset( $settings['modules']['template-importer'] ) ) {
				return (bool) $settings['modules']['template-importer'];
			}

			if ( 'template-importer' === $module_id && isset( $settings['modules']['template-kit'] ) ) {
				return (bool) $settings['modules']['template-kit'];
			}

			return true;
		}

		/**
		 * Whether a module must be forced ON due to existing content.
		 *
		 * @param string $module_id Module identifier.
		 * @return bool
		 */
		private static function should_force_enable_module( $module_id ) {
			$module_id = sanitize_key( (string) $module_id );
			if ( '' === $module_id ) {
				return false;
			}

			$map = array(
				'template-builder-header'  => class_exists( 'Wirakit_Template_Builder_Post_Type' ) ? Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE : 'wkit-header',
				'template-builder-footer'  => class_exists( 'Wirakit_Template_Builder_Post_Type' ) ? Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE : 'wkit-footer',
				'template-builder-single'  => class_exists( 'Wirakit_Template_Builder_Post_Type' ) ? Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE : 'wkit-single',
				'template-builder-archive' => class_exists( 'Wirakit_Template_Builder_Post_Type' ) ? Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE : 'wkit-archive',
				'template-builder-search'  => class_exists( 'Wirakit_Template_Builder_Post_Type' ) ? Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE : 'wkit-search',
				'template-builder-404'     => class_exists( 'Wirakit_Template_Builder_Post_Type' ) ? Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE : 'wkit-404',
			);

			if ( ! isset( $map[ $module_id ] ) ) {
				return false;
			}

			$post_type = sanitize_key( (string) $map[ $module_id ] );
			if ( '' === $post_type || ! function_exists( 'post_type_exists' ) || ! post_type_exists( $post_type ) ) {
				return false;
			}

			if ( ! function_exists( 'wp_count_posts' ) ) {
				return false;
			}

			$count = wp_count_posts( $post_type );
			$published = ( $count && isset( $count->publish ) ) ? (int) $count->publish : 0;
			return $published > 0;
		}

		/**
		 * Check whether Elementor is available.
		 *
		 * @since 1.0.0
		 * @return bool
		 */
		private static function is_elementor_available() {
			return did_action( 'elementor/loaded' ) || class_exists( '\\Elementor\\Plugin' );
		}

		/**
		 * Get widget definitions for registration and admin UI.
		 *
		 * @since 1.0.0
		 * @return array<int,array<string,string>>
		 */
		public static function get_widget_definitions() {
			$definitions = array(
				array( 'id' => 'nav-menu', 'label' => 'Nav Menu', 'file' => 'nav-menu/wirakit-nav-menu.php', 'class' => '\\Wirakit_Nav_Menu_Widget' ),
				array( 'id' => 'content', 'label' => 'Content', 'file' => 'content/wirakit-content-widget.php', 'class' => '\\Wirakit_Content_Widget' ),
				array( 'id' => 'post-sharer', 'label' => 'Post Sharer', 'file' => 'post-sharer/wirakit-post-sharer.php', 'class' => '\\Wirakit_Post_Sharer' ),
				array( 'id' => 'button', 'label' => 'Button', 'file' => 'button/wirakit-button.php', 'class' => '\\Wirakit_Button' ),
				array( 'id' => 'dynamic-button', 'label' => 'Dynamic Button', 'file' => 'dynamic-button/wirakit-dynamic-button.php', 'class' => '\\Wirakit_Dynamic_Button' ),
				array( 'id' => 'advanced-heading', 'label' => 'Advanced Heading', 'file' => 'advanced-heading/wirakit-advanced-heading.php', 'class' => '\\Wirakit_Advanced_Heading' ),
				array( 'id' => 'post-title', 'label' => 'Post Title', 'file' => 'post-title/wirakit-post-title.php', 'class' => '\\Wirakit_Post_Title' ),
				array( 'id' => 'comments', 'label' => 'Comments', 'file' => 'comments/wirakit-comments.php', 'class' => '\\Wirakit_Post_Comments' ),
				array( 'id' => 'archive-title', 'label' => 'Archive Title', 'file' => 'archive-title/wirakit-archive-title.php', 'class' => '\\Wirakit_Archive_Title' ),
				array( 'id' => 'archive-list', 'label' => 'Archive List', 'file' => 'archive-list/wirakit-archive-list.php', 'class' => '\\Wirakit_Archive_List' ),
				array( 'id' => 'search-title', 'label' => 'Search Title', 'file' => 'search-title/wirakit-search-title.php', 'class' => '\\Wirakit_Search_Title' ),
				array( 'id' => 'search-form', 'label' => 'Search Form', 'file' => 'search-form/wirakit-search-form.php', 'class' => '\\Wirakit_Search_Form' ),
				array( 'id' => 'post-meta', 'label' => 'Post Meta', 'file' => 'post-meta/wirakit-post-meta.php', 'class' => '\\Wirakit_Post_Meta' ),
				array( 'id' => 'post-navigation', 'label' => 'Post Navigation', 'file' => 'post-navigation/wirakit-post-navigation.php', 'class' => '\\Wirakit_Post_Navigation' ),
				array( 'id' => 'loop', 'label' => 'Loop', 'file' => 'loop/wirakit-loop.php', 'class' => '\\Wirakit_Loop' ),
				array( 'id' => 'blog-post', 'label' => 'Blog Post', 'file' => 'blog-post/wirakit-blog-post.php', 'class' => '\\Wirakit_Blog_Post' ),
				array( 'id' => 'post-excerpt', 'label' => 'Post Excerpt', 'file' => 'post-excerpt/wirakit-post-excerpt.php', 'class' => '\\Wirakit_Post_Excerpt' ),
				array( 'id' => 'featured-image', 'label' => 'Featured Image', 'file' => 'featured-image/wirakit-featured-image.php', 'class' => '\\Wirakit_Featured_Image' ),
				array( 'id' => 'brand-logo', 'label' => 'Brand Logo', 'file' => 'brand-logo/wirakit-brand-logo.php', 'class' => '\\Wirakit_Brand_Logo' ),
				array( 'id' => 'carousel', 'label' => 'Carousel', 'file' => 'carousel/wirakit-carousel.php', 'class' => '\\Wirakit_Carousel' ),
				array( 'id' => 'contact-form', 'label' => 'CF 7', 'file' => 'contact-form/wirakit-contact-form.php', 'class' => '\\Wirakit_Contact_Form' ),
				array( 'id' => 'info-box-repeater', 'label' => 'Info Box Repeater', 'file' => 'info-box-repeater/wirakit-info-box-repeater.php', 'class' => '\\Wirakit_Info_Box_Repeater' ),
				array( 'id' => 'icon-box', 'label' => 'Icon Box', 'file' => 'icon-box/wirakit-icon-box.php', 'class' => '\\Wirakit_Icon_Box' ),
				array( 'id' => 'accordion', 'label' => 'Accordion', 'file' => 'accordion/wirakit-accordion.php', 'class' => '\\Wirakit_Accordion' ),
				array( 'id' => 'progress-bar', 'label' => 'Progress Bar', 'file' => 'progress-bar/wirakit-progress-bar.php', 'class' => '\\Wirakit_Progress_Bar' ),
				array( 'id' => 'tab-widget', 'label' => 'Tab Widget', 'file' => 'tab-widget/wirakit-tab-widget.php', 'class' => '\\Wirakit_Tab_Widget' ),
				array( 'id' => 'tooltip', 'label' => 'Tooltip', 'file' => 'tooltip/wirakit-tooltip.php', 'class' => '\\Wirakit_Tooltip' ),
				array( 'id' => 'image-marquee', 'label' => 'Image Marquee', 'file' => 'image-marquee/wirakit-image-marquee.php', 'class' => '\\Wirakit_Image_Marquee' ),
				array( 'id' => 'portfolio-gallery', 'label' => 'Portfolio Gallery', 'file' => 'portfolio-gallery/wirakit-portfolio-gallery.php', 'class' => '\\Wirakit_Portfolio_Gallery' ),
				array( 'id' => 'testimonials', 'label' => 'Testimonials', 'file' => 'testimonials/wirakit-testimonials.php', 'class' => '\\Wirakit_Testimonials' ),
				array( 'id' => 'menu-list', 'label' => 'Menu List', 'file' => 'menu-list/wirakit-menu-list.php', 'class' => '\\Wirakit_Menu_List' ),
				array( 'id' => 'team', 'label' => 'Team', 'file' => 'team/wirakit-team.php', 'class' => '\\Wirakit_Team' ),
				array( 'id' => 'team-repeater', 'label' => 'Team Repeater', 'file' => 'team-repeater/wirakit-team-repeater.php', 'class' => '\\Wirakit_Team_Repeater' ),
				array( 'id' => 'block-template', 'label' => 'Block Components', 'file' => 'block-template/wirakit-block-template.php', 'class' => '\\Wirakit_Block_Template' ),
				array( 'id' => 'popup', 'label' => 'Popup', 'file' => 'popup/wirakit-popup.php', 'class' => '\\Wirakit_Popup' ),
				array( 'id' => 'countdown', 'label' => 'Countdown', 'file' => 'countdown/wirakit-countdown.php', 'class' => '\\Wirakit_Countdown' ),
				array( 'id' => 'text-marquee', 'label' => 'Text Marquee', 'file' => 'text-marquee/wirakit-text-marquee.php', 'class' => '\\Wirakit_Text_Marquee' ),
				array( 'id' => 'logo-marquee', 'label' => 'Logo Marquee', 'file' => 'logo-marquee/wirakit-logo-marquee.php', 'class' => '\\Wirakit_Logo_Marquee' ),
				array( 'id' => 'back-to-top', 'label' => 'Back To Top', 'file' => 'back-to-top/wirakit-back-to-top.php', 'class' => '\\Wirakit_Back_To_Top' ),
			);

			return apply_filters( 'wirakit_widget_definitions', $definitions );
		}

		/**
		 * Get widget categories label map.
		 *
		 * @since 1.0.0
		 * @return array<string,string>
		 */
		public static function get_widget_category_labels() {
			$labels = array(
				'wira-kit-for-elementor'         => 'Wira Kit - General',
				'wira-kit-for-elementor-dynamic' => 'Wira Kit - Dynamic',
				'wira-kit-for-elementor-single'  => 'Wira Kit - Single',
			);

			return apply_filters( 'wirakit_widget_category_labels', $labels );
		}

		/**
		 * Build widget items for admin (with category metadata).
		 *
		 * @since 1.0.0
		 * @return array<int,array<string,string>>
		 */
		public static function get_widget_items_for_admin() {
			$items           = array();
			$category_labels = self::get_widget_category_labels();
			$default_slug    = 'wira-kit-for-elementor';

			foreach ( self::get_widget_definitions() as $widget ) {
				$category_slug = $default_slug;

				if ( ! empty( $widget['category'] ) ) {
					$candidate = sanitize_key( $widget['category'] );
					if ( isset( $category_labels[ $candidate ] ) ) {
						$category_slug = $candidate;
					}
				}

				if ( ! empty( $widget['file'] ) || ! empty( $widget['file_path'] ) ) {
					$widget_file_path = ! empty( $widget['file_path'] )
						? $widget['file_path']
						: WIRAKIT_PATH . 'inc/widgets/' . $widget['file'];
					if ( file_exists( $widget_file_path ) && is_readable( $widget_file_path ) ) {
						$content = file_get_contents( $widget_file_path );
						if ( false !== $content ) {
							if ( preg_match( "/function\\s+get_categories\\s*\\(\\)\\s*\\{[\\s\\S]*?return\\s*\\[\\s*'([^']+)'/m", $content, $matches ) ) {
								$candidate = sanitize_key( $matches[1] );
								if ( isset( $category_labels[ $candidate ] ) ) {
									$category_slug = $candidate;
								}
							}
						}
					}
				}

				$widget['category']       = $category_slug;
				$widget['category_label'] = isset( $category_labels[ $category_slug ] ) ? $category_labels[ $category_slug ] : $category_labels[ $default_slug ];
				$items[]                  = $widget;
			}

			return apply_filters( 'wirakit_widget_items', $items, $category_labels, $default_slug );
		}

		/**
		 * Get module definitions for admin UI and runtime checks.
		 *
		 * @since 1.0.0
		 * @return array<int,array<string,string>>
		 */
		public static function get_module_definitions() {
			$modules = array(
				array( 'id' => 'glassmorphism', 'label' => 'Glassmorphism' ),
				array( 'id' => 'sticky-effect', 'label' => 'Sticky Effect' ),
				array( 'id' => 'featured-image-background', 'label' => 'Featured Image Background' ),
				array( 'id' => 'starter-templates', 'label' => 'Starter Templates' ),
				array( 'id' => 'advanced-template-import', 'label' => 'Advanced Template Import' ),
				array( 'id' => 'template-importer-auto-install', 'label' => 'Template Importer (AJAX)' ),
				array(
					'id'             => 'template-builder-header',
					'label'          => 'Header Builder',
					'category'       => 'template-builder',
					'category_label' => 'Template Builder',
				),
				array(
					'id'             => 'template-builder-footer',
					'label'          => 'Footer Builder',
					'category'       => 'template-builder',
					'category_label' => 'Template Builder',
				),
				array(
					'id'             => 'template-builder-single',
					'label'          => 'Single Builder',
					'category'       => 'template-builder',
					'category_label' => 'Template Builder',
				),
				array(
					'id'             => 'template-builder-archive',
					'label'          => 'Archive Builder',
					'category'       => 'template-builder',
					'category_label' => 'Template Builder',
				),
				array(
					'id'             => 'template-builder-search',
					'label'          => 'Search Result Builder',
					'category'       => 'template-builder',
					'category_label' => 'Template Builder',
				),
				array(
					'id'             => 'template-builder-404',
					'label'          => '404 Builder',
					'category'       => 'template-builder',
					'category_label' => 'Template Builder',
				),
			);

			return apply_filters( 'wirakit_module_definitions', $modules );
		}
	}

	new Wirakit_Functions();
}
