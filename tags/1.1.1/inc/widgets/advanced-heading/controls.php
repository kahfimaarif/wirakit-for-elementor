<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Advanced Heading Elementor Custom Widget
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
        'label' => __( 'Content', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'heading_tag',
    [
        'label' => __( 'HTML Tag', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'h2',
        'options' => [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'p'    => 'Paragraph',
            'span' => 'Span',
        ],
    ]
);

$this->add_control(
    'heading_before',
    [
        'label' => __( 'Text Before Animated', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Text Before Animated', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter text before the animated part', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'heading_featured',
    [
        'label' => __( 'Animated Text', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => __( 'Enter animated text (optional)', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'heading_after',
    [
        'label' => __( 'Text After Animated', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => __( 'Enter text after the animated part', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_general_style',
    [
        'label' => __( 'General', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'left'   => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'right'  => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
            'justify' => [
                'title' => __( 'Justify', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-justify',
            ],
        ],
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}}' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_title_style',
    [
        'label' => __( 'Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-advanced-heading' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-advanced-heading:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'     => 'title_text_shadow',
        'selector' => '{{WRAPPER}} .wkit-advanced-heading',
    ]
);

$this->add_responsive_control(
    'title_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-advanced-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'title_typography',
        'selector' => '{{WRAPPER}} .wkit-advanced-heading',
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_focused_title_style',
    [
        'label' => __( 'Animated Text', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'focused_title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'focused_title_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'focused_title_background_text',
        'label'    => __( 'Background Type', 'wira-kit-for-elementor' ),
        'types'    => [ 'classic', 'gradient'],
        'selector' => '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'focused_title_typography',
        'selector' => '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'     => 'focused_title_text_shadow',
        'selector' => '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text',
    ]
);

$this->add_responsive_control(
    'focused_title_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'focused_title_text_fill',
    [
        'label'        => __( 'Use Text Fill', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'no',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'focused_title_background',
        'label'    => __( 'Background Type', 'wira-kit-for-elementor' ),
        'types'    => [ 'classic', 'gradient'],
        'selector' => '{{WRAPPER}} .wkit-advanced-heading .wkit-animated-text',
        'condition' => [
            'focused_title_text_fill' => 'yes',
        ],
    ]
);

$this->end_controls_section();


