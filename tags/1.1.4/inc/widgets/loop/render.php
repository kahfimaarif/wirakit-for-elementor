<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Loop Elementor Custom Widget.
 *
 * Displays a list of posts (default or custom post type) with support for:
 * - include/exclude posts,
 * - exclude categories (for posts only),
 * - Elementor loop template rendering,
 * - slider/swiper integration with navigation & pagination.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once WIRAKIT_PATH . 'inc/widgets/loop/render-helper.php';

$settings = $this->get_settings_for_display();

/**
 * Build WP_Query arguments.
 */
$args = array(
	'post_type'      => $settings['post_type'],
	'posts_per_page' => $settings['posts_per_page'],
	'order'          => $settings['order'], // ASC / DESC.
	'orderby'        => ! empty( $settings['orderby'] ) ? $settings['orderby'] : 'post_date',
);

// Include posts.
if ( ! empty( $settings['include_posts'] ) ) {
	$args['post__in'] = array_map( 'absint', explode( ',', $settings['include_posts'] ) );
}

// Exclude posts.
if ( ! empty( $settings['exclude_posts'] ) ) {
	$args['post__not_in'] = array_map( 'absint', explode( ',', $settings['exclude_posts'] ) );
}

// Exclude categories (only for default "post").
if ( 'post' === $settings['post_type'] && ! empty( $settings['exclude_categories'] ) ) {
	$args['category__not_in'] = array_map( 'absint', explode( ',', $settings['exclude_categories'] ) );
}

// Keep a copy of query args for pagination / ajax.
$query_args = $args;

/**
 * Slider settings.
 */
$enable_slider        = ( 'yes' === $settings['enable_slider'] ) ? 'wkit-carousel swiper' : '';
$slides_per_view      = ! empty( $settings['slides_per_view'] ) ? $settings['slides_per_view'] : 1;
$slides_per_group     = ! empty( $settings['slides_per_group'] ) ? $settings['slides_per_group'] : 1;
$slides_per_view_tablet = ( ! empty( $settings['slides_per_view_tablet'] ) && 'default' !== $settings['slides_per_view_tablet'] )
	? $settings['slides_per_view_tablet']
	: $slides_per_view;
$slides_per_view_mobile = ( ! empty( $settings['slides_per_view_mobile'] ) && 'default' !== $settings['slides_per_view_mobile'] )
	? $settings['slides_per_view_mobile']
	: $slides_per_view_tablet;
$slides_per_group_tablet = ( ! empty( $settings['slides_per_group_tablet'] ) && 'default' !== $settings['slides_per_group_tablet'] )
	? $settings['slides_per_group_tablet']
	: $slides_per_group;
$slides_per_group_mobile = ( ! empty( $settings['slides_per_group_mobile'] ) && 'default' !== $settings['slides_per_group_mobile'] )
	? $settings['slides_per_group_mobile']
	: $slides_per_group_tablet;
