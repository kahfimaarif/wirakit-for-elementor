<?php
/**
 * Widget Helper.
 *
 * Provides additional Elementor controls and features such as:
 * - Post Preview Settings for Template Library templates.
 * - Featured Image background for containers.
 * - Glassmorphism background blur effects.
 * - Sticky effects for containers with responsive options.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'wira_elementor_kit_Widget_Helper' ) ) {

	/**
	 * Extends Elementor functionality with custom controls and effects.
	 *
	 * @since 1.0.0
	 */
	class Wirakit_Widget_Helper {

		/**
		 * Constructor.
		 *
		 * Initializes hooks for Elementor controls and rendering.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->load_hooks();
		}

		/**
		 * Register hooks for Elementor.
		 *
		 * Hooks include:
		 * - Post preview controls for documents.
		 * - Background options (featured image, blur).
		 * - Sticky effects for container.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function load_hooks() {

			// Register post preview settings in Elementor document.
			add_action(
				'elementor/documents/register_controls',
				array( $this, 'post_preview_settings' )
			);

			// Add custom controls into Elementor container (Style -> Background).
			if ( $this->is_module_enabled( 'featured-image-background' ) ) {
				add_action(
					'elementor/element/container/section_background/after_section_end',
					array( $this, 'add_container_featured_image_bg_control' ),
					10,
					2
				);
			}

			if ( $this->is_module_enabled( 'glassmorphism' ) ) {
				add_action(
					'elementor/element/container/section_background/after_section_end',
					array( $this, 'add_container_background_blur_controls' ),
					10,
					2
				);
			}

			// Add custom controls into Elementor common widgets (Style -> Background).
			if ( $this->is_module_enabled( 'glassmorphism' ) ) {
				add_action(
					'elementor/element/common/_section_background/after_section_end',
					array( $this, 'add_background_blur_controls' ),
					10,
					2
				);
			}

			// Add custom effects section after Motion Effects (Container only).
			if ( $this->is_module_enabled( 'sticky-effect' ) ) {
				add_action(
					'elementor/element/container/section_effects/after_section_end',
					array( $this, 'add_container_sticky_effects' ),
					10,
					2
				);

				// Render inject CSS for container.
				add_action(
					'elementor/frontend/container/before_render',
					array( $this, 'render_container_sticky_effects' )
				);
			}
		}

		/**
		 * Check if helper module is enabled.
		 *
		 * @since 1.0.0
		 * @param string $module_id Module identifier.
		 * @return bool
		 */
		private function is_module_enabled( $module_id ) {
			if ( class_exists( 'wira_elementor_kit_Functions' ) && method_exists( 'wira_elementor_kit_Functions', 'is_module_enabled' ) ) {
				return Wirakit_Functions::is_module_enabled( $module_id );
			}

			return true;
		}

		/**
		 * Register Post Preview settings for Elementor templates.
		 *
		 * Allows choosing a post for preview when editing Elementor Template Library items.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Core\DocumentTypes\Document $document Elementor document instance.
		 * @return void
		 */
		public function post_preview_settings( $document ) {
			$post_id = $document->get_main_id();
			$post_type = get_post_type( $post_id );

			$allowed_post_types = array( 'elementor_library', 'wkit-single', 'wkit-archive', 'wkit-search' );
			if ( class_exists( 'wira_elementor_kit_Template_Builder_Post_Type' ) ) {
				$allowed_post_types = array(
					'elementor_library',
					Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE,
					Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE,
				);
			}

			if ( ! in_array( $post_type, $allowed_post_types, true ) ) {
				return;
			}

			// Start new section for Post Preview controls.
			$document->start_controls_section(
				'section_post_preview',
				array(
					'label' => __( 'Post Preview Settings', 'wira-kit-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_SETTINGS,
				)
			);

			$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
			$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

			$posts = get_posts(
				array(
					'post_type'      => $post_types,
					'posts_per_page' => -1,
					'post_status'    => 'publish',
				)
			);

			$post_options = array();
			if ( $posts ) {
				foreach ( $posts as $p ) {
					$post_options[ $p->ID ] = $p->post_title;
				}
			}

			// Pick a random post for default preview.
			$random_post_id = null;
			$random_post    = get_posts(
				array(
					'post_type'      => $post_types,
					'posts_per_page' => 1,
					'orderby'        => 'rand',
					'post_status'    => 'publish',
				)
			);

			if ( $random_post ) {
				$random_post_id                  = $random_post[0]->ID;
				$post_options[ $random_post_id ] = get_the_title( $random_post_id );
			}

			$document->add_control(
				'include_posts',
				array(
					'label'            => __( 'Choose Post Preview', 'wira-kit-for-elementor' ),
					'type'             => \Elementor\Controls_Manager::SELECT2,
					'options'          => $post_options,
					'label_block'      => true,
					'default'          => $random_post_id,
				)
			);

			$document->add_control(
				'post_preview_reload',
				array(
					'type'       => \Elementor\Controls_Manager::ALERT,
					'alert_type' => 'info',
					'heading'    => esc_html__( 'Post Preview Notice', 'wira-kit-for-elementor' ),
					'content'    => esc_html__( 'After changing the post preview, please click Publish/Update first, then refresh the preview to see the changes.', 'wira-kit-for-elementor' ) .
									' <a href="#" onclick="if ( window.elementor && typeof elementor.reloadPreview === \'function\' ) { elementor.reloadPreview(); } return false;">' .
									esc_html__( 'Click here to refresh preview', 'wira-kit-for-elementor' ) . '</a>',
				)
			);

			$document->end_controls_section();
		}

		/**
		 * Add Featured Image Background controls to Elementor container.
		 *
		 * Adds switcher and options for using the current post's featured image
		 * as a container background with hover states.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Element_Base $element Element instance.
		 * @param array                   $args    Element args.
		 * @return void
		 */
		public function add_container_featured_image_bg_control( $element, $args ) {

			$post_id = get_the_ID();
			$url     = '';

			// Frontend or normal post context.
			if ( $post_id && get_post_status( $post_id ) ) {
				$url = get_the_post_thumbnail_url( $post_id, 'full' );
			} elseif ( is_singular() ) {
				$url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			}

			// Elementor editor preview mode (elementor_library).
			if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$post_type = get_post_type( $post_id );
				if ( 'elementor_library' === $post_type ) {
					$document      = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
					$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

					$exclude_types = array( 'media', 'floating-element', 'template', 'elementor_library' );
					$post_types    = array_diff( get_post_types( array( 'public' => true ), 'names' ), $exclude_types );

					$args = array(
						'post_type'      => $post_types,
						'posts_per_page' => 1,
						'post_status'    => 'publish',
					);

					if ( ! empty( $include_posts ) ) {
						$template_post_ids = is_array( $include_posts ) ? $include_posts : array( $include_posts );
						$args['post__in']  = array_map( 'absint', $template_post_ids );
						$args['orderby']   = 'post__in';
					}

					$query = new \WP_Query( $args );
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							$url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						wp_reset_postdata();
					}
				}
			}

			$bg_value = $url ? 'url(' . esc_url( $url ) . ')' : 'none';

			$element->start_controls_section(
				'section_featured_bg',
				array(
					'label' => __( 'Featured Image Background', 'wira-kit-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			// Switcher to enable Featured Image background.
			$element->add_control(
				'use_featured_image',
				array(
					'label'     => __( 'Use Featured Image', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'selectors' => array(
						'{{WRAPPER}}' => 'background-image:' . $bg_value . ';',
					),
				)
			);

			// Tabs Normal & Hover.
			$element->start_controls_tabs( 'tabs_featured_bg' );

			// Normal.
			$element->start_controls_tab(
				'tab_featured_bg_normal',
				array(
					'label'     => __( 'Normal', 'wira-kit-for-elementor' ),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->add_control(
				'background_size_normal',
				array(
					'label'     => __( 'Background Size', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => array(
						'cover'   => __( 'Cover', 'wira-kit-for-elementor' ),
						'contain' => __( 'Contain', 'wira-kit-for-elementor' ),
						'auto'    => __( 'Auto', 'wira-kit-for-elementor' ),
					),
					'default'   => 'cover',
					'selectors' => array(
						'{{WRAPPER}}' => 'background-size: {{VALUE}};',
					),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->add_control(
				'background_position_normal',
				array(
					'label'     => __( 'Background Position', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => array(
						'center center' => __( 'Center Center', 'wira-kit-for-elementor' ),
						'center left'   => __( 'Center Left', 'wira-kit-for-elementor' ),
						'center right'  => __( 'Center Right', 'wira-kit-for-elementor' ),
						'top center'    => __( 'Top Center', 'wira-kit-for-elementor' ),
						'top left'      => __( 'Top Left', 'wira-kit-for-elementor' ),
						'top right'     => __( 'Top Right', 'wira-kit-for-elementor' ),
						'bottom center' => __( 'Bottom Center', 'wira-kit-for-elementor' ),
						'bottom left'   => __( 'Bottom Left', 'wira-kit-for-elementor' ),
						'bottom right'  => __( 'Bottom Right', 'wira-kit-for-elementor' ),
					),
					'default'   => 'center center',
					'selectors' => array(
						'{{WRAPPER}}' => 'background-position: {{VALUE}};',
					),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->end_controls_tab();

			// Hover.
			$element->start_controls_tab(
				'tab_featured_bg_hover',
				array(
					'label'     => __( 'Hover', 'wira-kit-for-elementor' ),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->add_control(
				'background_size_hover',
				array(
					'label'     => __( 'Background Size', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => array(
						'cover'   => __( 'Cover', 'wira-kit-for-elementor' ),
						'contain' => __( 'Contain', 'wira-kit-for-elementor' ),
						'auto'    => __( 'Auto', 'wira-kit-for-elementor' ),
					),
					'default'   => 'cover',
					'selectors' => array(
						'{{WRAPPER}}:hover' => 'background-size: {{VALUE}};',
					),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->add_control(
				'background_position_hover',
				array(
					'label'     => __( 'Background Position', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => array(
						'center center' => __( 'Center Center', 'wira-kit-for-elementor' ),
						'center left'   => __( 'Center Left', 'wira-kit-for-elementor' ),
						'center right'  => __( 'Center Right', 'wira-kit-for-elementor' ),
						'top center'    => __( 'Top Center', 'wira-kit-for-elementor' ),
						'top left'      => __( 'Top Left', 'wira-kit-for-elementor' ),
						'top right'     => __( 'Top Right', 'wira-kit-for-elementor' ),
						'bottom center' => __( 'Bottom Center', 'wira-kit-for-elementor' ),
						'bottom left'   => __( 'Bottom Left', 'wira-kit-for-elementor' ),
						'bottom right'  => __( 'Bottom Right', 'wira-kit-for-elementor' ),
					),
					'default'   => 'center center',
					'selectors' => array(
						'{{WRAPPER}}:hover' => 'background-position: {{VALUE}};',
					),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->add_control(
				'bg_transition_duration',
				array(
					'label'     => __( 'Transition Duration', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min'  => 0,
							'max'  => 3,
							'step' => 0.01,
						),
					),
					'default'   => array(
						'size' => 0.3,
					),
					'selectors' => array(
						'{{WRAPPER}}' => 'transition: all {{SIZE}}s ease-in-out;',
					),
					'condition' => array(
						'use_featured_image' => 'yes',
					),
				)
			);

			$element->end_controls_tab();

			$element->end_controls_tabs();

			$element->end_controls_section();
		}

		/**
		 * Add Glassmorphism background blur controls to common widgets.
		 *
		 * Adds blur effect toggle and slider for widgets.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Element_Base $element Element instance.
		 * @return void
		 */
		public function add_background_blur_controls( $element ) {

			$element->start_controls_section(
				'section_bg_blur',
				array(
					'label' => __( 'Glassmorphism Effect', 'wira-kit-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$element->add_control(
				'wira_elementor_kit_bg_blur',
				array(
					'label'        => __( 'Enable Glassmorphism', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
				)
			);

			$element->add_responsive_control(
				'wira_elementor_kit_blur_value',
				array(
					'label'      => __( 'Blur Amount (px)', 'wira-kit-for-elementor' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					),
					'default'    => array(
						'size' => 10,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
					),
					'condition'  => array(
						'wira_elementor_kit_bg_blur' => 'yes',
					),
				)
			);

			$element->end_controls_section();
		}

		/**
		 * Add Glassmorphism background blur controls to container widgets.
		 *
		 * Similar to common widget blur, but applied at container level.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Element_Base $element Element instance.
		 * @return void
		 */
		public function add_container_background_blur_controls( $element ) {

			$element->start_controls_section(
				'section_bg_blur',
				array(
					'label' => __( 'Glassmorphism Effect', 'wira-kit-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			$element->add_control(
				'wira_elementor_kit_bg_blur',
				array(
					'label'        => __( 'Enable Glassmorphism', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
				)
			);

			$element->add_responsive_control(
				'wira_elementor_kit_blur_value',
				array(
					'label'      => __( 'Blur Amount (px)', 'wira-kit-for-elementor' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					),
					'default'    => array(
						'size' => 10,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
					),
					'condition'  => array(
						'wira_elementor_kit_bg_blur' => 'yes',
					),
				)
			);

			$element->end_controls_section();
		}

		/**
		 * Add Sticky Effects controls to Elementor container.
		 *
		 * Adds sticky positioning, offsets, background change, and
		 * device-specific toggles for applying sticky behavior.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Element_Base $element Element instance.
		 * @param array                   $args    Element args.
		 * @return void
		 */
		public function add_container_sticky_effects( $element, $args ) {

			$element->start_controls_section(
				'wira_elementor_kit_section_effects',
				array(
					'label' => __( 'Wkit -  Sticky Effects', 'wira-kit-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$element->add_control(
				'sticky_effect_note',
				array(
					'type'       => \Elementor\Controls_Manager::ALERT,
					'alert_type' => 'info',
					'heading'    => esc_html__( 'Sticky Effect Just Work on Frontend Only', 'wira-kit-for-elementor' ),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky',
				array(
					'label'        => __( 'Add Sticky Effect', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_position',
				array(
					'label'     => __( 'Sticky Position', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'default'   => 'top',
					'options'   => array(
						'top'    => __( 'Top', 'wira-kit-for-elementor' ),
						'bottom' => __( 'Bottom', 'wira-kit-for-elementor' ),
					),
					'condition' => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_responsive_control(
				'wira_elementor_kit_sticky_offset',
				array(
					'label'     => __( 'Sticky Offset', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::NUMBER,
					'default'   => 30,
					'selectors' => array(),
					'condition' => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_parent',
				array(
					'label'        => __( 'Stay In Column', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_bg_animated',
				array(
					'label'        => __( 'Header Animated Scroll', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_bg_change',
				array(
					'label'        => __( 'Header BG Change', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				array(
					'name'      => 'wira_elementor_kit_sticky_bg',
					'selector'  => '{{WRAPPER}}.has-wkit-sticky-change.sticky-bg-active, {{WRAPPER}}.has-wkit-sticky-change.sticky-bg-active .wkit-mobile-menu',
					'condition' => array(
						'wira_elementor_kit_sticky'           => 'yes',
						'wira_elementor_kit_sticky_bg_change' => 'yes',
					),
				)
			);

			$element->add_responsive_control(
				'wira_elementor_kit_nav_menu_item_change_color',
				array(
					'label'     => __( 'Menu Item Color', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}}.has-wkit-sticky-change.sticky-bg-active .wkit-nav > ul > li.nav-item > a.nav-link' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'wira_elementor_kit_sticky'           => 'yes',
						'wira_elementor_kit_sticky_bg_change' => 'yes',
					),
				)
			);

			$element->add_responsive_control(
				'wira_elementor_kit_nav_menu_item_change_color_hover',
				array(
					'label'     => __( 'Menu Item Hover Color', 'wira-kit-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}}.has-wkit-sticky-change.sticky-bg-active .wkit-nav > ul > li.nav-item:hover > a.nav-link' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'wira_elementor_kit_sticky'           => 'yes',
						'wira_elementor_kit_sticky_bg_change' => 'yes',
					),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_apply_desktop',
				array(
					'label'        => __( 'Apply on Desktop', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_apply_tablet',
				array(
					'label'        => __( 'Apply on Tablet', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->add_control(
				'wira_elementor_kit_sticky_apply_mobile',
				array(
					'label'        => __( 'Apply on Mobile', 'wira-kit-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => array(
						'wira_elementor_kit_sticky' => 'yes',
					),
				)
			);

			$element->end_controls_section();
		}

		/**
		 * Render hook: inject sticky attributes into container.
		 *
		 * Adds necessary wrapper attributes (`data-*` and classes)
		 * for sticky effects on frontend rendering.
		 *
		 * @since 1.0.0
		 * @param \Elementor\Element_Base $element Element instance.
		 * @return void
		 */
		public function render_container_sticky_effects( $element ) {
			if ( 'container' !== $element->get_name() ) {
				return;
			}

			$settings = $element->get_settings_for_display();

			if ( ! empty( $settings['wira_elementor_kit_sticky'] ) && 'yes' === $settings['wira_elementor_kit_sticky'] ) {
				$element->add_render_attribute( '_wrapper', 'class', 'has-wkit-sticky' );

				// Sticky parent.
				if ( ! empty( $settings['wira_elementor_kit_sticky_parent'] ) && 'yes' === $settings['wira_elementor_kit_sticky_parent'] ) {
					$element->add_render_attribute( '_wrapper', 'data-sticky-parent', 'yes' );
				}

				// Sticky position (top/bottom).
				if ( ! empty( $settings['wira_elementor_kit_sticky_position'] ) ) {
					$element->add_render_attribute( '_wrapper', 'data-sticky-position', esc_attr( $settings['wira_elementor_kit_sticky_position'] ) );
				}

				// Sticky offset.
				if ( isset( $settings['wira_elementor_kit_sticky_offset'] ) ) {
					$element->add_render_attribute( '_wrapper', 'data-sticky-offset', intval( $settings['wira_elementor_kit_sticky_offset'] ) );
				}

				// Background Change.
				if ( ! empty( $settings['wira_elementor_kit_sticky_bg_animated'] ) && 'yes' === $settings['wira_elementor_kit_sticky_bg_animated'] ) {
					$element->add_render_attribute( '_wrapper', 'data-header-animated', 'yes' );
				}

				// Background Change.
				if ( ! empty( $settings['wira_elementor_kit_sticky_bg_change'] ) && 'yes' === $settings['wira_elementor_kit_sticky_bg_change'] ) {
					$element->add_render_attribute( '_wrapper', 'data-bg-change', 'yes' );
					$element->add_render_attribute( '_wrapper', 'class', 'has-wkit-sticky-change' );
				}

				// Apply Effects.
				foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device ) {
					$key   = "wira_elementor_kit_sticky_apply_{$device}";
					$value = ( isset( $settings[ $key ] ) && 'yes' === $settings[ $key ] ) ? 'yes' : 'no';
					$element->add_render_attribute( '_wrapper', "data-on-{$device}", $value );
				}
			}
		}
	}

	new Wirakit_Widget_Helper();
}

