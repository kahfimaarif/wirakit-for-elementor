<?php
/**
 * Search Result Template Wrapper.
 *
 * @package Wira Kit for Elementor - Widgets & Template Builder System
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="wkit-template-search-wrap">
	<?php do_action( 'wkit_search' ); ?>
</div>
<?php
get_footer();

