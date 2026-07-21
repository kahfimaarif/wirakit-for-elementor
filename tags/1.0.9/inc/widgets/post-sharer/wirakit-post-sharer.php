<?php
/**
 * Post Sharer Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Post_Sharer extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_post_sharer';
    }

    public function get_title() {
        return __( 'Wkit - Post Sharer', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-share';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor-single' ];
    }

    public function get_keywords() {
        return [ 'share', 'social' ];
    }

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}



