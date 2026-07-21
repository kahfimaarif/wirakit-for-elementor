<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls for Tooltip Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->start_controls_section(
	'tooltip_content_section',
	array(
		'label' => __( 'Content', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	)
);

$this->add_control(
	'tooltip_trigger_text',
	array(
		'label'       => __( 'Trigger Text', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Hover me', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'dynamic' => [ 'active' => true ],
	)
);

$this->add_control(
	'tooltip_content_text',
	array(
		'label'       => __( 'Tooltip Content', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXTAREA,
		'default'     => __( 'Tooltip content goes here.', 'wira-kit-for-elementor' ),
		'rows'        => 4,
		'label_block' => true,
		'dynamic' => [ 'active' => true ],
	)
);

$this->add_control(
	'trigger_link',
	array(
		'label'       => __( 'Trigger Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
		'dynamic' => [ 'active' => true ],
	)
);

$this->add_control(
	'trigger_icon',
	array(
		'label'   => __( 'Trigger Icon', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::ICONS,
		'default' => [
			'value'   => 'fas fa-info-circle',
			'library' => 'fa-solid',
		],
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'tooltip_trigger_style_section',
	array(
		'label' => __( 'Trigger', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'trigger_icon_spacing',
	array(
		'label' => __( 'Icon Spacing', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => array(
			'px' => array( 'min' => 0, 'max' => 50 ),
		),
		'default'   => array( 'size' => 6, 'unit' => 'px' ),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-trigger' => 'gap: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'trigger_typography',
		'selector' => '{{WRAPPER}} .wkit-tooltip-trigger',
	)
);

$this->add_responsive_control(
	'trigger_alignment',
	array(
		'label'     => __( 'Alignment', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::CHOOSE,
		'options'   => array(
			'left' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'right' => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-wrapper' => 'text-align: {{VALUE}};',
		),
	)
);

$this->start_controls_tabs( 'tooltip_trigger_tabs' );

$this->start_controls_tab(
	'tooltip_trigger_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'trigger_text_color',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-trigger' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'trigger_icon_color',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'trigger_background',
		'selector' => '{{WRAPPER}} .wkit-tooltip-trigger',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'trigger_border',
		'selector' => '{{WRAPPER}} .wkit-tooltip-trigger',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'trigger_shadow',
		'selector' => '{{WRAPPER}} .wkit-tooltip-trigger',
	)
);

$this->add_control(
	'trigger_icon_bg_color',
	array(
		'label'     => __( 'Icon Background', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'background-color: {{VALUE}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_icon_width',
	array(
		'label'      => __( 'Icon Wrapper Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_icon_height',
	array(
		'label'      => __( 'Icon Wrapper Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
			'%'  => array( 'min' => 0, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_icon_size',
	array(
		'label'      => __( 'Icon Size', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'em' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
			'em' => array( 'min' => 0, 'max' => 10 ),
		),
		'default'    => array(
			'size' => 17,
			'unit' => 'px',
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
			'{{WRAPPER}} .wkit-tooltip-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_icon_line_height',
	array(
		'label'      => __( 'Icon Line Height', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', 'em' ),
		'range'      => array(
			'px' => array( 'min' => 0, 'max' => 200 ),
			'em' => array( 'min' => 0, 'max' => 10 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'trigger_icon_border',
		'selector' => '{{WRAPPER}} .wkit-tooltip-icon',
	)
);

$this->add_responsive_control(
	'trigger_icon_border_radius',
	array(
		'label'      => __( 'Icon Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'trigger_icon_shadow',
		'selector' => '{{WRAPPER}} .wkit-tooltip-icon',
	)
);

$this->add_responsive_control(
	'trigger_icon_padding',
	array(
		'label'      => __( 'Icon Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_icon_margin',
	array(
		'label'      => __( 'Icon Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'tooltip_trigger_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'trigger_text_color_hover',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-trigger' => 'color: {{VALUE}};',
		),
	)
);

$this->add_control(
	'trigger_icon_color_hover',
	array(
		'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-icon' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'trigger_background_hover',
		'selector' => '{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-trigger',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'trigger_border_hover',
		'selector' => '{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-trigger',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'trigger_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-trigger',
	)
);

$this->add_control(
	'trigger_icon_bg_color_hover',
	array(
		'label'     => __( 'Icon Background', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-icon' => 'background-color: {{VALUE}};',
		),
	)
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
	'trigger_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_margin',
	array(
		'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'trigger_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();

$this->start_controls_section(
	'tooltip_content_style_section',
	array(
		'label' => __( 'Tooltip Content', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

$this->add_responsive_control(
	'content_width',
	array(
		'label'      => __( 'Width', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%', 'em' ),
		'range'      => array(
			'px' => array( 'min' => 50, 'max' => 600 ),
			'%'  => array( 'min' => 10, 'max' => 100 ),
			'em' => array( 'min' => 5, 'max' => 50 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-content' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'content_horizontal_position',
	array(
		'label'      => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => -300, 'max' => 300 ),
			'%'  => array( 'min' => -100, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-content' => '--wkit-tooltip-x: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'content_vertical_position',
	array(
		'label'      => __( 'Vertical Position', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array( 'min' => -300, 'max' => 300 ),
			'%'  => array( 'min' => -100, 'max' => 100 ),
		),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-content' => '--wkit-tooltip-y: {{SIZE}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'content_text_align',
	array(
		'label'   => __( 'Text Alignment', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'left' => array(
				'title' => __( 'Left', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			),
			'right' => array(
				'title' => __( 'Right', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			),
			'justify' => array(
				'title' => __( 'Justify', 'wira-kit-for-elementor' ),
				'icon'  => 'eicon-text-align-justify',
			),
		),
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-content' => 'text-align: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'content_typography',
		'selector' => '{{WRAPPER}} .wkit-tooltip-content',
	)
);

$this->start_controls_tabs( 'tooltip_content_tabs' );

$this->start_controls_tab(
	'tooltip_content_normal',
	array(
		'label' => __( 'Normal', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'content_text_color',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-content' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'content_background',
		'selector' => '{{WRAPPER}} .wkit-tooltip-content',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'content_border',
		'selector' => '{{WRAPPER}} .wkit-tooltip-content',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'content_shadow',
		'selector' => '{{WRAPPER}} .wkit-tooltip-content',
	)
);

$this->end_controls_tab();

$this->start_controls_tab(
	'tooltip_content_hover',
	array(
		'label' => __( 'Hover', 'wira-kit-for-elementor' ),
	)
);

$this->add_control(
	'content_text_color_hover',
	array(
		'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => array(
			'{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-content' => 'color: {{VALUE}};',
		),
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	array(
		'name'     => 'content_background_hover',
		'selector' => '{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-content',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'content_border_hover',
		'selector' => '{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-content',
	)
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'content_shadow_hover',
		'selector' => '{{WRAPPER}} .wkit-tooltip-wrapper:hover .wkit-tooltip-content',
	)
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
	'content_padding',
	array(
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'content_margin',
	array(
		'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->add_responsive_control(
	'content_border_radius',
	array(
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .wkit-tooltip-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();
