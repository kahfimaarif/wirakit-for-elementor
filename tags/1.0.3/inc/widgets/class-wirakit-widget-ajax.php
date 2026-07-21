<?php
/**
 * AJAX handlers for widget pagination.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wirakit_Widget_Ajax' ) ) {
	class Wirakit_Widget_Ajax {

		public function __construct() {
			add_action( 'wp_ajax_Wirakit_load_more', array( $this, 'handle_load_more' ) );
			add_action( 'wp_ajax_nopriv_Wirakit_load_more', array( $this, 'handle_load_more' ) );
		}

		/**
		 * Handle ajax load more for dynamic widgets.
		 *
		 * @return void
		 */
		public function handle_load_more() {
			check_ajax_referer( 'Wirakit_load_more', 'nonce' );

			$widget = isset( $_POST['widget'] ) ? sanitize_key( wp_unslash( $_POST['widget'] ) ) : '';
			if ( ! in_array( $widget, array( 'blog', 'loop' ), true ) ) {
				wp_send_json_error( array( 'message' => 'Invalid widget.' ) );
			}

			$page = isset( $_POST['page'] ) ? absint( wp_unslash( $_POST['page'] ) ) : 1;
			if ( $page < 1 ) {
				$page = 1;
			}
			$page = min( $page, 500 );

			$query_raw = isset( $_POST['query'] ) ? wp_unslash( $_POST['query'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- JSON payload is sanitized after decode in sanitize_query_args().
			$query     = is_string( $query_raw ) ? json_decode( $query_raw, true ) : array();
			if ( ! is_array( $query ) ) {
				$query = array();
			}

			$settings_raw = isset( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- JSON payload is sanitized/validated per usage after decode.
			$settings     = is_string( $settings_raw ) ? json_decode( $settings_raw, true ) : array();
			if ( ! is_array( $settings ) ) {
				$settings = array();
			}

			$args = $this->sanitize_query_args( $query, $widget );
			$args['paged']       = $page;
			$args['post_status'] = 'publish';

			$query_obj = new WP_Query( $args );

			if ( 'blog' === $widget ) {
				require_once WIRAKIT_PATH . 'inc/widgets/blog-post/render-helper.php';
			} else {
				require_once WIRAKIT_PATH . 'inc/widgets/loop/render-helper.php';
			}

			ob_start();
			if ( $query_obj->have_posts() ) {
				while ( $query_obj->have_posts() ) {
					$query_obj->the_post();

					if ( 'blog' === $widget ) {
						if ( isset( $settings['style_variations'] ) ) {
							switch ( $settings['style_variations'] ) {
								case 'overlay':
									Wirakit_render_post_item_overlay( $settings );
									break;
								default:
									Wirakit_render_post_item_default( $settings );
									break;
							}
						}
					} else {
						Wirakit_render_loop_item( $settings );
					}
				}
			}
			wp_reset_postdata();

			$html = ob_get_clean();

			wp_send_json_success(
				array(
					'html'         => $html,
					'current_page' => $page,
					'max_pages'    => $query_obj->max_num_pages,
				)
			);
		}

		/**
		 * Sanitize and whitelist query args from client.
		 *
		 * @param array  $query  Raw query args.
		 * @param string $widget Widget type.
		 * @return array
		 */
		private function sanitize_query_args( $query, $widget ) {
			$allowed_keys = array(
				'post_type',
				'posts_per_page',
				'orderby',
				'order',
				'post__in',
				'post__not_in',
				'tax_query',
				'category__not_in',
			);

			$args = array_intersect_key( $query, array_flip( $allowed_keys ) );

			if ( 'loop' === $widget ) {
				$post_type = isset( $args['post_type'] ) ? sanitize_key( $args['post_type'] ) : 'post';
				$public_types = get_post_types( array( 'public' => true ) );
				$args['post_type'] = in_array( $post_type, $public_types, true ) ? $post_type : 'post';
			} elseif ( 'blog' === $widget ) {
				$args['post_type'] = 'post';
			} else {
				$args['post_type'] = 'post';
			}

			$posts_per_page = isset( $args['posts_per_page'] ) ? intval( $args['posts_per_page'] ) : 6;
			$posts_per_page = max( 1, min( 20, $posts_per_page ) );
			$args['posts_per_page'] = $posts_per_page;

			if ( isset( $args['orderby'] ) ) {
				$allowed_orderby = array(
					'date',
					'post_date',
					'title',
					'post_title',
					'menu_order',
					'modified',
					'comment_count',
					'rand',
					'ID',
					'post__in',
				);
				$orderby = sanitize_key( $args['orderby'] );
				$args['orderby'] = in_array( $orderby, $allowed_orderby, true ) ? $orderby : 'date';
			}

			if ( isset( $args['order'] ) ) {
				$order = strtoupper( sanitize_text_field( $args['order'] ) );
				$args['order'] = in_array( $order, array( 'ASC', 'DESC' ), true ) ? $order : 'DESC';
			}

			if ( isset( $args['post__in'] ) ) {
				$args['post__in'] = array_slice( array_map( 'absint', (array) $args['post__in'] ), 0, 200 );
			}

			if ( isset( $args['post__not_in'] ) ) {
				$args['post__not_in'] = array_slice( array_map( 'absint', (array) $args['post__not_in'] ), 0, 200 );
			}

			if ( isset( $args['category__not_in'] ) ) {
				$args['category__not_in'] = array_slice( array_map( 'absint', (array) $args['category__not_in'] ), 0, 200 );
			}

			if ( isset( $args['tax_query'] ) && is_array( $args['tax_query'] ) ) {
				foreach ( $args['tax_query'] as $index => $tax ) {
					if ( empty( $tax['taxonomy'] ) || empty( $tax['terms'] ) ) {
						unset( $args['tax_query'][ $index ] );
						continue;
					}

					$taxonomy = sanitize_key( $tax['taxonomy'] );
					if ( ! taxonomy_exists( $taxonomy ) ) {
						unset( $args['tax_query'][ $index ] );
						continue;
					}

					$allowed_fields = array( 'term_id', 'slug', 'name' );
					$field          = isset( $tax['field'] ) ? sanitize_key( $tax['field'] ) : 'term_id';
					$field          = in_array( $field, $allowed_fields, true ) ? $field : 'term_id';

					$terms = (array) $tax['terms'];
					if ( 'term_id' === $field ) {
						$terms = array_map( 'absint', $terms );
					} else {
						$terms = array_map( 'sanitize_text_field', $terms );
					}
					$terms = array_slice( $terms, 0, 200 );

					$args['tax_query'][ $index ]['taxonomy'] = $taxonomy;
					$args['tax_query'][ $index ]['field']    = $field;
					$args['tax_query'][ $index ]['terms']    = $terms;
				}
				$args['tax_query'] = array_values( $args['tax_query'] );
			}

			return $args;
		}
	}

	new Wirakit_Widget_Ajax();
}

