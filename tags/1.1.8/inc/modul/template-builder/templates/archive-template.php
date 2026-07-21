<?php
/**
 * Archive Template Wrapper.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="wkit-template-archive-wrap">
	<?php do_action( 'wkit_archive' ); ?>
</div>
<?php
get_footer();

