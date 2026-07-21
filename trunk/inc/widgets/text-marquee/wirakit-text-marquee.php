<?php
/**
 * Text Marquee Elementor Custom Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Text_Marquee extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_text_marquee';
	}

	public function get_title() {
		return __( 'Wkit - Text Marquee', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-animation-text';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'marquee', 'text', 'ticker', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-text-marquee-css' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}


