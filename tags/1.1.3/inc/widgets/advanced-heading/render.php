<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render template for Advanced Heading Elementor Custom Widget.
 *
 * This file handles the frontend rendering of the Advanced Heading widget,
 * including support for featured text animation and optional text fill effect.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get widget settings for display.
$settings = $this->get_settings_for_display();

// Define safe fallbacks for heading parts.
$heading_tag = ! empty( $settings['heading_tag'] ) ? $settings['heading_tag'] : 'h2';
$before      = ! empty( $settings['heading_before'] ) ? $settings['heading_before'] : '';
$featured    = ! empty( $settings['heading_featured'] ) ? $settings['heading_featured'] : '';
$after       = ! empty( $settings['heading_after'] ) ? $settings['heading_after'] : '';

// Support both possible control names, prefer 'use_text_fill'.
$use_text_fill = $settings['use_text_fill'] ?? $settings['focused_title_text_fill'] ?? '';

// Normalize boolean-ish values (Elementor returns 'yes' when switcher is on).
$use_text_fill_active = ( 'yes' === $use_text_fill || true === $use_text_fill || '1' === $use_text_fill );

// Build CSS classes safely.
$classes = array( 'wkit-advanced-heading' );
if ( $use_text_fill_active ) {
	$classes[] = 'wkit-text-fill';
}

// Start heading tag with classes.
echo '<' . esc_attr( $heading_tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">';

// Render "before" text if provided.
if ( '' !== $before ) {
	echo wp_kses_post( $before ) . ' ';
}

// Render "featured" text with animation wrapper if provided.
if ( '' !== $featured ) {
	echo '<span class="wkit-animated-text">' . wp_kses_post( $featured ) . '</span> ';
}

// Render "after" text if provided.
if ( '' !== $after ) {
	echo wp_kses_post( $after );
}

// Close heading tag.
echo '</' . esc_attr( $heading_tag ) . '>';

