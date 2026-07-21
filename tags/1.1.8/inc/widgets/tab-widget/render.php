<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Tab Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings   = $this->get_settings_for_display();
$tab_items  = ! empty( $settings['tab_items'] ) && is_array( $settings['tab_items'] ) ? $settings['tab_items'] : array();
$widget_uid = 'wkit-tab-widget-' . $this->get_id();
$active_desc_only = isset( $settings['show_description_active_only'] ) && 'yes' === $settings['show_description_active_only'];

if ( empty( $tab_items ) ) {
	echo '<p>' . esc_html__( 'Please add at least one tab item.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$active_index = isset( $settings['default_active_tab'] ) ? absint( $settings['default_active_tab'] ) - 1 : 0;
if ( $active_index < 0 || $active_index >= count( $tab_items ) ) {
	$active_index = 0;
}
?>

<div id="<?php echo esc_attr( $widget_uid ); ?>" class="wkit-tab-widget<?php echo $active_desc_only ? ' show-desc-active-only' : ''; ?>">
	<div class="wkit-tab-layout">
		<div class="wkit-tab-nav" role="tablist">
			<?php foreach ( $tab_items as $index => $item ) : ?>
				<?php
				$is_active   = ( $index === $active_index );
				$tab_id      = $widget_uid . '-tab-' . $index;
				$panel_id    = $widget_uid . '-panel-' . $index;
				$tab_title   = ! empty( $item['tab_title'] ) ? $item['tab_title'] : __( 'Tab', 'wira-kit-for-elementor' );
				$tab_desc    = ! empty( $item['tab_description'] ) ? $item['tab_description'] : '';
				$has_icon    = ! empty( $item['tab_icon']['value'] );
				?>
				<a
					id="<?php echo esc_attr( $tab_id ); ?>"
					class="wkit-tab-nav-item<?php echo $is_active ? ' is-active' : ''; ?>"
					type="button"
					role="tab"
					aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr( $panel_id ); ?>"
					data-tab-index="<?php echo esc_attr( $index ); ?>"
				>
					<div class="wkit-tab-nav-head">
						<?php if ( $has_icon ) : ?>
							<span class="wkit-tab-nav-icon" aria-hidden="true">
								<?php \Elementor\Icons_Manager::render_icon( $item['tab_icon'], array( 'aria-hidden' => 'true' ) ); ?>
							</span>
						<?php endif; ?>
						<span class="wkit-tab-nav-title"><?php echo esc_html( $tab_title ); ?></span>
					</div>
					<?php if ( ! empty( $tab_desc ) ) : ?>
						<span class="wkit-tab-nav-desc"><?php echo esc_html( $tab_desc ); ?></span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="wkit-tab-content">
			<?php foreach ( $tab_items as $index => $item ) : ?>
				<?php
				$is_active    = ( $index === $active_index );
				$panel_id     = $widget_uid . '-panel-' . $index;
				$tab_id       = $widget_uid . '-tab-' . $index;
				$content_type = ! empty( $item['tab_content_type'] ) ? $item['tab_content_type'] : 'content';
				?>
				<div
					id="<?php echo esc_attr( $panel_id ); ?>"
					class="wkit-tab-panel<?php echo $is_active ? ' is-active' : ''; ?>"
					role="tabpanel"
					aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
					<?php echo $is_active ? '' : ' hidden'; ?>
				>
					<?php
					if ( 'template' === $content_type ) {
						$template_id = ! empty( $item['tab_template_id'] ) ? absint( $item['tab_template_id'] ) : 0;
						if ( $template_id && class_exists( 'Wirakit_Template_Library_Helper' ) ) {
							$template_html = Wirakit_Template_Library_Helper::render_elementor_template( $template_id );
							echo $template_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor template render returns intended HTML.
						} else {
							echo esc_html__( 'Template is not selected.', 'wira-kit-for-elementor' );
						}
					} else {
						$content = isset( $item['tab_content'] ) ? $item['tab_content'] : '';
						echo $this->parse_text_editor( $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor parses/sanitizes editor HTML output.
					}
					?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
