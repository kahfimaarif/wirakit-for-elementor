<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Post Excerpt Custom Widgets
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
        'label' => __( 'Content Excerpt', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'excerpt_length',
    [
        'label' => __( 'Excerpt Length', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 12,
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_style',
    [
        'label' => __( 'Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'alignment',
    [
        'label' => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::CHOOSE,
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
            'justify'  => [
                'title' => __( 'Justify', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-justify',
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-post-excerpt' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'typography',
        'selector' => '{{WRAPPER}} .wkit-post-excerpt',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name' => 'text_shadow',
        'selector' => '{{WRAPPER}} .wkit-post-excerpt',
    ]
);

$this->add_responsive_control(
    'paragraph_spacing',
    [
        'label' => __( 'Paragraph Spacing', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-excerpt p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'text_color',
    [
        'label' => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-excerpt' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();


