<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" class="wkit-template-single-builder">
	<?php do_action( 'wkit_single' ); ?>
</main>
<?php
get_footer();
