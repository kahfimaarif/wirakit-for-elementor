<?php
/**
 * Custom Content Dynamic Elementor Content Widgets
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Kit;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wirakit_Content_Widget extends Widget_Base {

    public function get_name() {
        return 'wira_elementor_kit_content';
    }

    public function get_title() {
        return __( 'Wkit - Content Dynamic', 'wira-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-post-content';
    }

    public function get_categories() {
        return [ 'wira-kit-for-elementor-single' ];
    }

    public function register_controls() {
        
        require __DIR__ . '/controls.php';
    }

    protected function render() {
        require __DIR__ . '/render.php';
    }
}

