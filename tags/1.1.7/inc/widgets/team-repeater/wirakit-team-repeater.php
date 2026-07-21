<?php
/**
 * Team Repeater Elementor Custom Widget
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wirakit_Team_Repeater extends Widget_Base {

	public function get_name() {
		return 'wira_elementor_kit_team_repeater';
	}

	public function get_title() {
		return __( 'Wkit - Team Repeater', 'wira-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return array( 'wira-kit-for-elementor' );
	}

	public function get_keywords() {
		return array( 'team', 'repeater', 'member' );
	}

	public function get_style_depends(): array {
		return array(
			'wkit-team-css',
			'wkit-team-repeater-css',
			'wkit-swiper-bundle-min-css',
			'wkit-carousel-slider-css',
		);
	}

	public function get_script_depends(): array {
		return array(
			'wkit-swiper-bundle-min-js',
			'wkit-swiper-js',
		);
	}

	protected function register_controls() {
		require __DIR__ . '/controls.php';
	}

	protected function render() {
		require __DIR__ . '/render.php';
	}
}

