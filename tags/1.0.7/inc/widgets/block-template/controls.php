<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Controls For Block Template Elementor Custom Widget
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
    'section_block',
    [
        'label' => __( 'Component', 'wira-kit-for-elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'blocks_template',
    [
        'label'       => __( 'Choose Components', 'wira-kit-for-elementor' ),
        'type'        => \Elementor\Controls_Manager::SELECT2,
        'options'     => $this->get_blocks_templates(),
        'multiple'    => false,
        'label_block' => true,
    ]
);

$edit_base = admin_url( 'post.php?action=elementor&post=' );
$this->add_control(
    'edit_block_template',
    [
        'type'            => \Elementor\Controls_Manager::RAW_HTML,
        'raw'             => '<div class="wkit-edit-block-template-wrap" data-edit-base="' . esc_attr( $edit_base ) . '"><button type="button" class="button wkit-edit-block-template" style="border: none; padding: 15px 30px; background-color: var(--e-a-color-accent);">' . esc_html__( 'Edit Component', 'wira-kit-for-elementor' ) . '</button></div>',
        'content_classes' => 'wkit-edit-block-template-control',
    ]
);

$this->end_controls_section();


