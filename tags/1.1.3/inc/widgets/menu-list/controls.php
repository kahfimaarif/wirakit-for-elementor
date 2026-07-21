<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Menu List Elementor Custom Widget
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
    'section_title',
    [
        'label' => __( 'Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_title',
    [
        'label'        => __( 'Show Title', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'menu_list_title',
    [
        'label'     => __( 'Title Text', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'default'   => __( 'Menu List Title', 'wira-kit-for-elementor' ),
        'condition' => [
            'show_title' => 'yes',
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_menu_list',
    [
        'label' => __( 'Menu Items', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
    'item_icon',
    [
        'label'   => __( 'Icon', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value'   => 'fas fa-check',
            'library' => 'fa-solid',
        ],
    ]
);

$repeater->add_control(
    'item_text',
    [
        'label'   => __( 'Text', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Menu Item Text', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->add_control(
    'item_text_description',
    [
        'label'   => __( 'Text Description', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXTAREA,
        'default' => __( 'Text menu description', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->add_control(
    'item_link',
    [
        'label' => __( 'Menu Link', 'wira-kit-for-elementor' ),
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

$repeater->add_control(
    'item_badge',
    [
        'label'   => __( 'Badge', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'New', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'menu_items',
    [
        'label'       => __( 'Menu List', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'default'     => [
            [
                'item_text'  => __( 'First Item', 'wira-kit-for-elementor' ),
                'item_badge' => __( 'Hot', 'wira-kit-for-elementor' ),
            ],
            [
                'item_text'  => __( 'Second Item', 'wira-kit-for-elementor' ),
                'item_badge' => __( 'New', 'wira-kit-for-elementor' ),
            ],
        ],
        'title_field' => '{{{ item_text }}}',
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_style_title',
    [
        'label' => __( 'Title Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [ '{{WRAPPER}} .wkit-menu-list-title' => 'color: {{VALUE}};' ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'title_typography',
        'selector' => '{{WRAPPER}} .wkit-menu-list-title',
    ]
);

$this->add_responsive_control(
    'title_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-menu-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
    'vertical_alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => __( 'Top', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-v-align-top',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-v-align-middle',
            ],
            'flex-end' => [
                'title' => __( 'Bottom', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-v-align-bottom',
            ],
        ],
        'default'   => 'center',
        'selectors' => [
            '{{WRAPPER}} .wkit-menu-item a.wkit-menu-item-link' => 'align-items: {{VALUE}};',
        ],
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
            '{{WRAPPER}} .wkit-menu-item-link .wkit-menu-item-wrapper svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .wkit-menu-item-link .wkit-menu-item-wrapper' => 'width: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .wkit-menu-item-link .wkit-menu-item-wrapper' => 'height: {{SIZE}}{{UNIT}};',
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
                'min' => 0,
                'max' => 100,
            ],
        ],
        'default' => [
            'size' => 7,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'tabs_item_icon_style' );

$this->start_controls_tab(
    'tab_item_icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'item_icon_bg',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} a.wkit-menu-item-link .wkit-menu-item-wrapper',
    ]
);

$this->add_control(
    'icon_color',
    [
        'label'     => esc_html__( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link .wkit-menu-item-wrapper svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'tab_item_icon_hover',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'item_icon_bg_hover',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} a.wkit-menu-item-link:hover .wkit-menu-item-wrapper',
    ]
);

$this->add_control(
    'icon_hover_color',
    [
        'label'     => esc_html__( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link:hover svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_control(
    'icon_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} a.wkit-menu-item-link .wkit-menu-item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_items',
    [
        'label' => __( 'Items Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'icon_position',
    [
        'label'   => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'row' => [
                'title' => __( 'Top', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-h-align-left',
            ],
            'column' => [
                'title' => __( 'Top', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-v-align-top',
            ],
            'row-reverse' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-h-align-right',
            ],
        ],
        'default'   => 'row',
        'selectors' => [
            '{{WRAPPER}} .wkit-menu-item a.wkit-menu-item-link' => 'flex-direction: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'item_gap',
    [
        'label'     => esc_html__( 'Item Gap', 'wira-kit-for-elementor' ),
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
            '{{WRAPPER}} .wkit-menu-list-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'item_width',
    [
        'label' => __( 'Item Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range' => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 500 ],
        ],
        'default' => [
            'size' => 80,
            'unit' => '%',
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-menu-item-link' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'tabs_item_style' );

$this->start_controls_tab(
    'tab_item_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'item_bg',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} a.wkit-menu-item-link',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'tab_item_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'item_bg_hover',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} a.wkit-menu-item-link:hover',
    ]
);

$this->add_control(
    'hover_transition_duration',
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
            '{{WRAPPER}} a.wkit-menu-item-link span.menu-text, {{WRAPPER}} a.wkit-menu-item-link .wkit-menu-item-wrapper svg' => 'transition: all {{SIZE}}s ease-in-out;',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'item_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} a.wkit-menu-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'item_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} a.wkit-menu-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_menu_text_style',
    [
        'label' => __( 'Menu Text', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'item_text_typography',
        'selector' => '{{WRAPPER}} a.wkit-menu-item-link .menu-text',
    ]
);

$this->start_controls_tabs( 'tabs_item_menu_style' );

$this->start_controls_tab(
    'tab_item_menu_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'item_menu_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link .menu-text' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'tab_item_menu_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'item_menu_text_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link:hover .menu-text' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'menu_text_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} a.wkit-menu-item-link .menu-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_menu_text_description_style',
    [
        'label' => __( 'Menu Text Description', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'item_menu_text_description_typography',
        'selector' => '{{WRAPPER}} a.wkit-menu-item-link .menu-text-description',
    ]
);

$this->start_controls_tabs( 'tabs_item_menu_description_style' );

$this->start_controls_tab(
    'tab_item_menu_description_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'item_menu_text_description_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link .menu-text-description' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'tab_item_menu_description_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'item_menu_text_description_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.wkit-menu-item-link:hover .menu-text-description' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'menu_text_description_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} a.wkit-menu-item-link .menu-text-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_badge',
    [
        'label' => __( 'Badge Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'badge_typography',
        'selector' => '{{WRAPPER}} .wkit-menu-item .menu-badge',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name' => 'badge_bg',
        'types' => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-menu-item .menu-badge',
    ]
);

$this->add_control(
    'badge_color',
    [
        'label'     => __( 'Badge Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [ '{{WRAPPER}} .wkit-menu-item .menu-badge' => 'color: {{VALUE}};' ],
    ]
);

$this->add_responsive_control(
    'badge_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-menu-item .menu-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'badge_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-menu-item .menu-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'badge_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-menu-item .menu-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


