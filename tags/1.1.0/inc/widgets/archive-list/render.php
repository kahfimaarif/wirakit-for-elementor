<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Archive List Elementor Custom Widget.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings     = $this->get_settings_for_display();
$archive_type = ! empty( $settings['archive_type'] ) ? $settings['archive_type'] : 'category';
$show_icon = ! empty( $settings['enable_item_icon'] ) && 'yes' === $settings['enable_item_icon'] && ! empty( $settings['item_icon']['value'] );

echo '<div class="wkit-archive-list">';

echo '<div class="wkit-archive-items">';

if ( 'category' === $archive_type || 'all' === $archive_type ) {
	$categories = get_categories( [ 'hide_empty' => false ] );
	foreach ( $categories as $cat ) {
		echo '<div class="wkit-archive-item wkit-archive-item-category">';
		echo '<a class="wkit-archive-link" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">';
		if ( $show_icon ) {
			echo '<span class="wkit-archive-item-icon" aria-hidden="true">';
			\Elementor\Icons_Manager::render_icon( $settings['item_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		}
		echo esc_html( $cat->name );
		echo '</a>';
		echo '</div>';
	}
}

if ( 'tag' === $archive_type || 'all' === $archive_type ) {
	$tags = [];
	if ( 'yes' === ( $settings['related_tag_only'] ?? '' ) && is_singular() ) {
		$tags = get_the_tags( get_the_ID() );
	} else {
		$tags = get_tags( [ 'hide_empty' => false ] );
	}

	if ( ! empty( $tags ) ) {
		foreach ( $tags as $tag ) {
			echo '<div class="wkit-archive-item wkit-archive-item-tag">';
			echo '<a class="wkit-archive-link" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">';
			if ( $show_icon ) {
				echo '<span class="wkit-archive-item-icon" aria-hidden="true">';
				\Elementor\Icons_Manager::render_icon( $settings['item_icon'], [ 'aria-hidden' => 'true' ] );
				echo '</span>';
			}
			echo esc_html( $tag->name );
			echo '</a>';
			echo '</div>';
		}
	}
}

if ( 'author' === $archive_type || 'all' === $archive_type ) {
	$authors = get_users(
		[
			'who'                 => 'authors',
			'has_published_posts' => true,
		]
	);

	foreach ( $authors as $author ) {
		echo '<div class="wkit-archive-item wkit-archive-item-author">';
		echo '<a class="wkit-archive-link" href="' . esc_url( get_author_posts_url( $author->ID ) ) . '">';
		if ( $show_icon ) {
			echo '<span class="wkit-archive-item-icon" aria-hidden="true">';
			\Elementor\Icons_Manager::render_icon( $settings['item_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		}
		echo esc_html( $author->display_name );
		echo '</a>';
		echo '</div>';
	}
}

if ( 'date' === $archive_type || 'all' === $archive_type ) {
		$archive_html = wp_get_archives(
			[
				'type'   => 'monthly',
				'format' => 'custom',
				'before' => '<div class="wkit-archive-item wkit-archive-item-date">',
				'after'  => '</div>',
				'echo'   => 0,
			]
		);

		if ( $archive_html ) {
			if ( $show_icon ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['item_icon'], [ 'aria-hidden' => 'true' ] );
				$icon_svg  = ob_get_clean();
				$icon_html = '<span class="wkit-archive-item-icon" aria-hidden="true">' . $icon_svg . '</span>';
				$archive_html = preg_replace( '/(<a\b[^>]*>)/i', '$1' . $icon_html, $archive_html );
			}
			echo wp_kses_post( $archive_html );
		}
}

echo '</div>'; // .wkit-archive-items
echo '</div>'; // .wkit-archive-list

