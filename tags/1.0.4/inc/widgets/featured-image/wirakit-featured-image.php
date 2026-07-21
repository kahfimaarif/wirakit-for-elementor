<?php
/**
 * Featured Image Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Featured_Image extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_featured_image';
    }

    public function get_title() {
        return __( 'Wkit - Featured Image', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-featured-image';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor-single' ];
    }

    public function get_keywords() {
        return [ 'image', 'featured-image' ];
    }

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}

