<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Carousel Elementor Custom Widget
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
    'section_slides',
    [
        'label' => __( 'Slides', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
    'slide_title',
    [
        'label'   => __( 'Title', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Slide Title', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->add_control(
    'blocks_template',
    [
        'label'       => __( 'Blocks Template', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'options'     => $this->get_blocks_templates(),
        'multiple'    => false,
        'label_block' => true,
    ]
);

$this->add_control(
    'slides',
    [
        'label'       => __( 'Carousel Items', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => '{{{ slide_title }}}',
    ]
);

$this->add_responsive_control(
    'slides_per_view',
    [
        'label'   => __( 'Slides on display', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => '1',
        'options' => [
            '1' => __( '1', 'wira-kit-for-elementor' ),
            '2' => __( '2', 'wira-kit-for-elementor' ),
            '3' => __( '3', 'wira-kit-for-elementor' ),
            '4' => __( '4', 'wira-kit-for-elementor' ),
            '5' => __( '5', 'wira-kit-for-elementor' ),
            'default' => __( 'Default', 'wira-kit-for-elementor' ),
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
    ]
);

$this->add_responsive_control(
    'slides_per_group',
    [
        'label'   => __( 'Slides on scroll', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => '1',
        'options' => [
            '1' => __( '1', 'wira-kit-for-elementor' ),
            '2' => __( '2', 'wira-kit-for-elementor' ),
            '3' => __( '3', 'wira-kit-for-elementor' ),
            'default' => __( 'Default', 'wira-kit-for-elementor' ),
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
    ]
);

$this->add_control(
    'equal_height',
    [
        'label'        => __( 'Equal Height', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'On', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'Off', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'carousel_settings',
    [
        'label' => __( 'Settings', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'autoplay',
    [
        'label'        => __( 'Autoplay', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'scroll_speed',
    [
        'label'   => __( 'Scroll Speed (ms)', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::NUMBER,
        'default' => 5000,
    ]
);

$this->add_control(
    'pause_on_hover',
    [
        'label'        => __( 'Pause on hover', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'pause_on_interaction',
    [
        'label'        => __( 'Pause on interaction', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'infinite_scroll',
    [
        'label'        => __( 'Infinite scroll', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'transition_effect',
    [
        'label'   => __( 'Transition Effect', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'slide',
        'options' => [
            'slide'     => __( 'Slide', 'wira-kit-for-elementor' ),
            'fade'      => __( 'Fade', 'wira-kit-for-elementor' ),
            'cube'      => __( 'Cube', 'wira-kit-for-elementor' ),
            'coverflow' => __( 'Coverflow', 'wira-kit-for-elementor' ),
            'flip'      => __( 'Flip', 'wira-kit-for-elementor' ),
            'cards'     => __( 'Cards', 'wira-kit-for-elementor' ),
        ],
    ]
);


$this->add_control(
    'transition_duration',
    [
        'label'   => __( 'Transition Duration (ms)', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::NUMBER,
        'default' => 500,
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_navigation',
    [
        'label' => __( 'Navigation', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_arrows',
    [
        'label'        => __( 'Arrows', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
        'return_value' => 'yes',
    ]
);

$this->add_control(
    'prev_arrow_icon',
    [
        'label'   => __( 'Previous Arrow Icon', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value'   => 'eicon-chevron-left',
            'library' => 'elementor',
        ],
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'prev_arrow_horizontal_position',
    [
        'label' => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'prev_arrow_vertical_position',
    [
        'label' => __( 'Vertical Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-prev' => 'top: calc(50% + {{SIZE}}{{UNIT}});',
        ],
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->add_control(
    'next_arrow_icon',
    [
        'label'   => __( 'Next Arrow Icon', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value'   => 'eicon-chevron-right',
            'library' => 'elementor',
        ],
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'next_arrow_horizontal_position',
    [
        'label' => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'next_arrow_vertical_position',
    [
        'label' => __( 'Vertical Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next' => 'top: calc(50% + {{SIZE}}{{UNIT}});',
        ],
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_pagination',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'pagination_type_slider',
    [
        'label'   => __( 'Pagination', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __( 'None', 'wira-kit-for-elementor' ),
            'dots' => __( 'Dots', 'wira-kit-for-elementor' ),
        ],
        'default' => 'none',
    ]
);


$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'slides_style_section',
    [
        'label' => __( 'Slides', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'gap_between_slides',
    [
        'label' => __( 'Gap between slides', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ],
        ],
        'default' => [
            'size' => 10,
            'unit' => 'px',
        ],
    ]
);

$this->add_responsive_control(
    'slide_padding',
    [
        'label' => __( 'Padding', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'navigation_style_section',
    [
        'label' => __( 'Navigation', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_arrows' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'nav_icon_size',
    [
        'label' => __( 'Size', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-prev i, {{WRAPPER}} .swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'nav_tabs' );

$this->start_controls_tab(
    'nav_tab_normal',
    [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'nav_color',
    [
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name' => 'nav_background',
        'types' => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'nav_border',
        'size_units' => [ 'px', '%' ],
        'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'nav_shadow',
        'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'nav_tab_hover',
    [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'nav_hover_color',
    [
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name' => 'nav_hover_background',
        'types' => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'nav_hover_border',
        'size_units' => [ 'px', '%' ],
        'selector' => '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover',
    ]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_responsive_control(
    'nav_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'nav_padding',
    [
        'label' => __( 'Padding', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'pagination_style_section_slider',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'pagination_type_slider' => 'dots',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_space',
    [
        'label' => __( 'Space Between Dots', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 50 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_size_slider',
    [
        'label' => __( 'Size', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => 4, 'max' => 40 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'pagination_tabs_slider' );

$this->start_controls_tab(
    'pagination_tab_normal_slider',
    [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'pagination_color_slider',
    [
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'pagination_tab_hover_slider',
    [ 'label' => __( 'Hover/Active', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'pagination_hover_color_slider',
    [
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet:hover, {{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_width_active_slider',
    [
        'label' => __( 'Active Dots Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => 4, 'max' => 40 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_control(
    'pagination_custom_position',
    [
        'label' => __( 'Custom Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'wira-kit-for-elementor' ),
        'label_off' => __( 'Hide', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default' => '',
    ]
);

$this->add_responsive_control(
    'pagination_vertical_position',
    [
        'label' => __( 'Vertical Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'top'    => __( 'Top', 'wira-kit-for-elementor' ),
            'bottom' => __( 'Bottom', 'wira-kit-for-elementor' ),
        ],
        'default' => 'bottom',
        'condition' => [
            'pagination_custom_position' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_spacing_slider',
    [
        'label' => __( 'Spacing', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => -200, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination' => '{{pagination_vertical_position.VALUE}}: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'pagination_custom_position' => 'yes',
        ],
    ]
);

$this->add_control(
    'pagination_slider_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .swiper-pagination-bullet, {{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


