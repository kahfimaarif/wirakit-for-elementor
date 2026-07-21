<?php
/**
 * 404 Template Wrapper.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="wkit-template-404-wrap">
	<?php do_action( 'wkit_404' ); ?>
</div>
<?php
get_footer();

