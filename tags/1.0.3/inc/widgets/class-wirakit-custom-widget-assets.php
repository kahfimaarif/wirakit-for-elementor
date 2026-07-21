<?php
/**
 * Enqueue Assets for Custom Elementor Widgets
 *
 * Registers widget-specific assets and enqueues global styles/scripts.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Wirakit_Custom_Widget_Assets' ) ) {

	/**
	 * Handles registering and enqueueing of custom widget assets.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Custom_Widget_Assets {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->load_hooks();
		}

		/**
		 * Load WordPress hooks.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function load_hooks() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_icon_assets' ), 20 );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_icon_assets' ), 20 );

			// Enqueue sticky effect globally.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_sticky_effect' ) );
			add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_sticky_effect' ) );
		}

		/**
		 * Register widget-specific styles and scripts.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function enqueue_assets() {

			$css_dir = WIRAKIT_PATH . 'assets/widget/css/';
			$js_dir  = WIRAKIT_PATH . 'assets/widget/js/';

			$css_url = WIRAKIT_URL . 'assets/widget/css/';
			$js_url  = WIRAKIT_URL . 'assets/widget/js/';

			$this->enqueue_icon_assets();

			// Register widget CSS.
			$widget_css_files = array(
				'blog.css',
				'button.css',
				'carousel-slider.css',
				'contact-form.css',
				'archive-list.css',
				'search-form.css',
				'cmb2-video.css',
				'heading.css',
				'icon-box.css',
				'loop.css',
				'nav-menu.css',
				'info-box-repeater.css',
				'project.css',
				'team.css',
				'team-repeater.css',
				'testimonial.css',
				'swiper-bundle.min.css',
								'popup.css',
				'single.css',
				'countdown.css',
				'text-marquee.css',
				'logo-marquee.css',
				'image-marquee.css',
				'portfolio-gallery.css',
				'accordion.css',
				'progress-bar.css',
				'tabs-widget.css',
				'tooltip.css',
				'back-to-top.css',
			);

			if ( $this->is_module_enabled( 'glassmorphism' ) ) {
				$widget_css_files[] = 'glassmorphism.css';
			}

			foreach ( $widget_css_files as $file ) {
				$path = $css_dir . $file;
				if ( file_exists( $path ) ) {
					$slug   = str_replace( '.css', '', $file );
					$slug   = str_replace( '.', '-', $slug );
					$handle = 'wkit-' . $slug . '-css';

					wp_register_style(
						$handle,
						$css_url . $file,
						array(),
						filemtime( $path )
					);
				}
			}

			// Ensure nav menu CSS is enqueued early so it prints in <head>.
			if ( wp_style_is( 'wkit-nav-menu-css', 'registered' ) ) {
				wp_enqueue_style( 'wkit-nav-menu-css' );
			}

			// Register widget JS.
			$widget_js_files = array(
				'nav-menu.js',
				'countdown.js',
				'back-to-top.js',
				'swiper-bundle.min.js',
				'swiper.js',
				'ajax-pagination.js',
				'block-template-editor.js',
				'block-template-frontend.js',
				'popup.js',
				'accordion.js',
				'portfolio-gallery.js',
				'progress-bar.js',
				'tab-widget.js',
			);

			if ( $this->is_module_enabled( 'sticky-effect' ) ) {
				$widget_js_files[] = 'sticky-effect.js';
			}

			foreach ( $widget_js_files as $file ) {
				$path = $js_dir . $file;
				if ( file_exists( $path ) ) {
					$slug   = str_replace( '.js', '', $file );
					$slug   = str_replace( '.', '-', $slug );
					$handle = 'wkit-' . $slug . '-js';

					wp_register_script(
						$handle,
						$js_url . $file,
						array( 'jquery' ),
						filemtime( $path ),
						true
					);
				}
			}

			// Enqueue Swiper assets globally (similar to sticky effect).
			if ( wp_style_is( 'wkit-swiper-bundle-min-css', 'registered' ) ) {
				wp_enqueue_style( 'wkit-swiper-bundle-min-css' );
			}
			if ( wp_script_is( 'wkit-swiper-bundle-min-js', 'registered' ) ) {
				wp_enqueue_script( 'wkit-swiper-bundle-min-js' );
			}
			if ( wp_script_is( 'wkit-swiper-js', 'registered' ) ) {
				wp_enqueue_script( 'wkit-swiper-js' );
			}

			// Enqueue global widget style.
			$global_style = $css_dir . 'widget-style.css';
			if ( file_exists( $global_style ) ) {
				wp_enqueue_style(
					'wkit-widget-style',
					$css_url . 'widget-style.css',
					array( 'wkit-bootstrap' ),
					filemtime( $global_style )
				);
			}

			// Enqueue Bootstrap only if not already loaded by theme.
			if ( ! wp_style_is( 'bootstrap', 'enqueued' ) && ! wp_style_is( 'bootstrap', 'registered' ) ) {
				$bootstrap = $css_dir . 'bootstrap.min.css';
				if ( file_exists( $bootstrap ) ) {
					wp_enqueue_style(
						'wkit-bootstrap',
						$css_url . 'bootstrap.min.css',
						array(),
						filemtime( $bootstrap )
					);
				}
			}

			// Enqueue optional module: Glassmorphism.
			if ( $this->is_module_enabled( 'glassmorphism' ) && wp_style_is( 'wkit-glassmorphism-css', 'registered' ) ) {
				wp_enqueue_style( 'wkit-glassmorphism-css' );
			}

			// Enqueue global custom badge JS.
			$custom_badge = $js_dir . 'custom-badge.js';
			if ( file_exists( $custom_badge ) ) {
				wp_enqueue_script(
					'wkit-custom-badge',
					$js_url . 'custom-badge.js',
					array( 'jquery' ),
					filemtime( $custom_badge ),
					true
				);
			}

			// Enqueue editor helper only in Elementor editor context.
			if ( $this->is_elementor_editor_context() && wp_script_is( 'wkit-block-template-editor-js', 'registered' ) ) {
				wp_enqueue_script( 'wkit-block-template-editor-js' );
			}
		}

		/**
		 * Check if current request is Elementor editor context.
		 *
		 * @since 1.0.0
		 * @return bool
		 */
		private function is_elementor_editor_context() {
			return did_action( 'elementor/editor/before_enqueue_scripts' ) || did_action( 'elementor/editor/after_enqueue_scripts' );
		}

		/**
		 * Check if asset module is enabled.
		 *
		 * @since 1.0.0
		 * @param string $module_id Module identifier.
		 * @return bool
		 */
		private function is_module_enabled( $module_id ) {
			if ( class_exists( 'Wirakit_Functions' ) && method_exists( 'Wirakit_Functions', 'is_module_enabled' ) ) {
				return Wirakit_Functions::is_module_enabled( $module_id );
			}

			return true;
		}

		/**
		 * Enqueue Sticky Effects js.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function enqueue_sticky_effect() {
			if ( ! $this->is_module_enabled( 'sticky-effect' ) ) {
				return;
			}

			wp_enqueue_script( 'wkit-sticky-effect-js' );
		}

		/**
		 * Enqueue icon assets in a way compatible with Elementor versions/modes.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function enqueue_icon_assets() {
			$icon_loaded = false;

			if ( class_exists( '\\Elementor\\Icons_Manager' ) && method_exists( '\\Elementor\\Icons_Manager', 'enqueue_shim' ) ) {
				\Elementor\Icons_Manager::enqueue_shim();
				$icon_loaded = true;
			}

			$elementor_icon_handles = array(
				'elementor-icons',
				'elementor-icons-fa-brands',
				'elementor-icons-fa-regular',
				'elementor-icons-fa-solid',
			);
			foreach ( $elementor_icon_handles as $icon_handle ) {
				if ( wp_style_is( $icon_handle, 'registered' ) ) {
					wp_enqueue_style( $icon_handle );
					$icon_loaded = true;
				}
			}

			$fa_handles = array(
				'font-awesome',
				'font-awesome-5-all',
				'font-awesome-5-v4-shims',
				'font-awesome-4-shim',
			);
			foreach ( $fa_handles as $fa_handle ) {
				if ( wp_style_is( $fa_handle, 'registered' ) ) {
					wp_enqueue_style( $fa_handle );
					$icon_loaded = true;
				}
			}

			if ( ! $icon_loaded && defined( 'ELEMENTOR_ASSETS_URL' ) ) {
				wp_enqueue_style(
					'wkit-font-awesome-fallback',
					ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
					array(),
					defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : WIRAKIT_VERSION
				);
			}
		}
	}

	new Wirakit_Custom_Widget_Assets();
}
