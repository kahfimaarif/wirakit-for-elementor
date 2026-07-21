<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Contact Form 7 Elementor Custom Widget.
 *
 * Outputs a selected Contact Form 7 form inside Elementor.
 * Falls back to a message if no form ID is chosen.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();

// If a form ID is selected, render it via shortcode.
if ( ! empty( $settings['form_id'] ) ) {
	echo '<div class="wkit-contact-form">';
	// Safe: Contact Form 7 handles its own sanitization and escaping.
	echo do_shortcode( '[contact-form-7 id="' . esc_attr( $settings['form_id'] ) . '"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: shortcode renders plugin-controlled form HTML.
	echo '</div>';
} else {
	// Fallback message if no form is selected.
	echo '<p>' . esc_html__( 'Please select a Contact Form 7.', 'wira-kit-for-elementor' ) . '</p>';
}


