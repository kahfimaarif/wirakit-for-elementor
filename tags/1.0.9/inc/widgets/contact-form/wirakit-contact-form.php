<?php
/**
 * Contact Form 7 Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Contact_Form extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_contact_form';
    }

    public function get_title() {
        return __( 'Wkit - CF7', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-ehp-forms';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords() {
        return [ 'form' ];
    }

    public function get_style_depends(): array {
		return [ 'wkit-contact-form-css' ];
	}

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}



