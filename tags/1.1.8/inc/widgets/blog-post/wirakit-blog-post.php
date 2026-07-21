<?php
/**
 * Blog Post Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Blog_Post extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_blog_post';
    }

    public function get_title() {
        return __( 'Wkit - Blog Post', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords() {
        return [ 'post' ];
    }

    public function get_style_depends(): array {
		return [ 'wkit-blog-css', 'wkit-swiper-bundle-min-css', 'wkit-carousel-slider-css' ];
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

