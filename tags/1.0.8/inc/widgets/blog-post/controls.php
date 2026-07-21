<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Blog Post Custom Widgets
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
    'style_variations',
    [
        'label'   => __( 'Style Variations', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'default',
        'options' => [
            'default'  => __( 'Default', 'wira-kit-for-elementor' ),
            'overlay'  => __( 'Overlay', 'wira-kit-for-elementor' ),
        ],
    ]
);

$this->add_control(
    'layout_style',
    [
        'label'   => __( 'Layout Style', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'column',
        'options' => [
            'column'  => __( 'Block', 'wira-kit-for-elementor' ),
            'row'  => __( 'List', 'wira-kit-for-elementor' ),
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item' => 'flex-direction: {{VALUE}};',
        ],
        'condition' => [
            'style_variations' => 'default',
        ],
    ]
);

$this->add_control(
    'show_featured_image',
    [
        'label'        => __( 'Show Featured Image', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition' => [
            'style_variations' => 'default',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Image_Size::get_type(),
    [
        'name'      => 'featured_image',
        'default'   => 'large',
        'separator' => 'none',
        'condition' => [
            'show_featured_image' => 'yes',
            'style_variations' => 'default',
        ],
    ]
);

$this->add_responsive_control(
    'featured_image_alignment',
    [
        'label'     => __( 'Featured Image Alignment', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::CHOOSE,
        'options'   => [
            'row' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'row-reverse' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
        ],
        'default'   => 'row',
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item' => 'flex-direction: {{VALUE}};',
        ],
        'condition' => [
            'show_featured_image' => 'yes',
            'layout_style' => 'row',
            'style_variations' => 'default',
        ],
    ]
);

$this->add_responsive_control(
    'featured_image_width',
    [
        'label' => __( 'Featured Image Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px'],
        'range' => [
            '%'  => [ 'min' => 0, 'max' => 100 ],
            'px' => [ 'min' => 0, 'max' => 500 ],
        ],
        'default' => [ 'size' => 70, 'unit' => '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-thumbnail-post-grid' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'show_featured_image' => 'yes',
            'layout_style' => 'row',
            'style_variations' => 'default',
        ],
    ]
);

$this->add_control(
    'show_title',
    [
        'label'        => __( 'Show Title', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'crop_title_word',
    [
        'label'       => __( 'Crop title by word', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::NUMBER,
        'default'     => '',
        'description' => __( 'Enter the number of words to crop the title.', 'wira-kit-for-elementor' ),
        'condition'   => [
            'show_title' => 'yes',
        ],
    ]
);

$this->add_control(
    'show_content',
    [
        'label'        => __( 'Show Content', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'crop_content_word',
    [
        'label'       => __( 'Crop content by word', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::NUMBER,
        'default'     => '',
        'description' => __( 'Enter the number of words to crop the content.', 'wira-kit-for-elementor' ),
        'condition'   => [
            'show_content' => 'yes',
        ],
    ]
);

$this->add_control(
    'show_readmore',
    [
        'label'        => __( 'Show Read More', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'readmore_text',
    [
        'label' => __( 'Text', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Continue Reading', 'wira-kit-for-elementor' ),
        'placeholder' => __( 'Enter readmore text', 'wira-kit-for-elementor' ),
        'dynamic' => [ 'active' => true ],
    ]
);

$this->add_control(
    'readmore_icon',
    [
        'label' => __( 'Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default' => [
            'value' => '',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'icon_position',
    [
        'label' => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'before',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'readmore_icon[value]!' => '',
        ],
    ]
);

$this->add_responsive_control(
    'icon_spacing',
    [
        'label' => __( 'Icon Spacing', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 8,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 50,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .readmore-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'readmore_icon[value]!' => '',
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
    'section_query',
    [
        'label' => __( 'Query', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'enable_archive_query',
    [
        'label'        => __( 'Use Archive Query', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'enable_search_query',
    [
        'label'        => __( 'Use Search Query', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'enable_related_posts',
    [
        'label'        => __( 'Enable Related Posts', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
    ]
);

$this->add_control(
    'ignore_sticky_post',
    [
        'label'        => __( 'Ignore Sticky Post', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_responsive_control(
    'columns',
    [
        'label' => __( 'Columns', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 6,
        'step' => 1,
        'default' => 2,
        'selectors' => [
            '{{WRAPPER}} .wkit-blog-post' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
        ],
    ]
);

$this->add_control(
    'posts_per_page',
    [
        'label'   => __( 'Posts Per Page', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::NUMBER,
        'default' => 6,
        'min'     => -1, // -1 = unlimited
        'step'    => 1,
    ]
);

$this->add_control(
    'orderby',
    [
        'label' => __( 'Order By', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'post_date',
        'options' => [
            'post_date'     => __( 'Date', 'wira-kit-for-elementor' ),
            'post_title'    => __( 'Title', 'wira-kit-for-elementor' ),
            'menu_order'    => __( 'Menu Order', 'wira-kit-for-elementor' ),
            'modified'      => __( 'Last Modified', 'wira-kit-for-elementor' ),
            'comment_count' => __( 'Comment Count', 'wira-kit-for-elementor' ),
            'rand'          => __( 'Random', 'wira-kit-for-elementor' ),
        ],
        'description' => __( 'Select how to order posts.', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'order',
    [
        'label'   => __( 'Order', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'ASC'  => __( 'Ascending', 'wira-kit-for-elementor' ),
            'DESC' => __( 'Descending', 'wira-kit-for-elementor' ),
        ],
        'default' => 'DESC',
    ]
);

$this->add_control(
    'select_posts_by',
    [
        'label'   => __( 'Select posts by:', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'default' => 'recent',
        'options' => [
            'recent'   => __( 'Recent Post', 'wira-kit-for-elementor' ),
            'selected' => __( 'Selected Post', 'wira-kit-for-elementor' ),
            'category' => __( 'Category Post', 'wira-kit-for-elementor' ),
        ],
        'conditions' => [
            'relation' => 'and',
            'terms'    => [
                [
                    'name'     => 'enable_archive_query',
                    'operator' => '!=',
                    'value'    => 'yes',
                ],
                [
                    'name'     => 'enable_search_query',
                    'operator' => '!=',
                    'value'    => 'yes',
                ],
            ],
        ],
    ]
);

$posts = get_posts( [
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
] );

$post_options = [];
if ( $posts ) {
    foreach ( $posts as $p ) {
        $post_options[ $p->ID ] = $p->post_title;
    }
}

$categories = get_categories([
    'hide_empty' => false,
]);

$category_options = [];
if ( $categories ) {
    foreach ( $categories as $cat ) {
        $category_options[ $cat->term_id ] = $cat->name;
    }
}

$this->add_control(
    'include_posts',
    [
        'label'       => __( 'Include Posts', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'options'     => $post_options,
        'multiple'    => true,
        'label_block' => true,
        'condition'   => [
            'select_posts_by' => 'selected',
        ],
    ]
);

$this->add_control(
    'include_categories',
    [
        'label'       => __( 'Categories', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'options'     => $category_options,
        'multiple'    => true,
        'label_block' => true,
        'condition'   => [
            'select_posts_by' => 'category',
        ],
    ]
);

$this->add_control(
    'exclude_posts',
    [
        'label'       => __( 'Exclude Posts', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'options'     => $post_options,
        'multiple'    => true,
        'label_block' => true,
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'carousel_settings',
    [
        'label' => __( 'Slider Settings', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
            '1' => __( '1', 'wira-kit-for-elementor' ),
            '2' => __( '2', 'wira-kit-for-elementor' ),
            '3' => __( '3', 'wira-kit-for-elementor' ),
            '4' => __( '4', 'wira-kit-for-elementor' ),
            '5' => __( '5', 'wira-kit-for-elementor' ),
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
            '1' => __( '1', 'wira-kit-for-elementor' ),
            '2' => __( '2', 'wira-kit-for-elementor' ),
            '3' => __( '3', 'wira-kit-for-elementor' ),
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
        'label_on'     => __( 'On', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'Off', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'autoplay',
    [
        'label'        => __( 'Autoplay', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
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
        'label'        => __( 'Pause on hover', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'pause_on_interaction',
    [
        'label'        => __( 'Pause on interaction', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
    ]
);

$this->add_control(
    'infinite_scroll',
    [
        'label'        => __( 'Infinite scroll', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'default'      => 'yes',
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
        'label' => __( 'Navigation', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
        'label'   => __( 'Previous Arrow Icon', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::ICONS,
        'default' => [
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
        'label' => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
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
        'label' => __( 'Vertical Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
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
        'label'   => __( 'Next Arrow Icon', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::ICONS,
        'default' => [
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
        'label' => __( 'Horizontal Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
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
        'label' => __( 'Vertical Position', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'range' => [
            'px' => [ 'min' => -500, 'max' => 500 ],
            '%'  => [ 'min' => -100, 'max' => 100 ],
        ],
        'default' => [ 'size' => 0 ],
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
    'section_pagination_slider',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
        'label' => __( 'Slides', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'enable_slider' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'gap_between_slides',
    [
        'label' => __( 'Gap between slides', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ],
        ],
        'default' => [
            'size' => 10,
            'unit' => 'px',
        ],
    ]
);

$this->add_responsive_control(
    'slide_padding',
    [
        'label' => __( 'Padding', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_loop',
    [
        'label' => __( 'Loop Layout', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'enable_slider!' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'column_gap',
    [
        'label' => __( 'Column Gap', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%', 'em' ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 100 ],
            '%'  => [ 'min' => 0, 'max' => 100 ],
            'em' => [ 'min' => 0, 'max' => 10 ],
        ],
        'default' => [ 'size' => 20, 'unit' => 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-blog-post' => 'column-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'row_gap',
    [
        'label' => __( 'Row Gap', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%', 'em' ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 100 ],
            '%'  => [ 'min' => 0, 'max' => 100 ],
            'em' => [ 'min' => 0, 'max' => 10 ],
        ],
        'default' => [ 'size' => 20, 'unit' => 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-blog-post' => 'row-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);


$this->end_controls_section();

$this->start_controls_section(
    'section_meta_data',
    [
        'label' => __( 'Meta Data', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_floating_category',
    [
        'label'        => __( 'Show Floating Category', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'show_meta',
    [
        'label'        => __( 'Show Meta Data', 'wira-kit-for-elementor' ),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'wira-kit-for-elementor' ),
        'label_off'    => __( 'No', 'wira-kit-for-elementor' ),
        'return_value' => 'yes',
        'default'      => 'yes',
    ]
);

$this->add_control(
    'meta_position',
    [
        'label'     => __( 'Meta Position', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'before_title',
        'options'   => [
            'before_title' => __( 'Before Title', 'wira-kit-for-elementor' ),
            'after_title'  => __( 'After Title', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'show_meta' => 'yes',
        ],
    ]
);

$this->add_control(
    'meta_icon_position',
    [
        'label' => __( 'Icon Position', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'before',
        'options' => [
            'before' => __( 'Before', 'wira-kit-for-elementor' ),
            'after'  => __( 'After', 'wira-kit-for-elementor' ),
        ],
        'condition' => [
            'show_meta' => 'yes',
        ],
    ]
);

$this->add_control(
    'meta_data',
    [
        'label'       => __( 'Meta Data', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'multiple'    => true,
        'options'     => [
            'author'   => __( 'Author', 'wira-kit-for-elementor' ),
            'date'     => __( 'Date', 'wira-kit-for-elementor' ),
            'category' => __( 'Category', 'wira-kit-for-elementor' ),
            'comment'  => __( 'Comment', 'wira-kit-for-elementor' ),
        ],
        'default'   => ['date'],
        'condition'   => [
            'show_meta' => 'yes',
        ],
    ]
);

$this->add_control(
    'author_icon',
    [
        'label' => __( 'Author Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-user', // FontAwesome
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'author',
        ],
    ]
);

$this->add_control(
    'date_icon',
    [
        'label' => __( 'Date Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-calendar-alt', // FontAwesome
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'date',
        ],
    ]
);

$this->add_control(
    'category_icon',
    [
        'label' => __( 'Category Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-folder-open', // FontAwesome
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'category',
        ],
    ]
);

$this->add_control(
    'comment_icon',
    [
        'label' => __( 'Comment Icon', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-comments', // FontAwesome
            'library' => 'fa-solid',
        ],
        'condition'   => [
            'meta_data' => 'comment',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_pagination',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        'condition' => [
            'enable_slider!' => 'yes',
        ],
    ]
);

$this->add_control(
    'pagination_type',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '',
        'options' => [
            ''                                => __( 'None', 'wira-kit-for-elementor' ),
            'numbers_and_prev_next'            => __( 'Numbers + Previous/Next', 'wira-kit-for-elementor' ),
            'ajax_load_more'                   => __( 'Ajax Load More', 'wira-kit-for-elementor' ),
            'infinite_scroll'                  => __( 'Infinite Scroll', 'wira-kit-for-elementor' ),
        ],
        'description' => __( 'Select the type of pagination for the posts loop.', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'load_more_text',
    [
        'label'     => __( 'Button Text', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::TEXT,
        'default'   => __( 'Load More', 'wira-kit-for-elementor' ),
        'condition' => [
            'pagination_type' => [ 'ajax_load_more', 'infinite_scroll' ],
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_post',
    [
        'label' => __( 'Post Item', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'post_content_overlay_height',
    [
        'label' => __( 'Container Height', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', '%', 'vh' ],
        'range' => [
            'px' => [ 'min' => 0, 'max' => 1000 ],
            '%'  => [ 'min' => 0, 'max' => 100 ],
            'vh' => [ 'min' => 0, 'max' => 100 ],
        ],
        'default' => [
            'size' => 320,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-post-content-overlay' => 'height: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'style_variations' => 'overlay',
        ],
    ]
);

$this->start_controls_tabs( 'post_item_style_tabs' );

$this->start_controls_tab(
    'post_item_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'background_size_normal',
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
            '{{WRAPPER}} .wkit-post-item-overlay' => 'background-size: {{VALUE}};',
        ],
        'condition' => [
            'style_variations' => 'overlay',
        ],
    ]
);

$this->add_control(
    'background_position_normal',
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
            '{{WRAPPER}} .wkit-post-item-overlay' => 'background-position: {{VALUE}};',
        ],
        'condition' => [
            'style_variations' => 'overlay',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'post_box_background',
        'selector' => '{{WRAPPER}} .wkit-post-item, {{WRAPPER}} .wkit-post-content-overlay',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'post_box_border',
        'selector' => '{{WRAPPER}} .wkit-post-item, {{WRAPPER}} .wkit-post-item-overlay',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'post_box_shadow',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-post-item, {{WRAPPER}} .wkit-post-item-overlay',
    ]
);


$this->end_controls_tab();

$this->start_controls_tab(
    'post_item_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'background_size_hover',
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
            '{{WRAPPER}} .wkit-post-item-overlay:hover' => 'background-size: {{VALUE}};',
        ],
        'condition' => [
            'style_variations' => 'overlay',
        ],
    ]
);

$this->add_control(
    'background_position_hover',
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
            '{{WRAPPER}} .wkit-post-item-overlay:hover' => 'background-position: {{VALUE}};',
        ],
        'condition' => [
            'style_variations' => 'overlay',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'post_box_background_hover',
        'selector' => '{{WRAPPER}} .wkit-post-item:hover, {{WRAPPER}} .wkit-post-content-overlay:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'post_box_border_hover',
        'selector' => '{{WRAPPER}} .wkit-post-item:hover, {{WRAPPER}} .wkit-post-item-overlay:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'post_box_shadow_hover',
        'label'    => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-post-item:hover, {{WRAPPER}} .wkit-post-item-overlay:hover',
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
            '{{WRAPPER}} .wkit-post-item, {{WRAPPER}} .wkit-post-item-overlay, {{WRAPPER}} .wkit-post-content-overlay, {{WRAPPER}}  .wkit-blog-title, {{WRAPPER}}  .wkit-blog-title a, {{WRAPPER}}  .wkit-readmore, {{WRAPPER}}  .wkit-post-excerpt' => 'transition: all {{SIZE}}s ease-in-out;',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'post_box_padding_overlay',
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
            '{{WRAPPER}} .wkit-post-content-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
            'style_variations' => 'overlay',
        ],
    ]
);

$this->add_responsive_control(
    'post_box_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
            'style_variations' => 'default',
        ],
    ]
);

$this->add_responsive_control(
    'post_content_box_padding',
    [
        'label'      => __( 'Content Box Padding', 'wira-kit-for-elementor' ),
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
            '{{WRAPPER}} .wkit-post-item .wkit-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
            'style_variations' => 'default',
        ],
    ]
);

$this->add_control(
    'blog_post_radius',
    [
        'label'      => __( 'Blog Container Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-item, {{WRAPPER}} .wkit-post-item-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

// === Style Tab ===
$this->start_controls_section(
    'section_style_featured_image',
    [
        'label' => __( 'Featured Image', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'style_variations' => 'default',
        ],
    ]
);

$this->add_responsive_control(
    'thumbnail_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-thumbnail-post-grid img' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'thumbnail_max_width',
    [
        'label' => __( 'Max Width', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ '%', 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-thumbnail-post-grid img' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'thumbnail_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'vh', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-thumbnail-post-grid img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
        ],
    ]
);

$this->add_control(
    'thumbnail_opacity',
    [
        'label' => __( 'Opacity', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0.1,
                'max' => 1,
                'step'=> 0.01,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .wkit-thumbnail-post-grid a img' => 'opacity: {{SIZE}};',
        ],
    ]
);

$this->add_control(
    'thumbnail_radius',
    [
        'label'      => __( 'Thumbnail Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-thumbnail-post-grid a img, {{WRAPPER}} .wkit-thumbnail-post-grid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_title',
    [
        'label' => __( 'Title', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'title_typography',
        'selector' => '{{WRAPPER}} .wkit-blog-title',
    ]
);

$this->add_responsive_control(
    'title_alignment',
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
            '{{WRAPPER}} .wkit-blog-title' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-blog-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover .wkit-blog-title, {{WRAPPER}} .wkit-post-item-overlay:hover .wkit-blog-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'title_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-blog-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_floating_category',
    [
        'label' => __( 'Floating Category', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_floating_category' => 'yes',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'floating_category_typography',
        'selector' => '{{WRAPPER}} .wkit-post-category a',
    ]
);

$this->add_responsive_control(
    'floating_category_alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'right' => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
        ],
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .wkit-post-category' => '{{VALUE}}: 25px;',
        ],
    ]
);

$this->start_controls_tabs('floating_category_tabs_style');

$this->start_controls_tab(
    'floating_category_tab_normal',
    [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'floating_category_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-category a' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'floating_category_background',
        'selector' => '{{WRAPPER}} .wkit-post-category a',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'floating_category_border',
        'selector' => '{{WRAPPER}} .wkit-post-category a',
    ]
);

$this->add_responsive_control(
    'floating_category_border_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'floating_category_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-post-category a',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'floating_category_tab_hover',
    [ 'label' => __( 'Hover', 'wira-kit-for-elementor' ) ]
);

$this->add_control(
    'floating_category_hover_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-category a:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'floating_category_hover_background',
        'selector' => '{{WRAPPER}} .wkit-post-category a:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'floating_category_hover_border',
        'selector' => '{{WRAPPER}} .wkit-post-category a:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'floating_category_hover_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-post-category a:hover',
    ]
);

$this->add_control(
        'hover_animation',
        [
            'label' => __( 'Hover Animation', 'wira-kit-for-elementor' ),
            'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
        ]
    );

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'floating_category_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_meta',
    [
        'label' => __( 'Meta', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_meta' => 'yes',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'meta_typography',
        'selector' => '{{WRAPPER}} .wkit-post-meta span',
    ]
);

$this->add_control(
    'meta_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta span' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'meta_color_hover',
    [
        'label'     => __( 'Text Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover .wkit-post-meta span, {{WRAPPER}} .wkit-post-item-overlay:hover .wkit-post-meta span' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'meta_icon_color',
    [
        'label'     => __( 'Icon Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'meta_icon_color_hover',
    [
        'label'     => __( 'Icon Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover .wkit-post-meta i, {{WRAPPER}} .wkit-post-item-overlay:hover .wkit-post-meta i' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'meta_gap_spacing',
    [
        'label' => __( 'Spacing', 'wira-kit-for-elementor' ),
        'type'  => \Elementor\Controls_Manager::SLIDER,
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step'=> 1,
            ],
        ],
        'default' => [ 'size' => 20, 'unit' => 'px' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'meta_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'meta_alignment',
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
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .wkit-post-meta' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_excerpt',
    [
        'label' => __( 'Excerpt', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'excerpt_typography',
        'selector' => '{{WRAPPER}} .wkit-post-excerpt',
    ]
);

$this->add_responsive_control(
    'excerpt_alignment',
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
            '{{WRAPPER}} .wkit-post-excerpt' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'excerpt_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-excerpt' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'excerpt_color_hover',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover p, {{WRAPPER}} .wkit-post-item-overlay:hover p' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'excerpt_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'section_style_readmore',
    [
        'label' => __( 'Read More', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'readmore_typography',
        'selector' => '{{WRAPPER}} .wkit-readmore',
    ]
);

$this->add_control(
    'readmore_color',
    [
        'label'     => __( 'Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-readmore' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'readmore_hover_color',
    [
        'label'     => __( 'Hover Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-post-item:hover .wkit-readmore, {{WRAPPER}} .wkit-post-item-overlay:hover .wkit-readmore' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'read_more_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'readmore_alignment',
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
        'default'   => 'left',
        'selectors' => [
            '{{WRAPPER}} .readmore-wrapper' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'pagination_style_section',
    [
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'pagination_type'  => 'numbers_and_prev_next',
            'enable_slider!' => 'yes',
        ],
    ]
);

$this->start_controls_tabs( 'pagination_tabs' );

$this->start_controls_tab( 'pagination_tab_normal', [ 'label' => __( 'Normal', 'wira-kit-for-elementor' ) ] );

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_bg_color',
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link',
    ]
);

$this->add_control(
    'pagination_color',
    [
        'label' => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .page-item .page-link' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'pagination_border',
        'label' => __( 'Border', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'pagination_box_shadow',
        'label' => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab( 
    'pagination_tab_hover', 
    [ 
        'label' => __( 'Hover', 'wira-kit-for-elementor' ) 
    ] 
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_bg_color_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link:hover',
    ]
);

$this->add_control(
    'pagination_color_hover',
    [
        'label' => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .page-item .page-link:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'pagination_border_hover',
        'label' => __( 'Border', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'pagination_box_shadow_hover',
        'label' => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link:hover',
    ]
);

$this->end_controls_tab(); 

$this->start_controls_tab( 'pagination_tab_active', [ 'label' => __( 'Active', 'wira-kit-for-elementor' ) ] );

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_bg_color_active',
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link.current',
    ]
);

$this->add_control(
    'pagination_color_active',
    [
        'label' => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .page-item .page-link.current' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'pagination_border_active',
        'label' => __( 'Border', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link.current',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'pagination_box_shadow_active',
        'label' => __( 'Box Shadow', 'wira-kit-for-elementor' ),
        'selector' => '{{WRAPPER}} .wkit-pagination .page-item .page-link.current',
    ]
);

$this->end_controls_tab(); 

$this->end_controls_tabs(); 

$this->add_responsive_control(
    'pagination_width',
    [
        'label' => __( 'Width', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%', 'em' ],
        'range' => [
            'px' => ['min' => 0, 'max' => 200],
            '%' => ['min' => 0, 'max' => 200],
        ],
        'selectors' => [
            '{{WRAPPER}} ul.wkit-pagination li.page-item a.page-link, {{WRAPPER}} ul.wkit-pagination li.page-item.active span.page-link.current, {{WRAPPER}} ul.wkit-pagination li.page-item span.page-link.dots' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_height',
    [
        'label' => __( 'Height', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', '%' ],
        'range' => ['px' => ['min' => 0, 'max' => 200]],
        'selectors' => [
            '{{WRAPPER}} ul.wkit-pagination li.page-item a.page-link, {{WRAPPER}} ul.wkit-pagination li.page-item.active span.page-link.current, {{WRAPPER}} ul.wkit-pagination li.page-item span.page-link.dots' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_column_gap',
    [
        'label' => __( 'Column Gap', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', '%' ],
        'range' => ['px' => ['min' => 0, 'max' => 50]],
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination' => 'column-gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_margin',
    [
        'label' => __( 'Margin', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'pagination_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination .page-item .page-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'pagination_button_style_section',
    [
        'label' => __( 'Pagination Button', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'pagination_type' => [ 'ajax_load_more', 'infinite_scroll' ],
            'enable_slider!'  => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_btn_alignment',
    [
        'label'   => __( 'Alignment', 'wira-kit-for-elementor' ),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => __( 'Left', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-left',
            ],
            'center'     => [
                'title' => __( 'Center', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-center',
            ],
            'flex-end'   => [
                'title' => __( 'Right', 'wira-kit-for-elementor' ),
                'icon'  => 'eicon-text-align-right',
            ],
        ],
        'default'  => 'center',
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination' => 'justify-content: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'pagination_btn_typography',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->start_controls_tabs( 'pagination_btn_tabs' );

$this->start_controls_tab(
    'pagination_btn_tab_normal',
    [
        'label' => __( 'Normal', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'pagination_btn_text_color',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_btn_bg',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'pagination_btn_border',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'pagination_btn_box_shadow',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more',
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'pagination_btn_tab_hover',
    [
        'label' => __( 'Hover', 'wira-kit-for-elementor' ),
    ]
);

$this->add_control(
    'pagination_btn_text_color_hover',
    [
        'label'     => __( 'Text Color', 'wira-kit-for-elementor' ),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    [
        'name'     => 'pagination_btn_bg_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'     => 'pagination_btn_border_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'pagination_btn_box_shadow_hover',
        'selector' => '{{WRAPPER}} .wkit-pagination .wkit-load-more:hover',
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->add_responsive_control(
    'pagination_btn_padding',
    [
        'label'      => __( 'Padding', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_btn_margin',
    [
        'label'      => __( 'Margin', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_btn_radius',
    [
        'label'      => __( 'Border Radius', 'wira-kit-for-elementor' ),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
            '{{WRAPPER}} .wkit-pagination .wkit-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

$this->start_controls_section(
    'navigation_style_section',
    [
        'label' => __( 'Navigation', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_arrows' => 'yes',
            'enable_slider' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'nav_icon_size',
    [
        'label' => __( 'Size', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => 10, 'max' => 200 ],
        ],
        'selectors' => [
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
        'label' => __( 'Pagination', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
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
        'label' => __( 'Size', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range' => [
            'px' => [ 'min' => 4, 'max' => 40 ],
        ],
        'selectors' => [
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
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
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
        'label' => __( 'Color', 'wira-kit-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
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
