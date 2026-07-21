<?php
/**
 * Progress Bar Elementor Custom Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Progress_Bar extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_progress_bar';
	}

	public function get_title() {
		return __( 'Wkit - Progress Bar', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'progress', 'bar', 'skill', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-progress-bar-css' );
	}

	public function get_script_depends(): array {
		return array( 'wkit-progress-bar-js' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}
