<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Progress Bar Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
	'progress_bar_content_section',
	array(
		'label' => __( 'Progress Bar', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'progress_label',
	array(
		'label'       => __( 'Label', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'High Priority Support Cases', 'wira-kit-for-elementor' ),
		'placeholder' => __( 'Enter label', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'progress_value',
	array(
		'label'      => __( 'Percentage', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( '%' ),
		'range'      => array(
			'%' => array(
				'min' => 0,
				'max' => 100,
			),
		),
		'default' => array(
			'size' => 92,
			'unit' => '%',
		),
	)
);

$this->add_control(
	'show_percentage',
	array(
		'label'        => __( 'Show Percentage', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'progress_animation_duration',
	array(
		'label'       => __( 'Animation Duration (ms)', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::NUMBER,
		'default'     => 1200,
		'min'         => 0,
		'max'         => 10000,
		'step'        => 50,
		'description' => __( 'Set 0 for instant value.', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'progress_animation_easing',
	array(
		'label'   => __( 'Animation Easing', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'easeOutCubic',
		'options' => array(
			'linear'         => __( 'Linear', 'wira-kit-for-elementor' ),
			'ease'           => __( 'Ease', 'wira-kit-for-elementor' ),
			'easeIn'         => __( 'Ease In', 'wira-kit-for-elementor' ),
			'easeOut'        => __( 'Ease Out', 'wira-kit-for-elementor' ),
			'easeInOut'      => __( 'Ease In Out', 'wira-kit-for-elementor' ),
			'easeInSine'     => __( 'Ease In Sine', 'wira-kit-for-elementor' ),
			'easeOutSine'    => __( 'Ease Out Sine', 'wira-kit-for-elementor' ),
			'easeInOutSine'  => __( 'Ease In Out Sine', 'wira-kit-for-elementor' ),
			'easeInQuad'     => __( 'Ease In Quad', 'wira-kit-for-elementor' ),
			'easeOutQuad'    => __( 'Ease Out Quad', 'wira-kit-for-elementor' ),
			'easeInOutQuad'  => __( 'Ease In Out Quad', 'wira-kit-for-elementor' ),
			'easeInCubic'    => __( 'Ease In Cubic', 'wira-kit-for-elementor' ),
			'easeOutCubic'   => __( 'Ease Out Cubic', 'wira-kit-for-elementor' ),
			'easeInOutCubic' => __( 'Ease In Out Cubic', 'wira-kit-for-elementor' ),
			'easeInQuart'    => __( 'Ease In Quart', 'wira-kit-for-elementor' ),
			'easeOutQuart'   => __( 'Ease Out Quart', 'wira-kit-for-elementor' ),
			'easeInOutQuart' => __( 'Ease In Out Quart', 'wira-kit-for-elementor' ),
			'easeInQuint'    => __( 'Ease In Quint', 'wira-kit-for-elementor' ),
			'easeOutQuint'   => __( 'Ease Out Quint', 'wira-kit-for-elementor' ),
			'easeInOutQuint' => __( 'Ease In Out Quint', 'wira-kit-for-elementor' ),
			'easeInExpo'     => __( 'Ease In Expo', 'wira-kit-for-elementor' ),
			'easeOutExpo'    => __( 'Ease Out Expo', 'wira-kit-for-elementor' ),
			'easeInOutExpo'  => __( 'Ease In Out Expo', 'wira-kit-for-elementor' ),
			'easeInCirc'     => __( 'Ease In Circ', 'wira-kit-for-elementor' ),
			'easeOutCirc'    => __( 'Ease Out Circ', 'wira-kit-for-elementor' ),
			'easeInOutCirc'  => __( 'Ease In Out Circ', 'wira-kit-for-elementor' ),
			'easeInBack'     => __( 'Ease In Back', 'wira-kit-for-elementor' ),
			'easeOutBack'    => __( 'Ease Out Back', 'wira-kit-for-elementor' ),
			'easeInOutBack'  => __( 'Ease In Out Back', 'wira-kit-for-elementor' ),
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'progress_bar_header_style_section',
	array(
		'label' => __( 'Label & Percentage', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'progress_label_typography',
		'label'    => __( 'Label Typography', 'wira-kit-for-elementor' ),
		'selector' => '{{WRAPPER}} .wkit-progressbar-label',
	)
);

$this->add_control(
	'progress_label_color',
	array(
		'label'     => __( 'Label Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-progressbar-label' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'      => 'progress_percentage_typography',
		'label'     => __( 'Percentage Typography', 'wira-kit-for-elementor' ),
		'selector'  => '{{WRAPPER}} .wkit-progressbar-percentage',
		'condition' => array(
			'show_percentage' => 'yes',
		),
	)
);

$this->add_control(
	'progress_percentage_color',
	array(
		'label'     => __( 'Percentage Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'condition' => array(
			'show_percentage' => 'yes',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-progressbar-percentage' => 'color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'progress_gap',
	array(
		'label' => __( 'Gap Label/Percentage from Bar', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array(
				'min' => 0,
				'max' => 100,
			),
		),
		'default' => array(
			'size' => 16,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-progressbar-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'progress_bar_style_section',
	array(
		'label' => __( 'Progress Bar', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'progress_bar_height',
	array(
		'label' => __( 'Height', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array(
				'min' => 2,
				'max' => 60,
			),
		),
		'default' => array(
			'size' => 6,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-progressbar-track, {{WRAPPER}} .wkit-progressbar-fill' => 'height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'progress_bar_background',
	array(
		'label'     => __( 'Progress Bar Background', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#D5D5D5',
		'selectors' => array(
			'{{WRAPPER}} .wkit-progressbar-track' => 'background-color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'progress_bar_filled',
	array(
		'label'     => __( 'Progress Bar Filled', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#7E6BFF',
		'selectors' => array(
			'{{WRAPPER}} .wkit-progressbar-fill' => 'background-color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'progress_bar_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-progressbar-track, {{WRAPPER}} .wkit-progressbar-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();
