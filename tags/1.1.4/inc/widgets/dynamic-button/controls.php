<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Dynamic Button Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// === Content Tab ===
$this->start_controls_section(
    'section_content',
    [
        'label' => __( 'Button', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'button_trigger_type',
    [
        'label' => __( 'Button Type', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'button',
        'options' => [
            'button' => __( 'Button', 'wira-kit-for-elementor' ),
            'icon'   => __( 'Icon Only', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->add_control(
    'button_text',
    [
        'label' => __( 'Text', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Click here', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter button text', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
        'condition' => [
            'button_trigger_type' => 'button',
        ],
    ]
);

$this->add_control(
    'button_icon',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default' => [
            'value' => '',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'icon_position',
    [
        'label' => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'before',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'button_trigger_type' => 'button',
            'button_icon[value]!' => '',
        ],
    ]
);

$this->add_responsive_control(
    'icon_spacing',
    [
        'label' => __( 'Icon Spacing', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 8,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 50,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-btn-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'button_trigger_type' => 'button',
            'button_icon[value]!' => '',
        ],
    ]
);

$this->add_control(
    'button_id',
    [
        'label' => __( 'Button ID', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => __( 'unique-button-id', 'wira-kit-for-elementor' ),
        'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page. This field allows A-z 0-9 & underscore chars without spaces.', 'wira-kit-for-elementor' ),
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'button_style_section',
    [
        'label' => __( 'Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'button_trigger_type' => 'button',
        ],
    ]
);

$this->add_responsive_control(
    'button_alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'flex-end' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
        ],
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .wkit-button-wrapper' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'button_typography',
        'selector' => '{{WRAPPER}} .wkit-btn-text',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'     => 'button_text_shadow',
        'selector' => '{{WRAPPER}} .wkit-btn-text',
    ]
);

$this->start_controls_tabs('button_tabs_style');

$this->start_controls_tab(
    'button_tab_normal',
    [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'button_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-btn' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_background',
        'selector' => '{{WRAPPER}} .wkit-btn',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border',
        'selector' => '{{WRAPPER}} .wkit-btn',
    ]
);

$this->add_responsive_control(
    'button_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-btn , {{WRAPPER}} .wkit-btn::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-btn',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'button_tab_hover',
    [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'button_hover_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-btn:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_hover_background',
        'selector' => '{{WRAPPER}} .wkit-btn::before',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_hover_border',
        'selector' => '{{WRAPPER}} .wkit-btn:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_hover_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-btn:hover',
    ]
);

$this->add_control(
        'hover_animation',
        [
            'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
        ]
    );

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'button_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'button_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range' => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 500 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-btn' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_icon',
    [
        'label' => __( 'Icon Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'button_trigger_type' => 'icon',
        ],
    ]
);

$this->add_responsive_control(
    'icon_size',
    [
        'label' => __( 'Icon Size', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 35,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 200,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-button i' => 'font-size: {{SIZE}}{{UNIT}};',
        ]
    ]
);

$this->add_responsive_control(
    'icon_button_alignment',
    [
        'label'   => __( 'Icon Button Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'flex-end' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
        ],
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .wkit-button-wrapper' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
        ],
        'default'   => 'center',
        'selectors' => [
            '{{WRAPPER}} .icon-button' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-button' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-button' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_line_height',
    [
        'label' => __( 'Line Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-button i' => 'line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'icon_style_tabs' );

$this->start_controls_tab(
    'icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_background',
        'selector' => '{{WRAPPER}} .icon-button',
    ]
);

$this->add_control(
    'icon_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .icon-button i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_border',
        'selector' => '{{WRAPPER}} .icon-button',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .icon-button',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'icon_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_background_hover',
        'selector' => '{{WRAPPER}} .icon-button:hover',
    ]
);

$this->add_control(
    'icon_hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .icon-button:hover i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_border_hover',
        'selector' => '{{WRAPPER}} .icon-button:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .icon-button:hover',
    ]
);

$this->add_control(
    'bg_transition_duration',
    [
        'label' => __( 'Transition Duration', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min'  => 0,
                'max'  => 3,
                'step' => 0.01,
            ],
        ],
        'default' => [
            'size' => 0.3,
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-button' => 'transition: all {{SIZE}}s ease-in-out;',
        ],
    ]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_responsive_control(
    'icon_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .icon-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .icon-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


