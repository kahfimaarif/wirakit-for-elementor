<?php
/**
 * Template Importer (Elementor only).
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Importer' ) ) {

	/**
	 * Handles ZIP upload, extraction, kit storage, and Elementor template import.
	 */
	class Wirakit_Template_Importer {

		/**
		 * Internal CPT slug used to store imported kits.
		 *
		 * @var string
		 */
		const CPT_KIT = 'wira_tk_import';

		/**
		 * Nonce action for importer AJAX requests.
		 *
		 * @var string
		 */
		const NONCE_ACTION = 'Wirakit_template_importer';

		/**
		 * Get All Access URL.
		 *
		 * @var string
		 */
		const GET_ALL_ACCESS_URL = 'https://wiratheme.com/contact/';

		/**
		 * Remote API base endpoint for Wira kits.
		 *
		 * @var string
		 */
		const REMOTE_KITS_API = 'https://api.wiratheme.com/wp-json/wira/v1/kits';

		/**
		 * Full import remote API base endpoint.
		 *
		 * @var string
		 */
		const FULL_IMPORT_REMOTE_KITS_API = 'https://api.wiratheme.com/wp-json/wira/v1/kits';

		/**
		 * Allowed file types extracted from ZIP.
		 *
		 * @var string[]
		 */
		private $allowed_file_types = array( 'json', 'jpg', 'jpeg', 'png', 'css', 'html', 'webp', 'svg', 'gif' );

		/**
		 * Maximum uploaded ZIP size in bytes.
		 *
		 * @var int
		 */
		const MAX_ZIP_FILE_BYTES = 31457280; // 30 MB.

		/**
		 * Maximum number of entries allowed in ZIP.
		 *
		 * @var int
		 */
		const MAX_ZIP_ENTRIES = 2000;

		/**
		 * Maximum total uncompressed bytes allowed from ZIP.
		 *
		 * @var int
		 */
		const MAX_ZIP_TOTAL_UNCOMPRESSED_BYTES = 209715200; // 200 MB.

		/**
		 * Maximum uncompressed size for a single file entry.
		 *
		 * @var int
		 */
		const MAX_ZIP_SINGLE_FILE_BYTES = 20971520; // 20 MB.

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_cpt' ) );

			add_action( 'wp_ajax_Wirakit_ti_upload_zip', array( $this, 'ajax_upload_zip' ) );
			add_action( 'wp_ajax_Wirakit_ti_list_kits', array( $this, 'ajax_list_kits' ) );
			add_action( 'wp_ajax_Wirakit_ti_list_templates', array( $this, 'ajax_list_templates' ) );
			add_action( 'wp_ajax_Wirakit_ti_import_template', array( $this, 'ajax_import_template' ) );
			add_action( 'wp_ajax_Wirakit_ti_delete_kit', array( $this, 'ajax_delete_kit' ) );
			add_action( 'wp_ajax_Wirakit_ti_install_required_plugins', array( $this, 'ajax_install_required_plugins' ) );
			add_action( 'wp_ajax_Wirakit_ti_browse_kits', array( $this, 'ajax_browse_remote_kits' ) );
			add_action( 'wp_ajax_Wirakit_ti_import_remote_kit', array( $this, 'ajax_import_remote_kit' ) );
			add_action( 'wp_ajax_Wirakit_ti_browse_full_import_kits', array( $this, 'ajax_browse_full_import_remote_kits' ) );
			add_action( 'wp_ajax_Wirakit_ti_import_full_import_remote_kit', array( $this, 'ajax_import_full_import_remote_kit' ) );
			add_action( 'wp_ajax_Wirakit_ti_full_process_step', array( $this, 'ajax_full_process_step' ) );
		}

		/**
		 * Register internal post type for imported kits.
		 *
		 * @return void
		 */
		public function register_cpt() {
			register_post_type(
				self::CPT_KIT,
				array(
					'label'               => __( 'Imported Kits', 'wira-kit-for-elementor' ),
					'public'              => false,
					'show_ui'             => false,
					'show_in_menu'        => false,
					'show_in_nav_menus'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'capability_type'     => 'post',
					'map_meta_cap'        => true,
					'supports'            => array( 'title' ),
				)
			);
		}

		/**
		 * Upload and install a template kit ZIP file.
		 *
		 * @return void
		 */
		public function ajax_upload_zip() {
			$this->guard_manage_options();
			$this->verify_nonce();

			if ( empty( $_FILES['file'] ) || ! is_array( $_FILES['file'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
				wp_send_json_error( array( 'message' => __( 'ZIP file is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$file = $_FILES['file']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized,WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().

			if ( empty( $file['tmp_name'] ) || ! is_uploaded_file( $file['tmp_name'] ) || ! empty( $file['error'] ) ) {
				wp_send_json_error( array( 'message' => __( 'Failed to process uploaded ZIP file.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$upload_validation = $this->validate_uploaded_zip_file( $file );
			if ( is_wp_error( $upload_validation ) ) {
				wp_send_json_error( array( 'message' => $upload_validation->get_error_message() ), 400 );
			}

			$zip_path = $file['tmp_name'];

			$result = $this->install_template_kit_zip_to_db( $zip_path );
			wp_delete_file( $zip_path );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ), 500 );
			}

			wp_send_json_success(
				array(
					'templateKitId' => (int) $result,
					'message'       => __( 'ZIP installed successfully.', 'wira-kit-for-elementor' ),
				)
			);
		}

		/**
		 * Return remote kits from API for Browse Demo tab.
		 *
		 * @return void
		 */
		public function ajax_browse_remote_kits() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$response = wp_remote_get(
				add_query_arg(
					array(
						'import_type' => 'template_kit',
					),
					self::REMOTE_KITS_API
				),
				array(
					'timeout' => 25,
				)
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( array( 'message' => $response->get_error_message() ), 500 );
			}

			$code = (int) wp_remote_retrieve_response_code( $response );
			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( 200 !== $code || ! is_array( $data ) ) {
				wp_send_json_error( array( 'message' => __( 'Failed to load template kits from API.', 'wira-kit-for-elementor' ) ), 500 );
			}

			$kits = array();
			foreach ( $data as $kit ) {
				if ( ! is_array( $kit ) ) {
					continue;
				}

				$import_type = ! empty( $kit['import_type'] ) ? sanitize_key( $kit['import_type'] ) : '';
				if ( '' !== $import_type && 'template_kit' !== $import_type ) {
					continue;
				}

				$slug = ! empty( $kit['slug'] ) ? sanitize_title( $kit['slug'] ) : '';
				if ( '' === $slug ) {
					continue;
				}

				$kits[] = array(
					'slug'      => $slug,
					'name'      => ! empty( $kit['name'] ) ? wp_strip_all_tags( $kit['name'] ) : $slug,
					'demo'      => ! empty( $kit['demo'] ) ? esc_url_raw( $kit['demo'] ) : '',
					'version'   => ! empty( $kit['version'] ) ? sanitize_text_field( $kit['version'] ) : '',
					'pricing_type' => ! empty( $kit['pricing_type'] ) ? sanitize_key( $kit['pricing_type'] ) : '',
					'thumbnail' => ! empty( $kit['thumbnail'] ) ? esc_url_raw( $kit['thumbnail'] ) : '',
				);
			}

			wp_send_json_success( array( 'kits' => $kits ) );
		}

		/**
		 * Return remote kits from API for Full Import Template tab.
		 *
		 * @return void
		 */
		public function ajax_browse_full_import_remote_kits() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$response = wp_remote_get(
				add_query_arg(
					array(
						'import_type' => 'full_import',
					),
					self::FULL_IMPORT_REMOTE_KITS_API
				),
				array(
					'timeout' => 25,
				)
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( array( 'message' => $response->get_error_message() ), 500 );
			}

			$code = (int) wp_remote_retrieve_response_code( $response );
			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( 200 !== $code || ! is_array( $data ) ) {
				wp_send_json_error( array( 'message' => __( 'Failed to load full import kits from API.', 'wira-kit-for-elementor' ) ), 500 );
			}

			$kits = array();
			foreach ( $data as $kit ) {
				if ( ! is_array( $kit ) ) {
					continue;
				}

				$import_type = ! empty( $kit['import_type'] ) ? sanitize_key( $kit['import_type'] ) : '';
				if ( '' !== $import_type && 'full_import' !== $import_type ) {
					continue;
				}

				$slug = ! empty( $kit['slug'] ) ? sanitize_title( $kit['slug'] ) : '';
				if ( '' === $slug ) {
					continue;
				}

				$features = array();
				if ( ! empty( $kit['features'] ) && is_array( $kit['features'] ) ) {
					foreach ( $kit['features'] as $feature ) {
						$feature = sanitize_text_field( (string) $feature );
						if ( '' !== $feature ) {
							$features[] = $feature;
						}
					}
				}

				$what_import = array();
				if ( ! empty( $kit['what_will_import'] ) && is_array( $kit['what_will_import'] ) ) {
					foreach ( $kit['what_will_import'] as $item ) {
						$item = sanitize_text_field( (string) $item );
						if ( '' !== $item ) {
							$what_import[] = $item;
						}
					}
				}

				$kits[] = array(
					'slug'         => $slug,
					'name'         => ! empty( $kit['name'] ) ? sanitize_text_field( wp_specialchars_decode( wp_strip_all_tags( $kit['name'] ), ENT_QUOTES ) ) : $slug,
					'demo'         => ! empty( $kit['demo'] ) ? esc_url_raw( $kit['demo'] ) : '',
					'version'      => ! empty( $kit['version'] ) ? sanitize_text_field( $kit['version'] ) : '',
					'pricing_type' => ! empty( $kit['pricing_type'] ) ? sanitize_key( $kit['pricing_type'] ) : '',
					'import_type'  => ! empty( $kit['import_type'] ) ? sanitize_key( $kit['import_type'] ) : '',
					'thumbnail'    => ! empty( $kit['thumbnail'] ) ? esc_url_raw( $kit['thumbnail'] ) : '',
					'features'     => $features,
					'what_will_import' => $what_import,
				);
			}

			wp_send_json_success( array( 'kits' => $kits ) );
		}

		/**
		 * Import remote kit by slug: fetch detail, download ZIP, then install.
		 *
		 * @return void
		 */
		public function ajax_import_remote_kit() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$slug = isset( $_POST['slug'] ) ? sanitize_title( wp_unslash( $_POST['slug'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			if ( '' === $slug ) {
				wp_send_json_error( array( 'message' => __( 'Kit slug is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$detail_url = add_query_arg(
				array(
					'import_type' => 'template_kit',
				),
				trailingslashit( self::REMOTE_KITS_API ) . rawurlencode( $slug )
			);
			$response   = wp_remote_get(
				$detail_url,
				array(
					'timeout' => 25,
				)
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( array( 'message' => $response->get_error_message() ), 500 );
			}

			$code   = (int) wp_remote_retrieve_response_code( $response );
			$body   = wp_remote_retrieve_body( $response );
			$detail = json_decode( $body, true );

			if ( 200 !== $code || ! is_array( $detail ) ) {
				wp_send_json_error( array( 'message' => __( 'Failed to fetch kit detail.', 'wira-kit-for-elementor' ) ), 500 );
			}

			$pricing_type = ! empty( $detail['pricing_type'] ) ? sanitize_key( $detail['pricing_type'] ) : '';
			if ( 'subscribe' === $pricing_type ) {
				wp_send_json_error( array( 'message' => __( 'Subscription is required to import this kit.', 'wira-kit-for-elementor' ) ), 403 );
			}

			$download_url = '';
			if ( ! empty( $detail['download_endpoint'] ) ) {
				$download_url = esc_url_raw( $detail['download_endpoint'] );
			} elseif ( ! empty( $detail['zip_url'] ) ) {
				// Backward compatibility with old API payload.
				$download_url = esc_url_raw( $detail['zip_url'] );
			}

			if ( '' === $download_url || ! $this->is_allowed_remote_zip_url( $download_url ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid download endpoint from API.', 'wira-kit-for-elementor' ) ), 500 );
			}

			$download_check = wp_remote_get(
				$download_url,
				array(
					'timeout'             => 25,
					'redirection'         => 5,
					'headers'             => array(
						'Range' => 'bytes=0-0',
					),
					'limit_response_size' => 1,
				)
			);
			if ( is_wp_error( $download_check ) ) {
				wp_send_json_error( array( 'message' => $download_check->get_error_message() ), 500 );
			}

			$download_code = (int) wp_remote_retrieve_response_code( $download_check );
			if ( ! in_array( $download_code, array( 200, 206 ), true ) ) {
				wp_send_json_error(
					array(
						'message' => sprintf(
							/* translators: %d: HTTP status code */
							__( 'Download endpoint responded with HTTP %d.', 'wira-kit-for-elementor' ),
							$download_code
						),
					),
					500
				);
			}

			$checksum = $this->extract_remote_zip_checksum( $detail );
			if ( is_wp_error( $checksum ) ) {
				wp_send_json_error( array( 'message' => $checksum->get_error_message() ), 500 );
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			$temp_file = download_url( $download_url, 120 );

			if ( is_wp_error( $temp_file ) ) {
				wp_send_json_error( array( 'message' => $temp_file->get_error_message() ), 500 );
			}

			$checksum_check = $this->verify_remote_zip_checksum( $temp_file, $checksum );
			if ( is_wp_error( $checksum_check ) ) {
				wp_delete_file( $temp_file );
				wp_send_json_error( array( 'message' => $checksum_check->get_error_message() ), 500 );
			}

			$result = $this->install_template_kit_zip_to_db( $temp_file );
			wp_delete_file( $temp_file );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ), 500 );
			}

			wp_send_json_success(
				array(
					'templateKitId' => (int) $result,
					'message'       => __( 'Template kit imported successfully.', 'wira-kit-for-elementor' ),
				)
			);
		}

		/**
		 * Import remote kit by slug for full import flow.
		 *
		 * @return void
		 */
		public function ajax_import_full_import_remote_kit() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$slug = isset( $_POST['slug'] ) ? sanitize_title( wp_unslash( $_POST['slug'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			if ( '' === $slug ) {
				wp_send_json_error( array( 'message' => __( 'Kit slug is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$detail_url = add_query_arg(
				array(
					'import_type' => 'full_import',
				),
				trailingslashit( self::FULL_IMPORT_REMOTE_KITS_API ) . rawurlencode( $slug )
			);
			$response   = wp_remote_get(
				$detail_url,
				array(
					'timeout' => 25,
				)
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( array( 'message' => $response->get_error_message() ), 500 );
			}

			$code   = (int) wp_remote_retrieve_response_code( $response );
			$body   = wp_remote_retrieve_body( $response );
			$detail = json_decode( $body, true );

			if ( 200 !== $code || ! is_array( $detail ) ) {
				wp_send_json_error( array( 'message' => __( 'Failed to fetch full import kit detail.', 'wira-kit-for-elementor' ) ), 500 );
			}

			$pricing_type = ! empty( $detail['pricing_type'] ) ? sanitize_key( $detail['pricing_type'] ) : '';
			if ( 'subscribe' === $pricing_type ) {
				wp_send_json_error( array( 'message' => __( 'Subscription is required to import this kit.', 'wira-kit-for-elementor' ) ), 403 );
			}

			$download_url = '';
			if ( ! empty( $detail['download_endpoint'] ) ) {
				$download_url = esc_url_raw( $detail['download_endpoint'] );
			} elseif ( ! empty( $detail['zip_url'] ) ) {
				$download_url = esc_url_raw( $detail['zip_url'] );
			}

			if ( '' === $download_url || ! $this->is_allowed_remote_zip_url( $download_url ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid download endpoint from API.', 'wira-kit-for-elementor' ) ), 500 );
			}

			$download_check = wp_remote_get(
				$download_url,
				array(
					'timeout'             => 25,
					'redirection'         => 5,
					'headers'             => array(
						'Range' => 'bytes=0-0',
					),
					'limit_response_size' => 1,
				)
			);
			if ( is_wp_error( $download_check ) ) {
				wp_send_json_error( array( 'message' => $download_check->get_error_message() ), 500 );
			}

			$download_code = (int) wp_remote_retrieve_response_code( $download_check );
			$download_ok   = in_array( $download_code, array( 200, 206 ), true );

			if ( ! $download_ok && 415 === $download_code ) {
				$download_check = wp_remote_get(
					$download_url,
					array(
						'timeout'     => 25,
						'redirection' => 5,
					)
				);
				if ( is_wp_error( $download_check ) ) {
					wp_send_json_error( array( 'message' => $download_check->get_error_message() ), 500 );
				}
				$download_code = (int) wp_remote_retrieve_response_code( $download_check );
				$download_ok   = in_array( $download_code, array( 200, 206 ), true );
			}

			if ( ! $download_ok ) {
				wp_send_json_error(
					array(
						'message' => sprintf(
							/* translators: %d: HTTP status code */
							__( 'Download endpoint responded with HTTP %d.', 'wira-kit-for-elementor' ),
							$download_code
						),
					),
					500
				);
			}

			$checksum = $this->extract_remote_zip_checksum( $detail );
			if ( is_wp_error( $checksum ) ) {
				wp_send_json_error( array( 'message' => $checksum->get_error_message() ), 500 );
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			$temp_file = download_url( $download_url, 120 );

			if ( is_wp_error( $temp_file ) ) {
				wp_send_json_error( array( 'message' => $temp_file->get_error_message() ), 500 );
			}

			$checksum_check = $this->verify_remote_zip_checksum( $temp_file, $checksum );
			if ( is_wp_error( $checksum_check ) ) {
				wp_delete_file( $temp_file );
				wp_send_json_error( array( 'message' => $checksum_check->get_error_message() ), 500 );
			}

			$result = $this->install_template_kit_zip_to_db( $temp_file );
			wp_delete_file( $temp_file );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ), 500 );
			}

			wp_send_json_success(
				array(
					'templateKitId' => (int) $result,
					'message'       => __( 'Full import template kit downloaded successfully.', 'wira-kit-for-elementor' ),
				)
			);
		}

		/**
		 * Return installed kits list.
		 *
		 * @return void
		 */
		public function ajax_list_kits() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$posts = get_posts(
				array(
					'post_type'      => self::CPT_KIT,
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$kits = array();
			foreach ( $posts as $post ) {
				$manifest = $this->get_manifest_data( $post->ID );
				$kits[]   = array(
					'id'             => (int) $post->ID,
					'title'          => get_the_title( $post->ID ),
					'uploaded'       => date_i18n( 'F j, Y g:i a', strtotime( $post->post_date ) ),
					'template_count' => ! empty( $manifest['templates'] ) && is_array( $manifest['templates'] ) ? count( $manifest['templates'] ) : 0,
					'screenshot'     => $this->get_kit_screenshot_url( $post->ID, $manifest ),
				);
			}

			wp_send_json_success( array( 'kits' => $kits ) );
		}

		/**
		 * Return template list for a specific kit.
		 *
		 * @return void
		 */
		public function ajax_list_templates() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$kit_id = isset( $_POST['template_kit_id'] ) ? absint( $_POST['template_kit_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			if ( ! $kit_id ) {
				wp_send_json_error( array( 'message' => __( 'Template kit ID is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$kit_post = $this->get_kit_post( $kit_id );
			if ( is_wp_error( $kit_post ) ) {
				wp_send_json_error( array( 'message' => $kit_post->get_error_message() ), (int) $kit_post->get_error_data() );
			}

			$manifest  = $this->get_manifest_data( $kit_id );
			$templates = array();

			if ( ! empty( $manifest['templates'] ) && is_array( $manifest['templates'] ) ) {
				foreach ( $manifest['templates'] as $index => $template ) {
					if ( ! is_array( $template ) ) {
						continue;
					}

					$templates[] = array(
						'id'                => (int) $index,
						/* translators: %d: template number */
						'name'              => ! empty( $template['name'] ) ? $template['name'] : sprintf( __( 'Template %d', 'wira-kit-for-elementor' ), (int) $index + 1 ),
						'type'              => ! empty( $template['metadata']['template_type'] ) ? $template['metadata']['template_type'] : '',
						'elementor_pro'     => ! empty( $template['metadata']['elementor_pro_required'] ),
						'screenshot'        => ! empty( $template['screenshot'] ) ? $this->get_kit_file_url( $kit_id, $template['screenshot'] ) : '',
						'imports'           => $this->normalize_imports( isset( $template['imports'] ) ? $template['imports'] : array() ),
						'unmet_requirements'=> $this->get_unmet_requirements( $template ),
					);
				}
			}

			wp_send_json_success(
				array(
					'kit'       => array(
						'id'    => (int) $kit_post->ID,
						'title' => get_the_title( $kit_post->ID ),
					),
					'templates' => $templates,
					'required_plugins' => $this->get_required_plugins_status( $manifest ),
					'elementor_settings' => $this->get_elementor_settings_status(),
				)
			);
		}

		/**
		 * Import a single template from a kit into Elementor library.
		 *
		 * @return void
		 */
		public function ajax_import_template() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$kit_id       = isset( $_POST['template_kit_id'] ) ? absint( $_POST['template_kit_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			$template_id  = isset( $_POST['template_id'] ) ? absint( $_POST['template_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			$import_again = isset( $_POST['import_again'] ) ? filter_var( wp_unslash( $_POST['import_again'] ), FILTER_VALIDATE_BOOLEAN ) : false; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().

			if ( ! $kit_id || ! isset( $_POST['template_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
				wp_send_json_error( array( 'message' => __( 'Invalid import request.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$kit_post = $this->get_kit_post( $kit_id );
			if ( is_wp_error( $kit_post ) ) {
				wp_send_json_error( array( 'message' => $kit_post->get_error_message() ), (int) $kit_post->get_error_data() );
			}

			if ( ! class_exists( '\Elementor\Plugin' ) ) {
				wp_send_json_error( array( 'message' => __( 'Elementor plugin is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$manifest = $this->get_manifest_data( $kit_id );
			if ( empty( $manifest['templates'][ $template_id ] ) || ! is_array( $manifest['templates'][ $template_id ] ) ) {
				wp_send_json_error( array( 'message' => __( 'Template not found in kit.', 'wira-kit-for-elementor' ) ), 404 );
			}

			$template = $manifest['templates'][ $template_id ];

			if ( ! $import_again && ! empty( $template['imports'] ) && is_array( $template['imports'] ) ) {
				$imports = $this->normalize_imports( $template['imports'] );
				$latest  = end( $imports );
				if ( $latest && ! empty( $latest['imported_template_id'] ) ) {
					$latest_post = get_post( (int) $latest['imported_template_id'] );
					if ( $latest_post && 'publish' === $latest_post->post_status ) {
						wp_send_json_success(
							array(
								'imported_template_id' => (int) $latest['imported_template_id'],
								'edit_url'             => $this->get_imported_template_edit_url( (int) $latest['imported_template_id'] ),
								'already_imported'     => true,
							)
						);
					}
				}
			}

			$result = $this->import_template_to_elementor( $kit_id, $template_id, $template );
			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ), 500 );
			}

			wp_send_json_success(
				array(
					'imported_template_id' => (int) $result,
					'edit_url'             => $this->get_imported_template_edit_url( (int) $result ),
					'already_imported'     => false,
				)
			);
		}

		/**
		 * Delete installed kit and extracted files.
		 *
		 * @return void
		 */
		public function ajax_delete_kit() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$kit_id = isset( $_POST['template_kit_id'] ) ? absint( $_POST['template_kit_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			if ( ! $kit_id ) {
				wp_send_json_error( array( 'message' => __( 'Template kit ID is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$kit_post = $this->get_kit_post( $kit_id );
			if ( is_wp_error( $kit_post ) ) {
				wp_send_json_error( array( 'message' => $kit_post->get_error_message() ), (int) $kit_post->get_error_data() );
			}

			$folder = get_post_meta( $kit_id, '_wkit_ti_folder_name', true );
			wp_delete_post( $kit_id, true );
			$this->delete_extracted_folder_by_name( $folder );

			wp_send_json_success( array( 'deleted_id' => $kit_id ) );
		}

		/**
		 * Install missing required plugins from manifest.json.
		 *
		 * @return void
		 */
		public function ajax_install_required_plugins() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$kit_id = isset( $_POST['template_kit_id'] ) ? absint( $_POST['template_kit_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			if ( ! $kit_id ) {
				wp_send_json_error( array( 'message' => __( 'Template kit ID is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$kit_post = $this->get_kit_post( $kit_id );
			if ( is_wp_error( $kit_post ) ) {
				wp_send_json_error( array( 'message' => $kit_post->get_error_message() ), (int) $kit_post->get_error_data() );
			}

			$manifest          = $this->get_manifest_data( $kit_id );
			$required_statuses = $this->get_required_plugins_status( $manifest );
			$selected_plugins  = $this->get_selected_required_plugins_from_request();
			$disable_colors    = isset( $_POST['disable_default_colors'] ) ? filter_var( wp_unslash( $_POST['disable_default_colors'] ), FILTER_VALIDATE_BOOLEAN ) : false; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			$disable_fonts     = isset( $_POST['disable_default_fonts'] ) ? filter_var( wp_unslash( $_POST['disable_default_fonts'] ), FILTER_VALIDATE_BOOLEAN ) : false; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().

			if ( ! empty( $selected_plugins ) && empty( $required_statuses ) ) {
				wp_send_json_error( array( 'message' => __( 'No required plugins found in manifest.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$unmet_plugins = array();
			foreach ( $required_statuses as $plugin ) {
				if ( ! is_array( $plugin ) ) {
					continue;
				}

				$slug      = ! empty( $plugin['slug'] ) ? $plugin['slug'] : $this->infer_slug_from_file( ! empty( $plugin['file'] ) ? $plugin['file'] : '' );
				$file      = ! empty( $plugin['file'] ) ? $plugin['file'] : '';

				$is_needed = empty( $plugin['installed'] ) || empty( $plugin['active'] );

				if ( ! $is_needed ) {
					continue;
				}

				// For WordPress.org plugin directory compliance: this plugin does not install/activate other plugins.
				// We only report unmet requirements so the user can take action via WordPress core screens.
				$unmet_plugins[] = $plugin;
			}

			if ( $disable_colors ) {
				// Elementor core option: keep Elementor color schemes disabled for imported kits.
				update_option( 'elementor_disable_color_schemes', 'yes', false );
			}

			if ( $disable_fonts ) {
				// Elementor core option: keep Elementor typography schemes disabled for imported kits.
				update_option( 'elementor_disable_typography_schemes', 'yes', false );
			}

			// Refresh plugin statuses (and action URLs) after any settings changes.
			$required_statuses = $this->get_required_plugins_status( $manifest );

			wp_send_json_success(
				array(
					'message'  => empty( $unmet_plugins )
						? __( 'All required plugins are installed and active.', 'wira-kit-for-elementor' )
						: __( 'Some required plugins are missing or inactive. Please install/activate them manually using the provided links.', 'wira-kit-for-elementor' ),
					'required_plugins'        => $required_statuses,
					'unmet_required_plugins'  => $unmet_plugins,
					'elementor_settings' => $this->get_elementor_settings_status(),
				)
			);
		}

		/**
		 * Run one full import assignment step.
		 *
		 * @return void
		 */
		public function ajax_full_process_step() {
			$this->guard_manage_options();
			$this->verify_nonce();

			$kit_id = isset( $_POST['template_kit_id'] ) ? absint( $_POST['template_kit_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
			$step   = isset( $_POST['step'] ) ? sanitize_key( wp_unslash( $_POST['step'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().

			if ( ! $kit_id || '' === $step ) {
				wp_send_json_error( array( 'message' => __( 'Invalid full import request.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$kit_post = $this->get_kit_post( $kit_id );
			if ( is_wp_error( $kit_post ) ) {
				wp_send_json_error( array( 'message' => $kit_post->get_error_message() ), 404 );
			}

			switch ( $step ) {
				case 'import-acf':
					$result = $this->full_import_acf_scf( $kit_id );
					break;
				case 'assign-template-builder':
					$result = $this->full_assign_template_builder( $kit_id );
					break;
				case 'assign-metform':
					$result = $this->full_assign_metform( $kit_id );
					break;
				case 'assign-template':
					$result = $this->full_assign_templates( $kit_id );
					break;
				case 'assign-menu':
					$result = $this->full_assign_menu( $kit_id );
					break;
				case 'assign-front-page':
					$result = $this->full_assign_front_page( $kit_id );
					break;
				default:
					wp_send_json_error( array( 'message' => __( 'Unknown full import step.', 'wira-kit-for-elementor' ) ), 400 );
			}

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ), 500 );
			}

			$this->force_fix_template_references( $kit_id );
			wp_send_json_success( is_array( $result ) ? $result : array( 'done' => true ) );
		}

		/**
		 * Import custom field definitions if the kit provides ACF/SCF exports.
		 *
		 * Note: This step is intentionally "safe": if the kit doesn't contain any
		 * known export files, or if ACF/SCF isn't installed, we skip with a
		 * success response so the full import can continue.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array<string,mixed>|WP_Error
		 */
		private function full_import_acf_scf( $kit_id ) {
			$kit_path = $this->get_kit_folder_path( $kit_id );
			if ( is_wp_error( $kit_path ) ) {
				return $kit_path;
			}

			$kit_path  = trailingslashit( $kit_path );
			$candidate = array(
				'acf.json',
				'acf-field-groups.json',
				'acf-groups.json',
				'custom-fields.json',
				'scf.json',
				'scf-fields.json',
			);

			$files = array();
			foreach ( $candidate as $relative ) {
				$relative = ltrim( (string) $relative, '/\\' );
				if ( '' === $relative ) {
					continue;
				}

				$full = realpath( $kit_path . $relative );
				if ( ! $full ) {
					continue;
				}
				if ( 0 !== strpos( wp_normalize_path( $full ), wp_normalize_path( $kit_path ) ) ) {
					continue;
				}
				if ( is_file( $full ) && is_readable( $full ) ) {
					$files[] = $full;
				}
			}

			if ( empty( $files ) ) {
				return array(
					'message' => __( 'No ACF/SCF data found in this kit. Skipping.', 'wira-kit-for-elementor' ),
					'count'   => 0,
				);
			}

			$acf_available = function_exists( 'acf_import_field_group' );
			$imported      = 0;
			$notes         = array();

			foreach ( $files as $file ) {
				$data = null;
				if ( function_exists( 'wp_json_file_decode' ) ) {
					$data = wp_json_file_decode( $file, array( 'associative' => true ) );
				} else {
					$raw  = file_get_contents( $file ); // phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown -- local extracted kit file.
					$data = is_string( $raw ) ? json_decode( $raw, true ) : null;
				}

				if ( empty( $data ) || ! is_array( $data ) ) {
					continue;
				}

				// ACF export formats can vary; try a few common shapes.
				$groups = array();
				if ( isset( $data['acf_field_groups'] ) && is_array( $data['acf_field_groups'] ) ) {
					$groups = $data['acf_field_groups'];
				} elseif ( isset( $data['field_groups'] ) && is_array( $data['field_groups'] ) ) {
					$groups = $data['field_groups'];
				} elseif ( isset( $data[0] ) && is_array( $data[0] ) ) {
					$groups = $data;
				}

				if ( empty( $groups ) ) {
					continue;
				}

				if ( ! $acf_available ) {
					$notes[] = __( 'ACF export file detected but ACF is not installed/active. Skipped.', 'wira-kit-for-elementor' );
					continue;
				}

				foreach ( $groups as $group ) {
					if ( ! is_array( $group ) ) {
						continue;
					}
					if ( empty( $group['key'] ) || empty( $group['title'] ) ) {
						continue;
					}

					acf_import_field_group( $group );
					$imported += 1;
				}
			}

			$message = $imported
				? sprintf(
					/* translators: %d: number of imported field groups */
					__( 'Imported %d ACF field group(s).', 'wira-kit-for-elementor' ),
					(int) $imported
				)
				: __( 'No ACF field groups were imported. Skipping.', 'wira-kit-for-elementor' );

			return array(
				'message' => $message,
				'count'   => (int) $imported,
				'notes'   => $notes,
			);
		}

		/**
		 * Get Elementor default scheme disable statuses.
		 *
		 * @return array<string,bool>
		 */
		private function get_elementor_settings_status() {
			$colors = 'yes' === get_option( 'elementor_disable_color_schemes', '' );
			$fonts  = 'yes' === get_option( 'elementor_disable_typography_schemes', '' );

			return array(
				'disable_default_colors' => (bool) $colors,
				'disable_default_fonts'  => (bool) $fonts,
			);
		}

		/**
		 * Parse selected required plugins from request payload.
		 *
		 * @return array<int,string>
		 */
		private function get_selected_required_plugins_from_request() {
			if ( ! isset( $_POST['selected_plugins'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
				return array();
			}

			if ( is_string( $_POST['selected_plugins'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- nonce verified in verify_nonce(); value sanitized below.
				$raw_input = sanitize_text_field( wp_unslash( $_POST['selected_plugins'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in verify_nonce().
				$decoded   = json_decode( $raw_input, true );
				$raw     = is_array( $decoded ) ? $decoded : array();
			} elseif ( is_array( $_POST['selected_plugins'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- nonce verified in verify_nonce(); values sanitized below.
				$raw_input = wp_unslash( $_POST['selected_plugins'] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- nonce verified in verify_nonce(); values sanitized immediately after this line.
				$raw       = array_map( 'sanitize_text_field', $raw_input );
			} else {
				$raw = array();
			}

			if ( ! is_array( $raw ) ) {
				return array();
			}

			$selected = array();
			foreach ( $raw as $item ) {
				$value = is_string( $item ) ? trim( $item ) : '';
				if ( '' !== $value ) {
					$selected[] = sanitize_text_field( $value );
				}
			}

			return array_values( array_unique( $selected ) );
		}

		/**
		 * Install uploaded ZIP and create kit record.
		 *
		 * @param string $temporary_zip_file Uploaded ZIP temporary path.
		 * @return int|WP_Error
		 */
		private function install_template_kit_zip_to_db( $temporary_zip_file ) {
			$base_paths = $this->get_base_paths();
			if ( is_wp_error( $base_paths ) ) {
				return $base_paths;
			}

			$folder_name       = strtolower( wp_generate_password( 32, false, false ) );
			$extract_directory = trailingslashit( $base_paths['path'] ) . $folder_name;

			wp_mkdir_p( $extract_directory );

			$unzip_result = $this->unpack_template_kit_zip_to_folder( $temporary_zip_file, $extract_directory );
			if ( is_wp_error( $unzip_result ) ) {
				$this->delete_extracted_folder_by_name( $folder_name );
				return $unzip_result;
			}

			$manifest_path = trailingslashit( $extract_directory ) . 'manifest.json';
			$manifest_data = json_decode( file_get_contents( $manifest_path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			if ( ! is_array( $manifest_data ) || empty( $manifest_data['title'] ) ) {
				$this->delete_extracted_folder_by_name( $folder_name );
				return new WP_Error( 'manifest_error', __( 'Invalid manifest.json structure.', 'wira-kit-for-elementor' ) );
			}

			$post_id = wp_insert_post(
				array(
					'post_title'  => sanitize_text_field( $manifest_data['title'] ),
					'post_type'   => self::CPT_KIT,
					'post_status' => 'publish',
				),
				true
			);

			if ( is_wp_error( $post_id ) || ! $post_id ) {
				$this->delete_extracted_folder_by_name( $folder_name );
				return new WP_Error( 'db_error', __( 'Failed to store imported kit.', 'wira-kit-for-elementor' ) );
			}

			update_post_meta( $post_id, '_wkit_ti_manifest', $manifest_data );
			update_post_meta( $post_id, '_wkit_ti_folder_name', $folder_name );
			update_post_meta( $post_id, '_wkit_ti_builder', 'elementor' );

			return (int) $post_id;
		}

		/**
		 * Extract ZIP into a destination folder.
		 *
		 * @param string $temporary_zip_file ZIP path.
		 * @param string $destination_folder Destination directory.
		 * @return string|WP_Error
		 */
		private function unpack_template_kit_zip_to_folder( $temporary_zip_file, $destination_folder ) {
			if ( ! class_exists( 'ZipArchive' ) ) {
				return new WP_Error( 'zip_error', __( 'PHP Zip extension is not loaded.', 'wira-kit-for-elementor' ) );
			}

			$zip_size = @filesize( $temporary_zip_file ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			if ( false === $zip_size || $zip_size <= 0 ) {
				return new WP_Error( 'zip_error', __( 'Invalid ZIP file.', 'wira-kit-for-elementor' ) );
			}

			if ( $zip_size > self::MAX_ZIP_FILE_BYTES ) {
				return new WP_Error( 'zip_error', __( 'ZIP file is too large.', 'wira-kit-for-elementor' ) );
			}

			$zip = new ZipArchive();
			$ok  = $zip->open( $temporary_zip_file );
			if ( true !== $ok ) {
				return new WP_Error( 'zip_error', __( 'Unable to open ZIP file.', 'wira-kit-for-elementor' ) );
			}

			if ( $zip->numFiles > self::MAX_ZIP_ENTRIES ) {
				$zip->close();
				return new WP_Error( 'zip_error', __( 'ZIP contains too many files.', 'wira-kit-for-elementor' ) );
			}

			$allowed_files = array();
			$total_uncompressed_size = 0;
			for ( $i = 0; $i < $zip->numFiles; $i++ ) {
				$filename = $zip->getNameIndex( $i );
				if ( ! is_string( $filename ) || '' === $filename ) {
					continue;
				}

				if ( ! $this->is_safe_zip_entry_name( $filename ) ) {
					continue;
				}

				$entry_stat = $zip->statIndex( $i );
				if ( ! is_array( $entry_stat ) ) {
					continue;
				}

				$entry_size = isset( $entry_stat['size'] ) ? (int) $entry_stat['size'] : 0;
				if ( $entry_size < 0 || $entry_size > self::MAX_ZIP_SINGLE_FILE_BYTES ) {
					$zip->close();
					return new WP_Error( 'zip_error', __( 'ZIP contains an oversized file.', 'wira-kit-for-elementor' ) );
				}

				$total_uncompressed_size += $entry_size;
				if ( $total_uncompressed_size > self::MAX_ZIP_TOTAL_UNCOMPRESSED_BYTES ) {
					$zip->close();
					return new WP_Error( 'zip_error', __( 'ZIP uncompressed data is too large.', 'wira-kit-for-elementor' ) );
				}

				$extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
				if ( in_array( $extension, $this->allowed_file_types, true ) ) {
					$allowed_files[] = $filename;
				}
			}

			if ( empty( $allowed_files ) ) {
				$zip->close();
				return new WP_Error( 'zip_error', __( 'No valid template files found in ZIP.', 'wira-kit-for-elementor' ) );
			}

			$zip->extractTo( $destination_folder, $allowed_files );
			$zip->close();

			$manifest = trailingslashit( $destination_folder ) . 'manifest.json';
			if ( ! file_exists( $manifest ) ) {
				$this->delete_folder( $destination_folder );
				return new WP_Error( 'zip_error', __( 'Please upload a valid Template Kit ZIP file.', 'wira-kit-for-elementor' ) );
			}

			return $destination_folder;
		}

		/**
		 * Import one template to Elementor local library.
		 *
		 * @param int   $kit_id Kit post ID.
		 * @param int   $template_id Template index in manifest.
		 * @param array $template Template data from manifest.
		 * @return int|WP_Error
		 */
		private function import_template_to_elementor( $kit_id, $template_id, $template ) {
			if ( empty( $template['source'] ) ) {
				return new WP_Error( 'template_error', __( 'Template source file is missing.', 'wira-kit-for-elementor' ) );
			}

			$json_file_path = $this->get_kit_file_path( $kit_id, $template['source'] );
			if ( is_wp_error( $json_file_path ) ) {
				return $json_file_path;
			}

			if ( ! file_exists( $json_file_path ) ) {
				return new WP_Error( 'template_error', __( 'Template JSON file was not found.', 'wira-kit-for-elementor' ) );
			}

			$local_json_data = json_decode( file_get_contents( $json_file_path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			if ( ! is_array( $local_json_data ) ) {
				return new WP_Error( 'template_error', __( 'Template JSON is invalid.', 'wira-kit-for-elementor' ) );
			}

			$template_type = ! empty( $local_json_data['metadata']['template_type'] ) ? sanitize_key( (string) $local_json_data['metadata']['template_type'] ) : '';
			if ( 'metform' === $template_type && post_type_exists( 'metform-form' ) ) {
				$imported_template_id = $this->import_template_to_metform( $kit_id, $template_id, $local_json_data );
				if ( is_wp_error( $imported_template_id ) ) {
					return $imported_template_id;
				}
				$this->maybe_fix_template_references( $kit_id );
				return $imported_template_id;
			}

			$source = \Elementor\Plugin::$instance->templates_manager->get_source( 'local' );
			if ( ! $source ) {
				return new WP_Error( 'elementor_error', __( 'Elementor local template source is unavailable.', 'wira-kit-for-elementor' ) );
			}

			if ( ! empty( $local_json_data['metadata']['elementor_pro_required'] ) && ! class_exists( '\ElementorPro\Plugin' ) ) {
				$local_json_data['type'] = 'page';
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			$temp_wp_json_file = wp_tempnam( 'wkit-import-' );
			if ( ! $temp_wp_json_file ) {
				return new WP_Error( 'io_error', __( 'Unable to create temporary import file.', 'wira-kit-for-elementor' ) );
			}

			global $wp_filesystem;
			if ( ! $wp_filesystem ) {
				WP_Filesystem();
			}

			$temp_json_content = wp_json_encode( $local_json_data );
			$write_result      = ( $wp_filesystem && null !== $temp_json_content ) ? $wp_filesystem->put_contents( $temp_wp_json_file, $temp_json_content, FS_CHMOD_FILE ) : false;

			if ( ! $write_result ) {
				if ( file_exists( $temp_wp_json_file ) ) {
					wp_delete_file( $temp_wp_json_file );
				}
				return new WP_Error( 'io_error', __( 'Unable to write temporary import file.', 'wira-kit-for-elementor' ) );
			}

			$result = $source->import_template( basename( $temp_wp_json_file ), $temp_wp_json_file );

			if ( file_exists( $temp_wp_json_file ) ) {
				wp_delete_file( $temp_wp_json_file );
			}

			if ( is_wp_error( $result ) ) {
				/* translators: %s: import error message */
				return new WP_Error( 'import_error', sprintf( __( 'Failed to import template: %s', 'wira-kit-for-elementor' ), $result->get_error_message() ) );
			}

			if ( empty( $result[0]['template_id'] ) ) {
				return new WP_Error( 'import_error', __( 'Unknown template import error.', 'wira-kit-for-elementor' ) );
			}

			$imported_template_id = (int) $result[0]['template_id'];
			$this->record_imported_template_id_map( $kit_id, $local_json_data, $imported_template_id );
			$this->record_import_event( $kit_id, $template_id, $imported_template_id );

			if ( ! empty( $local_json_data['metadata']['elementor_pro_conditions'] ) ) {
				update_post_meta( $imported_template_id, '_elementor_conditions', $local_json_data['metadata']['elementor_pro_conditions'] );
			}

			if ( ! empty( $local_json_data['metadata']['wp_page_template'] ) ) {
				update_post_meta( $imported_template_id, '_wp_page_template', $local_json_data['metadata']['wp_page_template'] );
			}

			update_post_meta( $imported_template_id, '_wkit_ti_source_kit', $kit_id );
			update_post_meta( $imported_template_id, '_wkit_ti_source_index', $template_id );

			if ( ! empty( $local_json_data['metadata']['template_type'] ) && 'global-styles' === $local_json_data['metadata']['template_type'] ) {
				update_post_meta( $imported_template_id, '_elementor_edit_mode', 'builder' );
				update_post_meta( $imported_template_id, '_elementor_template_type', 'kit' );
				// Elementor core option: set active kit to the imported template.
				update_option( 'elementor_active_kit', $imported_template_id );

				wp_update_post(
					array(
						'ID'         => $imported_template_id,
						'post_title' => 'Kit Styles: ' . get_the_title( $kit_id ),
					)
				);
			}

			$this->maybe_fix_template_references( $kit_id );

			return $imported_template_id;
		}

		/**
		 * Import one MetForm template as metform-form CPT.
		 *
		 * @param int   $kit_id Kit post ID.
		 * @param int   $template_id Template index in manifest.
		 * @param array $local_json_data Template JSON data.
		 * @return int|WP_Error
		 */
		private function import_template_to_metform( $kit_id, $template_id, $local_json_data ) {
			$title = ! empty( $local_json_data['title'] ) ? wp_strip_all_tags( html_entity_decode( (string) $local_json_data['title'], ENT_QUOTES ) ) : '';
			if ( '' === $title ) {
				$title = __( 'MetForm Import', 'wira-kit-for-elementor' );
			}

			$post_id = wp_insert_post(
				array(
					'post_type'   => 'metform-form',
					'post_status' => 'publish',
					'post_title'  => $title,
				),
				true
			);

			if ( is_wp_error( $post_id ) || ! $post_id ) {
				return is_wp_error( $post_id ) ? $post_id : new WP_Error( 'metform_error', __( 'Failed to insert MetForm form.', 'wira-kit-for-elementor' ) );
			}

			$metform_settings = '';
			if ( ! empty( $local_json_data['metadata']['metform_form__form_setting'] ) && is_string( $local_json_data['metadata']['metform_form__form_setting'] ) ) {
				$metform_settings = $local_json_data['metadata']['metform_form__form_setting'];
			}
			update_post_meta( (int) $post_id, 'metform_form__form_setting', $metform_settings );

			if ( isset( $local_json_data['content'] ) ) {
				update_post_meta( (int) $post_id, '_elementor_data', wp_json_encode( $local_json_data['content'] ) );
			}
			if ( ! empty( $local_json_data['page_settings'] ) ) {
				update_post_meta( (int) $post_id, '_elementor_page_settings', $local_json_data['page_settings'] );
			}
			update_post_meta( (int) $post_id, '_elementor_edit_mode', 'builder' );

			$source_form_id = 0;
			if ( ! empty( $local_json_data['metadata']['metform_source_form_id'] ) ) {
				$source_form_id = absint( $local_json_data['metadata']['metform_source_form_id'] );
			}
			if ( $source_form_id ) {
				update_post_meta( (int) $post_id, '_wkit_ti_metform_source_id', $source_form_id );
			}

			$this->record_imported_template_id_map( $kit_id, $local_json_data, (int) $post_id );
			$this->record_import_event( $kit_id, $template_id, (int) $post_id );

			update_post_meta( (int) $post_id, '_wkit_ti_source_kit', $kit_id );
			update_post_meta( (int) $post_id, '_wkit_ti_source_index', $template_id );

			return (int) $post_id;
		}

		/**
		 * Record template ID map (source => imported) for later reference fixing.
		 *
		 * @param int   $kit_id Kit ID.
		 * @param array $template_json Template JSON data.
		 * @param int   $imported_template_id Imported template ID.
		 * @return void
		 */
		private function record_imported_template_id_map( $kit_id, $template_json, $imported_template_id ) {
			$source_id = 0;
			if ( is_array( $template_json ) && ! empty( $template_json['metadata']['source_template_id'] ) ) {
				$source_id = absint( $template_json['metadata']['source_template_id'] );
			}
			if ( ! $source_id || ! $imported_template_id ) {
				return;
			}

			$map = get_post_meta( (int) $kit_id, '_wkit_ti_template_id_map', true );
			if ( ! is_array( $map ) ) {
				$map = array();
			}
			$map[ $source_id ] = (int) $imported_template_id;
			update_post_meta( (int) $kit_id, '_wkit_ti_template_id_map', $map );

			delete_post_meta( (int) $kit_id, '_wkit_ti_template_refs_fixed' );
		}

		/**
		 * Record import info in manifest metadata.
		 *
		 * @param int $kit_id Kit ID.
		 * @param int $template_id Template index.
		 * @param int $imported_template_id Imported Elementor template ID.
		 * @return void
		 */
		private function record_import_event( $kit_id, $template_id, $imported_template_id ) {
			$manifest = $this->get_manifest_data( $kit_id );
			if ( empty( $manifest['templates'][ $template_id ] ) || ! is_array( $manifest['templates'][ $template_id ] ) ) {
				return;
			}

			if ( ! isset( $manifest['templates'][ $template_id ]['imports'] ) || ! is_array( $manifest['templates'][ $template_id ]['imports'] ) ) {
				$manifest['templates'][ $template_id ]['imports'] = array();
			}

			$manifest['templates'][ $template_id ]['imports'][] = array(
				'imported_template_id' => (int) $imported_template_id,
			);

			update_post_meta( $kit_id, '_wkit_ti_manifest', $manifest );
		}

		/**
		 * Normalize old/new import record format.
		 *
		 * @param array $imports Raw imports data.
		 * @return array
		 */
		private function normalize_imports( $imports ) {
			$output = array();
			foreach ( (array) $imports as $import ) {
				if ( is_array( $import ) && isset( $import['imported_template_id'] ) ) {
					$output[] = array(
						'imported_template_id' => (int) $import['imported_template_id'],
					);
				} elseif ( is_numeric( $import ) ) {
					$output[] = array(
						'imported_template_id' => (int) $import,
					);
				}
			}
			return $output;
		}

		/**
		 * Fix template ID references inside Elementor data (loop/block/popup/templates).
		 *
		 * @param int $kit_id Kit ID.
		 * @return void
		 */
		private function maybe_fix_template_references( $kit_id ) {
			$kit_id = (int) $kit_id;
			if ( $kit_id < 1 ) {
				return;
			}

			$already = get_post_meta( $kit_id, '_wkit_ti_template_refs_fixed', true );
			if ( $already ) {
				return;
			}

			$map = get_post_meta( $kit_id, '_wkit_ti_template_id_map', true );
			if ( ! is_array( $map ) || empty( $map ) ) {
				update_post_meta( $kit_id, '_wkit_ti_template_refs_fixed', 1 );
				return;
			}

			$post_ids = array();
			$imported_templates = get_posts(
				array(
					'post_type'      => 'any',
					'post_status'    => array( 'publish', 'draft', 'private' ),
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'meta_query'     => array(
						array(
							'key'   => '_wkit_ti_source_kit',
							'value' => $kit_id,
						),
					),
				)
			);
			if ( is_array( $imported_templates ) ) {
				$post_ids = array_merge( $post_ids, $imported_templates );
			}

			$full_posts = get_posts(
				array(
					'post_type'      => 'any',
					'post_status'    => array( 'publish', 'draft', 'private' ),
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'meta_query'     => array(
						array(
							'key'   => '_wkit_ti_full_source_kit',
							'value' => $kit_id,
						),
					),
				)
			);
			if ( is_array( $full_posts ) ) {
				$post_ids = array_merge( $post_ids, $full_posts );
			}

			$post_ids = array_values( array_unique( array_map( 'absint', $post_ids ) ) );
			foreach ( $post_ids as $post_id ) {
				if ( $post_id > 0 ) {
					$this->replace_template_references_on_post( $post_id, $map );
				}
			}

			update_post_meta( $kit_id, '_wkit_ti_template_refs_fixed', 1 );
		}

		/**
		 * Force rerun template reference mapping for a kit.
		 *
		 * @param int $kit_id Kit ID.
		 * @return void
		 */
		private function force_fix_template_references( $kit_id ) {
			$kit_id = (int) $kit_id;
			if ( $kit_id < 1 ) {
				return;
			}

			delete_post_meta( $kit_id, '_wkit_ti_template_refs_fixed' );
			$this->maybe_fix_template_references( $kit_id );
		}

		/**
		 * Replace template IDs inside _elementor_data for one post.
		 *
		 * @param int   $post_id Post ID.
		 * @param array $map     Source ID => Imported ID.
		 * @return void
		 */
		private function replace_template_references_on_post( $post_id, $map ) {
			if ( empty( $map ) || ! is_array( $map ) ) {
				return;
			}

			$raw = get_post_meta( (int) $post_id, '_elementor_data', true );
			if ( empty( $raw ) ) {
				return;
			}

			$result = $this->replace_template_ids_in_elementor_data( $raw, $map );
			if ( $result === $raw ) {
				return;
			}

			if ( is_string( $result ) ) {
				update_post_meta( (int) $post_id, '_elementor_data', wp_slash( $result ) );
			} else {
				update_post_meta( (int) $post_id, '_elementor_data', $result );
			}
		}

		/**
		 * Replace template ID references in Elementor data.
		 *
		 * @param mixed $elementor_data Elementor data (string/array).
		 * @param array $map            Source ID => Imported ID.
		 * @return mixed
		 */
		private function replace_template_ids_in_elementor_data( $elementor_data, $map ) {
			if ( empty( $map ) || ! is_array( $map ) ) {
				return $elementor_data;
			}

			$original_is_string = is_string( $elementor_data );
			$data = $elementor_data;
			if ( $original_is_string ) {
				$decoded = json_decode( $elementor_data, true );
				if ( ! is_array( $decoded ) ) {
					return $elementor_data;
				}
				$data = $decoded;
			}

			$changed = false;
			$data = $this->replace_template_ids_recursive( $data, $map, $changed );

			if ( ! $changed ) {
				return $elementor_data;
			}

			if ( $original_is_string ) {
				return wp_json_encode( $data );
			}

			return $data;
		}

		/**
		 * Recursive template ID replacement helper.
		 *
		 * @param mixed $value   Data node.
		 * @param array $map     Source ID => Imported ID.
		 * @param bool  $changed Change flag by reference.
		 * @return mixed
		 */
		private function replace_template_ids_recursive( $value, $map, &$changed ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $key => $item ) {
					if ( in_array( $key, array( 'loop_template', 'blocks_template', 'tab_template_id', 'popup_template' ), true ) ) {
						$resolved_id = $this->resolve_template_reference_id( $item, $map );
						if ( $resolved_id ) {
							$value[ $key ] = (int) $resolved_id;
							$changed = true;
						}
						continue;
					}

					if ( is_array( $item ) ) {
						$value[ $key ] = $this->replace_template_ids_recursive( $item, $map, $changed );
					}
				}
			}

			return $value;
		}

		/**
		 * Resolve template reference value (numeric ID or token) to imported ID.
		 *
		 * @param mixed $value Template reference value.
		 * @param array $map   Source ID => Imported ID.
		 * @return int
		 */
		private function resolve_template_reference_id( $value, $map ) {
			if ( empty( $map ) || ! is_array( $map ) ) {
				return 0;
			}

			$source_id = 0;
			if ( is_numeric( $value ) ) {
				$source_id = (int) $value;
			} elseif ( is_string( $value ) ) {
				$token = trim( $value );
				if ( preg_match( '/^wkit-template:(\\d+)$/', $token, $matches ) ) {
					$source_id = (int) $matches[1];
				} elseif ( preg_match( '/^wkit-template-name:(.+)$/', $token, $matches ) ) {
					$source_name = trim( (string) $matches[1] );
				}
			}

			if ( $source_id && isset( $map[ $source_id ] ) ) {
				return (int) $map[ $source_id ];
			}

			if ( $source_name ) {
				$resolved_by_name = $this->find_template_id_by_name( $source_name );
				if ( $resolved_by_name ) {
					return $resolved_by_name;
				}
			}

			return 0;
		}

		/**
		 * Find a post ID by exact post title for one or more post types.
		 *
		 * get_page_by_title() was deprecated in WP 6.2, but we still need a way to
		 * resolve imported references by their original title (not only by slug).
		 *
		 * @param string           $title      Exact title to match.
		 * @param array<int,mixed> $post_types Post types to search in.
		 * @return int
		 */
		private function find_post_id_by_exact_title( $title, $post_types ) {
			$title = (string) $title;
			if ( '' === $title ) {
				return 0;
			}

			$post_types = array_values(
				array_filter(
					array_map(
						'strval',
						is_array( $post_types ) ? $post_types : array()
					)
				)
			);
			if ( empty( $post_types ) ) {
				return 0;
			}

			$filter = static function( $where, $query ) use ( $title ) {
				if ( ! ( $query instanceof WP_Query ) ) {
					return $where;
				}
				if ( true !== $query->get( 'wirakit_exact_title' ) ) {
					return $where;
				}

				global $wpdb;
				return $where . $wpdb->prepare( " AND {$wpdb->posts}.post_title = %s", $title );
			};

			add_filter( 'posts_where', $filter, 10, 2 );

			$query = new WP_Query(
				array(
					'post_type'              => $post_types,
					'post_status'            => array( 'publish', 'draft', 'private' ),
					'posts_per_page'         => 1,
					'fields'                 => 'ids',
					'no_found_rows'          => true,
					'ignore_sticky_posts'    => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'suppress_filters'       => false,
					'wirakit_exact_title'    => true,
				)
			);

			remove_filter( 'posts_where', $filter, 10 );

			if ( ! empty( $query->posts[0] ) ) {
				return (int) $query->posts[0];
			}

			return 0;
		}

		/**
		 * Find template ID by title (Elementor library or WKit templates).
		 *
		 * @param string $title Template title.
		 * @return int
		 */
		private function find_template_id_by_name( $title ) {
			$title = (string) $title;
			if ( '' === $title ) {
				return 0;
			}

			$decoded    = html_entity_decode( $title, ENT_QUOTES );
			$normalized = preg_replace( '/\s*[–—−]\s*/u', ' - ', $decoded );
			$normalized = is_string( $normalized ) ? trim( preg_replace( '/\s+/', ' ', $normalized ) ) : $decoded;

			$candidates = array_values( array_unique( array_filter( array( $decoded, $normalized ) ) ) );
			$post_types = array( 'elementor_library' );
			if ( class_exists( 'Wirakit_Template_Builder_Post_Type' ) ) {
				$post_types = array_merge(
					$post_types,
					array(
						Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE,
						Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE,
						Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE,
						Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE,
						Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE,
						Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE,
					)
				);
			}

			foreach ( $candidates as $candidate ) {
				$found = $this->find_post_id_by_exact_title( $candidate, $post_types );
				if ( $found ) {
					return $found;
				}
			}

			foreach ( $candidates as $candidate ) {
				$slug = sanitize_title( $candidate );
				if ( '' === $slug ) {
					continue;
				}
				$found = get_posts(
					array(
						'post_type'      => $post_types,
						'name'           => $slug,
						'post_status'    => array( 'publish', 'draft', 'private' ),
						'posts_per_page' => 1,
						'fields'         => 'ids',
					)
				);
				if ( ! empty( $found ) ) {
					return (int) $found[0];
				}
			}

			return 0;
		}

		/**
		 * Get unmet import requirements for one template.
		 *
		 * @param array $template Template data.
		 * @return array<int,string>
		 */
		private function full_assign_template_builder( $kit_id ) {
			$assignments = $this->get_kit_json_data( $kit_id, 'assignments.json' );
			if ( is_wp_error( $assignments ) ) {
				return $assignments;
			}
			$metform_map = $this->get_full_metform_id_map( $kit_id );

			if ( empty( $assignments['template_builder'] ) || ! is_array( $assignments['template_builder'] ) ) {
				return array(
					'message' => __( 'No template builder assignment found.', 'wira-kit-for-elementor' ),
					'count'   => 0,
				);
			}

			$count = 0;
			foreach ( $assignments['template_builder'] as $assignment_key => $config ) {
				if ( ! is_array( $config ) ) {
					continue;
				}

				$post_type = ! empty( $config['post_type'] ) ? sanitize_key( $config['post_type'] ) : '';
				$source    = ! empty( $config['template_source'] ) ? (string) $config['template_source'] : '';
				$title     = ! empty( $config['title'] ) ? sanitize_text_field( $config['title'] ) : '';
				$active    = ! empty( $config['active'] );
				$display   = ! empty( $config['display_condition'] ) ? (string) $config['display_condition'] : 'all';

				if ( '' === $post_type || '' === $source || '' === $title ) {
					continue;
				}

				$imported_template_id = $this->get_imported_template_id_by_source( $kit_id, $source );
				if ( ! $imported_template_id ) {
					continue;
				}

				$display = $this->normalize_builder_display_condition( $display );
				$status  = $active ? 'active' : 'inactive';

				$target_post_id = $this->get_existing_full_builder_post( $post_type, $assignment_key, $kit_id );
				$post_data      = array(
					'post_type'   => $post_type,
					'post_title'  => $title,
					'post_status' => 'publish',
				);

				if ( $target_post_id ) {
					$post_data['ID'] = $target_post_id;
					$target_post_id  = wp_update_post( $post_data, true );
				} else {
					$target_post_id = wp_insert_post( $post_data, true );
				}

				if ( is_wp_error( $target_post_id ) || ! $target_post_id ) {
					continue;
				}

				$this->copy_elementor_meta(
					$imported_template_id,
					(int) $target_post_id,
					array(
						'metform_map' => $metform_map,
					)
				);
				update_post_meta( $target_post_id, '_wkit_condition_status', $status );
				update_post_meta( $target_post_id, '_wkit_condition_display', $display );
				update_post_meta( $target_post_id, '_wp_page_template', 'elementor_canvas' );
				update_post_meta( $target_post_id, '_wkit_ti_full_assignment_key', sanitize_key( (string) $assignment_key ) );
				update_post_meta( $target_post_id, '_wkit_ti_full_source_kit', (int) $kit_id );

				$count++;
			}

			return array(
				'message' => sprintf(
					/* translators: %d: number of assigned template builder posts. */
					__( 'Assigned %d Template Builder item(s).', 'wira-kit-for-elementor' ),
					(int) $count
				),
				'count'   => (int) $count,
			);
		}

		/**
		 * Full import step: assign MetForm templates (best-effort).
		 *
		 * @param int $kit_id Kit ID.
		 * @return array
		 */
		private function full_assign_metform( $kit_id ) {
			$metform_map = $this->get_full_metform_id_map( $kit_id );
			$count       = count( $metform_map );

			if ( ! empty( $metform_map ) ) {
				$builder_post_ids = get_posts(
					array(
						'post_type'      => array( 'wkit-header', 'wkit-footer', 'wkit-single', 'wkit-archive', 'wkit-search', 'wkit-404' ),
						'post_status'    => array( 'publish', 'draft', 'private' ),
						'posts_per_page' => -1,
						'fields'         => 'ids',
						'meta_query'     => array(
							array(
								'key'   => '_wkit_ti_full_source_kit',
								'value' => (int) $kit_id,
							),
						),
					)
				);

				if ( ! empty( $builder_post_ids ) ) {
					foreach ( $builder_post_ids as $builder_post_id ) {
						$this->replace_metform_ids_on_post( (int) $builder_post_id, $metform_map );
					}
				}
			}

			return array(
				'message' => sprintf(
					/* translators: %d: number of metform related templates. */
					__( 'MetForm step completed (%d template reference(s)).', 'wira-kit-for-elementor' ),
					(int) $count
				),
				'count'   => (int) $count,
			);
		}

		/**
		 * Assign imported templates into WP Pages based on content-map.json.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array|WP_Error
		 */
		private function full_assign_templates( $kit_id ) {
			$content_map = $this->get_kit_json_data( $kit_id, 'content-map.json' );
			if ( is_wp_error( $content_map ) ) {
				return $content_map;
			}

			if ( empty( $content_map['pages'] ) || ! is_array( $content_map['pages'] ) ) {
				return array(
					'message' => __( 'No page template assignment found.', 'wira-kit-for-elementor' ),
					'count'   => 0,
				);
			}

			$page_map = array();
			$count    = 0;
			$metform_map = $this->get_full_metform_id_map( $kit_id );
			foreach ( $content_map['pages'] as $page_config ) {
				if ( ! is_array( $page_config ) ) {
					continue;
				}

				$title  = ! empty( $page_config['title'] ) ? sanitize_text_field( $page_config['title'] ) : '';
				$slug   = ! empty( $page_config['slug'] ) ? sanitize_title( $page_config['slug'] ) : '';
				$status = ! empty( $page_config['status'] ) ? sanitize_key( $page_config['status'] ) : 'publish';
				$source = ! empty( $page_config['template_source'] ) ? (string) $page_config['template_source'] : '';
				$is_posts_page = ! empty( $page_config['set_as_posts_page'] );

				if ( '' === $title || '' === $slug ) {
					continue;
				}

				$page_post = get_page_by_path( $slug, OBJECT, 'page' );
				$page_id   = $page_post ? (int) $page_post->ID : 0;

				$post_data = array(
					'post_type'   => 'page',
					'post_title'  => $title,
					'post_name'   => $slug,
					'post_status' => in_array( $status, array( 'publish', 'draft', 'private' ), true ) ? $status : 'publish',
				);

				if ( $page_id ) {
					$post_data['ID'] = $page_id;
					$page_id          = wp_update_post( $post_data, true );
				} else {
					$page_id = wp_insert_post( $post_data, true );
				}

				if ( is_wp_error( $page_id ) || ! $page_id ) {
					continue;
				}

				$imported_template_id = $this->get_imported_template_id_by_source( $kit_id, $source );
				if ( $imported_template_id && ! $is_posts_page ) {
					$assigned_page_template = $this->resolve_assigned_page_template( $imported_template_id );
					$this->copy_elementor_meta(
						$imported_template_id,
						(int) $page_id,
						array(
							'copy_post_content'  => false,
							'copy_template_type' => false,
							'page_layout'        => $this->map_wp_template_to_elementor_layout( $assigned_page_template ),
							'metform_map'        => $metform_map,
						)
					);
					update_post_meta( (int) $page_id, '_wp_page_template', $assigned_page_template );
				}

				if ( $is_posts_page ) {
					$this->clear_elementor_meta( (int) $page_id );
					update_post_meta( (int) $page_id, '_wp_page_template', 'default' );
				}
				update_post_meta( (int) $page_id, '_wkit_ti_full_source_kit', (int) $kit_id );
				$page_map[ $slug ] = (int) $page_id;
				$count++;
			}

			// Regenerate frontend CSS/assets after page assignment to avoid stale template-library cache metadata.
			if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) && is_object( \Elementor\Plugin::$instance->files_manager ) ) {
				if ( method_exists( \Elementor\Plugin::$instance->files_manager, 'clear_cache' ) ) {
					\Elementor\Plugin::$instance->files_manager->clear_cache();
				}
			}

			update_post_meta( $kit_id, '_wkit_ti_full_page_map', $page_map );

			return array(
				'message' => sprintf(
					/* translators: %d: number of assigned pages. */
					__( 'Assigned %d page template(s).', 'wira-kit-for-elementor' ),
					(int) $count
				),
				'count'   => (int) $count,
				'pages'   => $page_map,
			);
		}

		/**
		 * Assign nav menus and menu locations.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array|WP_Error
		 */
		private function full_assign_menu( $kit_id ) {
			$menus_data = $this->get_kit_json_data( $kit_id, 'menus.json' );
			if ( is_wp_error( $menus_data ) ) {
				return $menus_data;
			}

			if ( empty( $menus_data['menus'] ) || ! is_array( $menus_data['menus'] ) ) {
				return array(
					'message' => __( 'No menus found to assign.', 'wira-kit-for-elementor' ),
					'count'   => 0,
				);
			}

			$page_map = get_post_meta( $kit_id, '_wkit_ti_full_page_map', true );
			$page_map = is_array( $page_map ) ? $page_map : array();

			$menu_term_by_slug = array();
			$count             = 0;
			foreach ( $menus_data['menus'] as $menu ) {
				if ( ! is_array( $menu ) ) {
					continue;
				}

				$menu_slug = ! empty( $menu['slug'] ) ? sanitize_title( $menu['slug'] ) : '';
				$menu_name = ! empty( $menu['name'] ) ? sanitize_text_field( $menu['name'] ) : $menu_slug;
				if ( '' === $menu_slug || '' === $menu_name ) {
					continue;
				}

				$term = get_term_by( 'slug', $menu_slug, 'nav_menu' );
				if ( ! $term || is_wp_error( $term ) ) {
					$menu_id = wp_create_nav_menu( $menu_name );
					if ( is_wp_error( $menu_id ) || ! $menu_id ) {
						continue;
					}
					$term = get_term( (int) $menu_id, 'nav_menu' );
				}

				if ( ! $term || is_wp_error( $term ) ) {
					continue;
				}

				$menu_term_by_slug[ $menu_slug ] = (int) $term->term_id;
				$count++;

				$existing_items = wp_get_nav_menu_items( (int) $term->term_id, array( 'post_status' => 'any' ) );
				if ( is_array( $existing_items ) ) {
					foreach ( $existing_items as $existing_item ) {
						wp_delete_post( (int) $existing_item->ID, true );
					}
				}

				if ( empty( $menu['items'] ) || ! is_array( $menu['items'] ) ) {
					continue;
				}

				$menu_items       = $this->normalize_menu_items_for_import( $menu['items'] );
				$created_menu_ids = array();

				foreach ( $menu_items as $item ) {
					if ( ! is_array( $item ) ) {
						continue;
					}

					$item_key    = ! empty( $item['item_key'] ) ? sanitize_key( (string) $item['item_key'] ) : '';
					$parent_key  = ! empty( $item['parent_key'] ) ? sanitize_key( (string) $item['parent_key'] ) : '';
					$item_title = ! empty( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
					$item_type  = ! empty( $item['type'] ) ? sanitize_key( $item['type'] ) : 'custom';
					$item_slug  = ! empty( $item['target_slug'] ) ? sanitize_title( $item['target_slug'] ) : '';
					$item_url   = ! empty( $item['url'] ) ? esc_url_raw( $item['url'] ) : '';

					$args = array(
						'menu-item-title'  => $item_title,
						'menu-item-status' => 'publish',
					);

					if ( 'page' === $item_type && ! empty( $item_slug ) ) {
						$page_id = ! empty( $page_map[ $item_slug ] ) ? (int) $page_map[ $item_slug ] : 0;
						if ( ! $page_id ) {
							$page_obj = get_page_by_path( $item_slug, OBJECT, 'page' );
							$page_id  = $page_obj ? (int) $page_obj->ID : 0;
						}

						if ( $page_id ) {
							$args['menu-item-object-id'] = $page_id;
							$args['menu-item-object']    = 'page';
							$args['menu-item-type']      = 'post_type';
						} else {
							$args['menu-item-type'] = 'custom';
							$args['menu-item-url']  = home_url( '/' . ltrim( $item_slug, '/' ) . '/' );
						}
					} else {
						$args['menu-item-type'] = 'custom';
						$args['menu-item-url']  = '' !== $item_url ? $item_url : home_url( '/' );
					}

					if ( '' !== $parent_key && ! empty( $created_menu_ids[ $parent_key ] ) ) {
						$args['menu-item-parent-id'] = (int) $created_menu_ids[ $parent_key ];
					}

					$created_item_id = wp_update_nav_menu_item( (int) $term->term_id, 0, $args );
					if ( '' !== $item_key && ! is_wp_error( $created_item_id ) && $created_item_id ) {
						$created_menu_ids[ $item_key ] = (int) $created_item_id;
					}
				}
			}

			$locations = get_theme_mod( 'nav_menu_locations', array() );
			$locations = is_array( $locations ) ? $locations : array();
			if ( ! empty( $menus_data['locations'] ) && is_array( $menus_data['locations'] ) ) {
				foreach ( $menus_data['locations'] as $location => $menu_slug ) {
					$location  = sanitize_key( (string) $location );
					$menu_slug = sanitize_title( (string) $menu_slug );
					if ( isset( $menu_term_by_slug[ $menu_slug ] ) ) {
						$locations[ $location ] = (int) $menu_term_by_slug[ $menu_slug ];
					}
				}
				set_theme_mod( 'nav_menu_locations', $locations );
			}

			return array(
				'message' => sprintf(
					/* translators: %d: number of menus assigned. */
					__( 'Assigned %d menu(s).', 'wira-kit-for-elementor' ),
					(int) $count
				),
				'count'   => (int) $count,
			);
		}

		/**
		 * Normalize menu item structure to flat list with parent references.
		 *
		 * Supports:
		 * - legacy flat items
		 * - items with parent_key
		 * - nested items via children[]
		 *
		 * @param array  $items Raw menu items.
		 * @param string $parent_key Parent item key.
		 * @param int    $counter Running counter.
		 * @return array<int,array<string,mixed>>
		 */
		private function normalize_menu_items_for_import( $items, $parent_key = '', &$counter = 0 ) {
			$normalized = array();
			foreach ( (array) $items as $item ) {
				if ( ! is_array( $item ) ) {
					continue;
				}

				$counter++;
				$item_key = ! empty( $item['item_key'] )
					? sanitize_key( (string) $item['item_key'] )
					: 'item_' . $counter;
				$this_parent_key = ! empty( $item['parent_key'] )
					? sanitize_key( (string) $item['parent_key'] )
					: sanitize_key( (string) $parent_key );

				$normalized[] = array(
					'item_key'    => $item_key,
					'parent_key'  => $this_parent_key,
					'title'       => ! empty( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '',
					'type'        => ! empty( $item['type'] ) ? sanitize_key( $item['type'] ) : 'custom',
					'target_slug' => ! empty( $item['target_slug'] ) ? sanitize_title( $item['target_slug'] ) : '',
					'url'         => ! empty( $item['url'] ) ? esc_url_raw( $item['url'] ) : '',
				);

				if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
					$normalized = array_merge(
						$normalized,
						$this->normalize_menu_items_for_import( $item['children'], $item_key, $counter )
					);
				}
			}

			return $normalized;
		}

		/**
		 * Assign front page and blog page.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array|WP_Error
		 */
		private function full_assign_front_page( $kit_id ) {
			$site_settings = $this->get_kit_json_data( $kit_id, 'site-settings.json' );
			if ( is_wp_error( $site_settings ) ) {
				return $site_settings;
			}

			$page_map = get_post_meta( $kit_id, '_wkit_ti_full_page_map', true );
			$page_map = is_array( $page_map ) ? $page_map : array();

			$reading        = ! empty( $site_settings['reading'] ) && is_array( $site_settings['reading'] ) ? $site_settings['reading'] : array();
			$show_on_front  = ! empty( $reading['show_on_front'] ) ? sanitize_key( $reading['show_on_front'] ) : 'posts';
			$page_on_front  = ! empty( $reading['page_on_front'] ) ? sanitize_title( $reading['page_on_front'] ) : '';
			$page_for_posts = ! empty( $reading['page_for_posts'] ) ? sanitize_title( $reading['page_for_posts'] ) : '';
			$front_page_id  = ! empty( $page_map[ $page_on_front ] ) ? (int) $page_map[ $page_on_front ] : 0;
			$posts_page_id  = ! empty( $page_map[ $page_for_posts ] ) ? (int) $page_map[ $page_for_posts ] : 0;

			if ( ! $front_page_id && '' !== $page_on_front ) {
				$page_obj      = get_page_by_path( $page_on_front, OBJECT, 'page' );
				$front_page_id = $page_obj ? (int) $page_obj->ID : 0;
			}

			if ( ! $posts_page_id && '' !== $page_for_posts ) {
				$page_obj      = get_page_by_path( $page_for_posts, OBJECT, 'page' );
				$posts_page_id = $page_obj ? (int) $page_obj->ID : 0;
			}

			if ( 'page' === $show_on_front && $front_page_id ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $front_page_id );
				update_option( 'page_for_posts', $posts_page_id ? $posts_page_id : 0 );
			} else {
				update_option( 'show_on_front', 'posts' );
			}

			return array(
				'message'        => __( 'Front page settings assigned.', 'wira-kit-for-elementor' ),
				'show_on_front'  => get_option( 'show_on_front', 'posts' ),
				'page_on_front'  => (int) get_option( 'page_on_front', 0 ),
				'page_for_posts' => (int) get_option( 'page_for_posts', 0 ),
			);
		}

		/**
		 * Read and decode JSON file from extracted kit.
		 *
		 * @param int    $kit_id Kit ID.
		 * @param string $relative_path Relative file path.
		 * @return array|WP_Error
		 */
		private function get_kit_json_data( $kit_id, $relative_path ) {
			$file_path = $this->get_kit_file_path( $kit_id, $relative_path );
			if ( is_wp_error( $file_path ) ) {
				return $file_path;
			}

			if ( ! file_exists( $file_path ) ) {
				return new WP_Error(
					'kit_file_missing',
					sprintf(
						/* translators: %s: missing file path in kit. */
						__( 'Required kit file is missing: %s', 'wira-kit-for-elementor' ),
						$relative_path
					)
				);
			}

			$data = json_decode( file_get_contents( $file_path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			if ( ! is_array( $data ) ) {
				return new WP_Error(
					'kit_file_invalid',
					sprintf(
						/* translators: %s: invalid file path in kit. */
						__( 'Invalid JSON format in file: %s', 'wira-kit-for-elementor' ),
						$relative_path
					)
				);
			}

			return $data;
		}

		/**
		 * Find imported Elementor template ID by manifest source path.
		 *
		 * @param int    $kit_id Kit ID.
		 * @param string $source Source file path from manifest.
		 * @return int
		 */
		private function get_imported_template_id_by_source( $kit_id, $source ) {
			$manifest = $this->get_manifest_data( $kit_id );
			if ( empty( $manifest['templates'] ) || ! is_array( $manifest['templates'] ) ) {
				return 0;
			}

			$source = wp_normalize_path( (string) $source );
			foreach ( $manifest['templates'] as $template ) {
				if ( ! is_array( $template ) ) {
					continue;
				}

				$template_source = ! empty( $template['source'] ) ? wp_normalize_path( (string) $template['source'] ) : '';
				if ( '' === $template_source || $template_source !== $source ) {
					continue;
				}

				$imports = ! empty( $template['imports'] ) && is_array( $template['imports'] ) ? $this->normalize_imports( $template['imports'] ) : array();
				if ( empty( $imports ) ) {
					return 0;
				}

				$latest = end( $imports );
				return ! empty( $latest['imported_template_id'] ) ? (int) $latest['imported_template_id'] : 0;
			}

			return 0;
		}

		/**
		 * Copy Elementor builder meta from source post to target post.
		 *
		 * @param int $source_post_id Source post ID.
		 * @param int $target_post_id Target post ID.
		 * @return void
		 */
		private function copy_elementor_meta( $source_post_id, $target_post_id, $args = array() ) {
			$source_post = get_post( $source_post_id );
			if ( ! $source_post || ! $target_post_id ) {
				return;
			}

			$args = wp_parse_args(
				(array) $args,
				array(
					'copy_post_content'  => true,
					'copy_template_type' => true,
					'page_layout'        => '',
					'metform_map'        => array(),
				)
			);

			if ( ! empty( $args['copy_post_content'] ) ) {
				wp_update_post(
					array(
						'ID'           => (int) $target_post_id,
						'post_content' => (string) $source_post->post_content,
					)
				);
			}

			$meta_keys = array(
				'_elementor_data',
				'_elementor_edit_mode',
				'_elementor_page_settings',
				'_elementor_version',
			);
			if ( ! empty( $args['copy_template_type'] ) ) {
				$meta_keys[] = '_elementor_template_type';
			}

			foreach ( $meta_keys as $meta_key ) {
				$meta_value = get_post_meta( $source_post_id, $meta_key, true );
				if ( '' !== $meta_value && null !== $meta_value ) {
					if ( '_elementor_data' === $meta_key && ! empty( $args['metform_map'] ) ) {
						$meta_value = $this->replace_metform_ids_in_elementor_data( $meta_value, (array) $args['metform_map'] );
					}
					if ( is_string( $meta_value ) ) {
						update_post_meta( $target_post_id, $meta_key, wp_slash( $meta_value ) );
					} else {
						update_post_meta( $target_post_id, $meta_key, $meta_value );
					}
				}
			}

			// These are generated/cache-like values and should not be copied from source template posts.
			delete_post_meta( $target_post_id, '_elementor_css' );
			delete_post_meta( $target_post_id, '_elementor_controls_usage' );
			delete_post_meta( $target_post_id, '_elementor_page_assets' );

			if ( ! empty( $args['page_layout'] ) ) {
				$page_settings = get_post_meta( $target_post_id, '_elementor_page_settings', true );
				$page_settings = is_array( $page_settings ) ? $page_settings : array();
				$page_settings['template'] = sanitize_text_field( (string) $args['page_layout'] );
				update_post_meta( $target_post_id, '_elementor_page_settings', $page_settings );
			}

			update_post_meta( $target_post_id, '_elementor_edit_mode', 'builder' );
		}

		/**
		 * Build map of exported MetForm placeholder IDs to imported local IDs.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array<string,int>
		 */
		private function get_full_metform_id_map( $kit_id ) {
			$cached = get_post_meta( (int) $kit_id, '_wkit_ti_full_metform_map', true );
			if ( is_array( $cached ) && ! empty( $cached ) ) {
				return $cached;
			}

			$template_id_map = get_post_meta( (int) $kit_id, '_wkit_ti_template_id_map', true );
			$template_id_map = is_array( $template_id_map ) ? $template_id_map : array();

			$assignments = $this->get_kit_json_data( $kit_id, 'assignments.json' );
			if ( is_wp_error( $assignments ) ) {
				return array();
			}

			$map = array();
			$metform_sources = array();
			if ( ! empty( $assignments['metform'] ) && is_array( $assignments['metform'] ) ) {
				foreach ( $assignments['metform'] as $item ) {
					if ( empty( $item['template_source'] ) ) {
						continue;
					}
					$source = wp_normalize_path( (string) $item['template_source'] );
					$metform_sources[] = $source;
				}
			}

			$metform_ids = array();
			foreach ( $metform_sources as $source ) {
				$imported_id = $this->get_imported_template_id_by_source( $kit_id, $source );
				if ( $imported_id ) {
					$metform_ids[] = (int) $imported_id;
				}

				$tokens_for_source = $this->collect_metform_tokens_from_source( $kit_id, $source );
				if ( $imported_id && ! empty( $tokens_for_source ) ) {
					foreach ( $tokens_for_source as $token ) {
						$map[ $token ] = (int) $imported_id;
					}
				}
			}

			$metform_ids = array_values( array_unique( $metform_ids ) );
			$tokens = $this->collect_metform_tokens_from_kit( $kit_id );
			if ( empty( $tokens ) ) {
				return array();
			}

			$source_form_map = array();
			$metform_posts   = get_posts(
				array(
					'post_type'      => array( 'metform-form', 'metform', 'mf_form' ),
					'post_status'    => array( 'publish', 'draft', 'private' ),
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'meta_query'     => array(
						array(
							'key'     => '_wkit_ti_metform_source_id',
							'compare' => 'EXISTS',
						),
						array(
							'key'   => '_wkit_ti_source_kit',
							'value' => (int) $kit_id,
						),
					),
				)
			);
			if ( ! empty( $metform_posts ) ) {
				foreach ( $metform_posts as $post_id ) {
					$source_id = absint( get_post_meta( (int) $post_id, '_wkit_ti_metform_source_id', true ) );
					if ( $source_id ) {
						$source_form_map[ $source_id ] = (int) $post_id;
					}
				}
			}

			foreach ( $tokens as $token ) {
				if ( isset( $map[ $token ] ) ) {
					continue;
				}
				if ( preg_match( '/^(\\d+)\\*\\*\\*/', (string) $token, $matches ) ) {
					$source_id = (int) $matches[1];
					if ( isset( $source_form_map[ $source_id ] ) ) {
						$map[ $token ] = (int) $source_form_map[ $source_id ];
						continue;
					}
					if ( $source_id && isset( $template_id_map[ $source_id ] ) ) {
						$map[ $token ] = (int) $template_id_map[ $source_id ];
					}
				}
			}

			if ( empty( $map ) && ! empty( $metform_ids ) ) {
				$limit = min( count( $tokens ), count( $metform_ids ) );
				for ( $i = 0; $i < $limit; $i++ ) {
					if ( empty( $map[ $tokens[ $i ] ] ) ) {
						$map[ $tokens[ $i ] ] = (int) $metform_ids[ $i ];
					}
				}
			}

			if ( ! empty( $map ) ) {
				update_post_meta( (int) $kit_id, '_wkit_ti_full_metform_map', $map );
			}

			return $map;
		}

		/**
		 * Collect ordered MetForm widget token values from template JSON files in kit.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array<int,string>
		 */
		private function collect_metform_tokens_from_kit( $kit_id ) {
			$manifest = $this->get_manifest_data( $kit_id );
			if ( empty( $manifest['templates'] ) || ! is_array( $manifest['templates'] ) ) {
				return array();
			}

			$tokens = array();
			foreach ( $manifest['templates'] as $template ) {
				if ( empty( $template['source'] ) ) {
					continue;
				}

				$file_path = $this->get_kit_file_path( $kit_id, (string) $template['source'] );
				if ( is_wp_error( $file_path ) || ! file_exists( $file_path ) ) {
					continue;
				}

				$contents = file_get_contents( $file_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
				if ( ! is_string( $contents ) || '' === $contents ) {
					continue;
				}

				if ( preg_match_all( '/"mf_form_id"\s*:\s*"([^"]+)"/', $contents, $matches ) ) {
					foreach ( $matches[1] as $token ) {
						$token = trim( (string) $token );
						if ( '' !== $token && ! in_array( $token, $tokens, true ) ) {
							$tokens[] = $token;
						}
					}
				}
			}

			return $tokens;
		}

		/**
		 * Collect MetForm widget tokens from a specific template source file.
		 *
		 * @param int    $kit_id Kit ID.
		 * @param string $source Template source path.
		 * @return array<int,string>
		 */
		private function collect_metform_tokens_from_source( $kit_id, $source ) {
			$source = (string) $source;
			if ( '' === $source ) {
				return array();
			}

			$file_path = $this->get_kit_file_path( $kit_id, $source );
			if ( is_wp_error( $file_path ) || ! file_exists( $file_path ) ) {
				return array();
			}

			$contents = file_get_contents( $file_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			if ( ! is_string( $contents ) || '' === $contents ) {
				return array();
			}

			$tokens = array();
			if ( preg_match_all( '/"mf_form_id"\s*:\s*"([^"]+)"/', $contents, $matches ) ) {
				foreach ( $matches[1] as $token ) {
					$token = trim( (string) $token );
					if ( '' !== $token && ! in_array( $token, $tokens, true ) ) {
						$tokens[] = $token;
					}
				}
			}

			return $tokens;
		}

		/**
		 * Replace MetForm token values in Elementor data.
		 *
		 * @param mixed $elementor_data Elementor data (array|string).
		 * @param array $metform_map Token => ID map.
		 * @return mixed
		 */
		private function replace_metform_ids_in_elementor_data( $elementor_data, $metform_map ) {
			if ( empty( $metform_map ) || empty( $elementor_data ) ) {
				return $elementor_data;
			}

			$json = is_array( $elementor_data ) ? wp_json_encode( $elementor_data ) : (string) $elementor_data;
			if ( ! is_string( $json ) || '' === $json ) {
				return $elementor_data;
			}

			$replaced = preg_replace_callback(
				'/"mf_form_id"\s*:\s*"([^"]+)"/',
				function ( $matches ) use ( $metform_map ) {
					$token = isset( $matches[1] ) ? (string) $matches[1] : '';
					if ( '' === $token ) {
						return $matches[0];
					}

					$resolved_id = $this->resolve_metform_token_to_id( $token, $metform_map );
					if ( ! $resolved_id ) {
						return $matches[0];
					}

					return '"mf_form_id":"' . (int) $resolved_id . '"';
				},
				$json
			);

			if ( ! is_string( $replaced ) || '' === $replaced ) {
				return $elementor_data;
			}

			if ( is_array( $elementor_data ) ) {
				$decoded = json_decode( $replaced, true );
				return is_array( $decoded ) ? $decoded : $elementor_data;
			}

			return $replaced;
		}

		/**
		 * Resolve MetForm token to local form ID using map or name fallback.
		 *
		 * @param string $token MetForm token string.
		 * @param array  $metform_map Token => ID map.
		 * @return int
		 */
		private function resolve_metform_token_to_id( $token, $metform_map ) {
			if ( isset( $metform_map[ $token ] ) ) {
				return (int) $metform_map[ $token ];
			}

			$token = trim( (string) $token );
			if ( '' === $token ) {
				return 0;
			}

			// Try token as a title.
			$resolved = $this->find_metform_id_by_name( $token );
			if ( $resolved ) {
				return $resolved;
			}

			// Try prefix before delimiter (e.g., "Form Name***timestamp").
			if ( strpos( $token, '***' ) !== false ) {
				$prefix = trim( (string) strstr( $token, '***', true ) );
				if ( '' !== $prefix ) {
					$resolved = $this->find_metform_id_by_name( $prefix );
					if ( $resolved ) {
						return $resolved;
					}
				}
			}

			return 0;
		}

		/**
		 * Find MetForm form ID by title.
		 *
		 * @param string $title Form title.
		 * @return int
		 */
		private function find_metform_id_by_name( $title ) {
			$title = (string) $title;
			if ( '' === $title ) {
				return 0;
			}

			$decoded    = html_entity_decode( $title, ENT_QUOTES );
			$normalized = preg_replace( '/\s*[–—−]\s*/u', ' - ', $decoded );
			$normalized = is_string( $normalized ) ? trim( preg_replace( '/\s+/', ' ', $normalized ) ) : $decoded;
			$candidates = array_values( array_unique( array_filter( array( $decoded, $normalized ) ) ) );
			$post_types = array( 'metform-form', 'metform', 'mf_form' );
			foreach ( $candidates as $candidate ) {
				$found = $this->find_post_id_by_exact_title( $candidate, $post_types );
				if ( $found ) {
					return $found;
				}
			}

			foreach ( $candidates as $candidate ) {
				$slug = sanitize_title( $candidate );
				if ( '' === $slug ) {
					continue;
				}
				$found = get_posts(
					array(
						'post_type'      => $post_types,
						'name'           => $slug,
						'post_status'    => array( 'publish', 'draft', 'private' ),
						'posts_per_page' => 1,
						'fields'         => 'ids',
					)
				);
				if ( ! empty( $found ) ) {
					return (int) $found[0];
				}
			}

			return 0;
		}

		/**
		 * Apply MetForm ID replacement directly on a post Elementor data meta.
		 *
		 * @param int   $post_id Post ID.
		 * @param array $metform_map Token => ID map.
		 * @return void
		 */
		private function replace_metform_ids_on_post( $post_id, $metform_map ) {
			$data = get_post_meta( (int) $post_id, '_elementor_data', true );
			if ( empty( $data ) ) {
				return;
			}

			$replaced = $this->replace_metform_ids_in_elementor_data( $data, $metform_map );
			if ( $replaced !== $data ) {
				if ( is_string( $replaced ) ) {
					update_post_meta( (int) $post_id, '_elementor_data', wp_slash( $replaced ) );
				} else {
					update_post_meta( (int) $post_id, '_elementor_data', $replaced );
				}
			}
		}

		/**
		 * Normalize older export JSON format to importer-compatible format.
		 *
		 * @param array $template_json Raw template JSON.
		 * @return array
		 */
		private function normalize_template_json_for_import( $template_json ) {
			$template_json = is_array( $template_json ) ? $template_json : array();
			$metadata      = ! empty( $template_json['metadata'] ) && is_array( $template_json['metadata'] ) ? $template_json['metadata'] : array();

			if ( array_key_exists( 'include_export', $metadata ) && ! array_key_exists( 'include_in_zip', $metadata ) ) {
				$metadata['include_in_zip'] = ! empty( $metadata['include_export'] ) ? '1' : '0';
			}

			$template_type = ! empty( $metadata['template_type'] ) ? sanitize_key( (string) $metadata['template_type'] ) : '';
			if ( 'front-page' === $template_type || 'front_page' === $template_type ) {
				$metadata['template_type'] = 'single-page';
			}

			if ( ! array_key_exists( 'elementor_pro_required', $metadata ) ) {
				$metadata['elementor_pro_required'] = null;
			}

			$template_json['metadata'] = $metadata;
			return $template_json;
		}

		/**
		 * Resolve the assigned WP page template from imported Elementor template.
		 *
		 * @param int $imported_template_id Imported template post ID.
		 * @return string
		 */
		private function resolve_assigned_page_template( $imported_template_id ) {
			$template = get_post_meta( (int) $imported_template_id, '_wp_page_template', true );
			$template = is_string( $template ) ? sanitize_key( $template ) : '';
			$allowed  = array( 'default', 'elementor_header_footer', 'elementor_canvas' );
			if ( '' === $template || ! in_array( $template, $allowed, true ) ) {
				return 'elementor_header_footer';
			}

			return $template;
		}

		/**
		 * Map WP page template to Elementor page layout setting.
		 *
		 * @param string $wp_page_template WP page template slug.
		 * @return string
		 */
		private function map_wp_template_to_elementor_layout( $wp_page_template ) {
			$wp_page_template = sanitize_key( (string) $wp_page_template );
			if ( 'elementor_canvas' === $wp_page_template ) {
				return 'elementor_canvas';
			}

			return '';
		}

		/**
		 * Remove Elementor builder metadata from a post.
		 *
		 * @param int $post_id Post ID.
		 * @return void
		 */
		private function clear_elementor_meta( $post_id ) {
			$meta_keys = array(
				'_elementor_data',
				'_elementor_edit_mode',
				'_elementor_page_settings',
				'_elementor_template_type',
				'_elementor_version',
				'_elementor_css',
				'_elementor_controls_usage',
				'_elementor_page_assets',
			);

			foreach ( $meta_keys as $meta_key ) {
				delete_post_meta( (int) $post_id, $meta_key );
			}
		}

		/**
		 * Get existing assigned builder post for same assignment key and kit.
		 *
		 * @param string $post_type Template builder post type.
		 * @param string $assignment_key Assignment key.
		 * @param int    $kit_id Kit ID.
		 * @return int
		 */
		private function get_existing_full_builder_post( $post_type, $assignment_key, $kit_id ) {
			$query = new WP_Query(
				array(
					'post_type'      => sanitize_key( $post_type ),
					'post_status'    => array( 'publish', 'draft', 'private' ),
					'posts_per_page' => 1,
					'fields'         => 'ids',
					'meta_query'     => array(
						array(
							'key'   => '_wkit_ti_full_assignment_key',
							'value' => sanitize_key( (string) $assignment_key ),
						),
						array(
							'key'   => '_wkit_ti_full_source_kit',
							'value' => (int) $kit_id,
						),
					),
				)
			);

			if ( ! empty( $query->posts[0] ) ) {
				return (int) $query->posts[0];
			}

			return 0;
		}

		/**
		 * Normalize assignment display condition to template builder format.
		 *
		 * @param string $display Raw display condition.
		 * @return string
		 */
		private function normalize_builder_display_condition( $display ) {
			$display = trim( strtolower( (string) $display ) );
			if ( '' === $display ) {
				return 'all';
			}

			$direct_map = array(
				'entire_site' => 'all',
				'front_page'  => 'front-page',
				'front-page'  => 'front-page',
				'blog_home'   => 'blog',
				'blog-home'   => 'blog',
				'error_404'   => '404',
				'404'         => '404',
			);

			if ( isset( $direct_map[ $display ] ) ) {
				return $direct_map[ $display ];
			}

			if ( 0 === strpos( $display, 'singular:' ) ) {
				$post_type = sanitize_key( substr( $display, 9 ) );
				return $post_type ? 'singular-' . $post_type : 'singular';
			}

			if ( 0 === strpos( $display, 'archive:' ) ) {
				$post_type = sanitize_key( substr( $display, 8 ) );
				return $post_type ? 'archive-' . $post_type : 'archive';
			}

			return sanitize_key( str_replace( ':', '-', $display ) );
		}

		/**
		 * Get unmet import requirements for one template.
		 *
		 * @param array $template Template data.
		 * @return array<int,string>
		 */

		private function get_unmet_requirements( $template ) {
			$requirements = array();

			if ( ! empty( $template['metadata']['elementor_pro_required'] ) && ! class_exists( '\ElementorPro\Plugin' ) ) {
				$requirements[] = __( 'Elementor Pro is required for this template.', 'wira-kit-for-elementor' );
			}

			return $requirements;
		}

		/**
		 * Resolve required plugin status from manifest.
		 *
		 * @param array $manifest Manifest data.
		 * @return array<int,array<string,mixed>>
		 */
		private function get_required_plugins_status( $manifest ) {
			$required_plugins = ! empty( $manifest['required_plugins'] ) && is_array( $manifest['required_plugins'] )
				? $manifest['required_plugins']
				: array();

			if ( empty( $required_plugins ) ) {
				return array();
			}

			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			$all_plugins = get_plugins();
			$statuses    = array();

			foreach ( $required_plugins as $plugin ) {
				if ( ! is_array( $plugin ) ) {
					continue;
				}

				$file = ! empty( $plugin['file'] ) ? $plugin['file'] : '';
				$slug = ! empty( $plugin['slug'] ) ? $plugin['slug'] : $this->infer_slug_from_file( $file );

				$resolved_file = $this->resolve_plugin_file( $file, $slug, array_keys( $all_plugins ) );
				$installed     = '' !== $resolved_file;
				$active        = $installed ? is_plugin_active( $resolved_file ) : false;

				$install_url         = '';
				$activate_url        = '';
				$install_screen_url  = '';
				$activate_screen_url = '';

				if ( ! $installed && $slug && current_user_can( 'install_plugins' ) && $this->is_allowed_required_plugin_slug( $slug ) ) {
					// User-initiated install via WordPress core action URL.
					// Note: wp_nonce_url() returns an HTML-escaped string (ampersands become &amp;). We need a raw URL for JSON.
					$install_url = add_query_arg(
						array(
							'action'   => 'install-plugin',
							'plugin'   => $slug,
							'_wpnonce' => wp_create_nonce( 'install-plugin_' . $slug ),
						),
						self_admin_url( 'update.php' )
					);

					// Fallback: open WP install screen (no action).
					$install_screen_url = add_query_arg(
						array(
							'tab'  => 'search',
							'type' => 'term',
							's'    => $slug,
						),
						self_admin_url( 'plugin-install.php' )
					);
				}

				if ( $installed && ! $active && current_user_can( 'activate_plugins' ) ) {
					// User-initiated activation via WordPress core action URL.
					// Note: wp_nonce_url() returns an HTML-escaped string (ampersands become &amp;). We need a raw URL for JSON.
					$activate_url = add_query_arg(
						array(
							'action'   => 'activate',
							'plugin'   => $resolved_file,
							'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $resolved_file ),
						),
						self_admin_url( 'plugins.php' )
					);

					// Fallback: open WP plugins screen filtered (no action).
					$activate_screen_url = add_query_arg(
						array(
							'plugin_status' => 'inactive',
							's'             => $slug ? $slug : $resolved_file,
						),
						self_admin_url( 'plugins.php' )
					);
				}

				$statuses[] = array(
					'name'      => ! empty( $plugin['name'] ) ? $plugin['name'] : $slug,
					'slug'      => $slug,
					'file'      => $file,
					'version'   => ! empty( $plugin['version'] ) ? $plugin['version'] : '',
					'resolved_file' => $resolved_file,
					'installed' => $installed,
					'active'    => $active,
					'install_url'         => $install_url,
					'activate_url'        => $activate_url,
					'install_screen_url'  => $install_screen_url,
					'activate_screen_url' => $activate_screen_url,
				);
			}

			return $statuses;
		}

		/**
		 * Get kit screenshot URL.
		 *
		 * @param int   $kit_id Kit ID.
		 * @param array $manifest Manifest data.
		 * @return string
		 */
		private function get_kit_screenshot_url( $kit_id, $manifest ) {
			if ( ! empty( $manifest['templates'] ) && is_array( $manifest['templates'] ) ) {
				foreach ( $manifest['templates'] as $template ) {
					if ( ! is_array( $template ) ) {
						continue;
					}

					$template_type = ! empty( $template['metadata']['template_type'] ) ? $template['metadata']['template_type'] : '';
					if ( 'global-styles' === $template_type && ! empty( $template['screenshot'] ) ) {
						return $this->get_kit_file_url( $kit_id, $template['screenshot'] );
					}
				}
			}

			if ( ! empty( $manifest['thumbnail'] ) ) {
				return $this->get_kit_file_url( $kit_id, $manifest['thumbnail'] );
			}

			if ( ! empty( $manifest['templates'][0]['screenshot'] ) ) {
				return $this->get_kit_file_url( $kit_id, $manifest['templates'][0]['screenshot'] );
			}

			return '';
		}

		/**
		 * Resolve one kit file path safely.
		 *
		 * @param int    $kit_id Kit ID.
		 * @param string $relative_path Relative file path in extracted kit.
		 * @return string|WP_Error
		 */
		private function get_kit_file_path( $kit_id, $relative_path ) {
			$base_path = $this->get_kit_folder_path( $kit_id );
			if ( is_wp_error( $base_path ) ) {
				return $base_path;
			}

			$full_path = realpath( trailingslashit( $base_path ) . ltrim( wp_normalize_path( $relative_path ), '/' ) );
			if ( ! $full_path || 0 !== strpos( wp_normalize_path( $full_path ), wp_normalize_path( $base_path ) ) ) {
				return new WP_Error( 'path_error', __( 'Invalid file path inside kit.', 'wira-kit-for-elementor' ) );
			}

			return $full_path;
		}

		/**
		 * Build kit file URL from relative path.
		 *
		 * @param int    $kit_id Kit ID.
		 * @param string $relative_path Relative file path in extracted kit.
		 * @return string
		 */
		private function get_kit_file_url( $kit_id, $relative_path ) {
			$folder = get_post_meta( $kit_id, '_wkit_ti_folder_name', true );
			if ( ! $folder ) {
				return '';
			}

			$base_paths = $this->get_base_paths();
			if ( is_wp_error( $base_paths ) ) {
				return '';
			}

			$relative_path = ltrim( str_replace( '\\', '/', $relative_path ), '/' );
			return trailingslashit( $base_paths['url'] ) . rawurlencode( $folder ) . '/' . str_replace( '%2F', '/', rawurlencode( $relative_path ) );
		}

		/**
		 * Resolve plugin file from manifest data.
		 *
		 * @param string   $file Plugin file from manifest.
		 * @param string   $slug Plugin slug from manifest.
		 * @param string[] $plugin_files Installed plugin files list.
		 * @return string
		 */
		private function resolve_plugin_file( $file, $slug, $plugin_files ) {
			$plugin_files = is_array( $plugin_files ) ? $plugin_files : array();
			$file         = is_string( $file ) ? trim( $file ) : '';
			$slug         = is_string( $slug ) ? trim( $slug ) : '';

			if ( $file && in_array( $file, $plugin_files, true ) ) {
				return $file;
			}

			if ( $file ) {
				foreach ( $plugin_files as $plugin_file ) {
					if ( false !== strpos( $plugin_file, $file ) ) {
						return $plugin_file;
					}
				}
			}

			if ( $slug ) {
				foreach ( $plugin_files as $plugin_file ) {
					if ( 0 === strpos( $plugin_file, $slug . '/' ) ) {
						return $plugin_file;
					}
				}
			}

			return '';
		}

		/**
		 * Infer WordPress.org plugin slug from plugin file path.
		 *
		 * @param string $file Plugin file value from manifest.
		 * @return string
		 */
		private function infer_slug_from_file( $file ) {
			$file = is_string( $file ) ? trim( $file ) : '';
			if ( '' === $file ) {
				return '';
			}

			$parts = explode( '/', str_replace( '\\', '/', $file ) );
			$slug  = isset( $parts[0] ) ? sanitize_key( $parts[0] ) : '';

			return $slug;
		}

		/**
		 * Get extracted folder path for a kit.
		 *
		 * @param int $kit_id Kit ID.
		 * @return string|WP_Error
		 */
		private function get_kit_folder_path( $kit_id ) {
			$folder = get_post_meta( $kit_id, '_wkit_ti_folder_name', true );
			if ( ! $folder || ! preg_match( '/^[a-zA-Z0-9_-]{8,64}$/', $folder ) ) {
				return new WP_Error( 'kit_error', __( 'Template kit folder is missing.', 'wira-kit-for-elementor' ) );
			}

			$base_paths = $this->get_base_paths();
			if ( is_wp_error( $base_paths ) ) {
				return $base_paths;
			}

			$path = realpath( trailingslashit( $base_paths['path'] ) . $folder );
			if ( ! $path || 0 !== strpos( wp_normalize_path( $path ), wp_normalize_path( $base_paths['path'] ) ) ) {
				return new WP_Error( 'kit_error', __( 'Template kit folder not found.', 'wira-kit-for-elementor' ) );
			}

			return $path;
		}

		/**
		 * Get upload path/url for template kits.
		 *
		 * @return array|WP_Error
		 */
		private function get_base_paths() {
			$upload = wp_upload_dir();
			if ( empty( $upload['basedir'] ) || empty( $upload['baseurl'] ) ) {
				return new WP_Error( 'upload_error', __( 'Upload directory is not available.', 'wira-kit-for-elementor' ) );
			}

			$base_path = trailingslashit( $upload['basedir'] ) . 'wira-template-kits';
			$base_url  = trailingslashit( $upload['baseurl'] ) . 'wira-template-kits';
			wp_mkdir_p( $base_path );

			return array(
				'path' => $base_path,
				'url'  => $base_url,
			);
		}

		/**
		 * Read manifest data from post meta.
		 *
		 * @param int $kit_id Kit ID.
		 * @return array
		 */
		private function get_manifest_data( $kit_id ) {
			$manifest = get_post_meta( $kit_id, '_wkit_ti_manifest', true );
			return is_array( $manifest ) ? $manifest : array();
		}

		/**
		 * Get internal kit post and validate type.
		 *
		 * @param int $kit_id Kit ID.
		 * @return WP_Post|WP_Error
		 */
		private function get_kit_post( $kit_id ) {
			$post = get_post( $kit_id );
			if ( ! $post || self::CPT_KIT !== $post->post_type ) {
				return new WP_Error( 'not_found', __( 'Template kit was not found.', 'wira-kit-for-elementor' ), 404 );
			}

			return $post;
		}

		/**
		 * Get edit URL for imported Elementor template.
		 *
		 * @param int $imported_template_id Template ID.
		 * @return string
		 */
		private function get_imported_template_edit_url( $imported_template_id ) {
			if ( $imported_template_id && class_exists( '\Elementor\Plugin' ) ) {
				$document = \Elementor\Plugin::$instance->documents->get( $imported_template_id );
				if ( $document ) {
					return $document->get_edit_url();
				}
			}

			return admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' );
		}

		/**
		 * Guard: current user must manage options.
		 *
		 * @return void
		 */
		private function guard_manage_options() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'wira-kit-for-elementor' ) ), 403 );
			}
		}

		/**
		 * Verify importer nonce from AJAX request.
		 *
		 * @return void
		 */
		private function verify_nonce() {
			check_ajax_referer( self::NONCE_ACTION, 'nonce' );
		}

		/**
		 * Delete extracted folder by folder name.
		 *
		 * @param string $folder_name Folder name.
		 * @return void
		 */
		private function delete_extracted_folder_by_name( $folder_name ) {
			if ( ! is_string( $folder_name ) || '' === $folder_name || ! preg_match( '/^[a-zA-Z0-9_-]{8,64}$/', $folder_name ) ) {
				return;
			}

			$base_paths = $this->get_base_paths();
			if ( is_wp_error( $base_paths ) ) {
				return;
			}

			$folder = trailingslashit( $base_paths['path'] ) . $folder_name;
			$this->delete_folder( $folder );
		}

		/**
		 * Validate uploaded ZIP payload before processing.
		 *
		 * @param array $file Uploaded file array from $_FILES.
		 * @return true|WP_Error
		 */
		private function validate_uploaded_zip_file( $file ) {
			$name = isset( $file['name'] ) ? sanitize_file_name( wp_unslash( $file['name'] ) ) : '';
			if ( '' === $name || ! preg_match( '/\.zip$/i', $name ) ) {
				return new WP_Error( 'zip_error', __( 'Only ZIP files are allowed.', 'wira-kit-for-elementor' ) );
			}

			$tmp_name = isset( $file['tmp_name'] ) ? $file['tmp_name'] : '';
			$size     = isset( $file['size'] ) ? (int) $file['size'] : 0;
			if ( '' === $tmp_name || $size <= 0 ) {
				return new WP_Error( 'zip_error', __( 'Invalid ZIP file upload.', 'wira-kit-for-elementor' ) );
			}

			if ( $size > self::MAX_ZIP_FILE_BYTES ) {
				return new WP_Error( 'zip_error', __( 'ZIP file is too large.', 'wira-kit-for-elementor' ) );
			}

			return true;
		}

		/**
		 * Ensure ZIP entry path is safe for extraction.
		 *
		 * @param string $entry_name ZIP entry name.
		 * @return bool
		 */
		private function is_safe_zip_entry_name( $entry_name ) {
			$entry_name = str_replace( '\\', '/', (string) $entry_name );
			if ( '' === $entry_name || false !== strpos( $entry_name, "\0" ) ) {
				return false;
			}

			if ( '/' === $entry_name[0] || preg_match( '/^[a-zA-Z]:\//', $entry_name ) ) {
				return false;
			}

			$parts = explode( '/', $entry_name );
			foreach ( $parts as $part ) {
				if ( '' === $part || '.' === $part || '..' === $part ) {
					return false;
				}
			}

			return true;
		}

		/**
		 * Validate whether remote ZIP URL is allowed.
		 *
		 * @param string $url ZIP URL from API.
		 * @return bool
		 */
		private function is_allowed_remote_zip_url( $url ) {
			$url = (string) $url;
			if ( '' === $url ) {
				return false;
			}

			$parsed = wp_parse_url( $url );
			if ( ! is_array( $parsed ) || empty( $parsed['scheme'] ) || empty( $parsed['host'] ) ) {
				return false;
			}

			$scheme = strtolower( $parsed['scheme'] );
			$host   = strtolower( $parsed['host'] );
			if ( 'https' !== $scheme ) {
				return false;
			}

			if ( in_array( $host, array( 'localhost', '127.0.0.1', '::1' ), true ) ) {
				return false;
			}

			$allowed_hosts = apply_filters(
				'Wirakit_template_importer_allowed_zip_hosts',
				array(
					'api.wiratheme.com',
					'wiratheme.com',
				)
			);

			if ( ! is_array( $allowed_hosts ) || empty( $allowed_hosts ) ) {
				return false;
			}

			foreach ( $allowed_hosts as $allowed_host ) {
				$allowed_host = strtolower( trim( (string) $allowed_host ) );
				if ( '' === $allowed_host ) {
					continue;
				}

				if ( $host === $allowed_host ) {
					return true;
				}

				if ( strlen( $host ) > strlen( $allowed_host ) && substr( $host, -strlen( '.' . $allowed_host ) ) === '.' . $allowed_host ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Extract optional checksum from remote kit detail payload.
		 *
		 * Supported keys:
		 * - zip_sha256
		 * - checksum_sha256
		 * - checksum (sha256 hex, 64 chars)
		 *
		 * @param array $detail Remote API detail payload.
		 * @return string|WP_Error Empty string means checksum is not provided.
		 */
		private function extract_remote_zip_checksum( $detail ) {
			if ( ! is_array( $detail ) ) {
				return '';
			}

			$candidates = array( 'zip_sha256', 'checksum_sha256', 'checksum' );
			$checksum   = '';
			foreach ( $candidates as $key ) {
				if ( isset( $detail[ $key ] ) && is_string( $detail[ $key ] ) ) {
					$checksum = strtolower( trim( $detail[ $key ] ) );
					if ( '' !== $checksum ) {
						break;
					}
				}
			}

			if ( '' === $checksum ) {
				$require_checksum = (bool) apply_filters( 'Wirakit_template_importer_require_remote_checksum', false );
				if ( $require_checksum ) {
					return new WP_Error( 'checksum_error', __( 'Remote ZIP checksum is required but missing.', 'wira-kit-for-elementor' ) );
				}
				return '';
			}

			// Be tolerant to upstream format changes unless strict mode is explicitly enabled.
			$strict_checksum = (bool) apply_filters( 'Wirakit_template_importer_require_remote_checksum', false );
			if ( ! preg_match( '/^[a-f0-9]{64}$/', $checksum ) ) {
				if ( $strict_checksum ) {
					return new WP_Error( 'checksum_error', __( 'Remote ZIP checksum format is invalid.', 'wira-kit-for-elementor' ) );
				}
				return '';
			}

			return $checksum;
		}

		/**
		 * Verify downloaded remote ZIP checksum when provided.
		 *
		 * @param string $temp_file Local temporary ZIP file path.
		 * @param string $expected_sha256 Expected SHA256 checksum.
		 * @return true|WP_Error
		 */
		private function verify_remote_zip_checksum( $temp_file, $expected_sha256 ) {
			$expected_sha256 = is_string( $expected_sha256 ) ? strtolower( trim( $expected_sha256 ) ) : '';
			if ( '' === $expected_sha256 ) {
				return true;
			}

			$actual_sha256 = @hash_file( 'sha256', $temp_file ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			if ( ! is_string( $actual_sha256 ) || '' === $actual_sha256 ) {
				return new WP_Error( 'checksum_error', __( 'Unable to verify remote ZIP checksum.', 'wira-kit-for-elementor' ) );
			}

			if ( ! hash_equals( $expected_sha256, strtolower( $actual_sha256 ) ) ) {
				return new WP_Error( 'checksum_error', __( 'Remote ZIP checksum mismatch.', 'wira-kit-for-elementor' ) );
			}

			return true;
		}

		/**
		 * Check whether plugin slug is allowed for auto-install.
		 *
		 * @param string $slug Plugin slug.
		 * @return bool
		 */
		private function is_allowed_required_plugin_slug( $slug ) {
			$slug = sanitize_key( (string) $slug );
			if ( '' === $slug ) {
				return false;
			}

			$default_allowed = array(
				'elementor',
				'elementor-pro',
				'skyboot-custom-icons-for-elementor',
				'metform',
				'secure-custom-fields',
				'mousewheel-smooth-scroll',
			);

			$allowed_slugs = apply_filters( 'Wirakit_template_importer_allowed_plugin_slugs', $default_allowed );
			if ( ! is_array( $allowed_slugs ) || empty( $allowed_slugs ) ) {
				return false;
			}

			$normalized = array();
			foreach ( $allowed_slugs as $allowed_slug ) {
				$normalized_slug = sanitize_key( (string) $allowed_slug );
				if ( '' !== $normalized_slug ) {
					$normalized[] = $normalized_slug;
				}
			}

			return in_array( $slug, array_unique( $normalized ), true );
		}

		/**
		 * Recursively delete a folder.
		 *
		 * @param string $folder Absolute folder path.
		 * @return void
		 */
		private function delete_folder( $folder ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

			$fs = new WP_Filesystem_Direct( false );
			if ( $fs->is_dir( $folder ) ) {
				$fs->rmdir( $folder, true );
			}
		}
	}
}
