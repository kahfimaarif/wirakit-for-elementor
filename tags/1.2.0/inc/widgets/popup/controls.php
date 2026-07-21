<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Popup Elementor Custom Widget
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
    'section_popup',
    [
        'label' => __( 'Popup', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'popup_type',
    [
        'label'   => __( 'Popup Type', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'inline',
        'options' => [
            'inline' => __( 'Elementor Template', 'wira-kit-for-elementor' ),
            'iframe'  => __( 'Iframe', 'wira-kit-for-elementor' ),
        ],
    ]
);
$this->add_control(
    'iframe_info',
    [
        'type' => \Elementor\Controls_Manager::RAW_HTML,
        'raw'  => __(
            '<strong>Iframe Popup Support:</strong><br>
            This popup type supports popular video and map platforms including:
            <ul style="margin: 5px 0 0 15px; list-style: disc;">
                <li><strong>YouTube</strong> - Example: <code>https://www.youtube.com/watch?v=dQw4w9WgXcQ</code></li>
                <li><strong>Vimeo</strong> - Example: <code>https://vimeo.com/76979871</code></li>
                <li><strong>Google Maps</strong> - Use an <em>embed</em> URL like:<br>
                    <code>https://www.google.com/maps/embed?pb=...</code>
                </li>
            </ul>
            Paste one of these URLs in the <strong>Iframe URL</strong> field below. 
            The popup will automatically detect and embed it correctly.',
            'wira-kit-for-elementor'
        ),
        'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        'condition' => [
            'popup_type' => 'iframe',
        ],
    ]
);


$this->add_control(
    'iframe_url',
    [
        'label'     => __( 'Iframe URL', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'placeholder' => __( 'https://www.youtube.com/watch?v=...', 'wira-kit-for-elementor' ),
        'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
        'condition' => [
            'popup_type' => 'iframe',
        ],
    ]
);

$this->add_control(
    'popup_template',
    [
        'label'       => __( 'Choose Popup Template', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'options'     => $this->get_popup_templates(),
        'multiple'    => false,
        'label_block' => true,
        'condition' => [
            'popup_type' => 'inline',
        ],
    ]
);

$this->add_control(
    'popup_trigger',
    [
        'label' => __( 'Popup Trigger', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'button',
        'options' => [
            'button'   => __( 'Button', 'wira-kit-for-elementor' ),
            'icon'   => __( 'Icon', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_button',
    [
        'label' => __( 'Button', 'wira-kit-for-elementor' ),
        'condition' => [
            'popup_trigger' => 'button',
        ],
    ]
);

$this->add_control(
    'button_text',
    [
        'label' => __( 'Text', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Click here', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter button text', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'button_icon',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default' => [
            'value' => '',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'icon_position',
    [
        'label' => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'before',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'button_icon[value]!' => '',
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
            '{{WRAPPER}} .wkit-btn-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'button_icon[value]!' => '',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_icon',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'condition' => [
            'popup_trigger' => 'icon',
        ],
    ]
);

$this->add_control(
    'icon_button',
    [
        'label'     => esc_html__( 'Icon', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::ICONS,
        'default'   => [
            'value'   => 'fas fa-arrow-right',
            'library' => 'fa-solid',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'popup_animation_section',
    [
        'label' => __( 'Popup Animation', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'popup_animation',
    [
        'label'   => __( 'Entrance Animation', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'wkit-slide-down',
        'options' => [
            'wkit-fade'        => __( 'Fade In', 'wira-kit-for-elementor' ),
            'wkit-slide-down'  => __( 'Slide Down', 'wira-kit-for-elementor' ),
            'wkit-slide-up'    => __( 'Slide Up', 'wira-kit-for-elementor' ),
            'wkit-slide-left'  => __( 'Slide Left', 'wira-kit-for-elementor' ),
            'wkit-slide-right' => __( 'Slide Right', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'container_style_section',
    [
        'label' => __( 'Container', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'popup_background',
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-content',
    ]
);

$this->add_control(
    'popup_background_overlay',
    [
        'label'     => __( 'Background Overlay', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-overlay' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'container_width',
    [
        'label' => __( 'Container With', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range' => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 2080 ],
        ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-content' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'container_height',
    [
        'label' => __( 'Container Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px', 'vh' ],
        'range' => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 2080 ],
            'vh' => [ 'min' => 0, 'max' => 100 ],
        ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-content' => 'height: {{SIZE}}{{UNIT}};',
            '.wkit-popup-{{ID}} .wkit-popup-content iframe' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'container_horizontal_alignment',
    [
        'label'   => __( 'Horizontal Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-h-align-left',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-h-align-center',
            ],
            'flex-end' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-h-align-right',
            ],
        ],
        'default'   => 'center',
        'selectors' => [
            '.wkit-popup-{{ID}}' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'container_vertical_alignment',
    [
        'label'   => __( 'Vertical Alignment', 'wira-kit-for-elementor' ),
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
            '.wkit-popup-{{ID}}' => 'align-items: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'container_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors'  => [
            '.wkit-popup-{{ID}} .wkit-popup-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'button_style_section',
    [
        'label' => __( 'Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'popup_trigger' => 'button',
        ],
    ]
);

$this->add_responsive_control(
    'button_alignment',
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
            '{{WRAPPER}} .wkit-button-wrapper' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'button_typography',
        'selector' => '{{WRAPPER}} .wkit-btn-text',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'     => 'button_text_shadow',
        'selector' => '{{WRAPPER}} .wkit-btn-text',
    ]
);

$this->start_controls_tabs('button_tabs_style');

$this->start_controls_tab(
    'button_tab_normal',
    [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'button_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-btn' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_background',
        'selector' => '{{WRAPPER}} .wkit-btn',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border',
        'selector' => '{{WRAPPER}} .wkit-btn',
    ]
);

$this->add_responsive_control(
    'button_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-btn , {{WRAPPER}} .wkit-btn::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-btn',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'button_tab_hover',
    [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'button_hover_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-btn:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_hover_background',
        'selector' => '{{WRAPPER}} .wkit-btn::before',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_hover_border',
        'selector' => '{{WRAPPER}} .wkit-btn:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'button_hover_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-btn:hover',
    ]
);

$this->add_control(
    'hover_animation',
    [
        'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
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
            '{{WRAPPER}} .wkit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'button_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'range' => [
            '%' => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 500 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-btn' => 'width: {{SIZE}}{{UNIT}};',
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
            'popup_trigger' => 'icon',
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
            '{{WRAPPER}} .icon-button i' => 'font-size: {{SIZE}}{{UNIT}};',
        ]
    ]
);

$this->add_responsive_control(
    'icon_button_alignment',
    [
        'label'   => __( 'Icon Button Alignment', 'wira-kit-for-elementor' ),
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
            '{{WRAPPER}} .wkit-button-wrapper' => 'justify-content: {{VALUE}};',
        ],
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
            '{{WRAPPER}} .icon-button' => 'text-align: {{VALUE}};',
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
            '{{WRAPPER}} .icon-button' => 'width: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .icon-button' => 'height: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .icon-button i' => 'line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'enable_btn_glow',
    [
        'label'        => __( 'Enable Glow', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
        'condition' => [
            'popup_type' => 'iframe',
        ],
    ]
);

$this->add_control(
    'glow_color',
    [
        'label'     => __( 'Glow Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .button-glow::before, {{WRAPPER}} .button-glow::after, {{WRAPPER}} .button-glow i::after' => 'color: {{VALUE}};',
        ],
        'condition' => [
            'enable_btn_glow' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'glow_size',
    [
        'label' => __( 'Glow Size', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 50 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .button-glow::before, {{WRAPPER}} .button-glow::after, {{WRAPPER}} .button-glow i::after' => '--glow-size: {{SIZE}}{{UNIT}};',
        ],
        'default' => [
            'size' => 15,
            'unit' => 'px',
        ],
        'condition' => [
            'enable_btn_glow' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'glow_border_radius',
    [
        'label' => __( 'Glow Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .button-glow::before, {{WRAPPER}} .button-glow::after, {{WRAPPER}} .button-glow i::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
            'enable_btn_glow' => 'yes',
        ],
    ]
);

$this->start_controls_tabs( 'icon_style_tabs' );

$this->start_controls_tab(
    'icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_background',
        'selector' => '{{WRAPPER}} .icon-button',
    ]
);

$this->add_control(
    'icon_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .icon-button i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_border',
        'selector' => '{{WRAPPER}} .icon-button',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .icon-button',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'icon_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_background_hover',
        'selector' => '{{WRAPPER}} .icon-button:hover',
    ]
);

$this->add_control(
    'icon_hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .icon-button:hover i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_border_hover',
        'selector' => '{{WRAPPER}} .icon-button:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .icon-button:hover',
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
            '{{WRAPPER}} .icon-button' => 'transition: all {{SIZE}}s ease-in-out;',
        ],
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
            '{{WRAPPER}} .icon-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .icon-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_icon_close',
    [
        'label' => __( 'Close Icon', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'icon_close_size',
    [
        'label' => __( 'Font Size', 'wira-kit-for-elementor' ),
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
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'font-size: {{SIZE}}{{UNIT}};',
        ]
    ]
);

$this->add_responsive_control(
    'icon_close_alignment',
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
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_close_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 40,
            'unit' => 'px',
        ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_close_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 40,
            'unit' => 'px',
        ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);


$this->start_controls_tabs( 'icon_close_style_tabs' );

$this->start_controls_tab(
    'icon_close_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_close_background',
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-close',
    ]
);

$this->add_control(
    'icon_close_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_close_border',
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-close',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_close_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-close',
    ]
);

$this->add_control(
    'icon_close_opacity',
    [
        'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0.1,
                'max' => 1,
                'step'=> 0.01,
            ],
        ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'opacity: {{SIZE}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'icon_close_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'icon_close_background_hover',
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-close:hover',
    ]
);

$this->add_control(
    'icon_close_hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'icon_close_border_hover',
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-close:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'icon_close_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '.wkit-popup-{{ID}} .wkit-popup-close:hover',
    ]
);

$this->add_control(
    'icon_close_opacity_hover',
    [
        'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0.1,
                'max' => 1,
                'step'=> 0.01,
            ],
        ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close:hover' => 'opacity: {{SIZE}};',
        ],
    ]
);

$this->add_control(
    'bg_close_transition_duration',
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
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'transition: all {{SIZE}}s ease-in-out;',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'icon_close_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'default'    => [
            'top'      => '0',
            'right'    => '0',
            'bottom'   => '0',
            'left'     => '0',
            'unit'     => 'px',
            'isLinked' => true,
        ],
        'selectors'  => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_close_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_close_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '.wkit-popup-{{ID}} .wkit-popup-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();
