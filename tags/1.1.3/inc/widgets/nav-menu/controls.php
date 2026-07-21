<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Nav Menu Elementor Custom Widget
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
    'wira_elementor_kit_menu_settings_section',
    [
        'label' => __( 'Menu Settings', 'wira-kit-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$menus = wp_get_nav_menus();
$menu_options = [];

if ( ! empty( $menus ) ) {
    foreach ( $menus as $menu ) {
        $menu_options[ $menu->term_id ] = $menu->name;
    }
}

$this->add_control(
    'wira_elementor_kit_nav_menu_list',
    [
        'label' => __( 'Select menu', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => $menu_options,
        'default' => ! empty( $menu_options ) ? array_key_first( $menu_options ) : '',
        'description' => empty( $menu_options ) ? __( 'No menus found. Please create one in Appearance > Menus.', 'wira-kit-for-elementor' ) : '',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_horizontal_position',
    [
        'label' => __( 'Horizontal menu position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'start' => [
                'title' => __( 'Start', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-align-start-h',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-align-center-h',
            ],
            'end' => [
                'title' => __( 'End', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-align-end-h',
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-navbar' => 'justify-content: {{VALUE}};',
        ],
        'default' => 'center',
        'toggle' => false,
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_hamburger_icon',
    [
        'label' => __( 'Hamburger Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-bars',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_icon',
    [
        'label' => __( 'Close Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-times',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_dropdown_icon',
    [
        'label' => __( 'Dropdown Arrow Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-angle-down',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_mobile_logo_mode',
    [
        'label' => __( 'Mobile Logo Mode', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'inherit',
        'options' => [
            'inherit' => __( 'Inherit from Custom Logo', 'wira-kit-for-elementor' ),
            'custom' => __( 'Custom Image Logo', 'wira-kit-for-elementor' ),
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'wira_elementor_kit_mobile_menu_logo',
    [
        'label' => __( 'Mobile Menu Logo', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'condition' => [
            'wira_elementor_kit_mobile_logo_mode' => 'custom',
        ],
    ]
);


$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'wira_elementor_kit_nav_menu_item_style_section',
    [
        'label' => __( 'Menu Item', 'wira-kit-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'wira_elementor_kit_nav_menu_item_typography',
        'label' => __( 'Typography', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-nav ul li a.nav-link',
    ]
);

$this->start_controls_tabs( 'wira_elementor_kit_nav_menu_item_style_tabs' );

$this->start_controls_tab(
    'wira_elementor_kit_nav_menu_item_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name' => 'wira_elementor_kit_nav_menu_item_bg_normal',
        'label' => __( 'Background Type', 'wira-kit-for-elementor' ),
        'types' => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_color_normal',
    [
        'label' => __( 'Item text color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link' => 'color: {{VALUE}}',
        ],
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_border_type_normal',
    [
        'label' => __( 'Border Type', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __( 'None', 'wira-kit-for-elementor' ),
            'solid' => __( 'Solid', 'wira-kit-for-elementor' ),
            'dashed' => __( 'Dashed', 'wira-kit-for-elementor' ),
            'dotted' => __( 'Dotted', 'wira-kit-for-elementor' ),
            'double' => __( 'Double', 'wira-kit-for-elementor' ),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link' => 'border-style: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_border_width_normal',
    [
        'label' => __( 'Border Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_menu_item_border_color_normal',
    [
        'label' => __( 'Border Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'wira_elementor_kit_nav_menu_item_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name' => 'wira_elementor_kit_nav_menu_item_bg_hover',
        'label' => __( 'Background Type', 'wira-kit-for-elementor' ),
        'types' => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link:hover',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_color_hover',
    [
        'label' => __( 'Item text color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link:hover, {{WRAPPER}} .wkit-nav ul li.nav-item:hover a.dropdown-toggle' => 'color: {{VALUE}}',
        ],
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_border_type_hover',
    [
        'label' => __( 'Border Type', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __( 'None', 'wira-kit-for-elementor' ),
            'solid' => __( 'Solid', 'wira-kit-for-elementor' ),
            'dashed' => __( 'Dashed', 'wira-kit-for-elementor' ),
            'dotted' => __( 'Dotted', 'wira-kit-for-elementor' ),
            'double' => __( 'Double', 'wira-kit-for-elementor' ),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link:hover,{{WRAPPER}} .wkit-nav ul li.nav-item:hover a.dropdown-toggle' => 'border-style: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_border_width_hover',
    [
        'label' => __( 'Border Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link:hover,{{WRAPPER}} .wkit-nav ul li.nav-item:hover a.dropdown-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_menu_item_border_color_hover',
    [
        'label' => __( 'Border Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link:hover,{{WRAPPER}} .wkit-nav ul li.nav-item:hover a.dropdown-toggle' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'wira_elementor_kit_nav_menu_item_active',
    [
        'label' => __( 'Active', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name' => 'wira_elementor_kit_nav_menu_item_bg_active',
        'label' => __( 'Background Type', 'wira-kit-for-elementor' ),
        'types' => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-nav ul li.nav-item.current-menu-item a.nav-link',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_color_active',
    [
        'label' => __( 'Item text color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item.current-menu-item a.nav-link' => 'color: {{VALUE}}',
        ],
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_border_type_active',
    [
        'label' => __( 'Border Type', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __( 'None', 'wira-kit-for-elementor' ),
            'solid' => __( 'Solid', 'wira-kit-for-elementor' ),
            'dashed' => __( 'Dashed', 'wira-kit-for-elementor' ),
            'dotted' => __( 'Dotted', 'wira-kit-for-elementor' ),
            'double' => __( 'Double', 'wira-kit-for-elementor' ),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item.current-menu-item a.nav-link' => 'border-style: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_border_width_active',
    [
        'label' => __( 'Border Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item.current-menu-item a.nav-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_menu_item_border_color_active',
    [
        'label' => __( 'Border Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item.current-menu-item a.nav-link' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_padding',
    [
        'label' => __( 'Item Padding', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'default' => [
            'top' => 35,
            'right' => 15,
            'bottom' => 35,
            'left' => 15,
            'tablet' => [
                'top'    => 20,
                'right'  => 20,
                'bottom' => 20,
                'left'   => 20,
            ],
            'unit' => 'px',
        ],
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);


$this->add_responsive_control(
    'wira_elementor_kit_nav_menu_item_margin',
    [
        'label' => __( 'Item Margin', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-nav ul li.nav-item a.nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'wira_elementor_kit_nav_submenu_item_style_section',
    [
        'label' => esc_html__('Submenu Item', 'wira-kit-for-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_submenu_bg',
        'label'    => esc_html__('Submenu Background', 'wira-kit-for-elementor'),
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .wkit-nav .wkit-dropdown ul, {{WRAPPER}} .wkit-nav .wkit-dropdown .wkit-mega-menu',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_submenu_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-nav .wkit-dropdown ul, {{WRAPPER}} .wkit-nav .wkit-dropdown .wkit-mega-menu',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_submenu_item_typography',
        'label'    => esc_html__('Typography', 'wira-kit-for-elementor'),
        'selector' => '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item a.nav-link',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_submenu_item_padding',
    [
        'label' => __( 'Item Padding', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'default' => [
            'top' => 25,
            'right' => 25,
            'bottom' => 25,
            'left' => 25,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item a.nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs('wira_elementor_kit_nav_submenu_item_style_tabs');

$this->start_controls_tab(
    'wira_elementor_kit_nav_submenu_item_style_normal',
    [
        'label' => esc_html__('Normal', 'wira-kit-for-elementor'),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_submenu_item_bg_normal',
        'label'    => esc_html__('Background Type', 'wira-kit-for-elementor'),
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item a.nav-link',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_submenu_item_color_normal',
    [
        'label'     => esc_html__('Item text color', 'wira-kit-for-elementor'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item a.nav-link' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'wira_elementor_kit_nav_submenu_item_style_hover',
    [
        'label' => esc_html__('Hover', 'wira-kit-for-elementor'),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_submenu_item_bg_hover',
        'selector' => '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item:hover a.dropdown-toggle-submenu, {{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item a.nav-link:hover',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_submenu_item_color_hover',
    [
        'label'     => esc_html__('Item text color', 'wira-kit-for-elementor'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item:hover a.dropdown-toggle-submenu, {{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item a.nav-link:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'wira_elementor_kit_nav_submenu_item_style_active',
    [
        'label' => esc_html__('Active', 'wira-kit-for-elementor'),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_submenu_item_bg_active',
        'selector' => '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item.current-menu-item a.nav-link',
    ]
);

$this->add_responsive_control(
    'wira_elementor_kit_nav_submenu_item_color_active',
    [
        'label'     => esc_html__('Item text color', 'wira-kit-for-elementor'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-nav .wkit-dropdown ul li.dropdown-item.current-menu-item a.nav-link' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'wira_elementor_kit_nav_submenu_item_border_radius',
    [
        'label'      => esc_html__('Border Radius', 'wira-kit-for-elementor'),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'default'    => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 0,
            'left'   => 0,
            'unit'   => 'px',
        ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-nav .wkit-dropdown ul.dropdown-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'wira_elementor_kit_nav_mobile_menu_style_section',
    [
        'label' => esc_html__('Mobile Menu', 'wira-kit-for-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_mobile_menu_logo_width',
    [
        'label'      => esc_html__( 'Mobile Menu Logo Width', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 215,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-brand img' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_mobile_menu_logo_border_radius',
    [
        'label'      => esc_html__( 'Logo Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'default'    => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 0,
            'left'   => 0,
            'unit'   => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-brand img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);


$this->add_control(
    'wira_elementor_kit_mobile_menu_bg_heading',
    [
        'label' => esc_html__( 'Panel Background', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_mobile_menu_panel_bg',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .wkit-mobile-menu',
    ]
);

$this->add_control(
    'wira_elementor_kit_mobile_menu_bg_overlay_heading',
    [
        'label' => esc_html__( 'Overlay Background', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_mobile_menu_panel_bg_overlay',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .wkit-mobile-menu-overlay',
    ]
);

$this->end_controls_section();

// Humberger Menu
$this->start_controls_section(
    'wira_elementor_kit_nav_humberger_btn_section',
    [
        'label' => esc_html__( 'Humberger Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_padding',
    [
        'label'      => esc_html__( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'default' => [
            'top' => 0,
            'right' => 0,
            'bottom' => 0,
            'left' => 0,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_width',
    [
        'label'      => esc_html__( 'Width', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 45,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_height',
    [
        'label'      => esc_html__( 'Height', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 45,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_line_height',
    [
        'label'      => esc_html__( 'Line Height', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 45,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_humberger_btn_item_border_type',
    [
        'label' => __( 'Border Type', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __( 'None', 'wira-kit-for-elementor' ),
            'solid' => __( 'Solid', 'wira-kit-for-elementor' ),
            'dashed' => __( 'Dashed', 'wira-kit-for-elementor' ),
            'dotted' => __( 'Dotted', 'wira-kit-for-elementor' ),
            'double' => __( 'Double', 'wira-kit-for-elementor' ),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'border-style: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_humberger_btn_border_width',
    [
        'label' => __( 'Border Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_humberger_btn_border_color',
    [
        'label' => __( 'Border Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_border_radius',
    [
        'label'      => esc_html__( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'default'    => [
            'top'    => 30,
            'right'  => 30,
            'bottom' => 30,
            'left'   => 30,
            'unit'   => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-menu-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_humberger_btn_background',
        'selector' => '{{WRAPPER}} .wkit-mobile-menu-btn',
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_icon_color',
    [
        'label'     => esc_html__( 'Icon Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-btn i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_humberger_btn_icon_size',
    [
        'label'      => esc_html__( 'Icon Size', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 16,
            'unit' => 'px',
        ],
        'range'      => [
            'px' => [ 'min' => 8, 'max' => 100 ],
        ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-menu-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


// ==== CLOSE BUTTON SECTION ====

$this->start_controls_section(
    'wira_elementor_kit_nav_close_btn_section',
    [
        'label' => esc_html__( 'Close Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_padding',
    [
        'label'      => esc_html__( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'default' => [
            'top' => 0,
            'right' => 0,
            'bottom' => 0,
            'left' => 0,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_width',
    [
        'label'      => esc_html__( 'Width', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 45,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_height',
    [
        'label'      => esc_html__( 'Height', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 45,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_line_height',
    [
        'label'      => esc_html__( 'Line Height', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 45,
            'unit' => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'range'      => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_item_border_type',
    [
        'label' => __( 'Border Type', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __( 'None', 'wira-kit-for-elementor' ),
            'solid' => __( 'Solid', 'wira-kit-for-elementor' ),
            'dashed' => __( 'Dashed', 'wira-kit-for-elementor' ),
            'dotted' => __( 'Dotted', 'wira-kit-for-elementor' ),
            'double' => __( 'Double', 'wira-kit-for-elementor' ),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'border-style: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_border_width',
    [
        'label' => __( 'Border Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_border_color',
    [
        'label' => __( 'Border Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_border_radius',
    [
        'label'      => esc_html__( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'default'    => [
            'top'    => 30,
            'right'  => 30,
            'bottom' => 30,
            'left'   => 30,
            'unit'   => 'px',
        ],
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-menu-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'wira_elementor_kit_nav_close_btn_background',
        'selector' => '{{WRAPPER}} .wkit-mobile-menu-close',
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_icon_color',
    [
        'label'     => esc_html__( 'Icon Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-mobile-menu-close i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'wira_elementor_kit_nav_close_btn_icon_size',
    [
        'label'      => esc_html__( 'Icon Size', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'default'    => [
            'size' => 16,
            'unit' => 'px',
        ],
        'range'      => [
            'px' => [ 'min' => 8, 'max' => 100 ],
        ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-mobile-menu-close i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();




