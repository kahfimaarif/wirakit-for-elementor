<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Countdown Timer Widget.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings  = $this->get_settings_for_display();
$unique_id = 'wkit-countdown-' . $this->get_id();

$due_date_raw = ! empty( $settings['due_date'] ) ? $settings['due_date'] : '';
$due_ts       = 0;

if ( ! empty( $due_date_raw ) ) {
	$datetime = date_create( $due_date_raw, wp_timezone() );
	if ( $datetime instanceof DateTime ) {
		$due_ts = $datetime->getTimestamp();
	}
}

$show_labels    = ( isset( $settings['show_labels'] ) && 'yes' === $settings['show_labels'] );
$show_separator = ( isset( $settings['show_separator'] ) && 'yes' === $settings['show_separator'] );
$separator_text = isset( $settings['separator_text'] ) ? $settings['separator_text'] : ':';

$units = array();

if ( isset( $settings['show_days'] ) && 'yes' === $settings['show_days'] ) {
	$units[] = array(
		'key'   => 'days',
		'label' => ! empty( $settings['day_label'] ) ? $settings['day_label'] : __( 'Days', 'wira-kit-for-elementor' ),
	);
}

if ( isset( $settings['show_hours'] ) && 'yes' === $settings['show_hours'] ) {
	$units[] = array(
		'key'   => 'hours',
		'label' => ! empty( $settings['hour_label'] ) ? $settings['hour_label'] : __( 'Hours', 'wira-kit-for-elementor' ),
	);
}

if ( isset( $settings['show_minutes'] ) && 'yes' === $settings['show_minutes'] ) {
	$units[] = array(
		'key'   => 'minutes',
		'label' => ! empty( $settings['minute_label'] ) ? $settings['minute_label'] : __( 'Minutes', 'wira-kit-for-elementor' ),
	);
}

if ( isset( $settings['show_seconds'] ) && 'yes' === $settings['show_seconds'] ) {
	$units[] = array(
		'key'   => 'seconds',
		'label' => ! empty( $settings['second_label'] ) ? $settings['second_label'] : __( 'Seconds', 'wira-kit-for-elementor' ),
	);
}

if ( empty( $units ) ) {
	$units[] = array(
		'key'   => 'seconds',
		'label' => ! empty( $settings['second_label'] ) ? $settings['second_label'] : __( 'Seconds', 'wira-kit-for-elementor' ),
	);
}

$expired_text = ! empty( $settings['expired_text'] ) ? $settings['expired_text'] : __( 'Countdown Finished', 'wira-kit-for-elementor' );

if ( $due_ts > 0 ) {
	wp_enqueue_script( 'wkit-countdown-js' );
}
?>

<div id="<?php echo esc_attr( $unique_id ); ?>" class="wkit-countdown-wrap" data-end="<?php echo esc_attr( $due_ts ); ?>">
	<?php if ( $due_ts <= 0 ) : ?>
		<div class="wkit-countdown-expired">
			<?php esc_html_e( 'Please set a valid due date.', 'wira-kit-for-elementor' ); ?>
		</div>
	<?php else : ?>
		<div class="wkit-countdown">
			<?php foreach ( $units as $index => $unit ) : ?>
				<div class="wkit-countdown-item" data-unit="<?php echo esc_attr( $unit['key'] ); ?>">
					<span class="wkit-countdown-number">00</span>
					<?php if ( $show_labels ) : ?>
						<span class="wkit-countdown-label"><?php echo esc_html( $unit['label'] ); ?></span>
					<?php endif; ?>
				</div>

				<?php if ( $show_separator && $index < count( $units ) - 1 ) : ?>
					<span class="wkit-countdown-separator"><?php echo esc_html( $separator_text ); ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<div class="wkit-countdown-expired" style="display:none;">
			<?php echo esc_html( $expired_text ); ?>
		</div>
	<?php endif; ?>
</div>
