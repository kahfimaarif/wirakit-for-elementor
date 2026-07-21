<?php
/**
 * Helper render functions for Blog Post widget.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper: Render meta
 */
if ( ! function_exists( 'Wirakit_render_post_meta' ) ) {
	/**
	 * Helper: render post meta items.
	 *
	 * @param array $settings Widget settings.
	 */
	function Wirakit_render_post_meta( $settings ) {
		if ( empty( $settings['meta_data'] ) || ! is_array( $settings['meta_data'] ) ) {
			return;
		}

		echo '<div class="wkit-post-meta d-flex">';

		foreach ( $settings['meta_data'] as $meta ) {
			$icon_before = ( $settings['meta_icon_position'] === 'before' );
			$icon_after  = ( $settings['meta_icon_position'] === 'after' );

			$icons = array(
				'date'     => $settings['date_icon']['value'] ?? '',
				'author'   => $settings['author_icon']['value'] ?? '',
				'category' => $settings['category_icon']['value'] ?? '',
				'comment'  => $settings['comment_icon']['value'] ?? '',
			);

			echo '<span class="wkit-text-small wkit-color-placeholder">';

			if ( $icon_before && ! empty( $icons[ $meta ] ) ) {
				echo '<i class="' . esc_attr( $icons[ $meta ] ) . ' wkit-color-secondary me-1"></i>';
			}

			switch ( $meta ) {
				case 'date':
					echo esc_html( get_the_date() );
					break;
				case 'author':
					echo esc_html( get_the_author() );
					break;
				case 'category':
					echo wp_kses_post( get_the_category_list( ', ' ) );
					break;
				case 'comment':
					echo esc_html( get_comments_number_text() );
					break;
			}

			if ( $icon_after && ! empty( $icons[ $meta ] ) ) {
				echo '<i class="' . esc_attr( $icons[ $meta ] ) . ' wkit-color-secondary ms-1"></i>';
			}

			echo '</span>';
		}

		echo '</div>';
	}
}

/**
 * Helper: Render title
 */
if ( ! function_exists( 'Wirakit_render_post_title' ) ) {
	function Wirakit_render_post_title( $settings ) {
		if ( 'yes' !== $settings['show_title'] ) {
			return;
		}

		$title_word_count = ! empty( $settings['crop_title_word'] ) ? intval( $settings['crop_title_word'] ) : 0;
		$title            = get_the_title();

		if ( $title_word_count > 0 ) {
			$title = wp_trim_words( $title, $title_word_count, '...' );
		}

		echo '<h4 class="wkit-blog-title">';
		if ( 'yes' === $settings['show_readmore'] || 'default' === $settings['style_variations'] ) {
			echo '<a href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $title ) . '</a>';
		} else {
			echo esc_html( $title );
		}
		echo '</h4>';
	}
}

/**
 * Helper: Render excerpt
 */
if ( ! function_exists( 'Wirakit_render_post_excerpt' ) ) {
	function Wirakit_render_post_excerpt( $settings ) {
		if ( 'yes' !== $settings['show_content'] ) {
			return;
		}

		$word_count = ! empty( $settings['crop_content_word'] ) ? intval( $settings['crop_content_word'] ) : 20;

		echo '<p class="wkit-post-excerpt wkit-color-body">';
		echo esc_html( wp_trim_words( get_the_excerpt(), $word_count ) );
		echo '</p>';
	}
}

/**
 * Helper: Render read more
 */
if ( ! function_exists( 'Wirakit_render_post_readmore' ) ) {
	function Wirakit_render_post_readmore( $settings ) {
		if ( 'yes' !== $settings['show_readmore'] ) {
			return;
		}

		$icon = $settings['readmore_icon']['value'] ?? '';
		$pos  = $settings['icon_position'] ?? 'before';

		echo '<div class="readmore-wrapper d-flex">';
		echo '<a href="' . esc_url( get_the_permalink() ) . '" class="wkit-readmore wkit-btn-text-two">';
		echo '<span class="readmore-wrapper d-flex">';

		if ( ! empty( $icon ) && $pos === 'before' ) {
			echo '<span class="readmore-icon"><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i></span>';
		}

		echo '<span class="readmore-text">' . esc_html( $settings['readmore_text'] ) . '</span>';

		if ( ! empty( $icon ) && $pos === 'after' ) {
			echo '<span class="readmore-icon"><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i></span>';
		}

		echo '</span>';
		echo '</a>';
		echo '</div>';
	}
}

