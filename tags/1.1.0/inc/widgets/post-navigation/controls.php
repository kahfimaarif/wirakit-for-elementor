<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Control for Post Navigation Elementor Custom Widget
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
        'label' => esc_html__( 'Content', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'show_prev_icon',
    [
        'label'        => esc_html__( 'Show Previous Icon', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => esc_html__( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => esc_html__( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'prev_icon',
    [
        'label'     => esc_html__( 'Previous Icon', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::ICONS,
        'default'   => [
            'value'   => 'fas fa-chevron-left',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_prev_icon' => 'yes',
        ],
    ]
);

$this->add_control(
    'prev_text',
    [
        'label'       => esc_html__( 'Previous Text', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => esc_html__( 'Previous Post', 'wira-kit-for-elementor' ),
        'placeholder' => esc_html__( 'Enter previous text', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'show_next_icon',
    [
        'label'        => esc_html__( 'Show Next Icon', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => esc_html__( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => esc_html__( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'next_icon',
    [
        'label'     => esc_html__( 'Next Icon', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::ICONS,
        'default'   => [
            'value'   => 'fas fa-chevron-right',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_next_icon' => 'yes',
        ],
    ]
);

$this->add_control(
    'next_text',
    [
        'label'       => esc_html__( 'Next Text', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => esc_html__( 'Next Post', 'wira-kit-for-elementor' ),
        'placeholder' => esc_html__( 'Enter next text', 'wira-kit-for-elementor' ),
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_style_wrapper',
    [
        'label' => esc_html__( 'Wrapper', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'wrapper_alignment',
    [
        'label'   => esc_html__( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => esc_html__( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'flex-end' => [
                'title' => esc_html__( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
            'space-between' => [
                'title' => esc_html__( 'Space Between', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-justify',
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .post-navigation' => 'justify-content: {{VALUE}};',
        ],
        'default' => 'space-between',
    ]
);

$this->add_responsive_control(
    'wrapper_spacing',
    [
        'label' => esc_html__( 'Spacing', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .post-navigation .prev-post' => 'margin-right: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .post-navigation .next-post' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_label',
    [
        'label' => esc_html__( 'Label (Previous/Next)', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'label_typography',
        'selector' => '{{WRAPPER}} .post-navigation span',
    ]
);

$this->add_control(
    'label_color',
    [
        'label'     => esc_html__( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .post-navigation span' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_title',
    [
        'label' => esc_html__( 'Post Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'title_typography',
        'selector' => '{{WRAPPER}} .post-navigation strong',
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => esc_html__( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .post-navigation strong' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_hover_color',
    [
        'label'     => esc_html__( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .post-navigation a:hover strong' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_icon',
    [
        'label' => esc_html__( 'Icons', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'icon_size',
    [
        'label'     => esc_html__( 'Size', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'range'     => [
            'px' => [
                'min' => 10,
                'max' => 100,
            ],
        ],
        'default' => [
            'size' => 20,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} .post-navigation svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_gap',
    [
        'label'     => esc_html__( 'Icon Gap', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'range'     => [
            'px' => [
                'min' => 10,
                'max' => 100,
            ],
        ],
        'default' => [
            'size' => 10,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-post-nav-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'icon_color',
    [
        'label'     => esc_html__( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .post-navigation svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'icon_hover_color',
    [
        'label'     => esc_html__( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .post-navigation a:hover svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();



