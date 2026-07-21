<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Logo Marquee Widget.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();
$items    = array();

if ( ! empty( $settings['logo_items'] ) && is_array( $settings['logo_items'] ) ) {
	foreach ( $settings['logo_items'] as $item ) {
		if ( empty( $item['logo_image'] ) ) {
			continue;
		}

		$image_url = '';
		if ( ! empty( $item['logo_image']['id'] ) ) {
			$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
				$item['logo_image']['id'],
				'marquee_logo',
				$settings
			);
		} elseif ( ! empty( $item['logo_image']['url'] ) ) {
			$image_url = $item['logo_image']['url'];
		}

		if ( ! $image_url ) {
			continue;
		}

		$items[] = array(
			'url'  => $image_url,
			'link' => ! empty( $item['logo_link'] ) ? $item['logo_link'] : array(),
		);
	}
}

if ( empty( $items ) ) {
	echo '<p>' . esc_html__( 'Please add logo images.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$direction   = isset( $settings['marquee_direction'] ) ? $settings['marquee_direction'] : 'left';
$pause_hover = ( isset( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] );

$classes = array( 'wkit-logo-marquee' );
if ( 'right' === $direction ) {
	$classes[] = 'direction-right';
}
if ( $pause_hover ) {
	$classes[] = 'pause-on-hover';
}

$loop_items = array_merge( $items, $items );
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wkit-logo-marquee-track">
		<?php foreach ( $loop_items as $logo ) : ?>
			<div class="wkit-logo-marquee-item">
				<?php
				$rel_parts = array();
				if ( ! empty( $logo['link']['nofollow'] ) ) {
					$rel_parts[] = 'nofollow';
				}
				if ( ! empty( $logo['link']['is_external'] ) ) {
					$rel_parts[] = 'noopener';
					$rel_parts[] = 'noreferrer';
				}
				$rel_attr = implode( ' ', array_unique( $rel_parts ) );
				?>
				<?php if ( ! empty( $logo['link']['url'] ) ) : ?>
					<a href="<?php echo esc_url( $logo['link']['url'] ); ?>"<?php echo ! empty( $logo['link']['is_external'] ) ? ' target="_blank"' : ''; ?><?php echo $rel_attr ? ' rel="' . esc_attr( $rel_attr ) . '"' : ''; ?>>
				<?php endif; ?>
					<img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr__( 'Logo', 'wira-kit-for-elementor' ); ?>">
				<?php if ( ! empty( $logo['link']['url'] ) ) : ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>


