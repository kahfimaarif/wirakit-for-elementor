<?php
/**
 * Block Template Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH') ) { exit;
}

class Wirakit_Block_Template extends Widget_Base
{

    public function get_name()
    {
        return 'wira_elementor_kit_block_template';
    }

    public function get_title()
    {
        return __('Wkit - Components', 'wira-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-library-grid';
    }

    public function get_categories()
    {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords()
    {
        return [ 'block', 'template', 'render' ];
    }

    public function get_script_depends(): array
    {
        return [ 'wkit-block-template-frontend-js' ];
    }

    protected function get_blocks_templates()
    {
        if (class_exists('Wirakit_Template_Library_Helper') ) {
            $options = Wirakit_Template_Library_Helper::get_templates_options();
            if (! empty($options) ) {
                return $options;
            }
        }

        return array();
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

