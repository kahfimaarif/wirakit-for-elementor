<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Button Elementor Custom Widget.
 *
 * Handles rendering of a customizable button with optional icon (before/after text),
 * hover animations, and Elementor link attributes.
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
$button_trigger_type = ! empty( $settings['button_trigger_type'] ) ? $settings['button_trigger_type'] : 'button';

/**
 * Setup button link attributes (URL, target, rel).
 * If no URL provided, fallback to "#".
 */
if ( ! empty( $settings['button_link']['url'] ) ) {
	$this->add_link_attributes( 'button', $settings['button_link'] );
} else {
	$this->add_render_attribute( 'button', 'href', '#' );
}

/**
 * Base button classes.
 */
if ( 'icon' === $button_trigger_type ) {
	$this->add_render_attribute(
		'button',
		'class',
		array(
			'icon-button',
			'd-inline-flex',
			'align-items-center',
			'justify-content-center',
			'position-relative',
		)
	);
} else {
	$this->add_render_attribute(
		'button',
		'class',
		array( 'wkit-btn', 'wkit-btn-main' )
	);
}

/**
 * Elementor hover animation class.
 */
if ( ! empty( $settings['hover_animation'] ) ) {
	$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
}

?>
<div class="wkit-button-wrapper d-flex">
	<a <?php echo $this->get_render_attribute_string( 'button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: already escaped by Elementor ?>>
		<?php if ( 'icon' === $button_trigger_type ) : ?>
			<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
				<i class="<?php echo esc_attr( $settings['button_icon']['value'] ); ?>" aria-hidden="true"></i>
			<?php else : ?>
				<span class="wkit-btn-text"><?php echo esc_html( $settings['button_text'] ); ?></span>
			<?php endif; ?>
		<?php else : ?>
		<span class="wkit-btn-wrapper d-flex">

			<?php // Icon before text. ?>
			<?php if ( ! empty( $settings['button_icon']['value'] ) && 'before' === $settings['icon_position'] ) : ?>
				<span class="wkit-btn-icon">
					<i class="<?php echo esc_attr( $settings['button_icon']['value'] ); ?>"></i>
				</span>
			<?php endif; ?>

			<?php // Button text. ?>
			<div class="wkit-btn-text-wrapper">
				<span class="wkit-btn-text">
					<?php echo esc_html( $settings['button_text'] ); ?>
				</span>
				<span class="wkit-btn-text">
					<?php echo esc_html( $settings['button_text'] ); ?>
				</span>
			</div>

			<?php // Icon after text. ?>
			<?php if ( ! empty( $settings['button_icon']['value'] ) && 'after' === $settings['icon_position'] ) : ?>
				<span class="wkit-btn-icon icon-right">
					<i class="<?php echo esc_attr( $settings['button_icon']['value'] ); ?>"></i>
				</span>
			<?php endif; ?>

		</span>
		<?php endif; ?>
	</a>
</div>
