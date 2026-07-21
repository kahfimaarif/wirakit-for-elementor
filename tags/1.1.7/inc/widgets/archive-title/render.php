<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render template for Archive Title Elementor Custom Widget.
 *
 * This file handles the rendering of archive titles for categories,
 * tags, authors, dates, and post type archives, with optional prefix
 * and link wrapping as configured via Elementor widget settings.
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

// Safe fallback for heading tag.
$heading_tag  = ! empty( $settings['heading_tag'] ) ? $settings['heading_tag'] : 'h1';
$content      = '';
$heading_link = '';
$prefix       = '';

// === Category Archive ===
if ( is_category() ) {
	if ( ! empty( $settings['enable_category_prefix'] ) && 'yes' === $settings['enable_category_prefix'] ) {
		$prefix = $settings['category_prefix_text'];
	} else {
		$prefix = __( 'Archive: ', 'wira-kit-for-elementor' );
	}
	$content = $prefix . single_cat_title( '', false );

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_category_link( get_queried_object_id() );
	}
}

// === Tag Archive ===
elseif ( is_tag() ) {
	if ( ! empty( $settings['enable_tag_prefix'] ) && 'yes' === $settings['enable_tag_prefix'] ) {
		$prefix = $settings['tag_prefix_text'];
	} else {
		$prefix = __( 'Tag: ', 'wira-kit-for-elementor' );
	}
	$content = $prefix . single_tag_title( '', false );

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_tag_link( get_queried_object_id() );
	}
}

// === Author Archive ===
elseif ( is_author() ) {
	if ( ! empty( $settings['enable_author_prefix'] ) && 'yes' === $settings['enable_author_prefix'] ) {
		$prefix = $settings['author_prefix_text'];
	} else {
		$prefix = __( 'Author: ', 'wira-kit-for-elementor' );
	}
	$content = $prefix . get_the_author();

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_author_posts_url( get_queried_object_id() );
	}
}

// === Date Archive (day, month, year) ===
elseif ( is_day() || is_month() || is_year() ) {
	if ( ! empty( $settings['enable_date_prefix'] ) && 'yes' === $settings['enable_date_prefix'] ) {
		$prefix = $settings['date_prefix_text'];
	} else {
		$prefix = __( 'Date Archive: ', 'wira-kit-for-elementor' );
	}
	$content = $prefix . get_the_date( is_year() ? 'Y' : ( is_month() ? 'F Y' : get_the_date() ) );

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		if ( is_day() ) {
			$heading_link = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
		} elseif ( is_month() ) {
			$heading_link = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
		} elseif ( is_year() ) {
			$heading_link = get_year_link( get_query_var( 'year' ) );
		}
	}
}

// === Post Type Archive ===
elseif ( is_post_type_archive() ) {
	$prefix  = __( 'Archive: ', 'wira-kit-for-elementor' );
	$content = $prefix . post_type_archive_title( '', false );

	if ( ! empty( $settings['enable_link'] ) && 'yes' === $settings['enable_link'] ) {
		$heading_link = get_post_type_archive_link( get_post_type() );
	}
}

// Size class for Elementor styling.
$size_class = ! empty( $settings['size'] ) ? 'elementor-size-' . $settings['size'] : 'elementor-size-default';

// Open heading element.
echo '<' . esc_attr( $heading_tag ) . ' class="wkit-dynamic-heading elementor-heading-title ' . esc_attr( $size_class ) . '">';

// Render content.
if ( ! empty( $content ) ) {
	if ( ! empty( $heading_link ) ) {
		// Prepare link attributes.
		$this->add_render_attribute( 'heading_link', 'href', esc_url( $heading_link ) );

		if ( ! empty( $settings['heading_link']['is_external'] ) ) {
			$this->add_render_attribute( 'heading_link', 'target', '_blank' );
		}
		if ( ! empty( $settings['heading_link']['nofollow'] ) ) {
			$this->add_render_attribute( 'heading_link', 'rel', 'nofollow' );
		}

		// Render linked heading text.
		echo '<a ' . $this->get_render_attribute_string( 'heading_link' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor escapes attributes internally.
		echo esc_html( $content );
		echo '</a>';
	} else {
		// Render plain heading text.
		echo esc_html( $content );
	}
} else {
	// Fallback if no archive context detected.
	echo esc_html__( 'Archive: Archive Title', 'wira-kit-for-elementor' );
}

// Close heading element.
echo '</' . esc_attr( $heading_tag ) . '>';


