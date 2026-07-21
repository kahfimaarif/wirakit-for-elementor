<?php
/**
 * Template Builder Post Type.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Builder_Post_Type' ) ) {

	/**
	 * Registers Header/Footer/Single template post types.
	 */
	class Wirakit_Template_Builder_Post_Type {
		/**
		 * Option key used to trigger a one-time rewrite flush.
		 *
		 * @var string
		 */
		const REWRITE_FLUSH_OPTION = 'Wirakit_flush_rewrite';

		/**
		 * Header post type slug.
		 *
		 * @var string
		 */
		const HEADER_POST_TYPE = 'wkit-header';

		/**
		 * Footer post type slug.
		 *
		 * @var string
		 */
		const FOOTER_POST_TYPE = 'wkit-footer';

		/**
		 * Single builder post type slug.
		 *
		 * @var string
		 */
		const SINGLE_POST_TYPE = 'wkit-single';

		/**
		 * Archive builder post type slug.
		 *
		 * @var string
		 */
		const ARCHIVE_POST_TYPE = 'wkit-archive';

		/**
		 * Search result builder post type slug.
		 *
		 * @var string
		 */
		const SEARCH_POST_TYPE = 'wkit-search';

		/**
		 * 404 builder post type slug.
		 *
		 * @var string
		 */
		const NOT_FOUND_POST_TYPE = 'wkit-404';

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_post_types' ) );
			add_action( 'init', array( $this, 'ensure_elementor_cpt_support' ), 30 );
			add_action( 'init', array( $this, 'maybe_flush_rewrite_rules' ), 99 );
		}

		/**
		 * Register template builder post types.
		 *
		 * @return void
		 */
		public function register_post_types() {
			register_post_type(
				self::HEADER_POST_TYPE,
				array(
					'labels' => array(
						'name'          => __( 'WKit Headers', 'wira-kit-for-elementor' ),
						'singular_name' => __( 'WKit Header', 'wira-kit-for-elementor' ),
						'add_new_item'  => __( 'Add New Header Template', 'wira-kit-for-elementor' ),
						'edit_item'     => __( 'Edit Header Template', 'wira-kit-for-elementor' ),
					),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'has_archive'         => false,
					'show_in_rest'        => true,
					'rewrite'             => array(
						'slug'       => self::HEADER_POST_TYPE,
						'with_front' => false,
					),
					'supports'            => array( 'title', 'editor', 'elementor' ),
					'menu_icon'           => 'dashicons-editor-kitchensink',
				)
			);
			add_post_type_support( self::HEADER_POST_TYPE, 'elementor' );

			register_post_type(
				self::FOOTER_POST_TYPE,
				array(
					'labels' => array(
						'name'          => __( 'WKit Footers', 'wira-kit-for-elementor' ),
						'singular_name' => __( 'WKit Footer', 'wira-kit-for-elementor' ),
						'add_new_item'  => __( 'Add New Footer Template', 'wira-kit-for-elementor' ),
						'edit_item'     => __( 'Edit Footer Template', 'wira-kit-for-elementor' ),
					),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'has_archive'         => false,
					'show_in_rest'        => true,
					'rewrite'             => array(
						'slug'       => self::FOOTER_POST_TYPE,
						'with_front' => false,
					),
					'supports'            => array( 'title', 'editor', 'elementor' ),
					'menu_icon'           => 'dashicons-editor-kitchensink',
				)
			);
			add_post_type_support( self::FOOTER_POST_TYPE, 'elementor' );

			register_post_type(
				self::SINGLE_POST_TYPE,
				array(
					'labels' => array(
						'name'          => __( 'WKit Singles', 'wira-kit-for-elementor' ),
						'singular_name' => __( 'WKit Single', 'wira-kit-for-elementor' ),
						'add_new_item'  => __( 'Add New Single Template', 'wira-kit-for-elementor' ),
						'edit_item'     => __( 'Edit Single Template', 'wira-kit-for-elementor' ),
					),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'has_archive'         => false,
					'show_in_rest'        => true,
					'rewrite'             => array(
						'slug'       => self::SINGLE_POST_TYPE,
						'with_front' => false,
					),
					'supports'            => array( 'title', 'editor', 'elementor' ),
					'menu_icon'           => 'dashicons-editor-kitchensink',
				)
			);
			add_post_type_support( self::SINGLE_POST_TYPE, 'elementor' );

			register_post_type(
				self::ARCHIVE_POST_TYPE,
				array(
					'labels' => array(
						'name'          => __( 'WKit Archives', 'wira-kit-for-elementor' ),
						'singular_name' => __( 'WKit Archive', 'wira-kit-for-elementor' ),
						'add_new_item'  => __( 'Add New Archive Template', 'wira-kit-for-elementor' ),
						'edit_item'     => __( 'Edit Archive Template', 'wira-kit-for-elementor' ),
					),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'has_archive'         => false,
					'show_in_rest'        => true,
					'rewrite'             => array(
						'slug'       => self::ARCHIVE_POST_TYPE,
						'with_front' => false,
					),
					'supports'            => array( 'title', 'editor', 'elementor' ),
					'menu_icon'           => 'dashicons-editor-kitchensink',
				)
			);
			add_post_type_support( self::ARCHIVE_POST_TYPE, 'elementor' );

			register_post_type(
				self::SEARCH_POST_TYPE,
				array(
					'labels' => array(
						'name'          => __( 'WKit Search Results', 'wira-kit-for-elementor' ),
						'singular_name' => __( 'WKit Search Result', 'wira-kit-for-elementor' ),
						'add_new_item'  => __( 'Add New Search Result Template', 'wira-kit-for-elementor' ),
						'edit_item'     => __( 'Edit Search Result Template', 'wira-kit-for-elementor' ),
					),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'has_archive'         => false,
					'show_in_rest'        => true,
					'rewrite'             => array(
						'slug'       => self::SEARCH_POST_TYPE,
						'with_front' => false,
					),
					'supports'            => array( 'title', 'editor', 'elementor' ),
					'menu_icon'           => 'dashicons-editor-kitchensink',
				)
			);
			add_post_type_support( self::SEARCH_POST_TYPE, 'elementor' );

			register_post_type(
				self::NOT_FOUND_POST_TYPE,
				array(
					'labels' => array(
						'name'          => __( 'WKit 404s', 'wira-kit-for-elementor' ),
						'singular_name' => __( 'WKit 404', 'wira-kit-for-elementor' ),
						'add_new_item'  => __( 'Add New 404 Template', 'wira-kit-for-elementor' ),
						'edit_item'     => __( 'Edit 404 Template', 'wira-kit-for-elementor' ),
					),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'has_archive'         => false,
					'show_in_rest'        => true,
					'rewrite'             => array(
						'slug'       => self::NOT_FOUND_POST_TYPE,
						'with_front' => false,
					),
					'supports'            => array( 'title', 'editor', 'elementor' ),
					'menu_icon'           => 'dashicons-editor-kitchensink',
				)
			);
			add_post_type_support( self::NOT_FOUND_POST_TYPE, 'elementor' );
		}

		/**
		 * Ensure Elementor setting includes template-builder post types.
		 *
		 * @return void
		 */
		public function ensure_elementor_cpt_support() {
			// Elementor core option: register custom template builder CPTs with Elementor.
			$cpt_support = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
			$cpt_support = is_array( $cpt_support ) ? $cpt_support : array( 'page', 'post' );
			$updated     = false;

			foreach ( array( self::HEADER_POST_TYPE, self::FOOTER_POST_TYPE, self::SINGLE_POST_TYPE, self::ARCHIVE_POST_TYPE, self::SEARCH_POST_TYPE, self::NOT_FOUND_POST_TYPE ) as $post_type ) {
				if ( ! in_array( $post_type, $cpt_support, true ) ) {
					$cpt_support[] = $post_type;
					$updated       = true;
				}
			}

			if ( $updated ) {
				// Elementor core option: persist CPT support list for Elementor editor.
				update_option( 'elementor_cpt_support', array_values( array_unique( $cpt_support ) ), false );
			}
		}

		/**
		 * Flush rewrite rules once after activation/update.
		 *
		 * @return void
		 */
		public function maybe_flush_rewrite_rules() {
			$needs_flush = get_option( self::REWRITE_FLUSH_OPTION, '' );

			if ( empty( $needs_flush ) ) {
				return;
			}

			flush_rewrite_rules( false );
			delete_option( self::REWRITE_FLUSH_OPTION );
		}

	}
}