/**
 * Post Item Default
 */
if ( ! function_exists( 'Wirakit_render_post_item_default' ) ) {
	function Wirakit_render_post_item_default( $settings ) {
		echo '<article class="wkit-post-item d-flex position-relative">';

		if ( 'yes' !== $settings['ignore_sticky_post'] && is_sticky() && ! is_paged() ) {
			echo '<span class="wkit-sticky-post wkit-text-subheading wkit-bg-primary wkit-color-white text-center py-1">';
			esc_html_e( 'Featured', 'wira-kit-for-elementor' );
			echo '</span>';
		}

	if ( 'yes' === $settings['show_featured_image'] ) {
			echo '<figure class="thumbnail wkit-thumbnail-post-grid">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';

			if ( has_post_thumbnail() ) {
				$image_id  = get_post_thumbnail_id();
				$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
					$image_id,
					'featured_image',
					$settings
				);

				if ( ! $image_url ) {
					$image_url = get_the_post_thumbnail_url( null, 'large' );
				}

				if ( $image_url ) {
					echo '<img src="' . esc_url( $image_url ) . '" class="img-fluid" alt="' . esc_attr( get_the_title() ) . '">';
				}
			} else {
				echo '<img src="' . esc_url( WIRAKIT_URL . '/assets/widget/img/default-thumbnail.jpg' ) . '" class="img-fluid" alt="No thumbnail">';
			}

			echo '</a>';
			echo '</figure>';
		}

		if ( 'yes' === $settings['show_floating_category'] ) {
			echo '<div class="wkit-post-category">';
			the_category( ' ' );
			echo '</div>';
		}

		echo '<div class="wkit-post-content">';

		if ( 'yes' === $settings['show_meta'] && 'before_title' === $settings['meta_position'] ) {
			Wirakit_render_post_meta( $settings );
		}

		Wirakit_render_post_title( $settings );

		if ( 'yes' === $settings['show_meta'] && 'after_title' === $settings['meta_position'] ) {
			Wirakit_render_post_meta( $settings );
		}

		Wirakit_render_post_excerpt( $settings );
		Wirakit_render_post_readmore( $settings );

		echo '</div>'; // .wkit-post-content
		echo '</article>';
	}
}

/**
 * Post Item Overlay
 */
if ( ! function_exists( 'Wirakit_render_post_item_overlay' ) ) {
	function Wirakit_render_post_item_overlay( $settings ) {
		$post_id       = get_the_ID();
		$thumbnail_url = '';
		if ( has_post_thumbnail( $post_id ) ) {
			$thumbnail_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src(
				get_post_thumbnail_id( $post_id ),
				'featured_image',
				$settings
			);
		}

		if ( ! $thumbnail_url ) {
			$thumbnail_url = WIRAKIT_URL . '/assets/widget/img/default-thumbnail.jpg';
		}

		echo '<article class="wkit-post-item-overlay position-relative" style="background-image:url(' . esc_url( $thumbnail_url ) . ');">';

		if ( 'yes' !== $settings['ignore_sticky_post'] && is_sticky() && ! is_paged() ) {
			echo '<span class="wkit-sticky-post wkit-text-subheading wkit-bg-primary wkit-color-white text-center py-1">';
			esc_html_e( 'Featured', 'wira-kit-for-elementor' );
			echo '</span>';
		}

		if ( 'yes' === $settings['show_floating_category'] ) {
			echo '<div class="wkit-post-category">';
			the_category( ' ' );
			echo '</div>';
		}

		if ( 'yes' !== $settings['show_readmore'] ) {
			echo '<a class="wkit-use-global-link" href="' . esc_url( get_the_permalink() ) . '">';
		}

		echo '<div class="wkit-post-content-overlay d-flex flex-column justify-content-end">';

		if ( 'yes' === $settings['show_meta'] && 'before_title' === $settings['meta_position'] ) {
			Wirakit_render_post_meta( $settings );
		}

		Wirakit_render_post_title( $settings );

		if ( 'yes' === $settings['show_meta'] && 'after_title' === $settings['meta_position'] ) {
			Wirakit_render_post_meta( $settings );
		}

		Wirakit_render_post_excerpt( $settings );
		Wirakit_render_post_readmore( $settings );

		echo '</div>'; // .wkit-post-content-overlay

		if ( 'yes' !== $settings['show_readmore'] ) {
			echo '</a>';
		}

		echo '</article>';
	}
}
