<?php
/**
 * Back To Top Elementor Custom Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Back_To_Top extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_back_to_top';
	}

	public function get_title() {
		return __( 'Wkit - Back To Top', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-arrow-up';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'back to top', 'scroll', 'button', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-back-to-top-css' );
	}

	public function get_script_depends(): array {
		return array( 'wkit-back-to-top-js' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}


