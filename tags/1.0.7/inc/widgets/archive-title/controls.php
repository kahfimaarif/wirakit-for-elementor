<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Archive Title Custom Widgets
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
        'label' => __( 'Archive Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'heading_tag',
    [
        'label' => __( 'HTML Tag', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'h1',
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
    'enable_link',
    [
        'label'        => __( 'Enable Link', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'heading_link',
    [
        'label'       => __( 'Custom Link', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
        'show_external' => true,
        'condition'   => [
            'enable_link' => 'yes',
            'heading_source' => 'static_text',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_archive_prefix',
    [
        'label' => __( 'Archive Prefix Settings', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'enable_category_prefix',
    [
        'label'        => __( 'Enable Category Prefix', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'category_prefix_text',
    [
        'label'       => __( 'Category Prefix Text', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => __( 'Category: ', 'wira-kit-for-elementor' ),
        'condition'   => [
            'enable_category_prefix' => 'yes',
        ],
    ]
);

$this->add_control(
    'enable_tag_prefix',
    [
        'label'        => __( 'Enable Tag Prefix', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'tag_prefix_text',
    [
        'label'     => __( 'Tag Prefix Text', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'default'   => __( 'Tag: ', 'wira-kit-for-elementor' ),
        'condition' => [
            'enable_tag_prefix' => 'yes',
        ],
    ]
);

$this->add_control(
    'enable_author_prefix',
    [
        'label'        => __( 'Enable Author Prefix', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'author_prefix_text',
    [
        'label'     => __( 'Author Prefix Text', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'default'   => __( 'Author: ', 'wira-kit-for-elementor' ),
        'condition' => [
            'enable_author_prefix' => 'yes',
        ],
    ]
);

$this->add_control(
    'enable_date_prefix',
    [
        'label'        => __( 'Enable Date Prefix', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'date_prefix_text',
    [
        'label'     => __( 'Date Prefix Text', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'default'   => __( 'Archive: ', 'wira-kit-for-elementor' ),
        'condition' => [
            'enable_date_prefix' => 'yes',
        ],
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

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'title_typography',
        'selector' => '{{WRAPPER}} .wkit-dynamic-heading',
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-dynamic-heading' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-dynamic-heading:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'     => 'title_text_shadow',
        'selector' => '{{WRAPPER}} .wkit-dynamic-heading',
    ]
);

$this->add_responsive_control(
    'title_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-dynamic-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


