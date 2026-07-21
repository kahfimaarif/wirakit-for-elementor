<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Tab Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$template_options = array( 0 => __( 'Select Template', 'wira-kit-for-elementor' ) );
if ( class_exists( 'Wirakit_Template_Library_Helper' ) ) {
	$template_options = $template_options + Wirakit_Template_Library_Helper::get_templates_options();
}

$this->start_controls_section(
	'tab_widget_content_section',
	array(
		'label' => __( 'Tabs', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
	'tab_title',
	array(
		'label'       => __( 'Title', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Tab Title', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'dynamic'     => array( 'active' => true ),
	)
);

$repeater->add_control(
	'tab_description',
	array(
		'label'       => __( 'Description', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXTAREA,
		'default'     => __( 'Tab short description', 'wira-kit-for-elementor' ),
		'rows'        => 5,
		'label_block' => true,
		'dynamic'     => array( 'active' => true ),
	)
);

$repeater->add_control(
	'tab_icon',
	array(
		'label'   => __( 'Icon', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::ICONS,
		'default' => array(
			'value'   => 'fas fa-star',
			'library' => 'fa-solid',
		),
	)
);

$repeater->add_control(
	'tab_content_type',
	array(
		'label'   => __( 'Source', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'content',
		'options' => array(
			'content'  => __( 'Content', 'wira-kit-for-elementor' ),
			'template' => __( 'Template', 'wira-kit-for-elementor' ),
		),
	)
);

$repeater->add_control(
	'tab_content',
	array(
		'label'     => __( 'Content', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::WYSIWYG,
		'default'   => __( 'Add your tab content here.', 'wira-kit-for-elementor' ),
		'dynamic'   => array( 'active' => true ),
		'condition' => array(
			'tab_content_type' => 'content',
		),
	)
);

$repeater->add_control(
	'tab_template_id',
	array(
		'label'       => __( 'Template', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::SELECT2,
		'options'     => $template_options,
		'default'     => 0,
		'label_block' => true,
		'condition'   => array(
			'tab_content_type' => 'template',
		),
	)
);

$edit_base = admin_url( 'post.php?action=elementor&post=' );
$repeater->add_control(
    'edit_block_template',
    [
        'type'            => \Elementor\Controls_Manager::RAW_HTML,
        'raw'             => '<div class="wkit-edit-block-template-wrap" data-edit-base="' . esc_attr( $edit_base ) . '" data-setting="tab_template_id"><button type="button" class="button wkit-edit-block-template" style="border: none; padding: 15px 30px; background-color: var(--e-a-color-accent);">' . esc_html__( 'Edit Component', 'wira-kit-for-elementor' ) . '</button></div>',
        'content_classes' => 'wkit-edit-block-template-control',
		'condition'   => array(
			'tab_content_type' => 'template',
		),
    ]
);

$this->add_control(
	'tab_items',
	array(
		'label'       => __( 'Tab Items', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $repeater->get_controls(),
		'default'     => array(
			array(
				'tab_title'       => __( 'Overview', 'wira-kit-for-elementor' ),
				'tab_description' => __( 'General info', 'wira-kit-for-elementor' ),
				'tab_content'     => __( 'Write overview content here.', 'wira-kit-for-elementor' ),
			),
			array(
				'tab_title'       => __( 'Features', 'wira-kit-for-elementor' ),
				'tab_description' => __( 'What you get', 'wira-kit-for-elementor' ),
				'tab_content'     => __( 'Write feature content here.', 'wira-kit-for-elementor' ),
			),
			array(
				'tab_title'       => __( 'Details', 'wira-kit-for-elementor' ),
				'tab_description' => __( 'Additional details', 'wira-kit-for-elementor' ),
				'tab_content'     => __( 'Write detail content here.', 'wira-kit-for-elementor' ),
			),
		),
		'title_field' => '{{{ tab_title }}}',
	)
);

$this->add_control(
	'default_active_tab',
	array(
		'label'       => __( 'Default Active Tab', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::NUMBER,
		'default'     => 1,
		'min'         => 1,
		'step'        => 1,
		'description' => __( 'Start from 1.', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'show_description_active_only',
	array(
		'label'        => __( 'Show Description on Active Tab Only', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'tabs_alignment',
	array(
		'label'     => __( 'Tab Alignment', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::CHOOSE,
		'options'   => array(
			'flex-start' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center'     => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'flex-end'   => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default'   => 'flex-start',
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav' => 'justify-content: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'tabs_direction',
	array(
		'label'   => __( 'Tab Header Position', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'column'         => array(
				'title' => __( 'Top', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-v-align-top',
			),
			'column-reverse' => array(
				'title' => __( 'Bottom', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-v-align-bottom',
			),
			'row'            => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-h-align-left',
			),
			'row-reverse'    => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-h-align-right',
			),
		),
		'default'   => 'column',
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-layout' => 'flex-direction: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'tabs_justify',
	array(
		'label'   => __( 'Justify', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'flex-start',
		'options' => array(
			'flex-start'    => __( 'Start', 'wira-kit-for-elementor' ),
			'center'        => __( 'Center', 'wira-kit-for-elementor' ),
			'flex-end'      => __( 'End', 'wira-kit-for-elementor' ),
			'space-between' => __( 'Space Between', 'wira-kit-for-elementor' ),
			'space-around'  => __( 'Space Around', 'wira-kit-for-elementor' ),
			'space-evenly'  => __( 'Space Evenly', 'wira-kit-for-elementor' ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav' => 'justify-content: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'tab_layout_gap',
	array(
		'label' => __( 'Header/Content Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'default'   => array(
			'size' => 20,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-layout' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'tab_header_area_width',
	array(
		'label'      => __( 'Header Area Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 800 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-nav' => 'width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'tab_item_width',
	array(
		'label'      => __( 'Tab Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 600 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-nav-item' => 'width: {{SIZE}}{{UNIT}}; flex: 0 0 auto;',
		),
	)
);

$this->add_responsive_control(
	'tab_title_align',
	array(
		'label'   => __( 'Align Title', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'flex-start' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center'     => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'flex-end'   => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default'   => 'flex-start',
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item' => 'align-items: {{VALUE}};',
			'{{WRAPPER}} .wkit-tab-nav-head' => 'justify-content: {{VALUE}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'tab_widget_header_style_section',
	array(
		'label' => __( 'Tab Header', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'tab_header_gap',
	array(
		'label' => __( 'Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 80 ),
		),
		'default'   => array(
			'size' => 12,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'tab_header_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'tab_header_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-nav-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'tab_header_transition',
	array(
		'label'     => __( 'Transition Duration (s)', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array( 'min' => 0, 'max' => 3, 'step' => 0.1 ),
		),
		'default'   => array(
			'size' => 0.3,
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->start_controls_tabs( 'tab_header_state_tabs' );

$this->start_controls_tab(
	'tab_header_state_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'tab_header_bg',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item',
	)
);

$this->add_control(
	'tab_header_title_color',
	array(
		'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'tab_header_desc_color',
	array(
		'label'     => __( 'Description Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-desc' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'tab_header_icon_color',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-icon i, {{WRAPPER}} .wkit-tab-nav-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'tab_header_border',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'tab_header_shadow',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'tab_header_state_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'tab_header_bg_hover',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item:hover',
	)
);

$this->add_control(
	'tab_header_title_color_hover',
	array(
		'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item:hover .wkit-tab-nav-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'tab_header_desc_color_hover',
	array(
		'label'     => __( 'Description Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item:hover .wkit-tab-nav-desc' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'tab_header_icon_color_hover',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item:hover .wkit-tab-nav-icon i, {{WRAPPER}} .wkit-tab-nav-item:hover .wkit-tab-nav-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'tab_header_border_hover',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'tab_header_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item:hover',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'tab_header_state_active',
	array(
		'label' => __( 'Active', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'tab_header_bg_active',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item.is-active',
	)
);

$this->add_control(
	'tab_header_title_color_active',
	array(
		'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'tab_header_desc_color_active',
	array(
		'label'     => __( 'Description Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-desc' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'tab_header_icon_color_active',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-icon i, {{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'tab_header_border_active',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item.is-active',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'tab_header_shadow_active',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item.is-active',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'tab_header_title_typography',
		'label'    => __( 'Title Typography', 'wira-kit-for-elementor' ),
		'selector' => '{{WRAPPER}} .wkit-tab-nav-title',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'tab_header_desc_typography',
		'label'    => __( 'Description Typography', 'wira-kit-for-elementor' ),
		'selector' => '{{WRAPPER}} .wkit-tab-nav-desc',
	)
);

$this->add_responsive_control(
	'tab_header_desc_active_padding',
	array(
		'label'      => __( 'Description Padding (Active)', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'tab_header_desc_active_radius',
	array(
		'label'      => __( 'Description Border Radius (Active)', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'tab_header_desc_active_bg',
		'selector' => '{{WRAPPER}} .wkit-tab-nav-item.is-active .wkit-tab-nav-desc',
	)
);

$this->add_responsive_control(
	'tab_header_icon_size',
	array(
		'label' => __( 'Icon Size', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 8, 'max' => 80 ),
		),
		'default'   => array(
			'size' => 18,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-nav-icon i, {{WRAPPER}} .wkit-tab-nav-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'tab_widget_content_style_section',
	array(
		'label' => __( 'Content Area', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'tab_content_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'tab_content_bg',
		'selector' => '{{WRAPPER}} .wkit-tab-content',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'tab_content_border',
		'selector' => '{{WRAPPER}} .wkit-tab-content',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'tab_content_shadow',
		'selector' => '{{WRAPPER}} .wkit-tab-content',
	)
);

$this->add_responsive_control(
	'tab_content_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'tab_content_typography',
		'selector' => '{{WRAPPER}} .wkit-tab-panel',
	)
);

$this->add_control(
	'tab_content_text_color',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tab-panel' => 'color: {{VALUE}};',
		),
	)
);

$this->end_controls_section();
