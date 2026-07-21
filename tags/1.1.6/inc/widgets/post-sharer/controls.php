<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Post Sharer Elementor Custom Widget
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
    'social_media_section',
    [
        'label' => __( 'Social Media', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'choose_style',
    [
        'label'   => __( 'Choose Style', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'icon',
        'options' => [
            'icon'  => __( 'Icon', 'wira-kit-for-elementor' ),
            'text'  => __( 'Text', 'wira-kit-for-elementor' ),
            'both'  => __( 'Icon + Text', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->add_responsive_control(
    'alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'start' => [
                'title' => __( 'Start', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-align-start-h',
            ],
            'center' => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-align-center-h',
            ],
            'end' => [
                'title' => __( 'End', 'wira-kit-for-elementor' ),
                'icon' => 'eicon-align-end-h',
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share' => 'justify-content: {{VALUE}};',
        ],
        'default' => 'center',
        'toggle' => false,
    ]
);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
    'icon',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fab fa-facebook-f',
            'library' => 'fa-brands',
        ],
    ]
);

$repeater->add_control(
    'social_media',
    [
        'label'   => __( 'Social Media', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'facebook',
        'options'  => [
            'facebook'      => __( 'Facebook', 'wira-kit-for-elementor' ),
            'twitter'       => __( 'Twitter X', 'wira-kit-for-elementor' ),
            'pinterest'     => __( 'Pinterest', 'wira-kit-for-elementor' ),
            'linkedin'      => __( 'LinkedIn', 'wira-kit-for-elementor' ),
            'tumblr'        => __( 'Tumblr', 'wira-kit-for-elementor' ),
            'flicker'       => __( 'Flickr', 'wira-kit-for-elementor' ),
            'vkontakte'     => __( 'VKontakte', 'wira-kit-for-elementor' ),
            'odnoklassniki' => __( 'Odnoklassniki', 'wira-kit-for-elementor' ),
            'moimir'        => __( 'Moimir', 'wira-kit-for-elementor' ),
            'live journal'  => __( 'Live Journal', 'wira-kit-for-elementor' ),
            'blogger'       => __( 'Blogger', 'wira-kit-for-elementor' ),
            'digg'          => __( 'Digg', 'wira-kit-for-elementor' ),
            'evernote'      => __( 'Evernote', 'wira-kit-for-elementor' ),
            'reddit'        => __( 'Reddit', 'wira-kit-for-elementor' ),
            'delicious'     => __( 'Delicious', 'wira-kit-for-elementor' ),
            'stumbleupon'   => __( 'Stumbleupon', 'wira-kit-for-elementor' ),
            'pocket'        => __( 'Pocket', 'wira-kit-for-elementor' ),
            'surfingbird'   => __( 'Surfingbird', 'wira-kit-for-elementor' ),
            'liveinternet'  => __( 'Liveinternet', 'wira-kit-for-elementor' ),
            'buffer'        => __( 'Buffer', 'wira-kit-for-elementor' ),
            'instapaper'    => __( 'Instapaper', 'wira-kit-for-elementor' ),
            'xing'          => __( 'Xing', 'wira-kit-for-elementor' ),
            'wordpress'     => __( 'WordPress', 'wira-kit-for-elementor' ),
            'baidu'         => __( 'Baidu', 'wira-kit-for-elementor' ),
            'renren'        => __( 'Renren', 'wira-kit-for-elementor' ),
            'weibo'         => __( 'Weibo', 'wira-kit-for-elementor' ),
            'skype'         => __( 'Skype', 'wira-kit-for-elementor' ),
            'telegram'      => __( 'Telegram', 'wira-kit-for-elementor' ),
            'viber'         => __( 'Viber', 'wira-kit-for-elementor' ),
            'whatsapp'      => __( 'Whatsapp', 'wira-kit-for-elementor' ),
            'line'          => __( 'Line', 'wira-kit-for-elementor' ),
        ],

    ]
);

$repeater->add_control(
    'label',
    [
        'label' => __( 'Label', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::TEXT,
        'default' => '',
    ]
);

$repeater->start_controls_tabs( 'style_tabs' );

$repeater->start_controls_tab(
    'style_normal',
    [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$repeater->add_control(
    'color',
    [
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
        ],
    ]
);

$repeater->add_control(
    'background_color',
    [
        'label' => __( 'Background Color', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
        ],
    ]
);

$repeater->end_controls_tab();

$repeater->start_controls_tab(
    'style_hover',
    [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ]
);

$repeater->add_control(
    'hover_color',
    [
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$repeater->add_control(
    'hover_background_color',
    [
        'label' => __( 'Background Color', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

$repeater->end_controls_tab();
$repeater->end_controls_tabs();

$repeater->add_control(
    'border_type',
    [
        'label' => __( 'Border Type', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'default' => __( 'Default', 'wira-kit-for-elementor' ),
            'solid'   => __( 'Solid', 'wira-kit-for-elementor' ),
            'dashed'  => __( 'Dashed', 'wira-kit-for-elementor' ),
        ],
        'default' => 'default',
    ]
);

$repeater->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [ 'name' => 'text_shadow' ]
);

$repeater->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [ 'name' => 'box_shadow' ]
);

$this->add_control(
    'social_media_list',
    [
        'label'       => __( 'Add Social Media', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => '{{{ social_media }}}',
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'style_section',
    [
        'label' => __( 'Social Media', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'style_alignment',
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
        'default'   => 'center',
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'style_display',
    [
        'label'   => __( 'Display', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'inline-flex',
        'options' => [
            'row' => __( 'Inline', 'wira-kit-for-elementor' ),
            'column'        => __( 'Block', 'wira-kit-for-elementor' ),
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share' => 'flex-direction: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_border_radius',
    [
        'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_line_height',
    [
        'label' => __( 'Line Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 200 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon i, {{WRAPPER}} .wkit-social-share-icon span' => 'line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_icon_size',
    [
        'label' => __( 'Icon Size', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [ 'min' => 0, 'max' => 100 ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'style_typography',
        'selector' => '{{WRAPPER}} .wkit-social-label',
    ]
);

$this->add_responsive_control(
    'style_margin',
    [
        'label' => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'style_padding',
    [
        'label' => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-social-share-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


