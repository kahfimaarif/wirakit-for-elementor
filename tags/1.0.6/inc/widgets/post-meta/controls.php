<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

/**
 * Control For Post Meta Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
    'section_meta_data',
    [
        'label' => __( 'Meta Data', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'meta_icon_position',
    [
        'label' => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'before',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->add_control(
    'meta_data',
    [
        'label'       => __( 'Meta Data', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'multiple'    => true,
        'options'     => [
            'author'   => __( 'Author', 'wira-kit-for-elementor' ),
            'date'     => __( 'Date', 'wira-kit-for-elementor' ),
            'category' => __( 'Category', 'wira-kit-for-elementor' ),
            'comment'  => __( 'Comment', 'wira-kit-for-elementor' ),
        ],
        'default'   => ['date'],
    ]
);

$this->add_control(
    'author_icon',
    [
        'label' => __( 'Author Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-user',
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'author',
        ],
    ]
);

$this->add_control(
    'date_icon',
    [
        'label' => __( 'Date Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-calendar-alt',
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'date',
        ],
    ]
);

$this->add_control(
    'category_icon',
    [
        'label' => __( 'Category Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-folder-open',
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'category',
        ],
    ]
);

$this->add_control(
    'comment_icon',
    [
        'label' => __( 'Comment Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-comments',
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'comment',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_meta',
    [
        'label' => __( 'Meta', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'meta_typography',
        'selector' => '{{WRAPPER}} .wkit-post-meta span',
    ]
);

$this->add_control(
    'meta_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta span' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'meta_color_hover',
    [
        'label'     => __( 'Text Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover .wkit-post-meta span, {{WRAPPER}} .wkit-post-item-overlay:hover .wkit-post-meta span' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'meta_icon_color',
    [
        'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'meta_icon_color_hover',
    [
        'label'     => __( 'Icon Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover .wkit-post-meta i, {{WRAPPER}} .wkit-post-item-overlay:hover .wkit-post-meta i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'meta_gap_spacing',
    [
        'label' => __( 'Spacing', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step'=> 1,
            ],
        ],
        'default' => [ 'size' => 20, 'unit' => 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'meta_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'meta_alignment',
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
            '{{WRAPPER}} .wkit-post-meta' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();


