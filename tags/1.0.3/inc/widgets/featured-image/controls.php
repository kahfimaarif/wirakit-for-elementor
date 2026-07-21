<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Featured Image Elementor Custom Widget
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
    'enable_link',
    [
        'label'        => __( 'Enable Link', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Image_Size::get_type(),
    [
        'name'    => 'thumbnail',
        'default' => 'large',
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_style_image',
    [
        'label' => __( 'Image', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'image_align',
    [
        'label'     => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::CHOOSE,
        'options'   => [
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
        'selectors' => [
            '{{WRAPPER}} .wkit-featured-image' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-featured-image img' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_max_width',
    [
        'label' => __( 'Max Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-featured-image img' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'vh', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-featured-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
        ],
    ]
);

$this->add_control(
    'image_opacity',
    [
        'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0.1,
                'max' => 1,
                'step'=> 0.01,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-featured-image img' => 'opacity: {{SIZE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Css_Filter::get_type(),
    [
        'name'     => 'css_filters',
        'selector' => '{{WRAPPER}} .wkit-featured-image img',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'image_border',
        'selector' => '{{WRAPPER}} .wkit-featured-image img',
    ]
);

$this->add_responsive_control(
    'image_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-featured-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'image_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-featured-image img',
    ]
);


