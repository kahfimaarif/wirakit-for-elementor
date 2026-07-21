<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Logo Marquee Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
	'logo_marquee_content_section',
	array(
		'label' => __( 'Logos', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
	'logo_image',
	array(
		'label'   => __( 'Image', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::MEDIA,
		'default' => array(
			'url' => \Elementor\Utils::get_placeholder_image_src(),
		),
	)
);

$repeater->add_control(
	'logo_link',
	array(
		'label'       => __( 'Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( '#', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'logo_items',
	array(
		'label'       => __( 'Logo Items', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $repeater->get_controls(),
		'default'     => array(
			array( 'logo_image' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ) ),
			array( 'logo_image' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ) ),
			array( 'logo_image' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ) ),
		),
		'title_field' => __( 'Logo Item', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Image_Size::get_type(),
	array(
		'name'    => 'marquee_logo',
		'default' => 'full',
	)
);

$this->add_control(
	'marquee_direction',
	array(
		'label'   => __( 'Direction', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'left',
		'options' => array(
			'left'  => __( 'Left', 'wira-kit-for-elementor' ),
			'right' => __( 'Right', 'wira-kit-for-elementor' ),
		),
	)
);

$this->add_control(
	'pause_on_hover',
	array(
		'label'        => __( 'Pause On Hover', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	)
);

$this->add_responsive_control(
	'marquee_duration',
	array(
		'label'      => __( 'Animation Duration (s)', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array(
				'min' => 5,
				'max' => 120,
			),
		),
		'default'    => array(
			'size' => 30,
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-track' => 'animation-duration: {{SIZE}}s;',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'logo_marquee_item_style_section',
	array(
		'label' => __( 'Item', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'item_gap',
	array(
		'label' => __( 'Item Gap', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 120 ),
		),
		'default' => array(
			'size' => 30,
			'unit' => 'px',
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-logo-marquee-track' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'item_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'item_style_tabs' );

$this->start_controls_tab(
	'item_style_normal_tab',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'item_background',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'item_border',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'item_shadow',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item',
	)
);

$this->add_responsive_control(
	'item_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'item_style_hover_tab',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'item_background_hover',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'item_border_hover',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'item_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item:hover',
	)
);

$this->add_responsive_control(
	'item_radius_hover',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'item_transition',
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
			'{{WRAPPER}} .wkit-logo-marquee-item' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->end_controls_section();

$this->start_controls_section(
	'logo_marquee_image_style_section',
	array(
		'label' => __( 'Image', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'image_width',
	array(
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 600 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item img' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'image_height',
	array(
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'vh' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 400 ),
			'vh' => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item img' => 'height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'image_object_fit',
	array(
		'label'   => __( 'Object Fit', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'contain',
		'options' => array(
			'contain' => __( 'Contain', 'wira-kit-for-elementor' ),
			'cover'   => __( 'Cover', 'wira-kit-for-elementor' ),
			'fill'    => __( 'Fill', 'wira-kit-for-elementor' ),
			'none'    => __( 'None', 'wira-kit-for-elementor' ),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-logo-marquee-item img' => 'object-fit: {{VALUE}};',
		),
	)
);

$this->start_controls_tabs( 'image_style_tabs' );

$this->start_controls_tab(
	'image_style_normal_tab',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'image_opacity',
	array(
		'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array(
				'min'  => 0.1,
				'max'  => 1,
				'step' => 0.01,
			),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-logo-marquee-item img' => 'opacity: {{SIZE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'image_border',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item img',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'image_shadow',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item img',
	)
);

$this->add_responsive_control(
	'image_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'image_style_hover_tab',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'image_opacity_hover',
	array(
		'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array(
				'min'  => 0.1,
				'max'  => 1,
				'step' => 0.01,
			),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-logo-marquee-item:hover img' => 'opacity: {{SIZE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'image_border_hover',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item:hover img',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'image_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-logo-marquee-item:hover img',
	)
);

$this->add_responsive_control(
	'image_radius_hover',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-logo-marquee-item:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_control(
	'image_transition',
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
			'{{WRAPPER}} .wkit-logo-marquee-item img' => 'transition: all {{SIZE}}s ease-in-out;',
		),
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->end_controls_section();



