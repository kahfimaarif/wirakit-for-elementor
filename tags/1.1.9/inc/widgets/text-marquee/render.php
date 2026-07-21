<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Text Marquee Widget.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();

$items = array();
if ( ! empty( $settings['marquee_items'] ) && is_array( $settings['marquee_items'] ) ) {
	foreach ( $settings['marquee_items'] as $item ) {
		$text = isset( $item['item_text'] ) ? trim( wp_strip_all_tags( $item['item_text'] ) ) : '';
		if ( '' !== $text ) {
			$items[] = $text;
		}
	}
}

if ( empty( $items ) ) {
	echo '<p>' . esc_html__( 'Please add marquee text items.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$show_separator = ( isset( $settings['show_separator'] ) && 'yes' === $settings['show_separator'] );
$separator_type = isset( $settings['separator_type'] ) ? $settings['separator_type'] : 'text';
$separator_text = isset( $settings['separator_text'] ) && '' !== $settings['separator_text'] ? $settings['separator_text'] : '*';
$direction      = isset( $settings['marquee_direction'] ) ? $settings['marquee_direction'] : 'left';
$pause_hover    = ( isset( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover' ] );

$classes = array( 'wkit-text-marquee' );
if ( 'right' === $direction ) {
	$classes[] = 'direction-right';
}
if ( $pause_hover ) {
	$classes[] = 'pause-on-hover';
}

$loop_items = array_merge( $items, $items );
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wkit-text-marquee-track">
		<?php foreach ( $loop_items as $index => $text ) : ?>
			<span class="wkit-text-marquee-item"><?php echo esc_html( $text ); ?></span>

			<?php if ( $show_separator && $index < count( $loop_items ) - 1 ) : ?>
				<span class="wkit-text-marquee-separator" aria-hidden="true">
					<?php if ( 'icon' === $separator_type && ! empty( $settings['separator_icon']['value'] ) ) : ?>
						<i class="<?php echo esc_attr( $settings['separator_icon']['value'] ); ?>" aria-hidden="true"></i>
					<?php else : ?>
						<?php echo esc_html( $separator_text ); ?>
					<?php endif; ?>
				</span>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>



