<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Post Navigation Elementor Custom Widget.
 *
 * Displays navigation links to the previous and next posts,
 * including optional icons, custom text, and truncated titles.
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

// Get adjacent posts.
$prev_post = get_previous_post();
$next_post = get_next_post();

// Bail early if no navigation available.
if ( empty( $prev_post ) && empty( $next_post ) ) {
	return;
}

// Main wrapper.
echo '<div class="post-navigation d-flex">';

/**
 * Previous Post.
 */
echo '<div class="prev-post">';

if ( ! empty( $prev_post ) ) {
	echo '<a href="' . esc_url( get_permalink( $prev_post->ID ) ) . '">';
	echo '<div class="wkit-post-nav-wrapper text-start d-flex align-items-center">';

	// Icon before text.
	if ( 'yes' === $settings['show_prev_icon'] && ! empty( $settings['prev_icon']['value'] ) ) {
		\Elementor\Icons_Manager::render_icon(
			$settings['prev_icon'],
			array(
				'aria-hidden' => 'true',
				'class'       => 'me-1',
			)
		);
	}

	// Content wrapper.
	echo '<div class="wkit-post-nav-content">';

	// Navigation label text.
	echo '<span class="wkit-text-small wkit-color-placeholder d-block mb-1">';
	echo esc_html( $settings['prev_text'] );
	echo '</span>';

	// Truncated title.
	echo '<strong>' . esc_html( wp_trim_words( get_the_title( $prev_post->ID ), 3, '...' ) ) . '</strong>';

	echo '</div>'; // .wkit-post-nav-content
	echo '</div>'; // .wkit-post-nav-wrapper
	echo '</a>';
}

echo '</div>'; // .prev-post

/**
 * Next Post.
 */
echo '<div class="next-post">';

if ( ! empty( $next_post ) ) {
	echo '<a href="' . esc_url( get_permalink( $next_post->ID ) ) . '">';
	echo '<div class="wkit-post-nav-wrapper text-end d-flex align-items-center">';

	// Content wrapper.
	echo '<div class="wkit-post-nav-content">';

	// Navigation label text.
	echo '<span class="wkit-text-small wkit-color-placeholder d-block mb-1">';
	echo esc_html( $settings['next_text'] );
	echo '</span>';

	// Truncated title.
	echo '<strong>' . esc_html( wp_trim_words( get_the_title( $next_post->ID ), 3, '...' ) ) . '</strong>';

	echo '</div>'; // .wkit-post-nav-content

	// Icon after text.
	if ( 'yes' === $settings['show_next_icon'] && ! empty( $settings['next_icon']['value'] ) ) {
		\Elementor\Icons_Manager::render_icon(
			$settings['next_icon'],
			array(
				'aria-hidden' => 'true',
				'class'       => 'ms-1',
			)
		);
	}

	echo '</div>'; // .wkit-post-nav-wrapper
	echo '</a>';
}

echo '</div>'; // .next-post

echo '</div>'; // .post-navigation

