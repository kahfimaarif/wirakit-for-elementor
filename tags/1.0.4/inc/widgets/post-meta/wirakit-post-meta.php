<?php
/**
 * Post Meta Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Post_Meta extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_post_meta';
    }

    public function get_title() {
        return __( 'Wkit - Post Meta', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-post-info';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor-single' ];
    }

    public function get_keywords() {
        return [ 'post', 'meta' ];
    }

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}

