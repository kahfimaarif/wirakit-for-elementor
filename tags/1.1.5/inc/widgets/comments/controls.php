<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Post Comments Custom Widgets
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// === Style Tab ===
$this->start_controls_section(
    'section_style_container',
    [
        'label' => __( 'Container', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'comments_area_background',
        'selector' => '{{WRAPPER}} .comments-area',
    ]
);

$this->add_responsive_control(
    'comments_area_padding',
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
            '{{WRAPPER}} .comments-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_area_border',
        'selector' => '{{WRAPPER}} .comments-area',
    ]
);

$this->add_control(
    'comments_area_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .comments-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'comments_area_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .comments-area',
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comments_title',
    [
        'label' => __( 'Comments Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comments_title_typography',
        'selector' => '{{WRAPPER}} .comments-title , {{WRAPPER}} .comment-reply-title , {{WRAPPER}} .title-comments',
    ]
);

$this->add_control(
    'comments_title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .comments-title , {{WRAPPER}} .comment-reply-title , {{WRAPPER}} .title-comments' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'comments_title_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'default'    => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 16,
            'left'   => 0,
            'unit'   => 'px',
        ],
        'selectors'  => [
            '{{WRAPPER}} .comments-title , {{WRAPPER}} .comment-reply-title , {{WRAPPER}} .title-comments' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
        ],
    ]
);

$this->add_responsive_control(
    'comments_title_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'default'    => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 48,
            'left'   => 0,
            'unit'   => 'px',
        ],
        'selectors'  => [
            '{{WRAPPER}} .comments-title , {{WRAPPER}} .comment-reply-title , {{WRAPPER}} .title-comments' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_title_border',
        'selector' => '{{WRAPPER}} .comments-title , {{WRAPPER}} .comment-reply-title , {{WRAPPER}} .title-comments',
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_avatar',
    [
        'label' => __( 'Avatar', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_img_border',
        'selector' => '{{WRAPPER}} .comments-img img , {{WRAPPER}} .avatar',
    ]
);

$this->add_control(
    'comments_img_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .comments-img img , {{WRAPPER}} .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comments_name',
    [
        'label' => __( 'Comments Name', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comments_name_typography',
        'selector' => '{{WRAPPER}} .comments-text h6 , {{WRAPPER}} .comment-content',
    ]
);

$this->add_control(
    'comments_name_color',
    [
        'label'     => __( 'Name Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .comments-text h6 , {{WRAPPER}} .comment-content' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comments_meta',
    [
        'label' => __( 'Comments Meta', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comments_meta_typography',
        'selector' => '{{WRAPPER}} .comments-text .comments-meta',
    ]
);

$this->add_control(
    'comments_meta_color',
    [
        'label'     => __( 'Meta Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .comments-text .comments-meta' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comment_content',
    [
        'label' => __( 'Comment Content', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comment_content_typography',
        'selector' => '{{WRAPPER}} .comments-text .comment-content',
    ]
);

$this->add_control(
    'comment_content_color',
    [
        'label'     => __( 'Comment Content Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .comments-text .comment-content' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comment_link',
    [
        'label' => __( 'Comment Link', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comment_link_typography',
        'selector' => '{{WRAPPER}} a',
    ]
);

$this->add_control(
    'comment_link_color',
    [
        'label'     => __( 'Link Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'comment_link_color_hover',
    [
        'label'     => __( 'Link Color Hover', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comment_reply_title',
    [
        'label' => __( 'Comment Reply Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comment_reply_title_typography',
        'selector' => '{{WRAPPER}} .comment-reply-title',
    ]
);

$this->add_control(
    'comment_reply_title_color',
    [
        'label'     => __( 'Reply Title Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .comment-reply-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comment_notes',
    [
        'label' => __( 'Comment Notes', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comment_notes_typography',
        'selector' => '{{WRAPPER}} p.logged-in-as, {{WRAPPER}} p.comment-notes',
    ]
);

$this->add_control(
    'comment_notes_color',
    [
        'label'     => __( 'Notes Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} p.logged-in-as, {{WRAPPER}} p.comment-notes' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comment_label',
    [
        'label' => __( 'Comment Label', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comment_label_typography',
        'selector' => '{{WRAPPER}} label',
    ]
);

$this->add_control(
    'comment_label_color',
    [
        'label'     => __( 'Notes Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} label' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comments_form',
    [
        'label' => __( 'Form Field', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comments_field_typography',
        'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea',
    ]
);

$this->add_responsive_control(
    'comments_field_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} input, {{WRAPPER}} textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
        ],
    ]
);

$this->start_controls_tabs( 'comments_field_style_tabs' );

$this->start_controls_tab(
    'comments_field_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'comments_field_background',
        'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea',
    ]
);

$this->add_control(
    'comments_field_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} input::placeholder, {{WRAPPER}} textarea::placeholder' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_field_border',
        'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea',
    ]
);

$this->add_control(
    'comments_field_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} input, {{WRAPPER}} textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'comments_field_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'comments_field_background_hover',
        'selector' => '{{WRAPPER}} input:hover, {{WRAPPER}} textarea:hover',
    ]
);

$this->add_control(
    'comments_field_color_hover',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} input:hover, {{WRAPPER}} textarea:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_field_border_hover',
        'selector' => '{{WRAPPER}} input:hover, {{WRAPPER}} textarea:hover',
    ]
);

$this->add_control(
    'comments_field_border_radius_hover',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} input:hover, {{WRAPPER}} textarea:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'comments_field_focus',
    [
        'label' => __( 'Focus', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'comments_field_background_focus',
        'selector' => '{{WRAPPER}} input:focus, {{WRAPPER}} textarea:focus',
    ]
);

$this->add_control(
    'comments_field_color_focus',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} input:focus, {{WRAPPER}} textarea:focus' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_field_border_focus',
        'selector' => '{{WRAPPER}} input:focus, {{WRAPPER}} textarea:focus',
    ]
);

$this->add_control(
    'comments_field_border_radius_focus',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} input:focus, {{WRAPPER}} textarea:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();

$this->start_controls_section(
    'section_style_comments_submit',
    [
        'label' => __( 'Form Submit', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'comments_submit_typography',
        'selector' => '{{WRAPPER}} .form-submit input.submit',
    ]
);

$this->add_responsive_control(
    'comments_submit_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .form-submit input.submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
        ],
    ]
);

$this->start_controls_tabs( 'comments_submit_style_tabs' );

$this->start_controls_tab(
    'comments_submit_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'comments_submit_background',
        'selector' => '{{WRAPPER}} .form-submit input.submit',
    ]
);

$this->add_control(
    'comments_submit_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .form-submit input.submit' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_submit_border',
        'selector' => '{{WRAPPER}} .form-submit input.submit',
    ]
);

$this->add_control(
    'comments_submit_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .form-submit input.submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'comments_submit_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .form-submit input.submit',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'comments_submit_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'comments_submit_background_hover',
        'selector' => '{{WRAPPER}} .form-submit input.submit:hover',
    ]
);

$this->add_control(
    'comments_submit_color_hover',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .form-submit input.submit:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'comments_submit_border_hover',
        'selector' => '{{WRAPPER}} .form-submit input.submit:hover',
    ]
);

$this->add_control(
    'comments_submit_border_radius_hover',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .form-submit input.submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'comments_submit_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .form-submit input.submit:hover',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();


