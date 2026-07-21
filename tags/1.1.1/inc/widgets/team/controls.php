<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Team Elementor Custom Widget
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
    'section_layout',
    [
        'label' => __( 'Layout', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'layout_style',
    [
        'label'   => __( 'Layout Style', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'default'     => __( 'Default', 'wira-kit-for-elementor' ),
            'hover-overlay'   => __( 'Hover Overlay', 'wira-kit-for-elementor' ),
        ],
        'default' => 'default',
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_team',
    [
        'label' => __( 'Team Member', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'team_image',
    [
        'label' => __( 'Team Image', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Image_Size::get_type(),
    [
        'name'    => 'thumbnail',
        'default' => 'large',
    ]
);

$this->add_control(
    'team_name',
    [
        'label'   => __( 'Team Name', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Mr. John Doe', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'team_position',
    [
        'label'   => __( 'Position', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Director', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_team_social',
    [
        'label' => __( 'Social Profiles', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_social_profiles',
    [
        'label'        => __( 'Display Social Profiles?', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
    'icon',
    [
        'label'   => __( 'Icon', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value'   => 'fab fa-facebook-f',
            'library' => 'fa-brands',
        ],
    ]
);

$repeater->add_control(
    'label',
    [
        'label'       => __( 'Label', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => __( 'Facebook', 'wira-kit-for-elementor' ),
        'label_block' => true,
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->add_control(
    'link',
    [
        'label'       => __( 'Link', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
        'default'     => [
            'url' => '#',
        ],
        'dynamic' => [ 'active' => true ],
    ]
);

$repeater->start_controls_tabs( 'tabs_icon_style' );

$repeater->start_controls_tab(
    'tab_icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$repeater->add_control(
    'color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$repeater->add_control(
    'background_color',
    [
        'label'     => __( 'Background Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
        ],
    ]
);

$repeater->end_controls_tab();

$repeater->start_controls_tab(
    'tab_icon_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$repeater->add_control(
    'hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$repeater->add_control(
    'hover_background_color',
    [
        'label'     => __( 'Background Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

$repeater->end_controls_tab();

$repeater->end_controls_tabs();

$repeater->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'border',
        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
    ]
);

$repeater->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'box_shadow',
        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
    ]
);

$this->add_control(
    'social_profiles',
    [
        'label'       => __( 'Add Icon', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => '{{{ label }}}',
        'condition'   => [
            'show_social_profiles' => 'yes',
        ],
        'default'     => [
            [
                'label' => 'Facebook',
                'icon'  => [ 'value' => 'fab fa-facebook-f', 'library' => 'fa-brands' ],
                'link'  => [ 'url' => 'https://facebook.com' ],
            ],
            [
                'label' => 'Twitter',
                'icon'  => [ 'value' => 'fab fa-x-twitter', 'library' => 'fa-brands' ],
                'link'  => [ 'url' => 'https://twitter.com' ],
            ],
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_team',
    [
        'label' => __( 'Container Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'container_height',
    [
        'label'     => esc_html__( 'Container Height', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'range'     => [
            'px' => [
                'min' => 10,
                'max' => 1000,
            ],
        ],
        'default' => [
            'size' => 350,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-team' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'team_style_tabs' );

$this->start_controls_tab(
    'team_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'team_box_background',
        'selector' => '{{WRAPPER}} .wkit-team',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'team_box_border',
        'selector' => '{{WRAPPER}} .wkit-team-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'team_box_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-team-wrapper',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'team_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'team_box_background_hover',
        'selector' => '{{WRAPPER}} .wkit-team-wrapper:hover .wkit-team',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'team_box_border_hover',
        'selector' => '{{WRAPPER}} .wkit-team-wrapper:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'team_box_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-team-wrapper:hover',
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
            '{{WRAPPER}} .wkit-team-wrapper:not(.has-team-hover-overlay) .wkit-team, {{WRAPPER}} .wkit-team-wrapper:not(.has-team-hover-overlay), {{WRAPPER}} .wkit-team-wrapper:not(.has-team-hover-overlay) .wkit-team-content-wrapper, {{WRAPPER}} .wkit-team h4, {{WRAPPER}} .wkit-team p' => 'transition: all {{SIZE}}s ease;',
        ],
    ]
);

$this->add_control(
    'hover_animation_container',
    [
        'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);


$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'team_box_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'default'    => [
            'top'    => 35,
            'right'  => 35,
            'bottom' => 35,
            'left'   => 35,
            'unit'   => 'px',
        ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-team' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'team_box_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'team_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-wrapper, {{WRAPPER}} .wkit-team' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_team_wrapper',
    [
        'label' => __( 'Team Wrapper Container', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->start_controls_tabs( 'team_wrapper_style_tabs' );

$this->start_controls_tab(
    'team_wrapper_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'team_wrapper_box_background',
        'selector' => '{{WRAPPER}} .wkit-team-content-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'team_wrapper_box_border',
        'selector' => '{{WRAPPER}} .wkit-team-content-wrapper',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'team_wrapper_box_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-team-content-wrapper',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'team_wrapper_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'team_wrapper_box_background_hover',
        'selector' => '{{WRAPPER}} .wkit-team-content-wrapper:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'team_wrapper_box_border_hover',
        'selector' => '{{WRAPPER}} .wkit-team-content-wrapper:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'team_wrapper_box_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-team-content-wrapper:hover',
    ]
);

$this->add_control(
    'hover_animation_wrapper_container',
    [
        'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'team_wrapper_box_padding',
    [
        'label'      => __( 'Content Wrapper Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'team_wrapper_box_margin',
    [
        'label'      => __( 'Content Wrapper Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'team_wrapper_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_team_image',
    [
        'label' => __( 'Team Image', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'background_size',
    [
        'label'   => __( 'Background Size', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'cover'     => __( 'Cover', 'wira-kit-for-elementor' ),
            'contain'   => __( 'Contain', 'wira-kit-for-elementor' ),
            'auto'      => __( 'Auto', 'wira-kit-for-elementor' ),
        ],
        'default' => 'cover',
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-wrapper' => 'background-size: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'background_position',
    [
        'label'   => __( 'Background Position', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'center center'     => __( 'Center Center', 'wira-kit-for-elementor' ),
            'center left'       => __( 'Center Left', 'wira-kit-for-elementor' ),
            'center right'      => __( 'Center Right', 'wira-kit-for-elementor' ),
            'top center'        => __( 'Top Center', 'wira-kit-for-elementor' ),
            'top left'          => __( 'Top Left', 'wira-kit-for-elementor' ),
            'top right'         => __( 'Top Right', 'wira-kit-for-elementor' ),
            'bottom center'     => __( 'Bottom Center', 'wira-kit-for-elementor' ),
            'bottom left'       => __( 'Bottom Left', 'wira-kit-for-elementor' ),
            'bottom right'      => __( 'Bottom Right', 'wira-kit-for-elementor' ),
        ],
        'default' => 'center center',
        'selectors'  => [
            '{{WRAPPER}} .wkit-team-wrapper' => 'background-position: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_team_name',
    [
        'label' => __( 'Team Name', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'team_name_typography',
        'selector' => '{{WRAPPER}} .team-name',
    ]
);

$this->add_responsive_control(
    'team_name_alignment',
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
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .team-name' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'team_name_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .team-name' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'team_name_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-team-content-wrapper:hover .team-name' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'team_name_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .team-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_team_position',
    [
        'label' => __( 'Team Position', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'team_position_typography',
        'selector' => '{{WRAPPER}} .team-position',
    ]
);

$this->add_responsive_control(
    'team_position_alignment',
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
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .team-position' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'team_position_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .team-position' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'team_position_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-team-content-wrapper:hover .team-position' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'team_position_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .team-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_social_icon',
    [
        'label' => __( 'Social Icon Style', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_social_profiles' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'social_icon_gap',
    [
        'label' => __( 'Icon Gap', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 10,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 200,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .team-social-profiles' => 'gap: {{SIZE}}{{UNIT}};',
        ]
    ]
);

$this->add_responsive_control(
    'social_icon_alignment',
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
        'default'   => 'flex-start',
        'selectors' => [
            '{{WRAPPER}} .team-social-profiles' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'social_icon_size',
    [
        'label' => __( 'Icon Size', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 17,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 200,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .team-social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ]
    ]
);

$this->add_responsive_control(
    'social_icon_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .team-social-link' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'social_icon_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .team-social-link' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->start_controls_tabs( 'social_icon_style_tabs' );

$this->start_controls_tab(
    'social_icon_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'social_icon_background',
        'selector' => '{{WRAPPER}} .team-social-link',
    ]
);

$this->add_control(
    'social_icon_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .team-social-link svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'social_icon_border',
        'selector' => '{{WRAPPER}} .team-social-link',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'social_icon_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .team-social-link',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'social_icon_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'social_icon_background_hover',
        'selector' => '{{WRAPPER}} .team-social-link:hover',
    ]
);

$this->add_control(
    'social_icon_hover_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .team-social-link:hover svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'social_icon_border_hover',
        'selector' => '{{WRAPPER}} .team-social-link:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'social_icon_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .team-social-link:hover',
    ]
);

$this->add_control(
    'hover_animation_social_icon',
    [
        'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'social_icon_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .team-social-profiles' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'social_icon_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .team-social-profiles a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


