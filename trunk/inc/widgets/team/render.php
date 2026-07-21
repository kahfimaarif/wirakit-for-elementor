<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Team Elementor Custom Widget.
 *
 * Displays a team member card with image background, name, position,
 * and optional social profile links.
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

if ( ! function_exists( 'Wirakit_render_team_default' ) ) {
	/**
	 * Render a team member block.
	 *
	 * @param array $settings Widget settings.
	 */
	function Wirakit_render_team_default( $settings ) {
		$team_name           = ! empty( $settings['team_name'] ) ? $settings['team_name'] : '';
		$team_position       = ! empty( $settings['team_position'] ) ? $settings['team_position'] : '';
		$layout_class        = '';
		$hover_class         = ! empty( $settings['hover_animation_container'] ) ? ' elementor-animation-' . $settings['hover_animation_container'] : '';
		$hover_class_wrapper = ! empty( $settings['hover_animation_wrapper_container'] ) ? ' elementor-animation-' . $settings['hover_animation_wrapper_container'] : '';
		$hover_social_icon   = ! empty( $settings['hover_animation_social_icon'] ) ? ' elementor-animation-' . $settings['hover_animation_social_icon'] : '';
		$image_id            = ! empty( $settings['team_image']['id'] ) ? $settings['team_image']['id'] : '';

		// Get team image URL.
		$image_url = '';
		if ( $image_id ) {
			$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
				$image_id,
				'thumbnail',
				$settings
			);
		} elseif ( ! empty( $settings['team_image']['url'] ) ) {
			$image_url = $settings['team_image']['url'];
		}

		// Background style.
		$bg_value = $image_url ? 'background-image:url(' . esc_url( $image_url ) . ');' : '';

		// Layout style.
		if ( isset( $settings['layout_style'] ) && 'hover-overlay' === $settings['layout_style'] ) {
			$layout_class = ' has-team-hover-overlay';
		}

		// Wrapper start.
		printf(
			'<div class="wkit-team-wrapper %1$s"%2$s>',
			esc_attr( $hover_class . $layout_class ),
			$bg_value ? ' style="' . esc_attr( $bg_value ) . '"' : ''
		);

		echo '<div class="wkit-team d-flex flex-column justify-content-end">';
		echo '<div class="wkit-team-content-wrapper' . esc_attr( $hover_class_wrapper ) . '">';

		// Position.
		if ( $team_position ) {
			echo '<p class="team-position">' . esc_html( $team_position ) . '</p>';
		}

		// Name.
		if ( $team_name ) {
			echo '<h4 class="team-name">' . esc_html( $team_name ) . '</h4>';
		}

		// Social profiles.
		if ( isset( $settings['show_social_profiles'] ) && 'yes' === $settings['show_social_profiles'] && ! empty( $settings['social_profiles'] ) ) {
			echo '<div class="team-social-profiles d-flex">';

			foreach ( $settings['social_profiles'] as $index => $item ) {
				$link     = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
				$target   = ! empty( $item['link']['is_external'] ) ? '_blank' : '';
				$rel_parts = array();
				if ( ! empty( $item['link']['nofollow'] ) ) {
					$rel_parts[] = 'nofollow';
				}
				if ( ! empty( $item['link']['is_external'] ) ) {
					$rel_parts[] = 'noopener';
					$rel_parts[] = 'noreferrer';
				}
				$rel_attr = implode( ' ', array_unique( $rel_parts ) );

				$this_item_class = 'elementor-repeater-item-' . esc_attr( $item['_id'] );

				printf(
					'<a class="team-social-link d-flex justify-content-center align-items-center %1$s" href="%2$s"%3$s%4$s>',
					esc_attr( $hover_social_icon . ' ' . $this_item_class ),
					esc_url( $link ),
					$target ? ' target="' . esc_attr( $target ) . '"' : '',
					$rel_attr ? ' rel="' . esc_attr( $rel_attr ) . '"' : ''
				);

				// Icon.
				if ( ! empty( $item['icon']['value'] ) ) {
					\Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) );
				}

				// Label (screen reader).
				if ( ! empty( $item['label'] ) ) {
					echo '<span class="sr-only">' . esc_html( $item['label'] ) . '</span>';
				}

				echo '</a>';
			}
			echo '</div>'; // .team-social-profiles
		}

		echo '</div>'; // .wkit-team-content-wrapper
		echo '</div>'; // .wkit-team
		echo '</div>'; // .wkit-team-wrapper
	}
}

// Render the team widget.
Wirakit_render_team_default( $settings );


