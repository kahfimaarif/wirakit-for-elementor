<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Search Form Elementor Custom Widget
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
        'label' => __( 'Search Form', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'placeholder_text',
    [
        'label'       => __( 'Placeholder', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => __( 'Search...', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter placeholder text', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'button_text',
    [
        'label'       => __( 'Button Text', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => __( 'Search', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter button text', 'wira-kit-for-elementor' ),
        'dynamic'     => [ 'active' => true ],
    ]
);

$this->add_control(
    'button_type',
    [
        'label'   => __( 'Button Type', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'text_icon',
        'options' => [
            'icon_only' => __( 'Icon Only', 'wira-kit-for-elementor' ),
            'text_only' => __( 'Text Only', 'wira-kit-for-elementor' ),
            'text_icon' => __( 'Text + Icon', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->add_control(
    'search_icon',
    [
        'label'            => __( 'Search Icon', 'wira-kit-for-elementor' ),
        'type'             => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default'          => [
            'value'   => 'fas fa-search',
            'library' => 'fa-solid',
        ],
        'condition'        => [
            'button_type!' => 'text_only',
        ],
    ]
);

$this->add_control(
    'icon_position',
    [
        'label'   => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'before',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'button_type'        => 'text_icon',
            'search_icon[value]!' => '',
        ],
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_form_style',
    [
        'label' => __( 'Form Container', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'form_alignment',
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
        'default'   => 'flex-start',
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__form' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'form_gap',
    [
        'label'      => __( 'Gap', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__form' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'form_width',
    [
        'label'      => __( 'Width', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range'      => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 1200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__form' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_field_style',
    [
        'label' => __( 'Field', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'field_typography',
        'selector' => '{{WRAPPER}} .wkit-search-form__input',
    ]
);

$this->start_controls_tabs( 'tabs_field_style' );

$this->start_controls_tab( 'tab_field_normal', [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'field_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__input' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'field_background',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-search-form__input',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'field_border',
        'selector' => '{{WRAPPER}} .wkit-search-form__input',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'field_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-search-form__input',
    ]
);

$this->add_responsive_control(
    'field_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_field_hover', [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'field_text_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__input:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'field_background_hover',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-search-form__input:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'field_border_hover',
        'selector' => '{{WRAPPER}} .wkit-search-form__input:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'field_box_shadow_hover',
        'selector' => '{{WRAPPER}} .wkit-search-form__input:hover',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_field_focus', [ 'label' => __( 'Focus', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'field_text_color_focus',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__input:focus' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'field_background_focus',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-search-form__input:focus',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'field_border_focus',
        'selector' => '{{WRAPPER}} .wkit-search-form__input:focus',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'field_box_shadow_focus',
        'selector' => '{{WRAPPER}} .wkit-search-form__input:focus',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'field_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'field_width',
    [
        'label'      => __( 'Width', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range'      => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 1200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__input' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_placeholder_style',
    [
        'label' => __( 'Placeholder', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'placeholder_typography',
        'selector' => '{{WRAPPER}} .wkit-search-form__input::placeholder',
    ]
);

$this->add_control(
    'placeholder_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__input::placeholder' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_button_style',
    [
        'label' => __( 'Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'button_typography',
        'selector' => '{{WRAPPER}} .wkit-search-form__button',
    ]
);

$this->start_controls_tabs( 'tabs_button_style' );

$this->start_controls_tab( 'tab_button_normal', [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'button_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__button' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_background',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-search-form__button',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border',
        'selector' => '{{WRAPPER}} .wkit-search-form__button',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-search-form__button',
    ]
);

$this->add_responsive_control(
    'button_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_button_hover', [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'button_text_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__button:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_background_hover',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-search-form__button:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border_hover',
        'selector' => '{{WRAPPER}} .wkit-search-form__button:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_box_shadow_hover',
        'selector' => '{{WRAPPER}} .wkit-search-form__button:hover',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_button_focus', [ 'label' => __( 'Focus', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'button_text_color_focus',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__button:focus' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_background_focus',
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wkit-search-form__button:focus',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border_focus',
        'selector' => '{{WRAPPER}} .wkit-search-form__button:focus',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_box_shadow_focus',
        'selector' => '{{WRAPPER}} .wkit-search-form__button:focus',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'button_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'button_width',
    [
        'label'      => __( 'Width', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range'      => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 400 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__button' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'button_gap',
    [
        'label'      => __( 'Icon Gap', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__button' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'button_type'        => 'text_icon',
            'search_icon[value]!' => '',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_icon_style',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'button_type!' => 'text_only',
            'search_icon[value]!' => '',
        ],
    ]
);

$this->add_responsive_control(
    'icon_size',
    [
        'label'      => __( 'Size', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-search-form__icon' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'tabs_icon_style' );

$this->start_controls_tab( 'tab_icon_normal', [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'icon_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__icon' => 'color: {{VALUE}};',
            '{{WRAPPER}} .wkit-search-form__icon svg' => 'fill: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_icon_hover', [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'icon_color_hover',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__button:hover .wkit-search-form__icon' => 'color: {{VALUE}};',
            '{{WRAPPER}} .wkit-search-form__button:hover .wkit-search-form__icon svg' => 'fill: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_icon_focus', [ 'label' => __( 'Focus', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'icon_color_focus',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-search-form__button:focus .wkit-search-form__icon' => 'color: {{VALUE}};',
            '{{WRAPPER}} .wkit-search-form__button:focus .wkit-search-form__icon svg' => 'fill: {{VALUE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();


