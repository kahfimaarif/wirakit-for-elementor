<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Blog Post Elementor Custom Widget.
 *
 * Handles querying posts (with support for selected, excluded, categories, related posts, etc.),
 * rendering blog post items in different layouts (default, overlay),
 * and adding pagination or slider functionality.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once WIRAKIT_PATH . 'inc/widgets/blog-post/render-helper.php';

$settings = $this->get_settings_for_display();

global $wp_query, $post;

/**
 * Build main query arguments.
 */
$paged_query = max(
	1,
	absint( get_query_var( 'paged' ) ),
	absint( get_query_var( 'page' ) )
);
$args = array(
	'post_type'      => 'post',
	'posts_per_page' => $settings['posts_per_page'],
	'orderby'        => $settings['orderby'],
	'order'          => $settings['order'],
	'post_status'    => 'publish',
	'paged'          => $paged_query,
);

/**
 * Selected posts only.
 */
if ( 'selected' === $settings['select_posts_by'] && ! empty( $settings['include_posts'] ) ) {
	$args['post__in'] = $settings['include_posts'];
	$args['orderby']  = 'post__in';
}

/**
 * Exclude posts.
 */
if ( ! empty( $settings['exclude_posts'] ) ) {
	$args['post__not_in'] = $settings['exclude_posts'];
}

/**
 * Query by categories.
 */
if ( 'category' === $settings['select_posts_by'] && ! empty( $settings['include_categories'] ) ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $settings['include_categories'],
		),
	);
}

/**
 * Related posts query (same category, exclude current).
 */
if ( ! empty( $settings['enable_related_posts'] ) && 'yes' === $settings['enable_related_posts'] && is_singular( 'post' ) ) {
	$current_id = $post->ID;
	$categories = wp_get_post_terms( $current_id, 'category', array( 'fields' => 'ids' ) );

	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $settings['posts_per_page'],
		'post__not_in'   => array( $current_id ), // exclude current post.
		'post_status'    => 'publish',
	);

	if ( ! empty( $categories ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $categories,
			),
		);
	}
}

// Keep a copy of query args for pagination / ajax.
$query_args = $args;

/**
 * Slider options.
 */
