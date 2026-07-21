<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Progress Bar Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();

$label = isset( $settings['progress_label'] ) ? $settings['progress_label'] : '';
$value = 0;
if ( isset( $settings['progress_value']['size'] ) ) {
	$value = absint( $settings['progress_value']['size'] );
}

if ( $value > 100 ) {
	$value = 100;
}

$show_percentage = isset( $settings['show_percentage'] ) && 'yes' === $settings['show_percentage'];
$unique_id       = 'wkit-progressbar-' . $this->get_id();
$duration_ms     = isset( $settings['progress_animation_duration'] ) ? max( 0, absint( $settings['progress_animation_duration'] ) ) : 1200;
$easing          = isset( $settings['progress_animation_easing'] ) ? sanitize_key( $settings['progress_animation_easing'] ) : 'easeoutcubic';
?>

<div
	id="<?php echo esc_attr( $unique_id ); ?>"
	class="wkit-progressbar-wrap"
	role="progressbar"
	aria-valuemin="0"
	aria-valuemax="100"
	aria-valuenow="0"
	data-target="<?php echo esc_attr( $value ); ?>"
	data-duration="<?php echo esc_attr( $duration_ms ); ?>"
	data-easing="<?php echo esc_attr( $easing ); ?>"
>
	<div class="wkit-progressbar-header">
		<?php if ( ! empty( $label ) ) : ?>
			<span class="wkit-progressbar-label"><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>

		<?php if ( $show_percentage ) : ?>
			<span class="wkit-progressbar-percentage" data-progress-percentage>0%</span>
		<?php endif; ?>
	</div>

	<div class="wkit-progressbar-track">
		<span class="wkit-progressbar-fill" style="width: 0%;"></span>
	</div>
</div>
