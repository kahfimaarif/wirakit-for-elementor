<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Brand Logo Elementor Custom Widget
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
		'label' => __( 'Content', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	]
);

$this->add_control(
	'logo_mode',
	[
		'label'   => __( 'Logo Source', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'inherit',
		'options' => [
			'inherit' => __( 'Inherit from Custom Logo', 'wira-kit-for-elementor' ),
			'custom'  => __( 'Custom Image', 'wira-kit-for-elementor' ),
		],
		'dynamic' => [ 'active' => true ],
	]
);

$this->add_control(
	'logo_image',
	[
		'label'     => __( 'Logo Image', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::MEDIA,
		'default'   => [
			'url' => \Elementor\Utils::get_placeholder_image_src(),
		],
		'condition' => [
			'logo_mode' => 'custom',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Image_Size::get_type(),
	[
		'name'      => 'logo',
		'default'   => 'full',
		'condition' => [
			'logo_mode' => 'custom',
		],
	]
);

$this->add_control(
	'enable_link',
	[
		'label'        => __( 'Enable Link', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
	'section_style_logo',
	[
		'label' => __( 'Image', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	]
);

$this->add_responsive_control(
	'logo_align',
	[
		'label'     => __( 'Alignment', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::CHOOSE,
		'options'   => [
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
		'selectors' => [
			'{{WRAPPER}} .wkit-brand-logo' => 'text-align: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
	'logo_width',
	[
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ '%', 'px' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-brand-logo img' => 'width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'logo_max_width',
	[
		'label'      => __( 'Max Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ '%', 'px' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-brand-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'logo_height',
	[
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', 'vh' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-brand-logo img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
		],
	]
);

$this->add_control(
	'logo_opacity',
	[
		'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => [
			'px' => [
				'min'  => 0.1,
				'max'  => 1,
				'step' => 0.01,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .wkit-brand-logo img' => 'opacity: {{SIZE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Css_Filter::get_type(),
	[
		'name'     => 'css_filters',
		'selector' => '{{WRAPPER}} .wkit-brand-logo img',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'logo_border',
		'selector' => '{{WRAPPER}} .wkit-brand-logo img',
	]
);

$this->add_responsive_control(
	'logo_border_radius',
	[
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-brand-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'logo_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-brand-logo img',
	]
);

$this->end_controls_section();


