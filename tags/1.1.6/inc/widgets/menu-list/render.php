<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Menu List Elementor Custom Widget.
 *
 * Displays a custom list of menu items with optional icon, description,
 * badge, and link support.
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

// Wrapper start.
echo '<div class="wkit-menu-list">';

// Title (optional).
if ( ! empty( $settings['show_title'] ) && 'yes' === $settings['show_title'] ) {
	echo '<h4 class="wkit-menu-list-title">' . esc_html( $settings['menu_list_title'] ) . '</h4>';
}

// Menu items.
if ( ! empty( $settings['menu_items'] ) ) {
	echo '<ul class="wkit-menu-list-wrapper d-flex flex-column mb-0">';

	foreach ( $settings['menu_items'] as $item ) {

		// Link attributes.
		$item_link = ! empty( $item['item_link']['url'] ) ? $item['item_link']['url'] : '';
		$target    = ! empty( $item['item_link']['is_external'] ) ? '_blank' : '';
		$nofollow  = ! empty( $item['item_link']['nofollow'] ) ? 'nofollow' : '';

		echo '<li class="wkit-menu-item position-relative d-flex">';

		// Item link start.
		if ( $item_link ) {
			printf(
				'<a class="wkit-menu-item-link d-flex" href="%1$s"%2$s%3$s>',
				esc_url( $item_link ),
				$target ? ' target="' . esc_attr( $target ) . '"' : '',
				$nofollow ? ' rel="' . esc_attr( $nofollow ) . '"' : ''
			);
		}

		// Item icon (optional).
		if ( ! empty( $item['item_icon']['value'] ) ) {
			echo '<div class="wkit-menu-item-wrapper d-flex justify-content-center align-items-center">';
			\Elementor\Icons_Manager::render_icon( $item['item_icon'], array( 'aria-hidden' => 'true' ) );
			echo '</div>';
		}

		// Item text + description.
		echo '<div class="wtookit-menu-item-text-wrapper d-flex flex-column">';
			echo '<span class="menu-text">' . esc_html( $item['item_text'] ) . '</span>';
			echo '<span class="menu-text-description">' . esc_html( $item['item_text_description'] ) . '</span>';
		echo '</div>';

		// Item link end.
		if ( $item_link ) {
			echo '</a>';
		}

		// Item badge (optional).
		if ( ! empty( $item['item_badge'] ) ) {
			echo '<span class="menu-badge">' . esc_html( $item['item_badge'] ) . '</span>';
		}

		echo '</li>';
	}

	echo '</ul>';
}

// Wrapper end.
echo '</div>';

