<?php
/**
 * Template Builder Admin.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Builder_Admin' ) ) {

	/**
	 * Handles AJAX CRUD for template builder items.
	 */
	class Wirakit_Template_Builder_Admin {

		/**
		 * Meta key for active/inactive condition.
		 *
		 * @var string
		 */
		const META_CONDITION_STATUS = '_wkit_condition_status';

		/**
		 * Meta key for display condition.
		 *
		 * @var string
		 */
		const META_CONDITION_DISPLAY = '_wkit_condition_display';

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'wp_ajax_Wirakit_tb_list', array( $this, 'ajax_list_items' ) );
			add_action( 'wp_ajax_Wirakit_tb_upsert', array( $this, 'ajax_upsert_item' ) );
			add_action( 'wp_ajax_Wirakit_tb_delete', array( $this, 'ajax_delete_item' ) );
		}

		/**
		 * Return available display conditions.
		 *
		 * @param string $template_type Template post type.
		 *
		 * @return array<string,string>
		 */
		public static function get_display_options( $template_type = '' ) {
			if ( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE === $template_type ) {
				return self::get_single_display_options();
			}
			if ( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE === $template_type ) {
				return self::get_archive_display_options();
			}
			if ( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE === $template_type ) {
				return self::get_search_display_options();
			}
			if ( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE === $template_type ) {
				return self::get_404_display_options();
			}

			$options = array(
				'all'        => __( 'Entire Site', 'wira-kit-for-elementor' ),
				'front-page' => __( 'Front Page', 'wira-kit-for-elementor' ),
				'singular'   => __( 'Singular', 'wira-kit-for-elementor' ),
				'archive'    => __( 'Archive', 'wira-kit-for-elementor' ),
			);

			$options = array_merge(
				$options,
				self::get_single_post_type_options(),
				self::get_archive_post_type_options()
			);

			$options['blog'] = __( 'Blog Home', 'wira-kit-for-elementor' );
			$options['404']  = __( '404 Page', 'wira-kit-for-elementor' );
			$options['shop'] = __( 'Shop Page', 'wira-kit-for-elementor' );

			return $options;
		}

		/**
		 * Single Builder display options.
		 *
		 * @return array<string,string>
		 */
		private static function get_single_display_options() {
			$options = array(
				'singular' => __( 'All Singular', 'wira-kit-for-elementor' ),
			);

			$options = array_merge( $options, self::get_single_post_type_options() );

			return $options;
		}

		/**
		 * Archive Builder display options.
		 *
		 * @return array<string,string>
		 */
		private static function get_archive_display_options() {
			$options = array(
				'archive' => __( 'All Archives', 'wira-kit-for-elementor' ),
			);

			$options = array_merge( $options, self::get_archive_post_type_options() );

			return $options;
		}

		/**
		 * Search Result Builder display options.
		 *
		 * @return array<string,string>
		 */
		private static function get_search_display_options() {
			return array(
				'search' => __( 'Search Results', 'wira-kit-for-elementor' ),
			);
		}

		/**
		 * 404 Builder display options.
		 *
		 * @return array<string,string>
		 */
		private static function get_404_display_options() {
			return array(
				'404' => __( '404 Page', 'wira-kit-for-elementor' ),
			);
		}

		/**
		 * Build per-post-type singular options.
		 *
		 * @return array<string,string>
		 */
		private static function get_single_post_type_options() {
			$post_types = get_post_types( array( 'public' => true ), 'objects' );
			$excluded   = self::get_excluded_single_post_types();
			$options    = array();

			foreach ( $post_types as $post_type ) {
				if ( empty( $post_type->name ) || in_array( $post_type->name, $excluded, true ) ) {
					continue;
				}

				$label                               = ! empty( $post_type->labels->singular_name ) ? $post_type->labels->singular_name : $post_type->label;
				$options[ 'singular-' . $post_type->name ] = sprintf(
					/* translators: %s: post type singular label */
					__( 'Singular: %s', 'wira-kit-for-elementor' ),
					$label
				);
			}

			return $options;
		}

		/**
		 * Build per-post-type archive options.
		 *
		 * @return array<string,string>
		 */
		private static function get_archive_post_type_options() {
			$post_types = get_post_types( array( 'public' => true ), 'objects' );
			$excluded   = self::get_excluded_single_post_types();
			$options    = array();

			foreach ( $post_types as $post_type ) {
				if ( empty( $post_type->name ) || in_array( $post_type->name, $excluded, true ) ) {
					continue;
				}

				$label                                = ! empty( $post_type->labels->name ) ? $post_type->labels->name : $post_type->label;
				$options[ 'archive-' . $post_type->name ] = sprintf(
					/* translators: %s: post type label */
					__( 'Archive: %s', 'wira-kit-for-elementor' ),
					$label
				);
			}

			return $options;
		}

		/**
		 * Post types excluded from single builder display list.
		 *
		 * @return array<int,string>
		 */
		private static function get_excluded_single_post_types() {
			return array(
				'attachment',
				'elementor_library',
				'wp_navigation',
				'wp_block',
				'wp_template',
				'wp_template_part',
				'wira_tk_import',
				Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE,
				Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE,
				Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE,
				Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE,
				Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE,
				Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE,
			);
		}

		/**
		 * AJAX list items by template type.
		 *
		 * @return void
		 */
		public function ajax_list_items() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'wira-kit-for-elementor' ) ), 403 );
			}

			check_ajax_referer( 'Wirakit_template_builder', 'nonce' );

			$type = isset( $_POST['template_type'] ) ? sanitize_key( wp_unslash( $_POST['template_type'] ) ) : '';
			if ( ! $this->is_allowed_template_type( $type ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid template type.', 'wira-kit-for-elementor' ) ), 400 );
			}

			wp_send_json_success(
				array(
					'items' => $this->get_items_by_type( $type ),
				)
			);
		}

		/**
		 * AJAX create/update item.
		 *
		 * @return void
		 */
		public function ajax_upsert_item() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'wira-kit-for-elementor' ) ), 403 );
			}

			check_ajax_referer( 'Wirakit_template_builder', 'nonce' );

			$type = isset( $_POST['template_type'] ) ? sanitize_key( wp_unslash( $_POST['template_type'] ) ) : '';
			if ( ! $this->is_allowed_template_type( $type ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid template type.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$post_id            = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
			$title              = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
			$condition_status   = isset( $_POST['condition_status'] ) ? sanitize_key( wp_unslash( $_POST['condition_status'] ) ) : 'active';
			$condition_display  = isset( $_POST['condition_display'] ) ? sanitize_key( wp_unslash( $_POST['condition_display'] ) ) : 'all';
			$publish            = isset( $_POST['publish'] ) ? filter_var( wp_unslash( $_POST['publish'] ), FILTER_VALIDATE_BOOLEAN ) : true;
			$display_options    = self::get_display_options( $type );

			if ( '' === $title ) {
				wp_send_json_error( array( 'message' => __( 'Title is required.', 'wira-kit-for-elementor' ) ), 400 );
			}

			if ( 'active' !== $condition_status && 'inactive' !== $condition_status ) {
				$condition_status = 'active';
			}

			if ( ! array_key_exists( $condition_display, $display_options ) ) {
				if ( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE === $type ) {
					$condition_display = 'singular';
				} elseif ( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE === $type ) {
					$condition_display = 'archive';
				} elseif ( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE === $type ) {
					$condition_display = 'search';
				} elseif ( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE === $type ) {
					$condition_display = '404';
				} else {
					$condition_display = 'all';
				}
			}

			$post_data = array(
				'post_type'   => $type,
				'post_title'  => $title,
				'post_status' => $publish ? 'publish' : 'draft',
			);

			if ( $post_id ) {
				$post = $this->validate_post_access( $post_id, $type, 'edit_post' );
				if ( is_wp_error( $post ) ) {
					wp_send_json_error( array( 'message' => $post->get_error_message() ), (int) $post->get_error_data() );
				}

				$post_data['ID'] = $post_id;
				$updated_id      = wp_update_post( $post_data, true );
				if ( is_wp_error( $updated_id ) ) {
					wp_send_json_error( array( 'message' => $updated_id->get_error_message() ), 500 );
				}
				$post_id = $updated_id;
			} else {
				$inserted_id = wp_insert_post( $post_data, true );
				if ( is_wp_error( $inserted_id ) ) {
					wp_send_json_error( array( 'message' => $inserted_id->get_error_message() ), 500 );
				}
				$post_id = $inserted_id;
			}

			update_post_meta( $post_id, self::META_CONDITION_STATUS, $condition_status );
			update_post_meta( $post_id, self::META_CONDITION_DISPLAY, $condition_display );
			update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );

			$item = $this->build_item( get_post( $post_id ) );

			wp_send_json_success(
				array(
					'item' => $item,
				)
			);
		}

		/**
		 * AJAX delete item.
		 *
		 * @return void
		 */
		public function ajax_delete_item() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'wira-kit-for-elementor' ) ), 403 );
			}

			check_ajax_referer( 'Wirakit_template_builder', 'nonce' );

			$type    = isset( $_POST['template_type'] ) ? sanitize_key( wp_unslash( $_POST['template_type'] ) ) : '';
			$post_id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

			if ( ! $this->is_allowed_template_type( $type ) || ! $post_id ) {
				wp_send_json_error( array( 'message' => __( 'Invalid delete request.', 'wira-kit-for-elementor' ) ), 400 );
			}

			$post = $this->validate_post_access( $post_id, $type, 'delete_post' );
			if ( is_wp_error( $post ) ) {
				wp_send_json_error( array( 'message' => $post->get_error_message() ), (int) $post->get_error_data() );
			}

			$deleted = wp_delete_post( $post_id, true );
			if ( ! $deleted ) {
				wp_send_json_error( array( 'message' => __( 'Failed to delete item.', 'wira-kit-for-elementor' ) ), 500 );
			}

			wp_send_json_success(
				array(
					'deleted_id' => $post_id,
				)
			);
		}

		/**
		 * Build list items for type.
		 *
		 * @param string $type Template post type.
		 *
		 * @return array<int,array<string,mixed>>
		 */
		private function get_items_by_type( $type ) {
			$posts = get_posts(
				array(
					'post_type'           => $type,
					'post_status'         => array( 'publish', 'draft', 'private', 'pending', 'future' ),
					'orderby'             => 'menu_order',
					'order'               => 'ASC',
					'numberposts'         => -1,
					'suppress_filters'    => false,
					'ignore_sticky_posts' => true,
				)
			);

			$items = array();
			foreach ( $posts as $post ) {
				$items[] = $this->build_item( $post );
			}

			return $items;
		}

		/**
		 * Build payload for a template item.
		 *
		 * @param WP_Post|object|null $post Post object.
		 *
		 * @return array<string,mixed>
		 */
		private function build_item( $post ) {
			if ( ! $post || empty( $post->ID ) ) {
				return array();
			}

			$condition_status  = get_post_meta( $post->ID, self::META_CONDITION_STATUS, true );
			$condition_display = get_post_meta( $post->ID, self::META_CONDITION_DISPLAY, true );
			$display_options   = self::get_display_options( $post->post_type );

			if ( 'inactive' !== $condition_status ) {
				$condition_status = 'active';
			}

			if ( ! isset( $display_options[ $condition_display ] ) ) {
				if ( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE === $post->post_type ) {
					$condition_display = 'singular';
				} elseif ( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE === $post->post_type ) {
					$condition_display = 'archive';
				} elseif ( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE === $post->post_type ) {
					$condition_display = 'search';
				} elseif ( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE === $post->post_type ) {
					$condition_display = '404';
				} else {
					$condition_display = 'all';
				}
			}

			return array(
				'id'                    => absint( $post->ID ),
				'title'                 => get_the_title( $post->ID ),
				'status'                => get_post_status( $post->ID ),
				'condition_status'      => $condition_status,
				'condition_display'     => $condition_display,
				'condition_display_text'=> $display_options[ $condition_display ],
				'edit_url'              => $this->get_editor_url( $post->ID ),
			);
		}

		/**
		 * Get edit URL in Elementor if available.
		 *
		 * @param int $post_id Post ID.
		 *
		 * @return string
		 */
		private function get_editor_url( $post_id ) {
			return admin_url( 'post.php?post=' . absint( $post_id ) . '&action=elementor' );
		}

		/**
		 * Check allowed template type.
		 *
		 * @param string $type Post type.
		 *
		 * @return bool
		 */
		private function is_allowed_template_type( $type ) {
			return in_array(
				$type,
				array(
					Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE,
				),
				true
			);
		}

		/**
		 * Validate post ownership/type and capability for sensitive actions.
		 *
		 * @param int    $post_id Post ID.
		 * @param string $type Expected post type.
		 * @param string $cap Capability name, e.g. edit_post/delete_post.
		 *
		 * @return WP_Post|WP_Error
		 */
		private function validate_post_access( $post_id, $type, $cap ) {
			$post = get_post( $post_id );
			if ( ! $post || $type !== $post->post_type ) {
				return new WP_Error( 'not_found', __( 'Item not found.', 'wira-kit-for-elementor' ), 404 );
			}

			if ( ! current_user_can( $cap, $post_id ) ) {
				return new WP_Error( 'forbidden', __( 'Permission denied.', 'wira-kit-for-elementor' ), 403 );
			}

			return $post;
		}
	}
}


