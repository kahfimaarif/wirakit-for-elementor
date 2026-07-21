<?php
/**
 * Carousel Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Carousel extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_carousel';
    }

    public function get_title() {
        return __( 'Wkit - Blocks Carousel', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords() {
        return [ 'carousel', 'slider' ];
    }

    protected function get_blocks_templates() {
        if ( class_exists( 'Wirakit_Template_Library_Helper' ) ) {
            $options = Wirakit_Template_Library_Helper::get_templates_options();
            if ( ! empty( $options ) ) {
                return $options;
            }
        }

        return array();
    }

    public function get_style_depends(): array {
		return [ 'wkit-swiper-bundle-min-css', 'wkit-carousel-slider-css' ];
	}

    public function get_script_depends(): array {
		return [ 'wkit-swiper-bundle-min-js', 'wkit-swiper-js' ];
	}

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}

