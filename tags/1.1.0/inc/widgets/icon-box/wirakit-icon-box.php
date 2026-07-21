<?php
/**
 * Icon Box Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Icon_Box extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_icon_box';
    }

    public function get_title() {
        return __( 'Wkit - Icon Box', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords() {
        return [ 'iconbox', 'icon', 'box' ];
    }

    public function get_style_depends(): array {
		return [ 'wkit-icon-box-css' ];
	}

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}

