<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Accordion Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
	'accordion_content_section',
	array(
		'label' => __( 'Accordion Items', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
	'accordion_title',
	array(
		'label'       => __( 'Title', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Accordion Title', 'wira-kit-for-elementor' ),
		'label_block' => true,
	)
);

$repeater->add_control(
	'accordion_content',
	array(
		'label'   => __( 'Content', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::WYSIWYG,
		'default' => __( 'Add accordion content here.', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_items',
	array(
		'label'       => __( 'Items', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $repeater->get_controls(),
		'title_field' => '{{{ accordion_title }}}',
		'default'     => array(
			array(
				'accordion_title'   => __( 'What services do you provide?', 'wira-kit-for-elementor' ),
				'accordion_content' => __( 'We provide web design, development, and brand strategy services for business growth.', 'wira-kit-for-elementor' ),
			),
			array(
				'accordion_title'   => __( 'How long is your project timeline?', 'wira-kit-for-elementor' ),
				'accordion_content' => __( 'Project timeline depends on scope, usually between 2-8 weeks.', 'wira-kit-for-elementor' ),
			),
			array(
				'accordion_title'   => __( 'Do you provide post-launch support?', 'wira-kit-for-elementor' ),
				'accordion_content' => __( 'Yes, we provide maintenance and optimization packages after launch.', 'wira-kit-for-elementor' ),
			),
		),
	)
);

$this->add_control(
	'accordion_icon',
	array(
		'label'   => __( 'Icon', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::ICONS,
		'default' => array(
			'value'   => 'fas fa-plus',
			'library' => 'fa-solid',
		),
	)
);

$this->add_control(
	'accordion_icon_active',
	array(
		'label'   => __( 'Active Icon', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::ICONS,
		'default' => array(
			'value'   => 'fas fa-minus',
			'library' => 'fa-solid',
		),
	)
);

$this->add_control(
	'default_active_item',
	array(
		'label'       => __( 'Default Active Item', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::NUMBER,
		'default'     => 1,
		'min'         => 1,
		'step'        => 1,
		'description' => __( 'Start from 1.', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'enable_faq_schema',
	array(
		'label'        => __( 'Enable FAQ Schema', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'accordion_item_style_section',
	array(
		'label' => __( 'Accordion Item', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'accordion_items_gap',
	array(
		'label'      => __( 'Gap Between Items', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 80 ),
		),
		'default'    => array(
			'size' => 12,
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'accordion_item_padding',
	array(
		'label'      => __( 'Item Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'accordion_item_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'accordion_item_style_tabs' );

$this->start_controls_tab(
	'accordion_item_style_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_item_bg_normal',
		'selector' => '{{WRAPPER}} .wkit-accordion-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'accordion_item_border_normal',
		'selector' => '{{WRAPPER}} .wkit-accordion-item',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'accordion_item_shadow_normal',
		'selector' => '{{WRAPPER}} .wkit-accordion-item',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'accordion_item_style_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_item_bg_hover',
		'selector' => '{{WRAPPER}} .wkit-accordion-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'accordion_item_border_hover',
		'selector' => '{{WRAPPER}} .wkit-accordion-item:hover',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'accordion_item_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-accordion-item:hover',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'accordion_item_style_active',
	array(
		'label' => __( 'Active', 'wira-kit-for-elementor' ),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_item_bg_active',
		'selector' => '{{WRAPPER}} .wkit-accordion-item.is-active',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'accordion_item_border_active',
		'selector' => '{{WRAPPER}} .wkit-accordion-item.is-active',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'accordion_item_shadow_active',
		'selector' => '{{WRAPPER}} .wkit-accordion-item.is-active',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->end_controls_section();

$this->start_controls_section(
	'accordion_header_style_section',
	array(
		'label' => __( 'Accordion Header', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'accordion_title_typography',
		'selector' => '{{WRAPPER}} .wkit-accordion-title',
	)
);

$this->add_responsive_control(
	'accordion_header_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'accordion_header_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'accordion_header_gap',
	array(
		'label'      => __( 'Title/Icon Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 60 ),
		),
		'default'    => array(
			'size' => 12,
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-header' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'accordion_icon_size',
	array(
		'label'      => __( 'Icon Size', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px' ),
		'range'      => array(
			'px' => array( 'min' => 8, 'max' => 80 ),
		),
		'default'    => array(
			'size' => 16,
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
			'{{WRAPPER}} .wkit-accordion-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->start_controls_tabs( 'accordion_header_style_tabs' );

$this->start_controls_tab(
	'accordion_header_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_header_title_color',
	array(
		'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'accordion_header_icon_color',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-icon' => 'color: {{VALUE}};',
			'{{WRAPPER}} .wkit-accordion-icon svg' => 'fill: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_header_bg_normal',
		'selector' => '{{WRAPPER}} .wkit-accordion-header',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'accordion_header_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_header_title_color_hover',
	array(
		'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-header:hover .wkit-accordion-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'accordion_header_icon_color_hover',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-header:hover .wkit-accordion-icon' => 'color: {{VALUE}};',
			'{{WRAPPER}} .wkit-accordion-header:hover .wkit-accordion-icon svg' => 'fill: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_header_bg_hover',
		'selector' => '{{WRAPPER}} .wkit-accordion-header:hover',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'accordion_header_active',
	array(
		'label' => __( 'Active', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_header_title_color_active',
	array(
		'label'     => __( 'Title Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-item.is-active .wkit-accordion-title' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'accordion_header_icon_color_active',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-item.is-active .wkit-accordion-icon' => 'color: {{VALUE}};',
			'{{WRAPPER}} .wkit-accordion-item.is-active .wkit-accordion-icon svg' => 'fill: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_header_bg_active',
		'selector' => '{{WRAPPER}} .wkit-accordion-item.is-active .wkit-accordion-header',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->end_controls_section();

$this->start_controls_section(
	'accordion_content_style_section',
	array(
		'label' => __( 'Accordion Content', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'accordion_content_typography',
		'selector' => '{{WRAPPER}} .wkit-accordion-body',
	)
);

$this->add_responsive_control(
	'accordion_content_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-body-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'accordion_content_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-accordion-body-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'accordion_content_border',
		'selector' => '{{WRAPPER}} .wkit-accordion-body-inner',
	)
);

$this->start_controls_tabs( 'accordion_content_style_tabs' );

$this->start_controls_tab(
	'accordion_content_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_content_color',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-body' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_content_bg_normal',
		'selector' => '{{WRAPPER}} .wkit-accordion-body-inner',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'accordion_content_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_content_color_hover',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-item:hover .wkit-accordion-body' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_content_bg_hover',
		'selector' => '{{WRAPPER}} .wkit-accordion-item:hover .wkit-accordion-body-inner',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'accordion_content_active',
	array(
		'label' => __( 'Active', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'accordion_content_color_active',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-accordion-item.is-active .wkit-accordion-body' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'accordion_content_bg_active',
		'selector' => '{{WRAPPER}} .wkit-accordion-item.is-active .wkit-accordion-body-inner',
	)
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->end_controls_section();

