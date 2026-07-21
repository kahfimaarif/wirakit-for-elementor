<?php
/**
 * Tooltip Elementor Custom Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Tooltip extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_tooltip';
	}

	public function get_title() {
		return __( 'Wkit - Tooltip', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-info-circle-o';
	}

	public function get_categories() {
		return [ 'wira-kit-for-elementor' ];
	}

	public function get_keywords() {
		return [ 'tooltip', 'info', 'hint' ];
	}

	public function get_style_depends(): array {
		return [ 'wkit-tooltip-css' ];
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}
