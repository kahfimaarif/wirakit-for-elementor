<?php
/**
 * Logo Marquee Elementor Custom Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Logo_Marquee extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_logo_marquee';
	}

	public function get_title() {
		return __( 'Wkit - Logo Marquee', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-logo';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'logo', 'marquee', 'brand', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-logo-marquee-css' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}


