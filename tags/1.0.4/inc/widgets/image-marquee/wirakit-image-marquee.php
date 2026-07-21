<?php
/**
 * Image Marquee Elementor Custom Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Image_Marquee extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_image_marquee';
	}

	public function get_title() {
		return __( 'Wkit - Image Marquee', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'image', 'marquee', 'scroll', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-image-marquee-css' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}
