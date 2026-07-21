<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Content Dynamic Custom Widgets
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
    'content_section',
    [
        'label' => __( 'Content Style', 'wira-kit-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_responsive_control(
    'alignment',
    [
        'label' => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-text-align-right',
            ],
        ],
        'default' => 'left',
        'selectors' => [
            '{{WRAPPER}} .wkit-content-widget' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'typography',
        'selector' => '{{WRAPPER}} .wkit-content-widget p',
    ]
);

$this->add_control(
    'text_color',
    [
        'label' => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#6e6e6e',
        'selectors' => [
            '{{WRAPPER}} .wkit-content-widget' => 'color: {{VALUE}}',
        ],
    ]
);

$this->add_control(
    'link_color',
    [
        'label' => __( 'Link Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-content-widget a' => 'color: {{VALUE}}',
        ],
    ]
);

$this->add_control(
    'link_hover_color',
    [
        'label' => __( 'Link Hover Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-content-widget a:hover' => 'color: {{VALUE}}',
        ],
    ]
);

$this->add_responsive_control(
    'paragraph_spacing',
    [
        'label' => __( 'Paragraph Spacing', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-content-widget p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


