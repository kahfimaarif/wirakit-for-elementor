<?php
/**
 * Bootstrap Nav Walker For Nav Menu Elementor Custom Widget
 * 
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wirakit_Bootstrap_Navwalker extends Walker_Nav_Menu {
	private function get_dropdown_icon_html( $args, $depth = 0 ) {
		$icon_setting = array();
		if ( isset( $args->wira_elementor_kit_nav_dropdown_icon ) && is_array( $args->wira_elementor_kit_nav_dropdown_icon ) ) {
			$icon_setting = $args->wira_elementor_kit_nav_dropdown_icon;
		}

		if ( empty( $icon_setting['value'] ) || ! class_exists( '\Elementor\Icons_Manager' ) ) {
			return '';
		}

		ob_start();
		echo '<span class="wkit-nav-dropdown-icon' . ( $depth > 0 ? ' is-submenu' : '' ) . '" aria-hidden="true">';
		\Elementor\Icons_Manager::render_icon( $icon_setting, array( 'aria-hidden' => 'true' ) );
		echo '</span>';
		return ob_get_clean();
	}

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $submenu = ( $depth > 0 ) ? 'dropdown-submenu' : 'dropdown-menu';
        $output .= "\n$indent<ul class=\"$submenu\">\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        // === Mega menu flags from meta ===
		$enable_mega = get_post_meta( $item->ID, '_enable_mega_menu', true );
		$mega_id     = get_post_meta( $item->ID, '_mega_menu', true );
		$has_mega    = ( $depth === 0 && $enable_mega && $mega_id );

        // === Classes for <li> ===
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'nav-item';

        if ( $has_mega ) {
			$classes[] = 'has-mega-menu';
			$classes[] = 'wkit-dropdown';
		} else {
			if ( in_array( 'menu-item-has-children', $classes, true ) && $depth === 0 ) {
				$classes[] = 'dropdown wkit-dropdown';
			}
			if ( $depth > 0 ) {
				$classes[] = 'dropdown-item wkit-dropdown';
			}
		}

		$class_names = join( ' ', array_filter( $classes ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= '<li' . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        if ( $has_mega ) {
			// Top-level item with mega menu -> like dropdown toggle
			$atts['class']         = 'nav-link dropdown-toggle';
			$atts['aria-current']  = 'page';
			$atts['aria-expanded'] = 'false';
		} elseif ( in_array( 'menu-item-has-children', $classes, true ) ) {
			if ( $depth === 0 ) {
				$atts['class']        = 'nav-link dropdown-toggle';
				$atts['aria-current'] = 'page';
				$atts['aria-expanded'] = 'false';
			} else {
				$atts['class']        = 'nav-link dropdown-toggle-submenu';
				$atts['aria-current'] = 'page';
			}
		} else {
			$atts['class']        = 'nav-link';
			$atts['aria-current'] = 'page';
		}

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
            $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = esc_html( apply_filters( 'the_title', $item->title, $item->ID ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$show_dropdown_icon = $has_mega || in_array( 'menu-item-has-children', $classes, true );
		$dropdown_icon_html = $show_dropdown_icon ? $this->get_dropdown_icon_html( $args, $depth ) : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $dropdown_icon_html . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        // === Inject mega menu content directly on walker ===
		if ( $has_mega && class_exists( 'Wirakit_Template_Library_Helper' ) &&
            method_exists( 'Wirakit_Template_Library_Helper', 'render_elementor_template' ) ) {
            $item_output .= '<div class="wkit-mega-menu" data-id="' . esc_attr($mega_id) . '">';
            $item_output .= Wirakit_Template_Library_Helper::render_elementor_template( (int) $mega_id );
            $item_output .= '</div>';
        }

        $output .= $item_output;
    }
}
