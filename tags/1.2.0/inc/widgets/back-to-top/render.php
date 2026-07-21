<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Back To Top Widget.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings    = $this->get_settings_for_display();
$unique_id   = 'wkit-back-to-top-' . $this->get_id();
$icon_class  = ! empty( $settings['icon_button']['value'] ) ? $settings['icon_button']['value'] : 'fas fa-arrow-up';
$auto_hide   = ( isset( $settings['auto_hide'] ) && 'yes' === $settings['auto_hide'] );
$hide_offset = isset( $settings['hide_offset'] ) ? absint( $settings['hide_offset'] ) : 200;

$wrapper_classes = array( 'wkit-back-to-top-wrap' );
if ( $auto_hide ) {
	$wrapper_classes[] = 'is-auto-hide';
} else {
	$wrapper_classes[] = 'is-visible';
}

wp_enqueue_script( 'wkit-back-to-top-js' );
?>

<div id="<?php echo esc_attr( $unique_id ); ?>" class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" data-offset="<?php echo esc_attr( $hide_offset ); ?>">
	<a href="#" class="wkit-back-to-top-btn" aria-label="<?php echo esc_attr__( 'Back to top', 'wira-kit-for-elementor' ); ?>">
		<i class="<?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
	</a>
</div>
