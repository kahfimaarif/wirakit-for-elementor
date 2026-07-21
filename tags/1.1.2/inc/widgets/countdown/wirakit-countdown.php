<?php
/**
 * Countdown Timer Elementor Custom Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Countdown extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_countdown';
	}

	public function get_title() {
		return __( 'Wkit - Countdown Timer', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'countdown', 'timer', 'time', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-countdown-css' );
	}

	public function get_script_depends(): array {
		return array( 'wkit-countdown-js' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}


