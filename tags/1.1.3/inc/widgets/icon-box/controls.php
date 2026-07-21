<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Icon Box Elementor Custom Widget
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
    'section_icon_box_item',
    [
        'label' => __( 'Icon Box Item', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_background_image',
    [
        'label'        => __( 'Show Background Image', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'background_image',
    [
        'label' => __( 'Background Image', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'condition' => [
            'show_background_image' => 'yes',
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'show_icon_box_icon',
    [
        'label'        => __( 'Show Icon', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_responsive_control(
    'icon_type',
    [
        'label'   => __( 'Icon Type', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'icon' => [
                'title' => __( 'Icon', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-icon',
            ],
            'image' => [
                'title' => __( 'Image', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-image',
            ],
        ],
        'default'   => 'icon',
        'condition' => [
            'show_icon_box_icon' => 'yes',
        ],
    ]
);

$this->add_control(
    'icon_box_icon',
    [
        'label'     => esc_html__( 'Icon', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::ICONS,
        'default'   => [
            'value'   => 'fas fa-check-circle',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_icon_box_icon' => 'yes',
            'icon_type' => 'icon',
        ],
    ]
);

$this->add_control(
    'icon_image',
    [
        'label' => __( 'Image', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'condition' => [
            'show_icon_box_icon' => 'yes',
            'icon_type' => 'image',
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_responsive_control(
    'icon_position_box',
    [
        'label'   => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'column',
        'options' => [
            'column'  => __( 'Top', 'wira-kit-for-elementor' ),
            'row'  => __( 'Left', 'wira-kit-for-elementor' ),
            'row-reverse'  => __( 'Right', 'wira-kit-for-elementor' ),
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-icon-box-item' => 'flex-direction: {{VALUE}};',
        ],
        'condition' => [
            'show_icon_box_icon' => 'yes',
        ],
    ]
);

$this->add_control(
    'icon_box_title',
    [
        'label'   => __( 'Title', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Icon Box Item Title', 'wira-kit-for-elementor' ),
        'label_block' => true,
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'icon_box_content_excerpt',
    [
        'label'   => __( 'Icon Box Content', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXTAREA,
        'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'wira-kit-for-elementor' ),
        'label_block' => true,
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'icon_box_button_link',
    [
        'label' => __( 'Learn More Link', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( '#', 'wira-kit-for-elementor' ),
        'default' => [
            'url' => '#',
            'is_external' => false,
            'nofollow' => false,
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'show_learnmore',
    [
        'label'        => __( 'Show Button', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'learnmore_text',
    [
        'label' => __( 'Text', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Learn More', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter learn more text', 'wira-kit-for-elementor' ),
        'label_block' => true,
        'condition' => [
            'show_learnmore' => 'yes',
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'learnmore_icon',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default' => [
            'value' => '',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_learnmore' => 'yes',
        ],
    ]
);

$this->add_control(
    'icon_position',
    [
        'label' => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'after',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'learnmore_icon[value]!' => '',
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
            '{{WRAPPER}} .learnmore-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'learnmore_icon[value]!' => '',
        ],
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_style_icon-box',
    [
        'label' => __( 'Container Item', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->start_controls_tabs( 'icon_box_item_style_tabs' );

$this->start_controls_tab(
    'icon_box_item_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_box_box_background',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_box_box_border',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_box_box_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'icon_box_item_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_box_box_background_hover',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_box_box_border_hover',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_box_box_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover',
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
            '{{WRAPPER}} .wkit-icon-box-item, {{WRAPPER}} .wkit-icon-box-item h4, {{WRAPPER}} .wkit-icon-box-item p, {{WRAPPER}} .wkit-icon-box-item .icon-box-icon, {{WRAPPER}} .wkit-icon-box-item i, {{WRAPPER}} .wkit-icon-box-item-wrapper' => 'transition: all {{SIZE}}s ease-in-out;',
        ],
    ]
);

$this->add_control(
    'hover_animation_container',
    [
        'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'icon_box_box_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'default'    => [
            'top'    => 35,
            'right'  => 35,
            'bottom' => 35,
            'left'   => 35,
            'unit'   => 'px',
        ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-icon-box-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_box_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_background_image',
    [
        'label' => __( 'Background Image', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_background_image' => 'yes',
        ],
    ]
);

$this->add_control(
    'background_size',
    [
        'label'   => __( 'Background Size', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'cover'     => __( 'Cover', 'wira-kit-for-elementor' ),
            'contain'   => __( 'Contain', 'wira-kit-for-elementor' ),
            'auto'      => __( 'Auto', 'wira-kit-for-elementor' ),
        ],
        'default' => 'cover',
        'selectors'  => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper' => 'background-size: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'background_position',
    [
        'label'   => __( 'Background Position', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'center center'     => __( 'Center Center', 'wira-kit-for-elementor' ),
            'center left'       => __( 'Center Left', 'wira-kit-for-elementor' ),
            'center right'      => __( 'Center Right', 'wira-kit-for-elementor' ),
            'top center'        => __( 'Top Center', 'wira-kit-for-elementor' ),
            'top left'          => __( 'Top Left', 'wira-kit-for-elementor' ),
            'top right'         => __( 'Top Right', 'wira-kit-for-elementor' ),
            'bottom center'     => __( 'Bottom Center', 'wira-kit-for-elementor' ),
            'bottom left'       => __( 'Bottom Left', 'wira-kit-for-elementor' ),
            'bottom right'      => __( 'Bottom Right', 'wira-kit-for-elementor' ),
        ],
        'default' => 'center center',
        'selectors'  => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper' => 'background-position: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_icon_image',
    [
        'label' => __( 'Icon Image', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_icon_box_icon' => 'yes',
            'icon_type' => 'image',
        ],
    ]
);

$this->add_responsive_control(
    'icon_image_alignment',
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
            '{{WRAPPER}} .icon-box-icon-wrapper' => 'justify-content: {{VALUE}};',
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
            '{{WRAPPER}} .icon-box-icon-wrapper img.icon-box-image' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'vh' ],
        'selectors' => [
            '{{WRAPPER}} .icon-box-icon-wrapper img.icon-box-image' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
        ],
    ]
);

$this->add_control(
    'image_size',
    [
        'label'   => __( 'Image Size', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'cover'     => __( 'Cover', 'wira-kit-for-elementor' ),
            'contain'   => __( 'Contain', 'wira-kit-for-elementor' ),
            'auto'      => __( 'Auto', 'wira-kit-for-elementor' ),
        ],
        'default' => 'auto',
        'selectors'  => [
            '{{WRAPPER}} .icon-box-icon-wrapper img.icon-box-image' => 'object-fit: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .icon-box-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'image_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .icon-box-icon-wrapper img.icon-box-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'show_icon_box_icon' => 'yes',
            'icon_type' => 'icon',
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
            '{{WRAPPER}} .icon-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
        ]
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
            '{{WRAPPER}} .icon-box-icon' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_horizontal_alignment',
    [
        'label'   => __( 'Icon Horizontal Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'start',
        'options' => [
            'start'  => __( 'Left', 'wira-kit-for-elementor' ),
            'center'  => __( 'Center', 'wira-kit-for-elementor' ),
            'end'  => __( 'Right', 'wira-kit-for-elementor' ),
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-box-icon-wrapper' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_vertical_alignment',
    [
        'label'   => __( 'Icon Vertical Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'flex-start',
        'options' => [
            'flex-start'  => __( 'Top', 'wira-kit-for-elementor' ),
            'center'  => __( 'Center', 'wira-kit-for-elementor' ),
            'flex-end'  => __( 'Bottom', 'wira-kit-for-elementor' ),
        ],
        'selectors' => [
            '{{WRAPPER}} .icon-box-icon-wrapper' => 'align-items: {{VALUE}};',
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
            '{{WRAPPER}} .icon-box-icon' => 'width: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .icon-box-icon' => 'height: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .icon-box-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'icon_box_icon_style_tabs' );

$this->start_controls_tab(
    'icon_box_icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_box_icon_background',
        'selector' => '{{WRAPPER}} .icon-box-icon',
    ]
);

$this->add_control(
    'icon_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .icon-box-icon i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_box_icon_border',
        'selector' => '{{WRAPPER}} .icon-box-icon',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_box_icon_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .icon-box-icon',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'icon_box_icon_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_box_icon_background_hover',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .icon-box-icon',
    ]
);

$this->add_control(
    'icon_hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .icon-box-icon i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_box_icon_border_hover',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .icon-box-icon',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_box_icon_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .icon-box-icon',
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
            '{{WRAPPER}} .icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .icon-box-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_title',
    [
        'label' => __( 'Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'title_typography',
        'selector' => '{{WRAPPER}} .icon-box-title',
    ]
);

$this->add_responsive_control(
    'title_alignment',
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
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .icon-box-title' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .icon-box-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .icon-box-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'title_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .icon-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_excerpt',
    [
        'label' => __( 'Excerpt', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'excerpt_typography',
        'selector' => '{{WRAPPER}} .wkit-icon-box-item .icon-box-excerpt',
    ]
);

$this->add_responsive_control(
    'excerpt_alignment',
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
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .icon-box-excerpt' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'excerpt_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-icon-box-item .icon-box-excerpt' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'excerpt_color_hover',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .icon-box-excerpt' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'excerpt_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-icon-box-item .icon-box-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_learnmore',
    [
        'label' => __( 'Learn More', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_learnmore' => 'yes',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'learnmore_typography',
        'selector' => '{{WRAPPER}} .wkit-learnmore',
    ]
);

$this->add_responsive_control(
    'learnmore_alignment',
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
            '{{WRAPPER}} .learnmore-wrapper' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'learnmore_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-learnmore' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'learnmore_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-icon-box-item-wrapper:hover .wkit-learnmore' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'read_more_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-learnmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'hover_animation_learnmore',
    [
        'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);

$this->end_controls_section();


