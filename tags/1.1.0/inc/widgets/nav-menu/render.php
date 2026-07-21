<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Nav Menu Elementor Custom Widget.
 *
 * Displays a responsive navigation menu with support for:
 * - Custom logo (inherit from theme or custom URL).
 * - Mobile menu with hamburger and close icons.
 * - Bootstrap-compatible desktop navigation.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings                    = $this->get_settings_for_display();
$Wirakit_menu_list          = $settings['wira_elementor_kit_nav_menu_list'];
$horizontal_position         = $settings['wira_elementor_kit_nav_horizontal_position'] ?? 'center';
$Wirakit_nav_hamburger_icon = $settings['wira_elementor_kit_nav_hamburger_icon'];
$Wirakit_nav_close_icon     = $settings['wira_elementor_kit_nav_close_icon'];

// Custom mobile logo URL.
$Wirakit_custom_logo_url = '';
if ( isset( $settings['wira_elementor_kit_mobile_menu_logo']['url'] ) ) {
	$Wirakit_custom_logo_url = $settings['wira_elementor_kit_mobile_menu_logo']['url'];
}
?>

<nav class="wkit-navbar navbar navbar-expand-lg navbar-light p-0">
	<div class="wkit-nav-wrapper">

		<!-- Mobile Menu Button -->
		<div class="wkit-mobile-menu-btn-wrapper w-100">
			<button class="wkit-mobile-menu-btn d-lg-none d-block" type="button">
				<?php if ( ! empty( $settings['wira_elementor_kit_nav_hamburger_icon']['value'] ) ) : ?>
					<i class="<?php echo esc_attr( $settings['wira_elementor_kit_nav_hamburger_icon']['value'] ); ?>"></i>
				<?php endif; ?>
			</button>
		</div>

		<!-- Mobile Menu -->
		<div class="wkit-mobile-menu">
			<div class="row mx-0 p-3">

				<!-- Mobile Logo -->
				<div class="d-flex align-items-center col-7 p-0">
					<div class="wkit-mobile-brand">
						<?php
						if ( 'inherit' === $settings['wira_elementor_kit_mobile_logo_mode'] ) {
							// Use theme custom logo if available.
							if ( has_custom_logo() ) {
								the_custom_logo();
							} else {
								// Fallback default logo.
								echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home">';
								echo '<img src="' . esc_url( WIRAKIT_URL . '/assets/widget/img/wira-kit-for-elementor-light.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="512" height="85" decoding="async" class="custom-logo">';
								echo '</a>';
							}
						} else {
							// Use custom logo URL.
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home">';
							echo '<img src="' . esc_url( $Wirakit_custom_logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="512" height="85" decoding="async" class="custom-logo">';
							echo '</a>';
						}
						?>
					</div>
				</div>

				<!-- Mobile Close Button -->
				<div class="d-flex justify-content-end col-5 p-0">
					<button class="wkit-mobile-menu-close d-lg-none d-block" type="button">
						<?php if ( ! empty( $settings['wira_elementor_kit_nav_close_icon']['value'] ) ) : ?>
							<i class="<?php echo esc_attr( $settings['wira_elementor_kit_nav_close_icon']['value'] ); ?>"></i>
						<?php endif; ?>
					</button>
				</div>
			</div>

			<!-- Mobile Navigation Placeholder -->
			<div class="wkit-mobile-nav wkit-nav p-0"><!-- Navigation Menu --></div>
		</div>

		<!-- Mobile Menu Overlay -->
		<div class="wkit-mobile-menu-overlay"></div>

		<!-- Main Navigation -->
		<div class="wkit-nav collapse navbar-collapse" id="wkit-main-navbar">
			<?php
			$menu_args = array(
				'menu'        => $Wirakit_menu_list,
				'menu_class'  => 'navbar-nav mb-2 mb-lg-0',
				'container'   => false,
				'fallback_cb' => false,
				'items_wrap'  => '<ul class="%2$s">%3$s</ul>',
				'depth'       => 4,
				'walker'      => new Wirakit_Bootstrap_Navwalker(),
				'wira_elementor_kit_nav_dropdown_icon' => ! empty( $settings['wira_elementor_kit_nav_dropdown_icon'] ) ? $settings['wira_elementor_kit_nav_dropdown_icon'] : array(),
			);

			$Wirakit_menus = $Wirakit_menu_list;

			if ( empty( $Wirakit_menus ) ) {
				// Fallback if no menu assigned: use first available menu or show notice in editor.
				$menus = wp_get_nav_menus();
				if ( ! empty( $menus ) ) {
					$menu_args['menu'] = $menus[0]->term_id;
					wp_nav_menu( $menu_args );
				} elseif ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					echo '<p>' . esc_html__( 'No menus found. Please create one in Appearance > Menus.', 'wira-kit-for-elementor' ) . '</p>';
				}
			} else {
				wp_nav_menu( $menu_args );
			}
			?>
		</div>
	</div>
</nav>
