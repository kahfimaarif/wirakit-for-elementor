<?php
/**
 * Popup Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Popup extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_popup';
    }

    public function get_title() {
        return __( 'Wkit - Popup', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-lightbox-expand';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor-dynamic' ];
    }

    public function get_keywords() {
        return [ 'popup', 'modal' ];
    }

    protected function get_popup_templates() {
        if ( class_exists( 'Wirakit_Template_Library_Helper' ) ) {
            $options = Wirakit_Template_Library_Helper::get_templates_options();
            if ( ! empty( $options ) ) {
                return $options;
            }
        }

        return array();
    }

	public function get_style_depends(): array {
		return [ 'wkit-button-css', 'wkit-popup-css' ];
	}

    public function get_script_depends(): array {
		return [ 'wkit-popup-js' ];
	}

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}



