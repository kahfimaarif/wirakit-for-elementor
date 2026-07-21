<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Tooltip Widget
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();

$trigger_text = ! empty( $settings['tooltip_trigger_text'] ) ? $settings['tooltip_trigger_text'] : '';
$content_text = ! empty( $settings['tooltip_content_text'] ) ? $settings['tooltip_content_text'] : '';
$trigger_link = ! empty( $settings['trigger_link'] ) ? $settings['trigger_link'] : array();
$trigger_icon = ! empty( $settings['trigger_icon'] ) ? $settings['trigger_icon'] : array();

if ( '' === $trigger_text && '' === $content_text ) {
	return;
}

echo '<div class="wkit-tooltip-wrapper">';
echo '<span class="wkit-tooltip">';

if ( '' !== $trigger_text || ! empty( $trigger_icon['value'] ) ) {
	$link_url = ! empty( $trigger_link['url'] ) ? $trigger_link['url'] : '';
	if ( $link_url ) {
		$this->add_render_attribute( 'tooltip_trigger_link', 'href', esc_url( $link_url ) );
		if ( ! empty( $trigger_link['is_external'] ) ) {
			$this->add_render_attribute( 'tooltip_trigger_link', 'target', '_blank' );
		}
		if ( ! empty( $trigger_link['nofollow'] ) ) {
			$this->add_render_attribute( 'tooltip_trigger_link', 'rel', 'nofollow noopener noreferrer' );
		}

		echo '<a class="wkit-tooltip-trigger" ' . $this->get_render_attribute_string( 'tooltip_trigger_link' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders escaped attributes.
		if ( ! empty( $trigger_icon['value'] ) ) {
			echo '<span class="wkit-tooltip-icon">';
			\Elementor\Icons_Manager::render_icon( $trigger_icon, array( 'aria-hidden' => 'true' ) );
			echo '</span>';
		}
		if ( '' !== $trigger_text ) {
			echo '<span class="wkit-tooltip-text">' . esc_html( $trigger_text ) . '</span>';
		}
		echo '</a>';
	} else {
		echo '<span class="wkit-tooltip-trigger">';
		if ( ! empty( $trigger_icon['value'] ) ) {
			echo '<span class="wkit-tooltip-icon">';
			\Elementor\Icons_Manager::render_icon( $trigger_icon, array( 'aria-hidden' => 'true' ) );
			echo '</span>';
		}
		if ( '' !== $trigger_text ) {
			echo '<span class="wkit-tooltip-text">' . esc_html( $trigger_text ) . '</span>';
		}
		echo '</span>';
	}
}

if ( '' !== $content_text ) {
	echo '<span class="wkit-tooltip-content">' . esc_html( $content_text ) . '</span>';
}

echo '</span>';
echo '</div>';
