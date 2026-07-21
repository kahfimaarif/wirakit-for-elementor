<?php
/**
 * Menu List Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Menu_List extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_menu_list';
    }

    public function get_title() {
        return __( 'Wkit - Menu List', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor' ];
    }

    public function get_keywords() {
        return [ 'menu', 'list', 'megamenu' ];
    }

    protected function register_controls() {

        require __DIR__ . '/controls.php';
        
    }

    protected function render() {

        require __DIR__ . '/render.php';

    }
}

