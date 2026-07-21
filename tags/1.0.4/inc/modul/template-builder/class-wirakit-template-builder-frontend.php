<?php
/**
 * Template Builder Frontend Integration.
 *
 * @package Wira Kit for Elementor
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Template_Builder_Frontend' ) ) {

	/**
	 * Replaces theme header/footer/content with Elementor-built templates.
	 */
	class Wirakit_Template_Builder_Frontend {
		/**
		 * Cache of template CSS IDs already enqueued.
		 *
		 * @var array<int,bool>
		 */
		private $enqueued_template_css = array();

		/**
		 * Whether the current request includes block-template widgets.
		 *
		 * @var bool
		 */
		private $has_block_templates = false;

		/**
		 * Header templates cache.
		 *
		 * @var array<int,array<string,mixed>>|null
		 */
		private $header_templates = null;

		/**
		 * Footer templates cache.
		 *
		 * @var array<int,array<string,mixed>>|null
		 */
		private $footer_templates = null;

		/**
		 * Single templates cache.
		 *
		 * @var array<int,array<string,mixed>>|null
		 */
		private $single_templates = null;

		/**
		 * Archive templates cache.
		 *
		 * @var array<int,array<string,mixed>>|null
		 */
		private $archive_templates = null;

		/**
		 * Search templates cache.
		 *
		 * @var array<int,array<string,mixed>>|null
		 */
		private $search_templates = null;

		/**
		 * 404 templates cache.
		 *
		 * @var array<int,array<string,mixed>>|null
		 */
		private $not_found_templates = null;

		/**
		 * Resolved active header ID for current request.
		 *
		 * @var int
		 */
		private $active_header_id = 0;

		/**
		 * Resolved active footer ID for current request.
		 *
		 * @var int
		 */
		private $active_footer_id = 0;

		/**
		 * Resolved active single ID for current request.
		 *
		 * @var int
		 */
		private $active_single_id = 0;

		/**
		 * Resolved active archive ID for current request.
		 *
		 * @var int
		 */
		private $active_archive_id = 0;

		/**
		 * Resolved active search ID for current request.
		 *
		 * @var int
		 */
		private $active_search_id = 0;

		/**
		 * Resolved active 404 ID for current request.
		 *
		 * @var int
		 */
		private $active_not_found_id = 0;

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'wp', array( $this, 'setup_template_hooks' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_elementor_styles' ), 30 );
			add_filter( 'elementor/frontend/print_css_in_footer', array( $this, 'maybe_print_css_in_head' ) );
		}

		/**
		 * Move Elementor CSS to head when block templates are used.
		 *
		 * @param bool $print_in_footer Current Elementor setting.
		 * @return bool
		 */
		public function maybe_print_css_in_head( $print_in_footer ) {
			if ( $this->has_block_templates ) {
				return false;
			}

			return $print_in_footer;
		}

		/**
		 * Ensure Elementor frontend styles are loaded.
		 *
		 * @return void
		 */
		public function enqueue_elementor_styles() {
			if ( ! $this->has_header_templates() && ! $this->has_footer_templates() && ! $this->has_single_templates() && ! $this->has_archive_templates() && ! $this->has_search_templates() && ! $this->has_not_found_templates() ) {
				return;
			}

			if ( class_exists( '\Elementor\Plugin' ) && ! empty( \Elementor\Plugin::$instance->frontend ) ) {
				\Elementor\Plugin::$instance->frontend->enqueue_styles();
				\Elementor\Plugin::$instance->frontend->enqueue_scripts();
			}

			foreach ( $this->get_runtime_template_ids_for_assets() as $template_id ) {
				$this->enqueue_template_runtime_assets( $template_id );
				$this->enqueue_template_post_css( $template_id );
			}
		}

		/**
		 * Collect template IDs that may render on this request.
		 *
		 * @return array<int>
		 */
		private function get_runtime_template_ids_for_assets() {
			$template_ids = array();

			$active_header_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE );
			$active_footer_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE );
			$active_single_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE );
			$active_archive_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE );
			$active_search_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE );
			$active_not_found_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE );

			foreach ( array( $active_header_id, $active_footer_id, $active_single_id, $active_archive_id, $active_search_id, $active_not_found_id ) as $template_id ) {
				if ( $template_id > 0 ) {
					$template_ids[] = (int) $template_id;
				}
			}

			$current_post_id = get_queried_object_id();
			if ( $current_post_id > 0 ) {
				$template_ids[] = (int) $current_post_id;
			}

			$seen_posts  = array();
			$nested_ids  = array();
			$unique_base = array_values( array_unique( array_map( 'absint', $template_ids ) ) );

			foreach ( $unique_base as $base_id ) {
				$this->collect_block_template_ids_from_post( $base_id, $nested_ids, $seen_posts );
			}

			return array_values(
				array_unique(
					array_merge(
						$unique_base,
						array_map( 'absint', $nested_ids )
					)
				)
			);
		}

		/**
		 * Enqueue Elementor generated CSS for a template post.
		 *
		 * @param int $template_id Template post ID.
		 *
		 * @return void
		 */
		private function enqueue_template_post_css( $template_id ) {
			$template_id = absint( $template_id );
			if ( $template_id < 1 || isset( $this->enqueued_template_css[ $template_id ] ) ) {
				return;
			}

			if ( ! class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				return;
			}

			$css_file = new \Elementor\Core\Files\CSS\Post( $template_id );
			$css_file->enqueue();
			$this->enqueued_template_css[ $template_id ] = true;
		}

		/**
		 * Enable Elementor widget assets for a template before wp_head is printed.
		 *
		 * @param int $template_id Template post ID.
		 *
		 * @return void
		 */
		private function enqueue_template_runtime_assets( $template_id ) {
			$template_id = absint( $template_id );
			if ( $template_id < 1 || ! class_exists( '\Elementor\Plugin' ) ) {
				return;
			}

			$page_assets = get_post_meta( $template_id, '_elementor_page_assets', true );
			if ( ! empty( $page_assets ) && is_array( $page_assets ) ) {
				\Elementor\Plugin::$instance->assets_loader->enable_assets( $page_assets );
				return;
			}

			$document = \Elementor\Plugin::$instance->documents->get( $template_id );
			if ( $document ) {
				$document->update_runtime_elements();
			}
		}

		/**
		 * Find nested block-template widget template IDs from Elementor data.
		 *
		 * @param int        $post_id     Post ID to parse.
		 * @param array<int> $result_ids  Collected template IDs.
		 * @param array<int> $seen_posts  Guard against recursive loops.
		 *
		 * @return void
		 */
		private function collect_block_template_ids_from_post( $post_id, &$result_ids, &$seen_posts ) {
			$post_id = absint( $post_id );
			if ( $post_id < 1 || in_array( $post_id, $seen_posts, true ) ) {
				return;
			}

			$seen_posts[] = $post_id;
			$raw_data     = get_post_meta( $post_id, '_elementor_data', true );
			if ( empty( $raw_data ) || ! is_string( $raw_data ) ) {
				return;
			}

			$data = json_decode( $raw_data, true );
			if ( ! is_array( $data ) ) {
				return;
			}

			$this->collect_block_template_ids_from_elements( $data, $result_ids );
			$result_ids = array_values( array_unique( array_map( 'absint', $result_ids ) ) );

			foreach ( $result_ids as $nested_post_id ) {
				if ( $nested_post_id > 0 ) {
					$this->collect_block_template_ids_from_post( $nested_post_id, $result_ids, $seen_posts );
				}
			}
		}

		/**
		 * Walk Elementor elements tree to extract block template IDs.
		 *
		 * @param array<mixed> $elements   Elementor elements.
		 * @param array<int>   $result_ids Collected template IDs.
		 *
		 * @return void
		 */
		private function collect_block_template_ids_from_elements( $elements, &$result_ids ) {
			foreach ( $elements as $element ) {
				if ( ! is_array( $element ) ) {
					continue;
				}

				$widget_type = isset( $element['widgetType'] ) ? (string) $element['widgetType'] : '';
				$settings    = ( isset( $element['settings'] ) && is_array( $element['settings'] ) ) ? $element['settings'] : array();

				if ( isset( $settings['blocks_template'] ) && in_array( $widget_type, array( 'wira_elementor_kit_block_template', 'Wirakit_block_template' ), true ) ) {
					$nested_template_id = absint( $settings['blocks_template'] );
					if ( $nested_template_id > 0 ) {
						$result_ids[] = $nested_template_id;
						$this->has_block_templates = true;
					}
				}

				if ( isset( $element['elements'] ) && is_array( $element['elements'] ) ) {
					$this->collect_block_template_ids_from_elements( $element['elements'], $result_ids );
				}
			}
		}

		/**
		 * Register runtime hooks when template exists.
		 *
		 * @return void
		 */
		public function setup_template_hooks() {
			if ( ! defined( 'ELEMENTOR_VERSION' ) || is_admin() ) {
				return;
			}

			if ( $this->has_header_templates() ) {
				add_action( 'get_header', array( $this, 'override_theme_header_template' ), 99 );
				add_action( 'wkit_header', array( $this, 'render_header' ) );
			}

			if ( $this->has_footer_templates() ) {
				add_action( 'get_footer', array( $this, 'override_theme_footer_template' ), 99 );
				add_action( 'wkit_footer', array( $this, 'render_footer' ) );
			}

			if ( $this->has_single_templates() ) {
				add_filter( 'template_include', array( $this, 'override_theme_single_template' ), 99 );
				add_action( 'wkit_single', array( $this, 'render_single' ) );
			}

			if ( $this->has_archive_templates() ) {
				add_filter( 'template_include', array( $this, 'override_theme_archive_template' ), 100 );
				add_action( 'wkit_archive', array( $this, 'render_archive' ) );
			}

			if ( $this->has_search_templates() ) {
				add_filter( 'template_include', array( $this, 'override_theme_search_template' ), 101 );
				add_action( 'wkit_search', array( $this, 'render_search' ) );
			}

			if ( $this->has_not_found_templates() ) {
				add_filter( 'template_include', array( $this, 'override_theme_404_template' ), 102 );
				add_action( 'wkit_404', array( $this, 'render_404' ) );
			}
		}

		/**
		 * Whether published header templates are available.
		 *
		 * @return bool
		 */
		private function has_header_templates() {
			return ! empty( $this->get_templates( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE ) );
		}

		/**
		 * Whether published footer templates are available.
		 *
		 * @return bool
		 */
		private function has_footer_templates() {
			return ! empty( $this->get_templates( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE ) );
		}

		/**
		 * Whether published single templates are available.
		 *
		 * @return bool
		 */
		private function has_single_templates() {
			return ! empty( $this->get_templates( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE ) );
		}

		/**
		 * Whether published archive templates are available.
		 *
		 * @return bool
		 */
		private function has_archive_templates() {
			return ! empty( $this->get_templates( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE ) );
		}

		/**
		 * Whether published search templates are available.
		 *
		 * @return bool
		 */
		private function has_search_templates() {
			return ! empty( $this->get_templates( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ) );
		}

		/**
		 * Whether published 404 templates are available.
		 *
		 * @return bool
		 */
		private function has_not_found_templates() {
			return ! empty( $this->get_templates( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE ) );
		}

		/**
		 * Get templates by post type ordered by menu_order.
		 *
		 * @param string $post_type Post type slug.
		 *
		 * @return array<int,array<string,mixed>>
		 */
		private function get_templates( $post_type ) {
			if ( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE === $post_type && is_array( $this->header_templates ) ) {
				return $this->header_templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE === $post_type && is_array( $this->footer_templates ) ) {
				return $this->footer_templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE === $post_type && is_array( $this->single_templates ) ) {
				return $this->single_templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE === $post_type && is_array( $this->archive_templates ) ) {
				return $this->archive_templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE === $post_type && is_array( $this->search_templates ) ) {
				return $this->search_templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE === $post_type && is_array( $this->not_found_templates ) ) {
				return $this->not_found_templates;
			}

			$query = get_posts(
				array(
					'post_type'         => $post_type,
					'post_status'       => 'publish',
					'orderby'           => 'menu_order',
					'order'             => 'ASC',
					'numberposts'       => -1,
					'suppress_filters'  => false,
				)
			);

			$templates = array();
			foreach ( $query as $post ) {
				$templates[] = array(
					'id' => $post->ID,
				);
			}

			wp_reset_postdata();

			if ( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE === $post_type ) {
				$this->header_templates = $templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE === $post_type ) {
				$this->footer_templates = $templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE === $post_type ) {
				$this->single_templates = $templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE === $post_type ) {
				$this->archive_templates = $templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE === $post_type ) {
				$this->search_templates = $templates;
			}

			if ( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE === $post_type ) {
				$this->not_found_templates = $templates;
			}

			return $templates;
		}

		/**
		 * Print plugin header wrapper and bypass theme visual header output.
		 *
		 * @return void
		 */
		public function override_theme_header_template() {
			$this->active_header_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE );
			if ( ! $this->active_header_id ) {
				return;
			}

			load_template( WIRAKIT_PATH . 'inc/modul/template-builder/templates/header-template.php' );
			remove_all_actions( 'wp_head' );
			ob_start();
			locate_template( array( 'header.php' ), true );
			ob_end_clean();
		}

		/**
		 * Print plugin footer wrapper and bypass theme visual footer output.
		 *
		 * @return void
		 */
		public function override_theme_footer_template() {
			$this->active_footer_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE );
			if ( ! $this->active_footer_id ) {
				return;
			}

			load_template( WIRAKIT_PATH . 'inc/modul/template-builder/templates/footer-template.php' );
			remove_all_actions( 'wp_footer' );
			ob_start();
			locate_template( array( 'footer.php' ), true );
			ob_end_clean();
		}

		/**
		 * Override current page template with single builder output.
		 *
		 * @param string $template Current template path.
		 *
		 * @return string
		 */
		public function override_theme_single_template( $template ) {
			if ( ! $this->is_supported_single_builder_context() ) {
				return $template;
			}

			$this->active_single_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE );
			if ( ! $this->active_single_id ) {
				return $template;
			}

			return WIRAKIT_PATH . 'inc/modul/template-builder/templates/single-template.php';
		}

		/**
		 * Override current page template with archive builder output.
		 *
		 * @param string $template Current template path.
		 *
		 * @return string
		 */
		public function override_theme_archive_template( $template ) {
			if ( ! $this->is_supported_archive_builder_context() ) {
				return $template;
			}

			$this->active_archive_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE );
			if ( ! $this->active_archive_id ) {
				return $template;
			}

			return WIRAKIT_PATH . 'inc/modul/template-builder/templates/archive-template.php';
		}

		/**
		 * Override current page template with search result builder output.
		 *
		 * @param string $template Current template path.
		 *
		 * @return string
		 */
		public function override_theme_search_template( $template ) {
			if ( ! $this->is_supported_search_builder_context() ) {
				return $template;
			}

			$this->active_search_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE );
			if ( ! $this->active_search_id ) {
				return $template;
			}

			return WIRAKIT_PATH . 'inc/modul/template-builder/templates/search-template.php';
		}

		/**
		 * Override current page template with 404 builder output.
		 *
		 * @param string $template Current template path.
		 *
		 * @return string
		 */
		public function override_theme_404_template( $template ) {
			if ( ! $this->is_supported_404_builder_context() ) {
				return $template;
			}

			$this->active_not_found_id = $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE );
			if ( ! $this->active_not_found_id ) {
				return $template;
			}

			return WIRAKIT_PATH . 'inc/modul/template-builder/templates/404-template.php';
		}

		/**
		 * Render selected header template.
		 *
		 * @return void
		 */
		public function render_header() {
			$template_id = $this->active_header_id ? $this->active_header_id : $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::HEADER_POST_TYPE );
			if ( ! $template_id ) {
				return;
			}
			?>
			<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
				<?php echo $this->get_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders template HTML content. ?>
			</header>
			<?php
		}

		/**
		 * Render selected footer template.
		 *
		 * @return void
		 */
		public function render_footer() {
			$template_id = $this->active_footer_id ? $this->active_footer_id : $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::FOOTER_POST_TYPE );
			if ( ! $template_id ) {
				return;
			}
			?>
			<footer id="colophon" itemscope="itemscope" itemtype="https://schema.org/WPFooter">
				<?php echo $this->get_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders template HTML content. ?>
			</footer>
			<?php
		}

		/**
		 * Render selected single builder template.
		 *
		 * @return void
		 */
		public function render_single() {
			$template_id = $this->active_single_id ? $this->active_single_id : $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE );
			if ( ! $template_id ) {
				return;
			}
			?>
			<div class="wkit-template-single-content">
				<?php echo $this->get_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders template HTML content. ?>
			</div>
			<?php
		}

		/**
		 * Render selected archive builder template.
		 *
		 * @return void
		 */
		public function render_archive() {
			$template_id = $this->active_archive_id ? $this->active_archive_id : $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE );
			if ( ! $template_id ) {
				return;
			}
			?>
			<div class="wkit-template-archive-content">
				<?php echo $this->get_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders template HTML content. ?>
			</div>
			<?php
		}

		/**
		 * Render selected search result builder template.
		 *
		 * @return void
		 */
		public function render_search() {
			$template_id = $this->active_search_id ? $this->active_search_id : $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE );
			if ( ! $template_id ) {
				return;
			}
			?>
			<div class="wkit-template-search-content">
				<?php echo $this->get_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders template HTML content. ?>
			</div>
			<?php
		}

		/**
		 * Render selected 404 builder template.
		 *
		 * @return void
		 */
		public function render_404() {
			$template_id = $this->active_not_found_id ? $this->active_not_found_id : $this->resolve_active_template_id( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE );
			if ( ! $template_id ) {
				return;
			}
			?>
			<div class="wkit-template-404-content">
				<?php echo $this->get_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders template HTML content. ?>
			</div>
			<?php
		}

		/**
		 * Resolve template ID with first-match strategy.
		 *
		 * Current concept:
		 * - priority by menu_order ASC.
		 * - condition status must be active.
		 * - condition display must match current query context.
		 *
		 * @param string $post_type Post type slug.
		 *
		 * @return int
		 */
		private function resolve_active_template_id( $post_type ) {
			$post_id   = get_the_ID();
			$templates = $this->get_templates( $post_type );

			foreach ( $templates as $template ) {
				$template_id = isset( $template['id'] ) ? absint( $template['id'] ) : 0;
				if ( ! $template_id ) {
					continue;
				}

				if ( ! $this->is_template_active( $template_id ) ) {
					continue;
				}

				if ( ! $this->match_display_condition( $template_id, $post_type ) ) {
					continue;
				}

				$matched = apply_filters( 'wkit_template_builder_match', true, $template_id, $post_type, $post_id );
				if ( $matched ) {
					return $template_id;
				}
			}

			return 0;
		}

		/**
		 * Check template active/inactive flag.
		 *
		 * @param int $template_id Template ID.
		 *
		 * @return bool
		 */
		private function is_template_active( $template_id ) {
			$status = get_post_meta( $template_id, $this->get_condition_status_meta_key(), true );
			return 'inactive' !== $status;
		}

		/**
		 * Check display condition.
		 *
		 * @param int $template_id Template ID.
		 *
		 * @return bool
		 */
		private function match_display_condition( $template_id, $template_post_type ) {
			$display = get_post_meta( $template_id, $this->get_condition_display_meta_key(), true );
			if ( empty( $display ) || 'all' === $display ) {
				return true;
			}

			if ( Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE === $template_post_type ) {
				return $this->match_archive_display_condition( $display );
			}

			if ( Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE === $template_post_type ) {
				return 'search' === $display && $this->is_supported_search_builder_context();
			}

			if ( Wirakit_Template_Builder_Post_Type::NOT_FOUND_POST_TYPE === $template_post_type ) {
				return '404' === $display && $this->is_supported_404_builder_context();
			}

			if ( 'singular' === $display ) {
				return is_singular() && ! $this->is_internal_builder_singular();
			}

			if ( 0 === strpos( $display, 'singular-' ) ) {
				$post_type = substr( $display, 9 );
				return ! empty( $post_type ) && is_singular( $post_type );
			}

			switch ( $display ) {
				case 'front-page':
					return is_front_page();
				case 'blog':
					return is_home();
				case 'shop':
					return function_exists( 'is_shop' ) && is_shop();
				default:
					return true;
			}
		}

		/**
		 * Check archive display condition.
		 *
		 * @param string $display Display condition.
		 *
		 * @return bool
		 */
		private function match_archive_display_condition( $display ) {
			if ( 'archive' === $display ) {
				return $this->is_supported_archive_builder_context();
			}

			if ( 0 === strpos( $display, 'archive-' ) ) {
				$post_type = substr( $display, 8 );
				return ! empty( $post_type ) && $this->current_archive_matches_post_type( $post_type );
			}

			return false;
		}

		/**
		 * Check whether current archive query matches a specific post type.
		 *
		 * @param string $post_type Target post type.
		 *
		 * @return bool
		 */
		private function current_archive_matches_post_type( $post_type ) {
			if ( is_home() && 'post' === $post_type ) {
				return true;
			}

			if ( is_post_type_archive( $post_type ) ) {
				return true;
			}

			$queried_object = get_queried_object();
			if ( ! $queried_object || empty( $queried_object->taxonomy ) ) {
				return false;
			}

			$taxonomy = get_taxonomy( $queried_object->taxonomy );
			if ( ! $taxonomy || empty( $taxonomy->object_type ) || ! is_array( $taxonomy->object_type ) ) {
				return false;
			}

			return in_array( $post_type, $taxonomy->object_type, true );
		}

		/**
		 * Check whether current singular page belongs to internal builder post types.
		 *
		 * @return bool
		 */
		private function is_internal_builder_singular() {
			if ( ! is_singular() ) {
				return false;
			}

			$post_type = get_post_type();
			return in_array(
				$post_type,
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
		 * Check whether current request supports single builder replacement.
		 *
		 * @return bool
		 */
		private function is_supported_single_builder_context() {
			if ( is_embed() || is_feed() ) {
				return false;
			}

			if ( is_singular() && $this->is_internal_builder_singular() ) {
				return false;
			}

			return is_singular();
		}

		/**
		 * Check whether current request supports archive builder replacement.
		 *
		 * @return bool
		 */
		private function is_supported_archive_builder_context() {
			if ( is_embed() || is_feed() ) {
				return false;
			}

			return is_archive() || is_home();
		}

		/**
		 * Check whether current request supports search builder replacement.
		 *
		 * @return bool
		 */
		private function is_supported_search_builder_context() {
			if ( is_embed() || is_feed() ) {
				return false;
			}

			return is_search();
		}

		/**
		 * Check whether current request supports 404 builder replacement.
		 *
		 * @return bool
		 */
		private function is_supported_404_builder_context() {
			if ( is_embed() || is_feed() ) {
				return false;
			}

			return is_404();
		}

		/**
		 * Get condition status meta key.
		 *
		 * @return string
		 */
		private function get_condition_status_meta_key() {
			if ( class_exists( 'Wirakit_Template_Builder_Admin' ) ) {
				return Wirakit_Template_Builder_Admin::META_CONDITION_STATUS;
			}
			return '_wkit_condition_status';
		}

		/**
		 * Get condition display meta key.
		 *
		 * @return string
		 */
		private function get_condition_display_meta_key() {
			if ( class_exists( 'Wirakit_Template_Builder_Admin' ) ) {
				return Wirakit_Template_Builder_Admin::META_CONDITION_DISPLAY;
			}
			return '_wkit_condition_display';
		}

		/**
		 * Render Elementor template content.
		 *
		 * @param int $template_id Template post ID.
		 *
		 * @return string
		 */
		private function get_template_content( $template_id ) {
			if ( ! class_exists( '\Elementor\Plugin' ) ) {
				return '';
			}

			return (string) \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, false );
		}
	}
}
