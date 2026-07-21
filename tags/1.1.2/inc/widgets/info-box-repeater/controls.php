<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Info Box Repeater Elementor Custom Widget
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
    'section_service_item',
    [
        'label' => __( 'Info Box Item', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
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

$repeater->add_control(
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

$repeater->add_control(
    'show_service_icon',
    [
        'label'        => __( 'Show Info Box Icon', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$repeater->add_control(
    'service_icon',
    [
        'label'     => esc_html__( 'Info Box Icon', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::ICONS,
        'default'   => [
            'value'   => 'fas fa-check-circle',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_service_icon' => 'yes',
        ],
    ]
);

$repeater->add_control(
    'service_title',
    [
        'label'   => __( 'Title', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Info Box Item Title', 'wira-kit-for-elementor' ),
        'label_block' => true,
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->add_control(
    'service_content_excerpt',
    [
        'label'   => __( 'Info Box Content', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXTAREA,
        'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'wira-kit-for-elementor' ),
        'label_block' => true,
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->add_control(
    'service_button_link',
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
    'services',
    [
        'label'       => __( 'Info Box Items', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => '{{{ service_title }}}',
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_layout',
    [
        'label' => __( 'Layout', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
            '{{WRAPPER}} .wkit-info-box-repeater' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
        ],
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
            '{{WRAPPER}} .wkit-info-box-repeater-item' => 'flex-direction: {{VALUE}};',
        ],
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
            'show_learnmore' => 'yes',
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
            'show_learnmore' => 'yes',
            'learnmore_icon[value]!' => '',
        ],
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
            '{{WRAPPER}} .wkit-info-box-repeater' => 'column-gap: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .wkit-info-box-repeater' => 'row-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_service',
    [
        'label' => __( 'Container Item', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->start_controls_tabs( 'service_item_style_tabs' );

$this->start_controls_tab(
    'service_item_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'service_box_background',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'service_box_border',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'service_box_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'service_item_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'service_box_background_hover',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'service_box_border_hover',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'service_box_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover',
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
            '{{WRAPPER}} .wkit-info-box-repeater-item, {{WRAPPER}} .wkit-info-box-repeater-item h4, {{WRAPPER}} .wkit-info-box-repeater-item p, {{WRAPPER}} .wkit-info-box-repeater-item .info-box-repeater-icon, {{WRAPPER}} .wkit-info-box-repeater-item i, {{WRAPPER}} .wkit-info-box-repeater-item-wrapper, {{WRAPPER}} .wkit-info-box-repeater-content-wrapper' => 'transition: all {{SIZE}}s ease-in-out;',
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
    'service_box_padding',
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
            '{{WRAPPER}} .wkit-info-box-repeater-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'service_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_content_wrapper',
    [
        'label' => __( 'Container Wrapper', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->start_controls_tabs( 'service_item_wrapper_style_tabs' );

$this->start_controls_tab(
    'service_item_wrapper_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'service_box_wrapper_background',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'service_box_wrapper_border',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'service_box_wrapper_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'service_item_wrapper_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'service_box_wrapper_background_hover',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .wkit-info-box-repeater-content-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'service_box_wrapper_border_hover',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'service_box_wrapper_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper:hover',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'service_box_wrapper_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'default'    => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 0,
            'left'   => 0,
            'unit'   => 'px',
        ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'service_wrapper_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-info-box-repeater-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_background_image',
    [
        'label' => __( 'Background Image', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper' => 'background-size: {{VALUE}};',
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
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper' => 'background-position: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_icon',
    [
        'label' => __( 'Icon Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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
            '{{WRAPPER}} .info-box-repeater-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .info-box-repeater-icon' => 'text-align: {{VALUE}};',
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
            '{{WRAPPER}} .info-box-repeater-icon-wrapper' => 'justify-content: {{VALUE}};',
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
            '{{WRAPPER}} .info-box-repeater-icon-wrapper' => 'align-items: {{VALUE}};',
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
            '{{WRAPPER}} .info-box-repeater-icon' => 'width: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .info-box-repeater-icon' => 'height: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .info-box-repeater-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'service_icon_style_tabs' );

$this->start_controls_tab(
    'service_icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'service_icon_background',
        'selector' => '{{WRAPPER}} .info-box-repeater-icon',
    ]
);

$this->add_control(
    'icon_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .info-box-repeater-icon i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'service_icon_border',
        'selector' => '{{WRAPPER}} .info-box-repeater-icon',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'service_icon_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .info-box-repeater-icon',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'service_icon_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'service_icon_background_hover',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .info-box-repeater-icon',
    ]
);

$this->add_control(
    'icon_hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .info-box-repeater-icon i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'service_icon_border_hover',
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .info-box-repeater-icon',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'service_icon_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .info-box-repeater-icon',
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
            '{{WRAPPER}} .info-box-repeater-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            '{{WRAPPER}} .info-box-repeater-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        'selector' => '{{WRAPPER}} .info-box-repeater-title',
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
            '{{WRAPPER}} .info-box-repeater-title' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .info-box-repeater-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .info-box-repeater-title' => 'color: {{VALUE}};',
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
            '{{WRAPPER}} .info-box-repeater-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-item .info-box-repeater-excerpt',
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
            '{{WRAPPER}} .info-box-repeater-excerpt' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'excerpt_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-info-box-repeater-item .info-box-repeater-excerpt' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'excerpt_color_hover',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .info-box-repeater-excerpt' => 'color: {{VALUE}};',
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
            '{{WRAPPER}} .wkit-info-box-repeater-item .info-box-repeater-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        'selector' => '{{WRAPPER}} .wkit-info-box-repeater-learnmore',
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
            '{{WRAPPER}} .wkit-info-box-repeater-learnmore' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'learnmore_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-info-box-repeater-item-wrapper:hover .wkit-info-box-repeater-learnmore' => 'color: {{VALUE}};',
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
            '{{WRAPPER}} .wkit-info-box-repeater-learnmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'enable_slider' => 'yes',
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
