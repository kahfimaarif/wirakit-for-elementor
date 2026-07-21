<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Post Comments Elementor Custom Widget.
 *
 * Outputs post comments with customized form styling, supporting both frontend and editor preview.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$target_post_id    = get_the_ID();
$is_elementor_edit = class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode();

// In Elementor edit mode, map comments to a real content post for supported builder post types.
if ( $is_elementor_edit && in_array( get_post_type( $target_post_id ), array( 'elementor_library', Wirakit_Template_Builder_Post_Type::SINGLE_POST_TYPE, Wirakit_Template_Builder_Post_Type::ARCHIVE_POST_TYPE, Wirakit_Template_Builder_Post_Type::SEARCH_POST_TYPE ), true ) ) {
	$document      = \Elementor\Plugin::$instance->documents->get( $target_post_id );
	$include_posts = $document ? $document->get_settings( 'include_posts' ) : '';

	$args = array(
		'post_type'      => array_diff(
			get_post_types( array( 'public' => true ), 'names' ),
			array( 'media', 'floating-element', 'template', 'elementor_library' )
		),
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	);

	if ( ! empty( $include_posts ) ) {
		$include_posts_ids = is_array( $include_posts ) ? $include_posts : array( $include_posts );
		$args['post__in']  = array_map( 'absint', $include_posts_ids );
		$args['orderby']   = 'post__in';
	}

	$preview_query = new \WP_Query( $args );
	if ( $preview_query->have_posts() ) {
		$preview_query->the_post();
		$target_post_id = get_the_ID();
		wp_reset_postdata();
	}
}

if ( ! $target_post_id || post_password_required( $target_post_id ) ) {
	return;
}

$original_post   = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
$GLOBALS['post'] = get_post( $target_post_id );
setup_postdata( $GLOBALS['post'] );
comments_template();
wp_reset_postdata();
$GLOBALS['post'] = $original_post;


