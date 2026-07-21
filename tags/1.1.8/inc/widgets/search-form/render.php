<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Search Form Elementor Custom Widget.
 *
 * Outputs a WordPress search form with optional icon/text button.
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

$placeholder  = ! empty( $settings['placeholder_text'] ) ? $settings['placeholder_text'] : __( 'Search...', 'wira-kit-for-elementor' );
$button_text  = ! empty( $settings['button_text'] ) ? $settings['button_text'] : __( 'Search', 'wira-kit-for-elementor' );
$button_type  = ! empty( $settings['button_type'] ) ? $settings['button_type'] : 'text_icon';
$icon_position = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'before';

$icon_setting = ! empty( $settings['search_icon'] ) ? $settings['search_icon'] : [];
$has_icon     = ! empty( $icon_setting['value'] );

$show_icon = $has_icon && in_array( $button_type, [ 'icon_only', 'text_icon' ], true );
$show_text = in_array( $button_type, [ 'text_only', 'text_icon' ], true );

// Fallback: if icon-only is selected but no icon is set, show text.
if ( 'icon_only' === $button_type && ! $show_icon ) {
	$show_text = true;
}

$input_id = 'wkit-search-' . $this->get_id();
?>
<div class="wkit-search-form">
	<form role="search" method="get" class="wkit-search-form__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>">
			<?php echo esc_html( $button_text ); ?>
		</label>
		<input
			id="<?php echo esc_attr( $input_id ); ?>"
			type="search"
			class="wkit-search-form__input"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
		/>
		<button type="submit" class="wkit-search-form__button" aria-label="<?php echo esc_attr( $button_text ); ?>">
			<?php if ( $show_icon && 'before' === $icon_position ) : ?>
				<span class="wkit-search-form__icon" aria-hidden="true">
					<?php \Elementor\Icons_Manager::render_icon( $icon_setting, [ 'aria-hidden' => 'true' ] ); ?>
				</span>
			<?php endif; ?>

			<?php if ( $show_text ) : ?>
				<span class="wkit-search-form__text">
					<?php echo esc_html( $button_text ); ?>
				</span>
			<?php else : ?>
				<span class="screen-reader-text">
					<?php echo esc_html( $button_text ); ?>
				</span>
			<?php endif; ?>

			<?php if ( $show_icon && 'after' === $icon_position ) : ?>
				<span class="wkit-search-form__icon" aria-hidden="true">
					<?php \Elementor\Icons_Manager::render_icon( $icon_setting, [ 'aria-hidden' => 'true' ] ); ?>
				</span>
			<?php endif; ?>
		</button>
	</form>
</div>


