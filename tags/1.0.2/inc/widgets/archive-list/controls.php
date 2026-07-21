<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Archive List Elementor Custom Widget
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
		'label' => __( 'Archive List', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	]
);

$this->add_control(
	'archive_type',
	[
		'label'   => __( 'Archive Type', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'category',
		'options' => [
			'category' => __( 'Category', 'wira-kit-for-elementor' ),
			'tag'      => __( 'Tag', 'wira-kit-for-elementor' ),
			'author'   => __( 'Author', 'wira-kit-for-elementor' ),
			'date'     => __( 'Date', 'wira-kit-for-elementor' ),
			'all'      => __( 'All', 'wira-kit-for-elementor' ),
		],
	]
);

$this->add_control(
	'related_tag_only',
	[
		'label'        => __( 'Related Post Tags Only', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
		'condition'    => [
			'archive_type' => 'tag',
		],
	]
);

$this->add_control(
	'enable_item_icon',
	[
		'label'        => __( 'Enable Item Icon', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
	]
);

$this->add_control(
	'item_icon',
	[
		'label'     => __( 'Item Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'fas fa-folder-open',
			'library' => 'fa-solid',
		],
		'condition' => [
			'enable_item_icon' => 'yes',
		],
	]
);

$this->end_controls_section();

// === Style Tab: Container ===
$this->start_controls_section(
	'section_container_style',
	[
		'label' => __( 'Archive Container', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	]
);

$this->add_responsive_control(
	'container_direction',
	[
		'label'   => __( 'Direction', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => [
			'column' => [
				'title' => __( 'Vertical', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-editor-list-ul',
			],
			'row' => [
				'title' => __( 'Horizontal', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-h-align-left',
			],
		],
		'default'   => 'column',
		'toggle'    => false,
		'selectors' => [
			'{{WRAPPER}} .wkit-archive-items' => 'flex-direction: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
	'container_alignment',
	[
		'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => [
			'flex-start' => [
				'title' => __( 'Start', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-align-start-h',
			],
			'center' => [
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-align-center-h',
			],
			'flex-end' => [
				'title' => __( 'End', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-align-end-h',
			],
			'space-between' => [
				'title' => __( 'Space Between', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-justify-space-between-h',
			],
		],
		'default'   => 'flex-start',
		'toggle'    => false,
		'selectors' => [
			'{{WRAPPER}} .wkit-archive-items' => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
	'container_gap',
	[
		'label'      => __( 'Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-items' => 'gap: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'container_padding',
	[
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'container_margin',
	[
		'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'     => 'container_background',
		'types'    => [ 'classic', 'gradient' ],
		'selector' => '{{WRAPPER}} .wkit-archive-list',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'container_border',
		'selector' => '{{WRAPPER}} .wkit-archive-list',
	]
);

$this->add_control(
	'container_radius',
	[
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'container_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-archive-list',
	]
);

$this->end_controls_section();

// === Style Tab: Title ===
$this->start_controls_section(
	'section_item_style',
	[
		'label' => __( 'Archive Item', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	[
		'name'     => 'item_typography',
		'selector' => '{{WRAPPER}} .wkit-archive-link',
	]
);

$this->add_responsive_control(
	'item_width',
	[
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-link' => 'width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'item_height',
	[
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-link' => 'height: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->start_controls_tabs( 'item_tabs' );

$this->start_controls_tab(
	'item_tab_normal',
	[
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	]
);

$this->add_control(
	'item_color',
	[
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .wkit-archive-link' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'     => 'item_background',
		'selector' => '{{WRAPPER}} .wkit-archive-link',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'item_border',
		'selector' => '{{WRAPPER}} .wkit-archive-link',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'item_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-archive-link',
	]
);

$this->end_controls_tab();

$this->start_controls_tab(
	'item_tab_hover',
	[
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	]
);

$this->add_control(
	'item_color_hover',
	[
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .wkit-archive-link:hover, {{WRAPPER}} .wkit-archive-item:hover .wkit-archive-link' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'     => 'item_background_hover',
		'selector' => '{{WRAPPER}} .wkit-archive-link:hover, {{WRAPPER}} .wkit-archive-item:hover .wkit-archive-link',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'item_border_hover',
		'selector' => '{{WRAPPER}} .wkit-archive-link:hover, {{WRAPPER}} .wkit-archive-item:hover .wkit-archive-link',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'item_box_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-archive-link:hover, {{WRAPPER}} .wkit-archive-item:hover .wkit-archive-link',
	]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
	'item_padding',
	[
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'item_margin',
	[
		'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'item_radius',
	[
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->end_controls_section();

// === Style Tab: Icon ===
$this->start_controls_section(
	'section_icon_style',
	[
		'label' => __( 'Icon', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'enable_item_icon' => 'yes',
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
			'{{WRAPPER}} .wkit-archive-item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'icon_width',
	[
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-item-icon' => 'width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'icon_height',
	[
		'label'      => __( 'Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-item-icon' => 'height: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->start_controls_tabs( 'icon_tabs' );

$this->start_controls_tab(
	'icon_tab_normal',
	[
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	]
);

$this->add_control(
	'icon_color',
	[
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .wkit-archive-item-icon' => 'color: {{VALUE}};',
			'{{WRAPPER}} .wkit-archive-item-icon svg' => 'fill: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'     => 'icon_background',
		'selector' => '{{WRAPPER}} .wkit-archive-item-icon',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'icon_border',
		'selector' => '{{WRAPPER}} .wkit-archive-item-icon',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'icon_box_shadow',
		'selector' => '{{WRAPPER}} .wkit-archive-item-icon',
	]
);

$this->end_controls_tab();

$this->start_controls_tab(
	'icon_tab_hover',
	[
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	]
);

$this->add_control(
	'icon_color_hover',
	[
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .wkit-archive-item:hover .wkit-archive-item-icon' => 'color: {{VALUE}};',
			'{{WRAPPER}} .wkit-archive-item:hover .wkit-archive-item-icon svg' => 'fill: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'     => 'icon_background_hover',
		'selector' => '{{WRAPPER}} .wkit-archive-item:hover .wkit-archive-item-icon',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'icon_border_hover',
		'selector' => '{{WRAPPER}} .wkit-archive-item:hover .wkit-archive-item-icon',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'icon_box_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-archive-item:hover .wkit-archive-item-icon',
	]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
	'icon_padding',
	[
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-item-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'icon_margin',
	[
		'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-item-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'icon_radius',
	[
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .wkit-archive-item-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->end_controls_section();


