<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Loop Custom Widgets
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
    'section_query',
    [
        'label' => __( 'Query', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'loop_template',
    [
        'label'   => __( 'Loop Template', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT2,
        'options' => $this->get_loop_templates(),
        'multiple'=> false,
        'label_block' => true,
    ]
);


$post_types = get_post_types(
    [
        'public' => true,
    ], 
    'objects'
);

$options = [];
if ( $post_types ) {
    foreach ( $post_types as $pt ) {
        $options[ $pt->name ] = $pt->labels->singular_name;
    }
}

$this->add_control(
    'post_type',
    [
        'label'   => __( 'Post Type', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT2,
        'options' => $options,
        'default' => 'post',
    ]
);

$this->add_responsive_control(
    'columns',
    [
        'label' => __( 'Columns', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 6,
        'step' => 1,
        'default' => 2,
        'selectors' => [
            '{{WRAPPER}} .wkit-loop' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
        ],
    ]
);



$this->add_control(
    'posts_per_page',
    [
        'label'   => __( 'Posts Per Page', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::NUMBER,
        'default' => 6,
        'min'     => -1, // -1 = unlimited
        'step'    => 1,
    ]
);

$this->add_control(
    'orderby',
    [
        'label' => __( 'Order By', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'post_date',
        'options' => [
            'post_date'     => __( 'Date', 'wira-kit-for-elementor' ),
            'post_title'    => __( 'Title', 'wira-kit-for-elementor' ),
            'menu_order'    => __( 'Menu Order', 'wira-kit-for-elementor' ),
            'modified'      => __( 'Last Modified', 'wira-kit-for-elementor' ),
            'comment_count' => __( 'Comment Count', 'wira-kit-for-elementor' ),
            'rand'          => __( 'Random', 'wira-kit-for-elementor' ),
        ],
        'description' => __( 'Select how to order posts.', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'order',
    [
        'label'   => __( 'Order', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'ASC'  => __( 'Ascending', 'wira-kit-for-elementor' ),
            'DESC' => __( 'Descending', 'wira-kit-for-elementor' ),
        ],
        'default' => 'DESC',
    ]
);

$this->add_control(
    'include_posts',
    [
        'label'       => __( 'Include Posts (IDs)', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'description' => __( 'Comma separated post IDs', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'exclude_posts',
    [
        'label'       => __( 'Exclude Posts (IDs)', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'description' => __( 'Comma separated post IDs', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'enable_slider',
    [
        'label'        => __( 'Enable Slider', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'enable_marquee_style',
    [
        'label'        => __( 'Enable Marquee Style', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
        'condition'    => [
            'enable_slider' => 'yes',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_pagination_loop',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        'condition' => [
            'enable_slider!' => 'yes',
        ],
    ]
);

$this->add_control(
    'pagination_type',
    [
        'label'       => __( 'Pagination Type', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT,
        'default'     => '',
        'options'     => [
            ''                => __( 'None', 'wira-kit-for-elementor' ),
            'ajax_load_more'  => __( 'Ajax Load More', 'wira-kit-for-elementor' ),
            'infinite_scroll' => __( 'Infinite Scroll', 'wira-kit-for-elementor' ),
        ],
        'description' => __( 'Select the pagination type for the loop.', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'load_more_text',
    [
        'label'     => __( 'Button Text', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'default'   => __( 'Load More', 'wira-kit-for-elementor' ),
        'condition' => [
            'pagination_type!' => '',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'carousel_settings',
    [
        'label' => __( 'Slider Settings', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        'condition' => [
            'enable_slider' => 'yes',
        ],
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
    'marquee_settings',
    [
        'label'     => __( 'Marquee Settings', 'wira-kit-for-elementor' ),
        'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
        'condition' => [
            'enable_slider'        => 'yes',
            'enable_marquee_style' => 'yes',
        ],
    ]
);

$this->add_control(
    'marquee_scroll_axis',
    [
        'label'   => __( 'Scroll Axis', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'horizontal',
        'options' => [
            'horizontal' => __( 'Horizontal Scroll', 'wira-kit-for-elementor' ),
            'vertical'   => __( 'Vertical Scroll', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->add_control(
    'marquee_direction_horizontal',
    [
        'label'     => __( 'Direction', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'left',
        'options'   => [
            'left'  => __( 'Left', 'wira-kit-for-elementor' ),
            'right' => __( 'Right', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'marquee_scroll_axis' => 'horizontal',
        ],
    ]
);

$this->add_control(
    'marquee_direction_vertical',
    [
        'label'     => __( 'Direction', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'up',
        'options'   => [
            'up'   => __( 'Up', 'wira-kit-for-elementor' ),
            'down' => __( 'Down', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'marquee_scroll_axis' => 'vertical',
        ],
    ]
);

$this->add_control(
    'marquee_pause_on_hover',
    [
        'label'        => __( 'Pause On Hover', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_responsive_control(
    'marquee_duration',
    [
        'label'      => __( 'Animation Duration (s)', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range'      => [
            'px' => [
                'min' => 5,
                'max' => 120,
            ],
        ],
        'default'    => [
            'size' => 30,
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_navigation',
    [
        'label' => __( 'Navigation', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        'condition' => [
            'enable_slider' => 'yes',
        ],
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
        'condition' => [
            'enable_slider' => 'yes',
        ],
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
    'pagination_style_section',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'pagination_type!' => '',
            'enable_slider!'   => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center'     => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'flex-end'   => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
        ],
        'default'  => 'center',
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'pagination_typography',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->start_controls_tabs( 'pagination_tabs' );

$this->start_controls_tab(
    'pagination_tab_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'pagination_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_bg',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'pagination_border',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'pagination_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'pagination_tab_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'pagination_text_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_bg_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'pagination_border_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'pagination_box_shadow_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'pagination_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'slides_style_section',
    [
        'label' => __( 'Slides', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'enable_slider' => 'yes',
        ],
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
    'section_style_loop',
    [
        'label' => __( 'Loop Layout', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'enable_slider!' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'column_gap',
    [
        'label' => __( 'Column Gap', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%', 'em' ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 100 ],
            '%'  => [ 'min' => 0, 'max' => 100 ],
            'em' => [ 'min' => 0, 'max' => 10 ],
        ],
        'default' => [ 'size' => 20, 'unit' => 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-loop' => 'column-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'row_gap',
    [
        'label' => __( 'Row Gap', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%', 'em' ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 100 ],
            '%'  => [ 'min' => 0, 'max' => 100 ],
            'em' => [ 'min' => 0, 'max' => 10 ],
        ],
        'default' => [ 'size' => 20, 'unit' => 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-loop' => 'row-gap: {{SIZE}}{{UNIT}};',
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
            'enable_slider' => 'yes',
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
