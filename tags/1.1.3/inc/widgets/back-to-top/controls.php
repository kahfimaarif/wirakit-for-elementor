<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Back To Top Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
	'back_to_top_content_section',
	array(
		'label' => __( 'Content', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'icon_button',
	array(
		'label'            => __( 'Icon', 'wira-kit-for-elementor' ),
		'type'             => \Elementor\Controls_Manager::ICONS,
		'fa4compatibility' => 'icon',
		'default'          => array(
			'value'   => 'fas fa-arrow-up',
			'library' => 'fa-solid',
		),
	)
);

$this->add_control(
	'auto_hide',
	array(
		'label'        => __( 'Auto Hide', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_control(
	'hide_offset',
	array(
		'label'     => __( 'Show After Scroll (px)', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 200,
		'min'       => 0,
		'step'      => 10,
		'condition' => array(
			'auto_hide' => 'yes',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'back_to_top_icon_style_section',
	array(
		'label' => __( 'Icon Style', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'icon_width',
	array(
		'label' => __( 'Width', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-back-to-top-btn' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'icon_height',
	array(
		'label' => __( 'Height', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-back-to-top-btn' => 'height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'icon_line_height',
	array(
		'label' => __( 'Line Height', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-back-to-top-btn i' => 'line-height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'icon_size',
	array(
		'label' => __( 'Icon Size', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-back-to-top-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'back_to_top_icon_tabs' );

$this->start_controls_tab(
	'back_to_top_icon_normal_tab',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'icon_background',
		'selector' => '{{WRAPPER}} .wkit-back-to-top-btn',
	)
);

$this->add_control(
	'icon_color',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-back-to-top-btn i' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'icon_border',
		'selector' => '{{WRAPPER}} .wkit-back-to-top-btn',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'icon_shadow',
		'selector' => '{{WRAPPER}} .wkit-back-to-top-btn',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'back_to_top_icon_hover_tab',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'icon_background_hover',
		'selector' => '{{WRAPPER}} .wkit-back-to-top-btn:hover',
	)
);

$this->add_control(
	'icon_color_hover',
	array(
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-back-to-top-btn:hover i' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'icon_border_hover',
		'selector' => '{{WRAPPER}} .wkit-back-to-top-btn:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'icon_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-back-to-top-btn:hover',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_responsive_control(
	'icon_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-back-to-top-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'icon_transition',
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
			'{{WRAPPER}} .wkit-back-to-top-btn' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_section();



