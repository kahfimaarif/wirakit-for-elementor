<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Countdown Timer Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Content Tab.
$this->start_controls_section(
	'countdown_content_section',
	array(
		'label' => __( 'Countdown', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'due_date',
	array(
		'label'       => __( 'Due Date', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::DATE_TIME,
		'description' => __( 'Set the target date and time for countdown.', 'wira-kit-for-elementor' ),
	)
);

$this->add_responsive_control(
	'countdown_alignment',
	array(
		'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'flex-start' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center'     => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'flex-end'   => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'default' => 'center',
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown' => 'justify-content: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_gap',
	array(
		'label' => __( 'Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array(
				'min' => 0,
				'max' => 80,
			),
		),
		'default' => array(
			'size' => 12,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'show_days',
	array(
		'label'        => __( 'Show Days', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'show_hours',
	array(
		'label'        => __( 'Show Hours', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'show_minutes',
	array(
		'label'        => __( 'Show Minutes', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'show_seconds',
	array(
		'label'        => __( 'Show Seconds', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'show_labels',
	array(
		'label'        => __( 'Show Labels', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'day_label',
	array(
		'label'     => __( 'Days Label', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => __( 'Days', 'wira-kit-for-elementor' ),
		'condition' => array(
			'show_labels' => 'yes',
		),
	)
);

$this->add_control(
	'hour_label',
	array(
		'label'     => __( 'Hours Label', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => __( 'Hours', 'wira-kit-for-elementor' ),
		'condition' => array(
			'show_labels' => 'yes',
		),
	)
);

$this->add_control(
	'minute_label',
	array(
		'label'     => __( 'Minutes Label', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => __( 'Minutes', 'wira-kit-for-elementor' ),
		'condition' => array(
			'show_labels' => 'yes',
		),
	)
);

$this->add_control(
	'second_label',
	array(
		'label'     => __( 'Seconds Label', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => __( 'Seconds', 'wira-kit-for-elementor' ),
		'condition' => array(
			'show_labels' => 'yes',
		),
	)
);

$this->add_control(
	'show_separator',
	array(
		'label'        => __( 'Show Separator', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'separator_text',
	array(
		'label'     => __( 'Separator', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::TEXT,
		'default'   => ':',
		'condition' => array(
			'show_separator' => 'yes',
		),
	)
);

$this->add_control(
	'expired_text',
	array(
		'label'       => __( 'Expired Text', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Countdown Finished', 'wira-kit-for-elementor' ),
		'placeholder' => __( 'Enter expired message', 'wira-kit-for-elementor' ),
	)
);

$this->end_controls_section();

// Wrapper Style.
$this->start_controls_section(
	'countdown_wrapper_style_section',
	array(
		'label' => __( 'Wrapper', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'countdown_width',
	array(
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 1400 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_height',
	array(
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'vh' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 1000 ),
			'vh' => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown' => 'min-height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_wrapper_item_gap',
	array(
		'label' => __( 'Item Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array(
				'min' => 0,
				'max' => 80,
			),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_margin',
	array(
		'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'countdown_wrapper_tabs' );

$this->start_controls_tab(
	'countdown_wrapper_tab_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'countdown_wrapper_background',
		'selector' => '{{WRAPPER}} .wkit-countdown',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'countdown_wrapper_border',
		'selector' => '{{WRAPPER}} .wkit-countdown',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'countdown_wrapper_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-countdown',
	)
);

$this->add_responsive_control(
	'countdown_wrapper_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'countdown_wrapper_tab_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'countdown_wrapper_background_hover',
		'selector' => '{{WRAPPER}} .wkit-countdown:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'countdown_wrapper_border_hover',
		'selector' => '{{WRAPPER}} .wkit-countdown:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'countdown_wrapper_box_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-countdown:hover',
	)
);

$this->add_responsive_control(
	'countdown_wrapper_border_radius_hover',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'countdown_wrapper_transition',
	array(
		'label'     => __( 'Transition Duration (s)', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		),
		'default'   => array(
			'size' => 0.3,
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->end_controls_section();

// Item Style.
$this->start_controls_section(
	'countdown_item_style_section',
	array(
		'label' => __( 'Item', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'countdown_item_width',
	array(
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 400 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-item' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_item_height',
	array(
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'vh' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 400 ),
			'vh' => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-item' => 'min-height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_item_gap',
	array(
		'label' => __( 'Content Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 60 ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-item' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_item_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'countdown_item_tabs' );

$this->start_controls_tab(
	'countdown_item_tab_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'countdown_item_background',
		'selector' => '{{WRAPPER}} .wkit-countdown-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'countdown_item_border',
		'selector' => '{{WRAPPER}} .wkit-countdown-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'countdown_item_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-countdown-item',
	)
);

$this->add_control(
	'countdown_number_color',
	array(
		'label'     => __( 'Number Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-number' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'countdown_label_color',
	array(
		'label'     => __( 'Label Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-label' => 'color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_item_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'countdown_item_tab_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'countdown_item_background_hover',
		'selector' => '{{WRAPPER}} .wkit-countdown-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'countdown_item_border_hover',
		'selector' => '{{WRAPPER}} .wkit-countdown-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'countdown_item_box_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-countdown-item:hover',
	)
);

$this->add_control(
	'countdown_number_color_hover',
	array(
		'label'     => __( 'Number Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-item:hover .wkit-countdown-number' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'countdown_label_color_hover',
	array(
		'label'     => __( 'Label Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-item:hover .wkit-countdown-label' => 'color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_item_border_radius_hover',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'countdown_item_transition',
	array(
		'label'     => __( 'Transition Duration (s)', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => array(
			'px' => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		),
		'default'   => array(
			'size' => 0.3,
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-item' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'countdown_number_typography',
		'label'    => __( 'Number Typography', 'wira-kit-for-elementor' ),
		'selector' => '{{WRAPPER}} .wkit-countdown-number',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'countdown_label_typography',
		'label'    => __( 'Label Typography', 'wira-kit-for-elementor' ),
		'selector' => '{{WRAPPER}} .wkit-countdown-label',
		'condition' => array(
			'show_labels' => 'yes',
		),
	)
);

$this->end_controls_section();

// Separator Style.
$this->start_controls_section(
	'countdown_separator_style_section',
	array(
		'label' => __( 'Separator', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => array(
			'show_separator' => 'yes',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'countdown_separator_typography',
		'selector' => '{{WRAPPER}} .wkit-countdown-separator',
	)
);

$this->add_control(
	'countdown_separator_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-separator' => 'color: {{VALUE}};',
		),
	)
);

$this->end_controls_section();

// Expired Message Style.
$this->start_controls_section(
	'countdown_expired_style_section',
	array(
		'label' => __( 'Expired Message', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'countdown_expired_typography',
		'selector' => '{{WRAPPER}} .wkit-countdown-expired',
	)
);

$this->add_control(
	'countdown_expired_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-countdown-expired' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'countdown_expired_background',
		'selector' => '{{WRAPPER}} .wkit-countdown-expired',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'countdown_expired_border',
		'selector' => '{{WRAPPER}} .wkit-countdown-expired',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'countdown_expired_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-countdown-expired',
	)
);

$this->add_responsive_control(
	'countdown_expired_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-expired' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'countdown_expired_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-countdown-expired' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();


