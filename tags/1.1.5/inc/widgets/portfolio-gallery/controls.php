<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Portfolio Gallery Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$category_repeater = new \Elementor\Repeater();

$category_repeater->add_control(
	'category_label',
	array(
		'label'   => __( 'Category Label', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::TEXT,
		'default' => __( 'Branding', 'wira-kit-for-elementor' ),
	)
);

$category_repeater->add_control(
	'category_slug',
	array(
		'label'       => __( 'Category Slug', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => 'branding',
		'description' => __( 'Unique key, use lowercase and dash. Example: web-design', 'wira-kit-for-elementor' ),
	)
);

$category_options = array(
	'' => __( 'None', 'wira-kit-for-elementor' ),
	'branding'   => __( 'Branding', 'wira-kit-for-elementor' ),
	'web-design' => __( 'Web Design', 'wira-kit-for-elementor' ),
	'ui-ux'      => __( 'UI/UX', 'wira-kit-for-elementor' ),
);

$portfolio_repeater = new \Elementor\Repeater();

$portfolio_repeater->add_control(
	'portfolio_image',
	array(
		'label'   => __( 'Image', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::MEDIA,
		'default' => array(
			'url' => \Elementor\Utils::get_placeholder_image_src(),
		),
		'dynamic' => array( 'active' => true ),
	)
);

$portfolio_repeater->add_control(
	'portfolio_title',
	array(
		'label'   => __( 'Title', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::TEXT,
		'default' => __( 'Portfolio Title', 'wira-kit-for-elementor' ),
		'dynamic' => array( 'active' => true ),
	)
);

$portfolio_repeater->add_control(
	'portfolio_description',
	array(
		'label'   => __( 'Description', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::TEXTAREA,
		'default' => __( 'Portfolio short description', 'wira-kit-for-elementor' ),
		'rows'    => 3,
		'dynamic' => array( 'active' => true ),
	)
);

$portfolio_repeater->add_control(
	'portfolio_category',
	array(
		'label'       => __( 'Portfolio Category', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'description' => __( 'Use category slug. Example: branding', 'wira-kit-for-elementor' ),
	)
);

$portfolio_repeater->add_control(
	'action_type',
	array(
		'label'   => __( 'Button Type', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'none',
		'options' => array(
			'none'      => __( 'None', 'wira-kit-for-elementor' ),
			'button'    => __( 'Button', 'wira-kit-for-elementor' ),
			'icon-only' => __( 'Icon Only', 'wira-kit-for-elementor' ),
		),
	)
);

$portfolio_repeater->add_control(
	'action_text',
	array(
		'label'     => __( 'Button Text', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => __( 'View Project', 'wira-kit-for-elementor' ),
		'condition' => array(
			'action_type' => 'button',
		),
	)
);

$portfolio_repeater->add_control(
	'action_icon',
	array(
		'label'   => __( 'Action Icon', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::ICONS,
		'default' => array(
			'value'   => 'fas fa-arrow-right',
			'library' => 'fa-solid',
		),
		'condition' => array(
			'action_type!' => 'none',
		),
	)
);

$portfolio_repeater->add_control(
	'action_link',
	array(
		'label'       => __( 'Action Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
		'default'     => array( 'url' => '#' ),
		'dynamic'     => array( 'active' => true ),
		'condition'   => array(
			'action_type!' => 'none',
		),
	)
);

$this->start_controls_section(
	'portfolio_category_section',
	array(
		'label' => __( 'Portfolio Category', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'enable_portfolio_category',
	array(
		'label'        => __( 'Enable Portfolio Category', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
	)
);

$this->add_control(
	'portfolio_all_tab_label',
	array(
		'label'     => __( 'All Tab Label', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => __( 'All', 'wira-kit-for-elementor' ),
		'condition' => array(
			'enable_portfolio_category' => 'yes',
		),
	)
);

$this->add_control(
	'portfolio_categories',
	array(
		'label'       => __( 'Categories', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $category_repeater->get_controls(),
		'title_field' => '{{{ category_label }}}',
		'default'     => array(
			array(
				'category_label' => __( 'Branding', 'wira-kit-for-elementor' ),
				'category_slug'  => 'branding',
			),
			array(
				'category_label' => __( 'Web Design', 'wira-kit-for-elementor' ),
				'category_slug'  => 'web-design',
			),
			array(
				'category_label' => __( 'UI/UX', 'wira-kit-for-elementor' ),
				'category_slug'  => 'ui-ux',
			),
		),
		'condition'   => array(
			'enable_portfolio_category' => 'yes',
		),
	)
);

$this->add_control(
	'portfolio_category_note',
	array(
		'type'            => \Elementor\Controls_Manager::RAW_HTML,
		'raw'             => esc_html__( 'After updating category list, reload the editor panel so item category select picks the latest category options.', 'wira-kit-for-elementor' ),
		'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		'condition'       => array(
			'enable_portfolio_category' => 'yes',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_items_section',
	array(
		'label' => __( 'Portfolio Items', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'portfolio_items',
	array(
		'label'       => __( 'Items', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $portfolio_repeater->get_controls(),
		'title_field' => '{{{ portfolio_title }}}',
		'default'     => array(
			array( 'portfolio_title' => __( 'Modern Interior', 'wira-kit-for-elementor' ) ),
			array( 'portfolio_title' => __( 'Creative Agency', 'wira-kit-for-elementor' ) ),
			array( 'portfolio_title' => __( 'Architecture Concept', 'wira-kit-for-elementor' ) ),
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Image_Size::get_type(),
	array(
		'name'    => 'portfolio_thumb',
		'default' => 'large',
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_layout_section',
	array(
		'label' => __( 'Layout', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'layout_style',
	array(
		'label'   => __( 'Layout Style', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'options' => array(
			'default'       => __( 'Default', 'wira-kit-for-elementor' ),
			'hover-overlay' => __( 'Hover Overlay', 'wira-kit-for-elementor' ),
		),
		'default' => 'default',
	)
);

$this->add_responsive_control(
	'columns',
	array(
		'label'     => __( 'Columns', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'min'       => 1,
		'max'       => 6,
		'step'      => 1,
		'default'   => 3,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-gallery' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
		),
	)
);

$this->add_responsive_control(
	'column_gap',
	array(
		'label'      => __( 'Column Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'default'    => array( 'size' => 20 ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-gallery' => 'column-gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'row_gap',
	array(
		'label'      => __( 'Row Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'default'    => array( 'size' => 20 ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-gallery' => 'row-gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'item_min_height',
	array(
		'label'      => __( 'Item Min Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'vh' ),
		'range'      => array(
			'px' => array( 'min' => 80, 'max' => 1000 ),
			'vh' => array( 'min' => 10, 'max' => 100 ),
		),
		'default'    => array(
			'size' => 320,
			'unit' => 'px',
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-item' => 'min-height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_container_style_section',
	array(
		'label' => __( 'Container Style', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->start_controls_tabs( 'portfolio_container_tabs' );

$this->start_controls_tab(
	'portfolio_container_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_overlay_background',
		'selector' => '{{WRAPPER}} .wkit-portfolio-overlay',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'portfolio_item_border',
		'selector' => '{{WRAPPER}} .wkit-portfolio-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'portfolio_item_shadow',
		'selector' => '{{WRAPPER}} .wkit-portfolio-item',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'portfolio_container_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_overlay_background_hover',
		'selector' => '{{WRAPPER}} .wkit-portfolio-item:hover .wkit-portfolio-overlay',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'portfolio_item_border_hover',
		'selector' => '{{WRAPPER}} .wkit-portfolio-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'portfolio_item_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-portfolio-item:hover',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_responsive_control(
	'item_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			'{{WRAPPER}} .wkit-portfolio-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'item_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_category_style_section',
	array(
		'label' => __( 'Portfolio Category', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'portfolio_category_align_items',
	array(
		'label'   => __( 'Align Items', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'flex-start' => array(
				'title' => __( 'Start', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'flex-end' => array(
				'title' => __( 'End', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default' => 'flex-start',
		'toggle'  => true,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-tabs' => 'justify-content: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_category_gap',
	array(
		'label'      => __( 'Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 80 ),
		),
		'default'    => array(
			'size' => 10,
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-tabs' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_category_wrapper_margin',
	array(
		'label'      => __( 'Wrapper Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_category_padding',
	array(
		'label'      => __( 'Item Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_category_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'portfolio_category_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'portfolio_category_typography',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab',
	)
);

$this->start_controls_tabs( 'portfolio_category_state_tabs' );

$this->start_controls_tab(
	'portfolio_category_state_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'portfolio_category_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-tab' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_category_bg',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'portfolio_category_border',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'portfolio_category_state_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'portfolio_category_color_hover',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-tab:hover' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_category_bg_hover',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'portfolio_category_border_hover',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab:hover',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'portfolio_category_state_active',
	array(
		'label' => __( 'Active', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'portfolio_category_color_active',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-tab.is-active' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_category_bg_active',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab.is-active',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'portfolio_category_border_active',
		'selector' => '{{WRAPPER}} .wkit-portfolio-tab.is-active',
	)
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_title_style_section',
	array(
		'label' => __( 'Title', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'portfolio_title_typography',
		'selector' => '{{WRAPPER}} .wkit-portfolio-title',
	)
);

$this->add_responsive_control(
	'portfolio_title_align',
	array(
		'label'   => __( 'Text Align', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'left' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'right' => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default' => 'left',
		'toggle'  => true,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-title' => 'text-align: {{VALUE}};',
		),
	)
);

$this->add_control(
	'portfolio_title_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'portfolio_title_color_hover',
	array(
		'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-item:hover .wkit-portfolio-title' => 'color: {{VALUE}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_description_style_section',
	array(
		'label' => __( 'Description', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'portfolio_description_typography',
		'selector' => '{{WRAPPER}} .wkit-portfolio-description',
	)
);

$this->add_responsive_control(
	'portfolio_description_align',
	array(
		'label'   => __( 'Text Align', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'left' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'right' => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default' => 'left',
		'toggle'  => true,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-description' => 'text-align: {{VALUE}};',
		),
	)
);

$this->add_control(
	'portfolio_description_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-description' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'portfolio_description_color_hover',
	array(
		'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-item:hover .wkit-portfolio-description' => 'color: {{VALUE}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'portfolio_action_style_section',
	array(
		'label' => __( 'Action', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'portfolio_action_typography',
		'selector' => '{{WRAPPER}} .wkit-portfolio-action',
	)
);

$this->add_responsive_control(
	'portfolio_action_text_align',
	array(
		'label'   => __( 'Text Align', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'left' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'right' => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default' => 'left',
		'toggle'  => true,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-action-wrap' => 'text-align: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_action_align',
	array(
		'label'   => __( 'Action Align', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'flex-start' => array(
				'title' => __( 'Start', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-h-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-h-align-center',
			),
			'flex-end' => array(
				'title' => __( 'End', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-h-align-right',
			),
		),
		'default' => 'flex-start',
		'toggle'  => true,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-action-wrap' => 'justify-content: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_action_wrapper_margin',
	array(
		'label'      => __( 'Wrapper Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-action-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'portfolio_action_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-action' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'portfolio_action_border',
		'selector' => '{{WRAPPER}} .wkit-portfolio-action',
	)
);

$this->add_responsive_control(
	'portfolio_action_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-portfolio-action' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'portfolio_action_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-portfolio-action',
	)
);

$this->start_controls_tabs( 'portfolio_action_tabs' );

$this->start_controls_tab(
	'portfolio_action_tab_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'portfolio_action_color',
	array(
		'label'     => __( 'Text/Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-action' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_action_bg',
		'selector' => '{{WRAPPER}} .wkit-portfolio-action.is-icon-only, {{WRAPPER}} .wkit-portfolio-action',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'portfolio_action_tab_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'portfolio_action_color_hover',
	array(
		'label'     => __( 'Text/Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-portfolio-action:hover' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'portfolio_action_bg_hover',
		'selector' => '{{WRAPPER}} .wkit-portfolio-action.is-icon-only:hover , {{WRAPPER}} .wkit-portfolio-action:hover',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->end_controls_section();
