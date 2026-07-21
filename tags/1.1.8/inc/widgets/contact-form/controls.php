<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Contact Form 7 Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get Contact Form 7 Post
$forms = [];

if ( class_exists( 'WPCF7_ContactForm' ) ) {

    if ( function_exists( 'wpcf7_contact_forms' ) ) {
        $cf7_forms = wpcf7_contact_forms();

        if ( is_array( $cf7_forms ) && ! empty( $cf7_forms ) ) {
            foreach ( $cf7_forms as $form ) {

                if ( is_object( $form ) && method_exists( $form, 'id' ) ) {
                    $forms[ (string) $form->id() ] = $form->title();
                } elseif ( is_object( $form ) && property_exists( $form, 'ID' ) ) {
                    // fallback
                    $forms[ (string) $form->ID ] = get_the_title( $form->ID );
                }
            }
        }
    }

    if ( empty( $forms ) ) {
        $posts = get_posts( [
            'post_type'      => 'wpcf7_contact_form',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ] );

        if ( $posts ) {
            foreach ( $posts as $p ) {

                $cf7 = WPCF7_ContactForm::get_instance( $p->ID );
                if ( $cf7 && method_exists( $cf7, 'id' ) ) {
                    $forms[ (string) $cf7->id() ] = $cf7->title();
                } else {
                    $forms[ (string) $p->ID ] = get_the_title( $p->ID );
                }
            }
        }
    }
}

if ( empty( $forms ) ) {
    $forms = [
        '' => __( 'No Contact Form 7 found', 'wira-kit-for-elementor' ),
    ];
}


// === Content Tab ===
$this->start_controls_section(
    'section_content',
    [
        'label' => __( 'Content', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'form_id',
    [
        'label'   => __( 'Select Form', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => $forms,
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
    'row_gap',
    [
        'label'     => __( 'Row Gap', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wpcf7 .cf7-custom-layout, {{WRAPPER}} .wpcf7 .wpcf7-form, {{WRAPPER}} .wpcf7 .form-row, {{WRAPPER}} .wpcf7 .row' => 'row-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'column_gap',
    [
        'label'     => __( 'Column Gap', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wpcf7 .form-row, {{WRAPPER}} .wpcf7 .row' => 'column-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_input_style',
    [
        'label' => __( 'Input Fields', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'input_typography',
        'selector' => '{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea, {{WRAPPER}} .wpcf7 select',
    ]
);

$this->start_controls_tabs( 'tabs_input_style' );

$this->start_controls_tab( 'tab_input_normal', [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'input_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea, {{WRAPPER}} .wpcf7 select' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'input_bg',
        'label'    => __( 'Background', 'wira-kit-for-elementor' ),
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea, {{WRAPPER}} .wpcf7 select',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'input_border',
        'selector' => '{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea, {{WRAPPER}} .wpcf7 select',
    ]
);

$this->add_responsive_control(
    'input_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea, {{WRAPPER}} .wpcf7 select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_input_hover', [ 'label' => __( 'Hover / Focus', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'input_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 input:hover, {{WRAPPER}} .wpcf7 input:focus, {{WRAPPER}} .wpcf7 textarea:hover, {{WRAPPER}} .wpcf7 textarea:focus, {{WRAPPER}} .wpcf7 select:hover, {{WRAPPER}} .wpcf7 select:focus' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'input_bg_hover',
        'label'    => __( 'Background', 'wira-kit-for-elementor' ),
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wpcf7 input:hover, {{WRAPPER}} .wpcf7 input:focus, {{WRAPPER}} .wpcf7 textarea:hover, {{WRAPPER}} .wpcf7 textarea:focus, {{WRAPPER}} .wpcf7 select:hover, {{WRAPPER}} .wpcf7 select:focus',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'input_border_hover',
        'selector' => '{{WRAPPER}} .wpcf7 input:hover, {{WRAPPER}} .wpcf7 input:focus, {{WRAPPER}} .wpcf7 textarea:hover, {{WRAPPER}} .wpcf7 textarea:focus, {{WRAPPER}} .wpcf7 select:hover, {{WRAPPER}} .wpcf7 select:focus',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'list_item_item_gap',
    [
        'label'     => __( 'List Item Item Gap', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-contact-form .wpcf7-list-item label input' => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'list_item_column_gap',
    [
        'label'     => __( 'List Item Column Gap', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-contact-form .wpcf7-list-item' => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'list_item_row_gap',
    [
        'label'     => __( 'List Item Row Gap', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-contact-form .wpcf7-list-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'input_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea, {{WRAPPER}} .wpcf7 select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_select_style',
    [
        'label' => __( 'Select Fields', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'select_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 select option' => 'color: {{VALUE}};',
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

$this->add_control(
    'placeholder_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 input::placeholder, {{WRAPPER}} .wpcf7 textarea::placeholder, {{WRAPPER}} .wpcf7 select::placeholder, {{WRAPPER}} .wkit-contact-form .form-select-wrapper span::after, {{WRAPPER}} .wkit-contact-form .form-date-wrapper span::after' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_required_text_style',
    [
        'label' => __( 'Required Text', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'required_text_typography',
        'selector' => '{{WRAPPER}} .wpcf7-not-valid-tip',
    ]
);

$this->add_control(
    'required_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'required_text_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_label_style',
    [
        'label' => __( 'Labels', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'label_typography',
        'selector' => '{{WRAPPER}} .wpcf7 label',
    ]
);

$this->add_control(
    'label_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 label' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'label_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7 label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_button_style',
    [
        'label' => __( 'Submit Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'button_typography',
        'selector' => '{{WRAPPER}} .wpcf7 input[type="submit"]',
    ]
);

$this->start_controls_tabs( 'tabs_button_style' );

$this->start_controls_tab( 'tab_button_normal', [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ] );

$this->add_responsive_control(
    'button_alignment',
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
        ],
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .wpcf7 p:has(input[type="submit"])' => 'text-align: {{VALUE}};',
        ],

    ]
);

$this->add_control(
    'button_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 input[type="submit"]' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_bg',
        'label'    => __( 'Background', 'wira-kit-for-elementor' ),
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wpcf7 input[type="submit"]',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border',
        'selector' => '{{WRAPPER}} .wpcf7 input[type="submit"]',
    ]
);

$this->add_responsive_control(
    'button_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7 input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 'tab_button_hover', [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ] );

$this->add_control(
    'button_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wpcf7 input[type="submit"]:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'button_bg_hover',
        'label'    => __( 'Background', 'wira-kit-for-elementor' ),
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .wpcf7 input[type="submit"]:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'button_border_hover',
        'selector' => '{{WRAPPER}} .wpcf7 input[type="submit"]:hover',
    ]
);

$this->add_responsive_control(
    'button_radius_hover',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7 input[type="submit"]:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'button_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wpcf7 input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'button_width',
    [
        'label' => __( 'Button Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wpcf7 input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