$enable_slider = '';
if ( 'yes' === $settings['enable_slider'] ) {
	$enable_slider = 'wkit-carousel swiper';
}

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
$equal_height         = ( ! empty( $settings['equal_height'] ) && $settings['equal_height'] === 'yes' ) ? 'yes' : 'no';
$autoplay             = ( ! empty( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) ? 'yes' : 'no';
$scroll_speed         = ! empty( $settings['scroll_speed'] ) ? $settings['scroll_speed'] : 5000;
$pause_on_hover       = ( ! empty( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ) ? 'yes' : 'no';
$pause_on_interaction = ( ! empty( $settings['pause_on_interaction'] ) && $settings['pause_on_interaction'] === 'yes' ) ? 'yes' : 'no';
$infinite_scroll      = ( ! empty( $settings['infinite_scroll'] ) && $settings['infinite_scroll'] === 'yes' ) ? 'yes' : 'no';
$transition_duration  = ! empty( $settings['transition_duration'] ) ? $settings['transition_duration'] : 500;

$arrows_show = ( ! empty( $settings['show_arrows'] ) && $settings['show_arrows'] === 'yes' );
$prev_h_pos  = ! empty( $settings['prev_arrow_horizontal_position']['size'] );
$prev_v_pos  = ! empty( $settings['prev_arrow_vertical_position']['size'] );

$next_h_pos         = ! empty( $settings['next_arrow_horizontal_position']['size'] );
$next_v_pos         = ! empty( $settings['next_arrow_vertical_position']['size'] );
$pagination_type    = ! empty( $settings['pagination_type_slider'] ) ? $settings['pagination_type_slider'] : 'none';
$gap_between_slides = ! empty( $settings['gap_between_slides']['size'] ) ? $settings['gap_between_slides']['size'] : 10;
$effect             = ! empty( $settings['transition_effect'] ) ? $settings['transition_effect'] : 'slide';
$enable_marquee     = ( ! empty( $settings['enable_marquee_style'] ) && 'yes' === $settings['enable_marquee_style'] );
$marquee_axis       = ! empty( $settings['marquee_scroll_axis'] ) ? $settings['marquee_scroll_axis'] : 'horizontal';
$marquee_direction_h = ! empty( $settings['marquee_direction_horizontal'] ) ? $settings['marquee_direction_horizontal'] : 'left';
$marquee_direction_v = ! empty( $settings['marquee_direction_vertical'] ) ? $settings['marquee_direction_vertical'] : 'up';
$marquee_pause_on_hover = ( ! empty( $settings['marquee_pause_on_hover'] ) && 'yes' === $settings['marquee_pause_on_hover'] ) ? 'yes' : 'no';
$marquee_duration   = ! empty( $settings['marquee_duration']['size'] ) ? $settings['marquee_duration']['size'] : 30;
$marquee_direction  = ( 'vertical' === $marquee_axis ) ? $marquee_direction_v : $marquee_direction_h;

// Pagination (ajax/infinite).
$loop_pagination_type = ! empty( $settings['pagination_type'] ) ? $settings['pagination_type'] : '';
$load_more_text       = ! empty( $settings['load_more_text'] ) ? $settings['load_more_text'] : __( 'Load More', 'wira-kit-for-elementor' );

/**
 * Query context (archive, search, or custom WP_Query).
 */
if ( ! empty( $settings['enable_archive_query'] ) && 'yes' === $settings['enable_archive_query'] && is_archive() ) {
	$query = $wp_query;
	$loop_pagination_type = '';
} elseif ( ! empty( $settings['enable_search_query'] ) && 'yes' === $settings['enable_search_query'] && is_search() ) {
	$query = $wp_query;
	$loop_pagination_type = '';
} else {
	$query = new \WP_Query( $args );
}

// Ensure current page matches the active query (archive/search/main query).
$paged_query = max(
	1,
	absint( $query->get( 'paged' ) ),
	absint( $query->get( 'page' ) )
);

/**
 * === Main Loop Output ===
 */
if ( $query->have_posts() ) {
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

	if ( $loop_pagination_ok ) {
		printf(
			'<div class="wkit-dynamic-pagination" data-pagination-type="%1$s" data-widget="%2$s" data-query="%3$s" data-settings="%4$s" data-current-page="%5$d" data-max-pages="%6$d">',
			esc_attr( $loop_pagination_type ),
			esc_attr( 'blog' ),
			esc_attr( wp_json_encode( $query_args ) ),
			esc_attr( wp_json_encode( $settings ) ),
			1,
			absint( $max_pages )
		);
	}

	$wrapper_classes = 'wkit-blog-post ' . trim( $enable_slider ) . ( $loop_pagination_ok ? ' wkit-dynamic-items' : '' );
	echo '<div class="' . esc_attr( trim( $wrapper_classes ) ) . '"';

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
		printf( ' data-gap="%s"', esc_attr( $gap_between_slides ) );
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

	if ( 'yes' === $settings['enable_slider'] ) {
		echo '<div class="swiper-wrapper">';
	}

	while ( $query->have_posts() ) {
		$query->the_post();

		if ( 'yes' === $settings['enable_slider'] ) {
			echo '<div class="swiper-slide">';
		}

		if ( isset( $settings['style_variations'] ) ) {
			switch ( $settings['style_variations'] ) {
				case 'default':
					Wirakit_render_post_item_default( $settings );
					break;

				case 'overlay':
					Wirakit_render_post_item_overlay( $settings );
					break;
			}
		}

		if ( 'yes' === $settings['enable_slider'] ) {
			echo '</div>';
		}
	}

	if ( 'yes' === $settings['enable_slider'] ) {
		echo '</div>';
	}

	if ( 'yes' === $settings['enable_slider'] ) {
		// Pagination.
		if ( $pagination_type === 'dots' ) {
			echo '<div class="swiper-pagination wkit-swiper-pagination"></div>';
		}

		// Navigation arrows if active.
		if ( $arrows_show ) {
			// Prev
			echo '<div class="swiper-button-prev">';
			if ( ! empty( $settings['prev_arrow_icon']['value'] ) ) {
				echo '<i class="' . esc_attr( $settings['prev_arrow_icon']['value'] ) . '"></i>';
			}
			echo '</div>';

			// Next
			echo '<div class="swiper-button-next">';
			if ( ! empty( $settings['next_arrow_icon']['value'] ) ) {
				echo '<i class="' . esc_attr( $settings['next_arrow_icon']['value'] ) . '"></i>';
			}
			echo '</div>';
		}
	}

	echo '</div>';

	if ( $loop_pagination_ok ) {
		echo '<div class="wkit-pagination d-flex justify-content-center">';
		echo '<button type="button" class="wkit-load-more wkit-btn-text-two">' . esc_html( $load_more_text ) . '</button>';
		echo '<span class="wkit-load-more-sentinel" aria-hidden="true"></span>';
		echo '</div>';
		echo '</div>';
	}

	if ( ! empty( $settings['pagination_type'] ) && 'numbers_and_prev_next' === $settings['pagination_type'] && $query->max_num_pages > 1 ) {

		echo '<div class="wkit-pagination">';

		switch ( $settings['pagination_type'] ) {

			case 'numbers_and_prev_next':
				$big       = 999999999;
				$add_args  = false;
				if ( is_search() ) {
					$add_args = array( 's' => get_search_query() );
				}

				$pages_links = paginate_links(
					array(
						'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'total'              => $query->max_num_pages,
						'current'            => $paged_query,
						'mid_size'           => 2,
						'prev_text'          => false,
						'next_text'          => false,
						'add_args'           => $add_args,
						'type'               => 'array',
						'screen_reader_text' => __( 'Posts navigation', 'wira-kit-for-elementor' ),
					)
				);

				if ( is_array( $pages_links ) ) {
					echo '<nav aria-label="' . esc_attr__( 'Pagination', 'wira-kit-for-elementor' ) . '">';
					echo '<ul class="pagination wkit-pagination justify-content-center">';

					foreach ( $pages_links as $page ) {
						$active      = strpos( $page, 'current' ) !== false ? ' active' : '';
						$active_attr = trim( $active );
						$pagelink    = str_replace( 'page-numbers', 'page-link', $page );
						printf(
							'<li class="page-item %1$s">%2$s</li>',
							esc_attr( $active_attr ),
							wp_kses_post( $pagelink )
						);
					}

					echo '</ul>';
					echo '</nav>';
				}

				break;
		}

		echo '</div>';
	}
	wp_reset_postdata();
} else {
	echo '<p>' . esc_html__( 'No posts found.', 'wira-kit-for-elementor' ) . '</p>';
}
