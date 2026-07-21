<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Image Marquee Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();
$items    = array();

if ( ! empty( $settings['image_items'] ) && is_array( $settings['image_items'] ) ) {
	foreach ( $settings['image_items'] as $item ) {
		if ( empty( $item['image'] ) ) {
			continue;
		}

		$image_url = '';
		if ( ! empty( $item['image']['id'] ) ) {
			$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
				$item['image']['id'],
				'marquee_image',
				$settings
			);
		} elseif ( ! empty( $item['image']['url'] ) ) {
			$image_url = $item['image']['url'];
		}

		if ( ! $image_url ) {
			continue;
		}

		$items[] = array(
			'url'  => $image_url,
			'link' => ! empty( $item['image_link'] ) ? $item['image_link'] : array(),
		);
	}
}

if ( empty( $items ) ) {
	echo '<p>' . esc_html__( 'Please add images.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$axis           = isset( $settings['marquee_scroll_axis'] ) ? $settings['marquee_scroll_axis'] : 'horizontal';
$direction_h    = isset( $settings['marquee_direction_horizontal'] ) ? $settings['marquee_direction_horizontal'] : 'left';
$direction_v    = isset( $settings['marquee_direction_vertical'] ) ? $settings['marquee_direction_vertical'] : 'up';
$pause_hover    = ( isset( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] );
$should_reverse = ( 'horizontal' === $axis && 'right' === $direction_h ) || ( 'vertical' === $axis && 'down' === $direction_v );

$classes = array( 'wkit-image-marquee' );
$classes[] = ( 'vertical' === $axis ) ? 'scroll-vertical' : 'scroll-horizontal';

if ( $should_reverse ) {
	$classes[] = 'direction-reverse';
}
if ( $pause_hover ) {
	$classes[] = 'pause-on-hover';
}

$loop_items = array_merge( $items, $items );
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wkit-image-marquee-track">
		<?php foreach ( $loop_items as $image ) : ?>
			<div class="wkit-image-marquee-item">
				<?php
				$rel_parts = array();
				if ( ! empty( $image['link']['nofollow'] ) ) {
					$rel_parts[] = 'nofollow';
				}
				if ( ! empty( $image['link']['is_external'] ) ) {
					$rel_parts[] = 'noopener';
					$rel_parts[] = 'noreferrer';
				}
				$rel_attr = implode( ' ', array_unique( $rel_parts ) );
				?>
				<?php if ( ! empty( $image['link']['url'] ) ) : ?>
					<a href="<?php echo esc_url( $image['link']['url'] ); ?>"<?php echo ! empty( $image['link']['is_external'] ) ? ' target="_blank"' : ''; ?><?php echo $rel_attr ? ' rel="' . esc_attr( $rel_attr ) . '"' : ''; ?>>
				<?php endif; ?>
					<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr__( 'Marquee image', 'wira-kit-for-elementor' ); ?>">
				<?php if ( ! empty( $image['link']['url'] ) ) : ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
