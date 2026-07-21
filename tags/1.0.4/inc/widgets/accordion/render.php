<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Accordion Widget.
 *
 * @package Wira Elementor Kit
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings   = $this->get_settings_for_display();
$items      = ! empty( $settings['accordion_items'] ) && is_array( $settings['accordion_items'] ) ? $settings['accordion_items'] : array();
$icon        = ! empty( $settings['accordion_icon']['value'] ) ? $settings['accordion_icon'] : array();
$icon_active = ! empty( $settings['accordion_icon_active']['value'] ) ? $settings['accordion_icon_active'] : $icon;
$widget_uid = 'wkit-accordion-' . $this->get_id();

if ( empty( $items ) ) {
	echo '<p>' . esc_html__( 'Please add at least one accordion item.', 'wira-kit-for-elementor' ) . '</p>';
	return;
}

$active_index = isset( $settings['default_active_item'] ) ? absint( $settings['default_active_item'] ) - 1 : 0;
if ( $active_index < 0 || $active_index >= count( $items ) ) {
	$active_index = 0;
}
?>

<div id="<?php echo esc_attr( $widget_uid ); ?>" class="wkit-accordion">
	<?php foreach ( $items as $index => $item ) : ?>
		<?php
		$is_active   = ( $index === $active_index );
		$item_id     = $widget_uid . '-item-' . $index;
		$header_id   = $widget_uid . '-header-' . $index;
		$panel_id    = $widget_uid . '-panel-' . $index;
		$title       = ! empty( $item['accordion_title'] ) ? $item['accordion_title'] : __( 'Accordion Item', 'wira-kit-for-elementor' );
		$content     = isset( $item['accordion_content'] ) ? $item['accordion_content'] : '';
		?>
		<div id="<?php echo esc_attr( $item_id ); ?>" class="wkit-accordion-item<?php echo $is_active ? ' is-active' : ''; ?>">
			<a
				id="<?php echo esc_attr( $header_id ); ?>"
				class="wkit-accordion-header"
				type="button"
				aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
				aria-controls="<?php echo esc_attr( $panel_id ); ?>"
			>
				<span class="wkit-accordion-title"><?php echo esc_html( $title ); ?></span>
				<span class="wkit-accordion-icon" aria-hidden="true">
					<span class="wkit-accordion-icon-default">
						<?php
						if ( ! empty( $icon['value'] ) ) {
							\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
						}
						?>
					</span>
					<span class="wkit-accordion-icon-active">
						<?php
						if ( ! empty( $icon_active['value'] ) ) {
							\Elementor\Icons_Manager::render_icon( $icon_active, array( 'aria-hidden' => 'true' ) );
						}
						?>
					</span>
				</span>
			</a>
			<div
				id="<?php echo esc_attr( $panel_id ); ?>"
				class="wkit-accordion-body"
				role="region"
				aria-labelledby="<?php echo esc_attr( $header_id ); ?>"
				data-open="<?php echo $is_active ? 'true' : 'false'; ?>"
			>
				<div class="wkit-accordion-body-inner">
					<?php echo $this->parse_text_editor( $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor parses/sanitizes editor HTML output. ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?php
if ( ! empty( $settings['enable_faq_schema'] ) && 'yes' === $settings['enable_faq_schema'] ) {
	$schema_entities = array();

	foreach ( $items as $item ) {
		$name  = ! empty( $item['accordion_title'] ) ? wp_strip_all_tags( $item['accordion_title'] ) : '';
		$text  = ! empty( $item['accordion_content'] ) ? wp_strip_all_tags( $item['accordion_content'] ) : '';
		$name  = trim( (string) $name );
		$text  = trim( (string) $text );

		if ( '' === $name || '' === $text ) {
			continue;
		}

		$schema_entities[] = array(
			'@type'          => 'Question',
			'name'           => $name,
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $text,
			),
		);
	}

	if ( ! empty( $schema_entities ) ) {
		$schema = array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $schema_entities,
		);
		$schema_json = wp_json_encode( $schema );
		echo '<span class="wkit-accordion-schema" data-schema="' . esc_attr( $schema_json ) . '"></span>';
	}
}