$equal_height         = ( ! empty( $settings['equal_height'] ) && 'yes' === $settings['equal_height'] ) ? 'yes' : 'no';
$autoplay             = ( ! empty( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ) ? 'yes' : 'no';
$scroll_speed         = ! empty( $settings['scroll_speed'] ) ? $settings['scroll_speed'] : 5000;
$pause_on_hover       = ( ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ) ? 'yes' : 'no';
$pause_on_interaction = ( ! empty( $settings['pause_on_interaction'] ) && 'yes' === $settings['pause_on_interaction'] ) ? 'yes' : 'no';
$infinite_scroll      = ( ! empty( $settings['infinite_scroll'] ) && 'yes' === $settings['infinite_scroll'] ) ? 'yes' : 'no';
$transition_duration  = ! empty( $settings['transition_duration'] ) ? $settings['transition_duration'] : 500;

$arrows_show     = ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] );
$pagination_type = ! empty( $settings['pagination_type_slider'] ) ? $settings['pagination_type_slider'] : 'none';
$gap_between     = ! empty( $settings['gap_between_slides']['size'] ) ? $settings['gap_between_slides']['size'] : 10;
$effect          = ! empty( $settings['transition_effect'] ) ? $settings['transition_effect'] : 'slide';
$enable_marquee  = ( ! empty( $settings['enable_marquee_style'] ) && 'yes' === $settings['enable_marquee_style'] );
$marquee_axis    = ! empty( $settings['marquee_scroll_axis'] ) ? $settings['marquee_scroll_axis'] : 'horizontal';
$marquee_direction_h = ! empty( $settings['marquee_direction_horizontal'] ) ? $settings['marquee_direction_horizontal'] : 'left';
$marquee_direction_v = ! empty( $settings['marquee_direction_vertical'] ) ? $settings['marquee_direction_vertical'] : 'up';
$marquee_pause_on_hover = ( ! empty( $settings['marquee_pause_on_hover'] ) && 'yes' === $settings['marquee_pause_on_hover'] ) ? 'yes' : 'no';
$marquee_duration = ! empty( $settings['marquee_duration']['size'] ) ? $settings['marquee_duration']['size'] : 30;
$marquee_direction = ( 'vertical' === $marquee_axis ) ? $marquee_direction_v : $marquee_direction_h;

// Pagination (ajax/infinite).
$loop_pagination_type = ! empty( $settings['pagination_type'] ) ? $settings['pagination_type'] : '';
$load_more_text       = ! empty( $settings['load_more_text'] ) ? $settings['load_more_text'] : __( 'Load More', 'wira-kit-for-elementor' );

// Data attributes for swiper initialization.
// (Output is rendered inline at echo-time to satisfy escaping rules.)

/**
 * Query posts.
 */
$query = new \WP_Query( $args );

