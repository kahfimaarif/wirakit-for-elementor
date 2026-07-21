<?php
/**
 * Button Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH') ) {
     exit;
}

class Wirakit_Button extends Widget_Base {

    public function get_name()
    {
        return 'wira_elementor_kit_button';
    }

    public function get_title()
    {
        return __('Wkit - Button', 'wira-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-button';
    }

    public function get_categories()
    {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords()
    {
        return [ 'button' ];
    }

    public function get_style_depends(): array
    {
        return [ 'wkit-button-css' ];
    }

    protected function register_controls()
    {

        include __DIR__ . '/controls.php';
        
    }

    protected function render()
    {

        include __DIR__ . '/render.php';

    }
}

