<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Portfolio Gallery Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();
$items    = ! empty( $settings['portfolio_items'] ) && is_array( $settings['portfolio_items'] ) ? $settings['portfolio_items'] : array();

if ( empty( $items ) ) {
	echo '<p>' . esc_html__( 'No portfolio item found.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$enable_category_tabs = ! empty( $settings['enable_portfolio_category'] ) && 'yes' === $settings['enable_portfolio_category'];
$category_items       = ! empty( $settings['portfolio_categories'] ) && is_array( $settings['portfolio_categories'] ) ? $settings['portfolio_categories'] : array();
$category_map         = array();

if ( $enable_category_tabs && ! empty( $category_items ) ) {
	foreach ( $category_items as $category_item ) {
		$raw_slug  = ! empty( $category_item['category_slug'] ) ? (string) $category_item['category_slug'] : '';
		$raw_label = ! empty( $category_item['category_label'] ) ? (string) $category_item['category_label'] : '';
		$slug      = sanitize_title( $raw_slug ? $raw_slug : $raw_label );
		$label     = $raw_label ? $raw_label : ucfirst( str_replace( '-', ' ', $slug ) );

		if ( $slug && $label ) {
			$category_map[ $slug ] = $label;
		}
	}
}

$layout_class = ( ! empty( $settings['layout_style'] ) && 'hover-overlay' === $settings['layout_style'] ) ? ' is-overlay' : ' is-default';
$widget_id    = 'wkit-portfolio-' . $this->get_id();

echo '<div id="' . esc_attr( $widget_id ) . '" class="wkit-portfolio-gallery-wrap">';

if ( $enable_category_tabs && ! empty( $category_map ) ) {
	$all_label = ! empty( $settings['portfolio_all_tab_label'] ) ? $settings['portfolio_all_tab_label'] : __( 'All', 'wira-kit-for-elementor' );

	echo '<div class="wkit-portfolio-tabs" role="tablist">';
	echo '<button type="button" class="wkit-portfolio-tab is-active" role="tab" aria-selected="true" data-category="all">' . esc_html( $all_label ) . '</button>';
	foreach ( $category_map as $tab_slug => $tab_label ) {
		echo '<button type="button" class="wkit-portfolio-tab" role="tab" aria-selected="false" data-category="' . esc_attr( $tab_slug ) . '">' . esc_html( $tab_label ) . '</button>';
	}
	echo '</div>';
}

echo '<div class="wkit-portfolio-gallery' . esc_attr( $layout_class ) . '">';

foreach ( $items as $item ) {
	$title       = ! empty( $item['portfolio_title'] ) ? $item['portfolio_title'] : '';
	$description = ! empty( $item['portfolio_description'] ) ? $item['portfolio_description'] : '';
	$action_type = ! empty( $item['action_type'] ) ? $item['action_type'] : 'none';
	$image_url   = '';
	$image_id    = ! empty( $item['portfolio_image']['id'] ) ? $item['portfolio_image']['id'] : 0;

	if ( $image_id ) {
		$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $image_id, 'portfolio_thumb', $settings );
	} elseif ( ! empty( $item['portfolio_image']['url'] ) ) {
		$image_url = $item['portfolio_image']['url'];
	}

	$bg_style = $image_url ? 'background-image:url(' . esc_url( $image_url ) . ');' : '';

	$link_data = ! empty( $item['action_link'] ) && is_array( $item['action_link'] ) ? $item['action_link'] : array();
	$link      = ! empty( $link_data['url'] ) ? $link_data['url'] : '';
	$target    = ! empty( $link_data['is_external'] ) ? '_blank' : '';
	$rel_parts = array();
	if ( ! empty( $link_data['nofollow'] ) ) {
		$rel_parts[] = 'nofollow';
	}
	if ( ! empty( $link_data['is_external'] ) ) {
		$rel_parts[] = 'noopener';
		$rel_parts[] = 'noreferrer';
	}
	$rel_attr = ! empty( $rel_parts ) ? implode( ' ', array_unique( $rel_parts ) ) : '';
	$item_category = '';

	if ( $enable_category_tabs ) {
		$raw_item_category = ! empty( $item['portfolio_category'] ) ? (string) $item['portfolio_category'] : '';
		$item_category     = sanitize_title( $raw_item_category );
		if ( $item_category && ! isset( $category_map[ $item_category ] ) ) {
			$item_category = '';
		}
	}

	$item_attr = $item_category ? $item_category : 'uncategorized';

	echo '<div class="wkit-portfolio-item" data-category="' . esc_attr( $item_attr ) . '"' . ( $bg_style ? ' style="' . esc_attr( $bg_style ) . '"' : '' ) . '>';
	echo '<div class="wkit-portfolio-overlay"></div>';
	echo '<div class="wkit-portfolio-content">';

	if ( $title ) {
		echo '<h4 class="wkit-portfolio-title">' . esc_html( $title ) . '</h4>';
	}

	if ( $description ) {
		echo '<p class="wkit-portfolio-description">' . esc_html( $description ) . '</p>';
	}

	if ( in_array( $action_type, array( 'button', 'icon-only' ), true ) && $link ) {
		$action_classes = 'wkit-portfolio-action';
		if ( 'icon-only' === $action_type ) {
			$action_classes .= ' is-icon-only';
		}

		echo '<div class="wkit-portfolio-action-wrap">';
		echo '<a class="' . esc_attr( $action_classes ) . '" href="' . esc_url( $link ) . '"' . ( $target ? ' target="' . esc_attr( $target ) . '"' : '' ) . ( $rel_attr ? ' rel="' . esc_attr( $rel_attr ) . '"' : '' ) . '>';
		if ( 'button' === $action_type ) {
			$action_text = ! empty( $item['action_text'] ) ? $item['action_text'] : __( 'View Project', 'wira-kit-for-elementor' );
			echo '<span class="wkit-portfolio-action-text">' . esc_html( $action_text ) . '</span>';
		}

		if ( ! empty( $item['action_icon']['value'] ) ) {
			echo '<span class="wkit-portfolio-action-icon">';
			\Elementor\Icons_Manager::render_icon( $item['action_icon'], array( 'aria-hidden' => 'true' ) );
			echo '</span>';
		}
		echo '</a>';
		echo '</div>';
	}

	echo '</div>';
	echo '</div>';
}

echo '</div>';
echo '</div>';

if ( $enable_category_tabs && ! empty( $category_map ) ) :
	?>
	<?php
endif;