if ( $query->have_posts() ) :
	$max_pages          = $query->max_num_pages;
	$posts_per_page     = isset( $query_args['posts_per_page'] ) ? intval( $query_args['posts_per_page'] ) : 0;
	$loop_pagination_ok = (
		in_array( $loop_pagination_type, array( 'ajax_load_more', 'infinite_scroll' ), true ) &&
		'yes' !== $settings['enable_slider'] &&
		$max_pages > 1 &&
		$posts_per_page > 0
	);

	if ( $loop_pagination_ok ) {
		wp_enqueue_script( 'wkit-ajax-pagination-js' );
		wp_localize_script(
			'wkit-ajax-pagination-js',
			'wiraElementorKitAjax',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'Wirakit_load_more' ),
			)
		);
	}

	// Unique wrapper class for this widget instance.
	$loop_class = 'wkit-loop-' . $this->get_id();
	$this->add_render_attribute( $loop_class, 'class', 'wkit-loop' );

	if ( $loop_pagination_ok ) {
		printf(
			'<div class="wkit-dynamic-pagination" data-pagination-type="%1$s" data-widget="%2$s" data-query="%3$s" data-settings="%4$s" data-current-page="%5$d" data-max-pages="%6$d">',
			esc_attr( $loop_pagination_type ),
			esc_attr( 'loop' ),
			esc_attr( wp_json_encode( $query_args ) ),
			esc_attr( wp_json_encode( $settings ) ),
			1,
			absint( $max_pages )
		);
		$this->add_render_attribute( $loop_class, 'class', 'wkit-dynamic-items' );
	}

	if ( 'yes' === $settings['enable_slider'] ) {
		$this->add_render_attribute( $loop_class, 'class', 'wkit-carousel swiper' );
	}

	echo '<div ' . $this->get_render_attribute_string( $loop_class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders escaped attributes.

	if ( 'yes' === $settings['enable_slider'] ) {
		printf( ' data-slides-per-view="%s"', esc_attr( $slides_per_view ) );
		printf( ' data-slides-per-view-tablet="%s"', esc_attr( $slides_per_view_tablet ) );
		printf( ' data-slides-per-view-mobile="%s"', esc_attr( $slides_per_view_mobile ) );
		printf( ' data-slides-per-group="%s"', esc_attr( $slides_per_group ) );
		printf( ' data-slides-per-group-tablet="%s"', esc_attr( $slides_per_group_tablet ) );
		printf( ' data-slides-per-group-mobile="%s"', esc_attr( $slides_per_group_mobile ) );
		printf( ' data-equal-height="%s"', esc_attr( $equal_height ) );
		printf( ' data-autoplay="%s"', esc_attr( $autoplay ) );
		printf( ' data-scroll-speed="%s"', esc_attr( $scroll_speed ) );
		printf( ' data-pause-on-hover="%s"', esc_attr( $pause_on_hover ) );
		printf( ' data-pause-on-interaction="%s"', esc_attr( $pause_on_interaction ) );
		printf( ' data-infinite-scroll="%s"', esc_attr( $infinite_scroll ) );
		printf( ' data-transition-duration="%s"', esc_attr( $transition_duration ) );
		printf( ' data-pagination="%s"', esc_attr( $pagination_type ) );
		printf( ' data-gap="%s"', esc_attr( $gap_between ) );
		printf( ' data-effect="%s"', esc_attr( $effect ) );

		if ( $enable_marquee ) {
			echo ' data-marquee="yes"';
			printf( ' data-marquee-axis="%s"', esc_attr( $marquee_axis ) );
			printf( ' data-marquee-direction="%s"', esc_attr( $marquee_direction ) );
			printf( ' data-marquee-pause-on-hover="%s"', esc_attr( $marquee_pause_on_hover ) );
			printf( ' data-marquee-duration="%s"', esc_attr( $marquee_duration ) );
		}
	}

	echo '>';

	// Start slider wrapper.
	if ( 'yes' === $settings['enable_slider'] ) {
		echo '<div class="swiper-wrapper">';
	}

	while ( $query->have_posts() ) :
		$query->the_post();

		// Wrap each item as a slide when slider enabled.
		if ( 'yes' === $settings['enable_slider'] ) {
			echo '<div class="swiper-slide">';
		}

		Wirakit_render_loop_item( $settings );

		if ( 'yes' === $settings['enable_slider'] ) {
			echo '</div>'; // .swiper-slide.
		}

	endwhile;

	// End slider wrapper.
	if ( 'yes' === $settings['enable_slider'] ) {
		echo '</div>';
	}

	// Slider controls.
	if ( 'yes' === $settings['enable_slider'] ) {
		// Pagination.
		if ( 'dots' === $pagination_type ) {
			echo '<div class="swiper-pagination wkit-swiper-pagination"></div>';
		}

		// Navigation arrows.
		if ( $arrows_show ) {
			echo '<div class="swiper-button-prev">';
			if ( ! empty( $settings['prev_arrow_icon']['value'] ) ) {
				echo '<i class="' . esc_attr( $settings['prev_arrow_icon']['value'] ) . '"></i>';
			}
			echo '</div>';

			echo '<div class="swiper-button-next">';
			if ( ! empty( $settings['next_arrow_icon']['value'] ) ) {
				echo '<i class="' . esc_attr( $settings['next_arrow_icon']['value'] ) . '"></i>';
			}
			echo '</div>';
		}
	}

	echo '</div>'; // .wkit-loop.

	if ( $loop_pagination_ok ) {
		$load_more_button_style = ( 'infinite_scroll' === $loop_pagination_type ) ? ' style="display:none"' : '';
		echo '<div class="wkit-pagination d-flex justify-content-center">';
		printf(
			'<button type="button" class="wkit-load-more wkit-btn-text-two"%1$s>%2$s</button>',
			$load_more_button_style, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static inline style for initial hidden state in infinite scroll.
			esc_html( $load_more_text )
		);
		if ( 'infinite_scroll' === $loop_pagination_type ) {
			echo '<span class="wkit-load-more-sentinel" aria-hidden="true"></span>';
		}
		echo '</div>';
		echo '</div>';
	}

	wp_reset_postdata();

else :
	echo '<p>' . esc_html__( 'No posts found.', 'wira-kit-for-elementor' ) . '</p>';
endif;
