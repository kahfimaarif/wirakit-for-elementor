<?php
/**
 * Accordion Elementor Custom Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Accordion extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_accordion';
	}

	public function get_title() {
		return __( 'Wkit - Accordion', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'accordion', 'faq', 'toggle', 'collapse', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-accordion-css' );
	}

	public function get_script_depends(): array {
		return array( 'wkit-accordion-js' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}
