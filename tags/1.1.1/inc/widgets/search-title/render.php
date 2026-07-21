<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Search Title Elementor Custom Widget.
 *
 * Outputs the search results title with optional prefix and link.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get widget settings.
$settings = $this->get_settings_for_display();

// Define heading tag, default to h1.
$heading_tag  = ! empty( $settings['heading_tag'] ) ? $settings['heading_tag'] : 'h1';
$content      = '';
$heading_link = '';
$prefix       = '';

// Prefix handling.
if ( ! empty( $settings['enable_search_prefix'] ) && 'yes' === $settings['enable_search_prefix'] ) {
	$prefix = $settings['search_prefix_text'];
} else {
	$prefix = esc_html__( 'Search result for: ', 'wira-kit-for-elementor' );
}

// Build content if search query is active.
if ( is_search() ) {
	$content = $prefix . get_search_query();

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_search_link();
	}
}

// Size class.
$size_class = ! empty( $settings['size'] ) ? 'elementor-size-' . $settings['size'] : 'elementor-size-default';

// Render heading output.
echo '<' . esc_attr( $heading_tag ) . ' class="wkit-dynamic-heading elementor-heading-title ' . esc_attr( $size_class ) . '">';

if ( ! empty( $content ) ) {
	echo esc_html( $content );
} else {
	// Fallback title if no search query found.
	echo esc_html( $prefix . esc_html__( 'Search Title', 'wira-kit-for-elementor' ) );
}

echo '</' . esc_attr( $heading_tag ) . '>';


