<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Team Repeater Elementor Custom Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$team_repeater = new \Elementor\Repeater();

$team_repeater->add_control(
	'team_image',
	[
		'label'   => __( 'Team Image', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::MEDIA,
		'default' => [
			'url' => \Elementor\Utils::get_placeholder_image_src(),
		],
		'dynamic' => [ 'active' => true ],
	]
);

$team_repeater->add_control(
	'team_name',
	[
		'label'   => __( 'Team Name', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::TEXT,
		'default' => __( 'Mr. John Doe', 'wira-kit-for-elementor' ),
		'dynamic' => [ 'active' => true ],
	]
);

$team_repeater->add_control(
	'team_position',
	[
		'label'   => __( 'Position', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::TEXT,
		'default' => __( 'Director', 'wira-kit-for-elementor' ),
		'dynamic' => [ 'active' => true ],
	]
);

$team_repeater->add_control(
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

$team_repeater->add_control(
	'social_1_enable',
	[
		'label'        => __( 'Enable Social 1', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
		'condition'   => [
			'show_social_profiles' => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_1_label',
	[
		'label'       => __( 'Social 1 Label', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Facebook', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_1_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_1_icon',
	[
		'label'     => __( 'Social 1 Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'fab fa-facebook-f',
			'library' => 'fa-brands',
		],
		'condition' => [
			'show_social_profiles' => 'yes',
			'social_1_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_1_link',
	[
		'label'       => __( 'Social 1 Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
		'default'     => [ 'url' => '#' ],
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_1_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_2_enable',
	[
		'label'        => __( 'Enable Social 2', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
		'condition'    => [
			'show_social_profiles' => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_2_label',
	[
		'label'       => __( 'Social 2 Label', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Twitter', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_2_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_2_icon',
	[
		'label'     => __( 'Social 2 Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'fab fa-x-twitter',
			'library' => 'fa-brands',
		],
		'condition' => [
			'show_social_profiles' => 'yes',
			'social_2_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_2_link',
	[
		'label'       => __( 'Social 2 Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
		'default'     => [ 'url' => '#' ],
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_2_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_3_enable',
	[
		'label'        => __( 'Enable Social 3', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
		'condition'    => [
			'show_social_profiles' => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_3_label',
	[
		'label'       => __( 'Social 3 Label', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'LinkedIn', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_3_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_3_icon',
	[
		'label'     => __( 'Social 3 Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'fab fa-linkedin-in',
			'library' => 'fa-brands',
		],
		'condition' => [
			'show_social_profiles' => 'yes',
			'social_3_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_3_link',
	[
		'label'       => __( 'Social 3 Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
		'default'     => [ 'url' => '#' ],
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_3_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_4_enable',
	[
		'label'        => __( 'Enable Social 4', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
		'condition'    => [
			'show_social_profiles' => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_4_label',
	[
		'label'       => __( 'Social 4 Label', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => __( 'Instagram', 'wira-kit-for-elementor' ),
		'label_block' => true,
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_4_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_4_icon',
	[
		'label'     => __( 'Social 4 Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'fab fa-instagram',
			'library' => 'fa-brands',
		],
		'condition' => [
			'show_social_profiles' => 'yes',
			'social_4_enable'      => 'yes',
		],
	]
);

$team_repeater->add_control(
	'social_4_link',
	[
		'label'       => __( 'Social 4 Link', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::URL,
		'placeholder' => __( 'https://your-link.com', 'wira-kit-for-elementor' ),
		'default'     => [ 'url' => '#' ],
		'condition'   => [
			'show_social_profiles' => 'yes',
			'social_4_enable'      => 'yes',
		],
	]
);

$this->start_controls_section(
	'section_team_items',
	[
		'label' => __( 'Team Member', 'wira-kit-for-elementor' ),
		'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
	]
);

$this->add_control(
	'team_members',
	[
		'label'       => __( 'Team Members', 'wira-kit-for-elementor' ),
		'type'        => \Elementor\Controls_Manager::REPEATER,
		'fields'      => $team_repeater->get_controls(),
		'title_field' => '{{{ team_name }}}',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Image_Size::get_type(),
	[
		'name'    => 'thumbnail',
		'default' => 'large',
	]
);

$this->end_controls_section();

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
			'default'       => __( 'Default', 'wira-kit-for-elementor' ),
			'hover-overlay' => __( 'Hover Overlay', 'wira-kit-for-elementor' ),
		],
		'default' => 'default',
	]
);

$this->add_responsive_control(
	'columns',
	[
		'label'     => __( 'Columns', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'min'       => 1,
		'max'       => 6,
		'step'      => 1,
		'default'   => 2,
		'selectors' => [
			'{{WRAPPER}} .wkit-team-repeater' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
		],
		'condition' => [
			'enable_slider!' => 'yes',
		],
	]
);

$this->add_control(
	'enable_slider',
	[
		'label'        => __( 'Enable Slider', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
	]
);

$this->add_control(
	'enable_marquee_style',
	[
		'label'        => __( 'Enable Marquee Style', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => '',
		'condition'    => [
			'enable_slider' => 'yes',
		],
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'carousel_settings',
	[
		'label'     => __( 'Slider Settings', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
		'condition' => [
			'enable_slider' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'slides_per_view',
	[
		'label'   => __( 'Slides on display', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => '1',
		'options' => [
			'1'       => '1',
			'2'       => '2',
			'3'       => '3',
			'4'       => '4',
			'5'       => '5',
			'default' => __( 'Default', 'wira-kit-for-elementor' ),
		],
		'devices' => [ 'desktop', 'tablet', 'mobile' ],
	]
);

$this->add_responsive_control(
	'slides_per_group',
	[
		'label'   => __( 'Slides on scroll', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => '1',
		'options' => [
			'1'       => '1',
			'2'       => '2',
			'3'       => '3',
			'default' => __( 'Default', 'wira-kit-for-elementor' ),
		],
		'devices' => [ 'desktop', 'tablet', 'mobile' ],
	]
);

$this->add_control(
	'equal_height',
	[
		'label'        => __( 'Equal Height', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'default'      => 'yes',
	]
);

$this->add_control(
	'autoplay',
	[
		'label'   => __( 'Autoplay', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'default' => 'yes',
	]
);

$this->add_control(
	'scroll_speed',
	[
		'label'   => __( 'Scroll Speed (ms)', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::NUMBER,
		'default' => 5000,
	]
);

$this->add_control(
	'pause_on_hover',
	[
		'label'   => __( 'Pause on hover', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'default' => 'yes',
	]
);

$this->add_control(
	'pause_on_interaction',
	[
		'label'   => __( 'Pause on interaction', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'default' => 'yes',
	]
);

$this->add_control(
	'infinite_scroll',
	[
		'label'   => __( 'Infinite scroll', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'default' => 'yes',
	]
);

$this->add_control(
	'transition_effect',
	[
		'label'   => __( 'Transition Effect', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'slide',
		'options' => [
			'slide'     => __( 'Slide', 'wira-kit-for-elementor' ),
			'fade'      => __( 'Fade', 'wira-kit-for-elementor' ),
			'cube'      => __( 'Cube', 'wira-kit-for-elementor' ),
			'coverflow' => __( 'Coverflow', 'wira-kit-for-elementor' ),
			'flip'      => __( 'Flip', 'wira-kit-for-elementor' ),
			'cards'     => __( 'Cards', 'wira-kit-for-elementor' ),
		],
	]
);

$this->add_control(
	'transition_duration',
	[
		'label'   => __( 'Transition Duration (ms)', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::NUMBER,
		'default' => 500,
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'marquee_settings',
	[
		'label'     => __( 'Marquee Settings', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
		'condition' => [
			'enable_slider'        => 'yes',
			'enable_marquee_style' => 'yes',
		],
	]
);

$this->add_control(
	'marquee_scroll_axis',
	[
		'label'   => __( 'Scroll Axis', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'default' => 'horizontal',
		'options' => [
			'horizontal' => __( 'Horizontal Scroll', 'wira-kit-for-elementor' ),
			'vertical'   => __( 'Vertical Scroll', 'wira-kit-for-elementor' ),
		],
	]
);

$this->add_control(
	'marquee_direction_horizontal',
	[
		'label'     => __( 'Direction', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SELECT,
		'default'   => 'left',
		'options'   => [
			'left'  => __( 'Left', 'wira-kit-for-elementor' ),
			'right' => __( 'Right', 'wira-kit-for-elementor' ),
		],
		'condition' => [
			'marquee_scroll_axis' => 'horizontal',
		],
	]
);

$this->add_control(
	'marquee_direction_vertical',
	[
		'label'     => __( 'Direction', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SELECT,
		'default'   => 'up',
		'options'   => [
			'up'   => __( 'Up', 'wira-kit-for-elementor' ),
			'down' => __( 'Down', 'wira-kit-for-elementor' ),
		],
		'condition' => [
			'marquee_scroll_axis' => 'vertical',
		],
	]
);

$this->add_control(
	'marquee_pause_on_hover',
	[
		'label'        => __( 'Pause On Hover', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default'      => 'yes',
	]
);

$this->add_responsive_control(
	'marquee_duration',
	[
		'label'      => __( 'Animation Duration (s)', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range'      => [
			'px' => [
				'min' => 5,
				'max' => 120,
			],
		],
		'default'    => [
			'size' => 30,
		],
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_navigation',
	[
		'label'     => __( 'Navigation', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
		'condition' => [
			'enable_slider' => 'yes',
		],
	]
);

$this->add_control(
	'show_arrows',
	[
		'label'        => __( 'Arrows', 'wira-kit-for-elementor' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => __( 'Show', 'wira-kit-for-elementor' ),
		'label_off'    => __( 'Hide', 'wira-kit-for-elementor' ),
		'default'      => 'yes',
		'return_value' => 'yes',
	]
);

$this->add_control(
	'prev_arrow_icon',
	[
		'label'     => __( 'Previous Arrow Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'eicon-chevron-left',
			'library' => 'elementor',
		],
		'condition' => [
			'show_arrows' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'prev_arrow_horizontal_position',
	[
		'label'      => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'range'      => [
			'px' => [
				'min' => -500,
				'max' => 500,
			],
			'%'  => [
				'min' => -100,
				'max' => 100,
			],
		],
		'default'    => [ 'size' => 0 ],
		'selectors' => [
			'{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
		],
		'condition' => [
			'show_arrows' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'prev_arrow_vertical_position',
	[
		'label'      => __( 'Vertical Position', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'range'      => [
			'px' => [
				'min' => -500,
				'max' => 500,
			],
			'%'  => [
				'min' => -100,
				'max' => 100,
			],
		],
		'default'    => [ 'size' => 0 ],
		'selectors' => [
			'{{WRAPPER}} .swiper-button-prev' => 'top: calc(50% + {{SIZE}}{{UNIT}});',
		],
		'condition' => [
			'show_arrows' => 'yes',
		],
	]
);

$this->add_control(
	'next_arrow_icon',
	[
		'label'     => __( 'Next Arrow Icon', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::ICONS,
		'default'   => [
			'value'   => 'eicon-chevron-right',
			'library' => 'elementor',
		],
		'condition' => [
			'show_arrows' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'next_arrow_horizontal_position',
	[
		'label'      => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'range'      => [
			'px' => [
				'min' => -500,
				'max' => 500,
			],
			'%'  => [
				'min' => -100,
				'max' => 100,
			],
		],
		'default'    => [ 'size' => 0 ],
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
		],
		'condition' => [
			'show_arrows' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'next_arrow_vertical_position',
	[
		'label'      => __( 'Vertical Position', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px', '%' ],
		'range'      => [
			'px' => [
				'min' => -500,
				'max' => 500,
			],
			'%'  => [
				'min' => -100,
				'max' => 100,
			],
		],
		'default'    => [ 'size' => 0 ],
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next' => 'top: calc(50% + {{SIZE}}{{UNIT}});',
		],
		'condition' => [
			'show_arrows' => 'yes',
		],
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_pagination',
	[
		'label'     => __( 'Pagination', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
		'condition' => [
			'enable_slider' => 'yes',
		],
	]
);

$this->add_control(
	'pagination_type_slider',
	[
		'label'   => __( 'Pagination', 'wira-kit-for-elementor' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'options' => [
			'none' => __( 'None', 'wira-kit-for-elementor' ),
			'dots' => __( 'Dots', 'wira-kit-for-elementor' ),
		],
		'default' => 'none',
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'slides_style_section',
	[
		'label'     => __( 'Slides', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'enable_slider' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'gap_between_slides',
	[
		'label'      => __( 'Gap between slides', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range'      => [
			'px' => [
				'min' => 0,
				'max' => 100,
			],
		],
		'default'    => [
			'size' => 10,
			'unit' => 'px',
		],
	]
);

$this->add_responsive_control(
	'slide_padding',
	[
		'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', 'em', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_style_loop',
	[
		'label'     => __( 'Loop Layout', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'enable_slider!' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'column_gap',
	[
		'label'      => __( 'Column Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range'      => [
			'px' => [
				'min' => 0,
				'max' => 100,
			],
		],
		'default'    => [
			'size' => 20,
			'unit' => 'px',
		],
		'selectors'  => [
			'{{WRAPPER}} .wkit-team-repeater' => 'column-gap: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'row_gap',
	[
		'label'      => __( 'Row Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range'      => [
			'px' => [
				'min' => 0,
				'max' => 100,
			],
		],
		'default'    => [
			'size' => 20,
			'unit' => 'px',
		],
		'selectors'  => [
			'{{WRAPPER}} .wkit-team-repeater' => 'row-gap: {{SIZE}}{{UNIT}};',
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
		'label'     => __( 'Container Height', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::SLIDER,
		'range'     => [
			'px' => [
				'min' => 10,
				'max' => 1000,
			],
		],
		'default'   => [
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
		'selector' => '{{WRAPPER}} .wkit-team-wrapper:hover',
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
		'selector' => '{{WRAPPER}} .wkit-team-content-wrapper',
	]
);

$this->add_control(
	'hover_animation_wrapper_container',
	[
		'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
	]
);

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
			'cover'   => __( 'Cover', 'wira-kit-for-elementor' ),
			'contain' => __( 'Contain', 'wira-kit-for-elementor' ),
			'auto'    => __( 'Auto', 'wira-kit-for-elementor' ),
		],
		'default' => 'cover',
		'selectors' => [
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
			'center center' => __( 'Center Center', 'wira-kit-for-elementor' ),
			'center left'   => __( 'Center Left', 'wira-kit-for-elementor' ),
			'center right'  => __( 'Center Right', 'wira-kit-for-elementor' ),
			'top center'    => __( 'Top Center', 'wira-kit-for-elementor' ),
			'bottom center' => __( 'Bottom Center', 'wira-kit-for-elementor' ),
		],
		'default' => 'center center',
		'selectors' => [
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
	]
);

$this->add_responsive_control(
	'social_icon_gap',
	[
		'label'      => __( 'Icon Gap', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'default'    => [ 'size' => 10 ],
		'range'      => [
			'px' => [
				'min' => 0,
				'max' => 200,
			],
		],
		'selectors'  => [
			'{{WRAPPER}} .team-social-profiles' => 'gap: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'social_icon_size',
	[
		'label'      => __( 'Icon Size', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'default'    => [ 'size' => 17 ],
		'range'      => [
			'px' => [
				'min' => 0,
				'max' => 200,
			],
		],
		'selectors'  => [
			'{{WRAPPER}} .team-social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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

$this->add_control(
	'hover_animation_social_icon',
	[
		'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
		'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
	]
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->end_controls_section();

$this->start_controls_section(
	'navigation_style_section',
	[
		'label'     => __( 'Navigation', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'enable_slider' => 'yes',
			'show_arrows'   => 'yes',
		],
	]
);

$this->add_responsive_control(
	'nav_icon_size',
	[
		'label'      => __( 'Size', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range'      => [
			'px' => [
				'min' => 10,
				'max' => 200,
			],
		],
		'selectors'  => [
			'{{WRAPPER}} .swiper-button-prev i, {{WRAPPER}} .swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->start_controls_tabs( 'nav_tabs' );

$this->start_controls_tab(
	'nav_tab_normal',
	[ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
	'nav_color',
	[
		'label' => __( 'Color', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name' => 'nav_background',
		'types' => [ 'classic', 'gradient' ],
		'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name' => 'nav_border',
		'size_units' => [ 'px', '%' ],
		'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name' => 'nav_shadow',
		'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
	]
);

$this->end_controls_tab();

$this->start_controls_tab(
	'nav_tab_hover',
	[ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
	'nav_hover_color',
	[
		'label' => __( 'Color', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name' => 'nav_hover_background',
		'types' => [ 'classic', 'gradient' ],
		'selector' => '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name' => 'nav_hover_border',
		'size_units' => [ 'px', '%' ],
		'selector' => '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover',
	]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_responsive_control(
	'nav_radius',
	[
		'label' => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'nav_padding',
	[
		'label' => __( 'Padding', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'pagination_style_section_slider',
	[
		'label'     => __( 'Pagination', 'wira-kit-for-elementor' ),
		'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'enable_slider'          => 'yes',
			'pagination_type_slider' => 'dots',
		],
	]
);

$this->add_responsive_control(
	'pagination_space',
	[
		'label' => __( 'Space Between Dots', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range' => [
			'px' => [ 'min' => 0, 'max' => 50 ],
		],
		'selectors' => [
			'{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'pagination_size_slider',
	[
		'label'      => __( 'Size', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range'      => [
			'px' => [
				'min' => 4,
				'max' => 40,
			],
		],
		'selectors'  => [
			'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->start_controls_tabs( 'pagination_tabs_slider' );

$this->start_controls_tab(
	'pagination_tab_normal_slider',
	[ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
	'pagination_color_slider',
	[
		'label'     => __( 'Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
		],
	]
);

$this->end_controls_tab();

$this->start_controls_tab(
	'pagination_tab_hover_slider',
	[ 'label' => __( 'Hover/Active', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
	'pagination_hover_color_slider',
	[
		'label'     => __( 'Hover/Active Color', 'wira-kit-for-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .swiper-pagination-bullet:hover, {{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
	'pagination_width_active_slider',
	[
		'label' => __( 'Active Dots Width', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range' => [
			'px' => [ 'min' => 4, 'max' => 40 ],
		],
		'selectors' => [
			'{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_control(
	'pagination_custom_position',
	[
		'label' => __( 'Custom Position', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => __( 'Show', 'wira-kit-for-elementor' ),
		'label_off' => __( 'Hide', 'wira-kit-for-elementor' ),
		'return_value' => 'yes',
		'default' => '',
	]
);

$this->add_responsive_control(
	'pagination_vertical_position',
	[
		'label' => __( 'Vertical Position', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::SELECT,
		'options' => [
			'top'    => __( 'Top', 'wira-kit-for-elementor' ),
			'bottom' => __( 'Bottom', 'wira-kit-for-elementor' ),
		],
		'default' => 'bottom',
		'condition' => [
			'pagination_custom_position' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'pagination_spacing_slider',
	[
		'label' => __( 'Spacing', 'wira-kit-for-elementor' ),
		'type' => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ 'px' ],
		'range' => [
			'px' => [ 'min' => -200, 'max' => 200 ],
		],
		'selectors' => [
			'{{WRAPPER}} .swiper-pagination' => '{{pagination_vertical_position.VALUE}}: {{SIZE}}{{UNIT}};',
		],
		'condition' => [
			'pagination_custom_position' => 'yes',
		],
	]
);

$this->add_control(
	'pagination_slider_radius',
	[
		'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .swiper-pagination-bullet, {{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->end_controls_section();
