<?php
/**
 * Portfolio Gallery Elementor Custom Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Portfolio_Gallery extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_portfolio_gallery';
	}

	public function get_title() {
		return __( 'Wkit - Portfolio Gallery', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'portfolio', 'gallery', 'project', 'wkit' );
	}

	public function get_style_depends(): array {
		return array( 'wkit-portfolio-gallery-css' );
	}

	public function get_script_depends(): array {
		return array( 'wkit-portfolio-gallery-js' );
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}
