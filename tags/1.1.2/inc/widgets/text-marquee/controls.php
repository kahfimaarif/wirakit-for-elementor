<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Text Marquee Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
	'text_marquee_content_section',
	array(
		'label' => __( 'Marquee', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
	'item_text',
	array(
		'label'       => __( 'Text', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Wira Kit for Elementor - Widgets & Template Builder System', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'dynamic'     => array( 'active' => true ),
	)
);

$this->add_control(
	'marquee_items',
	array(
		'label'       => __( 'Text Items', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $repeater->get_controls(),
		'default'     => array(
			array( 'item_text' => __( 'Wira Kit for Elementor - Widgets & Template Builder System', 'wira-kit-for-elementor' ) ),
			array( 'item_text' => __( 'Works well with Wira Theme', 'wira-kit-for-elementor' ) ),
			array( 'item_text' => __( 'Elementor Ready Widgets', 'wira-kit-for-elementor' ) ),
		),
		'title_field' => '{{{ item_text }}}',
	)
);

$this->add_control(
	'show_separator',
	array(
		'label'        => __( 'Show Separator', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'separator_type',
	array(
		'label'     => __( 'Separator Type', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SELECT,
		'default'   => 'text',
		'options'   => array(
			'text' => __( 'Text', 'wira-kit-for-elementor' ),
			'icon' => __( 'Icon', 'wira-kit-for-elementor' ),
		),
		'condition' => array(
			'show_separator' => 'yes',
		),
	)
);

$this->add_control(
	'separator_text',
	array(
		'label'     => __( 'Separator Text', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => '*',
		'condition' => array(
			'show_separator' => 'yes',
			'separator_type' => 'text',
		),
	)
);

$this->add_control(
	'separator_icon',
	array(
		'label'            => __( 'Separator Icon', 'wira-kit-for-elementor' ),
		'type'             => \Elementor\Controls_Manager::ICONS,
		'fa4compatibility' => 'icon',
		'default'          => array(
			'value'   => 'fas fa-circle',
			'library' => 'fa-solid',
		),
		'condition'        => array(
			'show_separator' => 'yes',
			'separator_type' => 'icon',
		),
	)
);

$this->add_control(
	'marquee_direction',
	array(
		'label'   => __( 'Direction', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'left',
		'options' => array(
			'left'  => __( 'Left', 'wira-kit-for-elementor' ),
			'right' => __( 'Right', 'wira-kit-for-elementor' ),
		),
	)
);

$this->add_control(
	'pause_on_hover',
	array(
		'label'        => __( 'Pause On Hover', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_responsive_control(
	'marquee_duration',
	array(
		'label'      => __( 'Animation Duration (s)', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array(
				'min' => 5,
				'max' => 120,
			),
		),
		'default'    => array(
			'size' => 30,
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee-track' => 'animation-duration: {{SIZE}}s;',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'text_marquee_wrapper_style_section',
	array(
		'label' => __( 'Wrapper', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'marquee_wrapper_height',
	array(
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'vh' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 400 ),
			'vh' => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee' => 'min-height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'marquee_wrapper_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'marquee_wrapper_tabs' );

$this->start_controls_tab(
	'marquee_wrapper_normal_tab',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'marquee_wrapper_background',
		'selector' => '{{WRAPPER}} .wkit-text-marquee',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'marquee_wrapper_border',
		'selector' => '{{WRAPPER}} .wkit-text-marquee',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'marquee_wrapper_shadow',
		'selector' => '{{WRAPPER}} .wkit-text-marquee',
	)
);

$this->add_responsive_control(
	'marquee_wrapper_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'marquee_wrapper_hover_tab',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'marquee_wrapper_background_hover',
		'selector' => '{{WRAPPER}} .wkit-text-marquee:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'marquee_wrapper_border_hover',
		'selector' => '{{WRAPPER}} .wkit-text-marquee:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'marquee_wrapper_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-text-marquee:hover',
	)
);

$this->add_responsive_control(
	'marquee_wrapper_radius_hover',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'marquee_wrapper_transition',
	array(
		'label'     => __( 'Transition Duration (s)', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		),
		'default'   => array(
			'size' => 0.3,
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-text-marquee' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->end_controls_section();

$this->start_controls_section(
	'text_marquee_item_style_section',
	array(
		'label' => __( 'Item', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'item_gap',
	array(
		'label' => __( 'Item Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'default' => array(
			'size' => 36,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-text-marquee-track' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'item_padding',
	array(
		'label'      => __( 'Item Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'item_style_tabs' );

$this->start_controls_tab(
	'item_style_normal_tab',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'item_typography',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item',
	)
);

$this->add_control(
	'item_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-text-marquee-item' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'item_background',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'item_border',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'item_shadow',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item',
	)
);

$this->add_responsive_control(
	'item_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'item_style_hover_tab',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'item_color_hover',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-text-marquee-item:hover' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'item_background_hover',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'item_border_hover',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'item_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-text-marquee-item:hover',
	)
);

$this->add_responsive_control(
	'item_radius_hover',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'item_transition',
	array(
		'label'     => __( 'Transition Duration (s)', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		),
		'default'   => array(
			'size' => 0.3,
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-text-marquee-item' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->end_controls_section();

$this->start_controls_section(
	'text_marquee_separator_style_section',
	array(
		'label' => __( 'Separator', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => array(
			'show_separator' => 'yes',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'      => 'separator_typography',
		'selector'  => '{{WRAPPER}} .wkit-text-marquee-separator',
		'condition' => array(
			'separator_type' => 'text',
		),
	)
);

$this->add_control(
	'separator_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-text-marquee-separator' => 'color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'separator_icon_size',
	array(
		'label'      => __( 'Icon Size', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-text-marquee-separator i' => 'font-size: {{SIZE}}{{UNIT}};',
		),
		'condition'  => array(
			'separator_type' => 'icon',
		),
	)
);

$this->end_controls_section();




