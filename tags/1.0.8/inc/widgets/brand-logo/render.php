<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Brand Logo Elementor Custom Widget.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings  = $this->get_settings_for_display();
$logo_mode = isset( $settings['logo_mode'] ) ? $settings['logo_mode'] : 'inherit';
$logo_html = '';

if ( 'custom' === $logo_mode && ! empty( $settings['logo_image'] ) ) {
	$logo_url = '';

	if ( ! empty( $settings['logo_image']['id'] ) ) {
		$logo_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
			$settings['logo_image']['id'],
			'logo',
			$settings
		);
	} elseif ( ! empty( $settings['logo_image']['url'] ) ) {
		$logo_url = $settings['logo_image']['url'];
	}

	if ( $logo_url ) {
		$logo_html = '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
	}
} else {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$logo_html = wp_get_attachment_image(
			$custom_logo_id,
			'full',
			false,
			[
				'class' => 'custom-logo',
				'alt'   => get_bloginfo( 'name' ),
			]
		);
	}
}

// Fallback default logo.
if ( empty( $logo_html ) ) {
	$logo_html = '<img src="' . esc_url( WIRAKIT_URL . 'assets/widget/img/wira-kit-for-elementor-light.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="512" height="85" decoding="async" class="custom-logo">';
}

// Wrap with link if enabled.
if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
	$logo_html = '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home">' . $logo_html . '</a>';
}

echo '<div class="wkit-brand-logo">' . wp_kses_post( $logo_html ) . '</div>';



