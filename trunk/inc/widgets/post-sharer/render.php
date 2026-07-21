<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Render for Post Sharer Elementor Custom Widget.
 *
 * Outputs social share buttons for a configurable list of networks.
 * Supports icons, text, or both styles with safe escaped URLs.
 *
 * @package    Wira Kit for Elementor - Widgets & Template Builder System
 * @subpackage Elementor Widgets
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings            = $this->get_settings_for_display();
$Wirakit_post_url_raw = get_permalink();
$Wirakit_post_url     = rawurlencode( $Wirakit_post_url_raw );
$Wirakit_post_title   = rawurlencode( wp_strip_all_tags( get_the_title() ) );

if ( ! empty( $settings['social_media_list'] ) ) :
	?>
	<div class="wkit-social-share d-flex">
		<?php
		foreach ( $settings['social_media_list'] as $index => $item ) :
			$url        = '#';
			$icon_class = '';

			switch ( $item['social_media'] ) {
				case 'facebook':
					$url        = "https://www.facebook.com/sharer/sharer.php?u={$Wirakit_post_url}";
					$icon_class = 'fab fa-facebook-f';
					break;

				case 'twitter':
					$url        = "https://twitter.com/intent/tweet?url={$Wirakit_post_url}&text={$Wirakit_post_title}";
					$icon_class = 'fab fa-twitter';
					break;

				case 'pinterest':
					$url        = "https://pinterest.com/pin/create/button/?url={$Wirakit_post_url}&description={$Wirakit_post_title}";
					$icon_class = 'fab fa-pinterest-p';
					break;

				case 'linkedin':
					$url        = "https://www.linkedin.com/sharing/share-offsite/?url={$Wirakit_post_url}";
					$icon_class = 'fab fa-linkedin-in';
					break;

				case 'tumblr':
					$url        = "https://www.tumblr.com/share/link?url={$Wirakit_post_url}&name={$Wirakit_post_title}";
					$icon_class = 'fab fa-tumblr';
					break;

				case 'flicker':
					$url        = 'https://www.flickr.com/'; // no direct share.
					$icon_class = 'fab fa-flickr';
					break;

				case 'vkontakte':
					$url        = "https://vk.com/share.php?url={$Wirakit_post_url}";
					$icon_class = 'fab fa-vk';
					break;

				case 'odnoklassniki':
					$url        = "https://connect.ok.ru/offer?url={$Wirakit_post_url}";
					$icon_class = 'fab fa-odnoklassniki';
					break;

				case 'moimir':
					$url        = "https://my.mail.ru/apps/share?url={$Wirakit_post_url}";
					$icon_class = 'fas fa-envelope'; // no fa-brand, fallback.
					break;

				case 'live journal':
					$url        = "https://www.livejournal.com/update.bml?event={$Wirakit_post_url}&subject={$Wirakit_post_title}";
					$icon_class = 'fas fa-book';
					break;

				case 'blogger':
					$url        = "https://www.blogger.com/blog-this.g?u={$Wirakit_post_url}&n={$Wirakit_post_title}";
					$icon_class = 'fab fa-blogger';
					break;

				case 'digg':
					$url        = "http://digg.com/submit?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-digg';
					break;

				case 'evernote':
					$url        = "https://www.evernote.com/clip.action?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-evernote';
					break;

				case 'reddit':
					$url        = "https://www.reddit.com/submit?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-reddit-alien';
					break;

				case 'delicious':
					$url        = "https://del.icio.us/post?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-delicious';
					break;

				case 'stumbleupon':
					$url        = "http://www.stumbleupon.com/submit?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-stumbleupon';
					break;

				case 'pocket':
					$url        = "https://getpocket.com/save?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-get-pocket';
					break;

				case 'surfingbird':
					$url        = "http://surfingbird.ru/share?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fas fa-dove'; // no official icon.
					break;

				case 'liveinternet':
					$url        = "http://www.liveinternet.ru/journal_post.php?action=n_add&cnurl={$Wirakit_post_url}&cntitle={$Wirakit_post_title}";
					$icon_class = 'fas fa-rss';
					break;

				case 'buffer':
					$url        = "https://buffer.com/add?url={$Wirakit_post_url}&text={$Wirakit_post_title}";
					$icon_class = 'fab fa-buffer';
					break;

				case 'instapaper':
					$url        = "https://www.instapaper.com/edit?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fas fa-bookmark';
					break;

				case 'xing':
					$url        = "https://www.xing.com/social/share/spi?op=share&url={$Wirakit_post_url}";
					$icon_class = 'fab fa-xing';
					break;

				case 'WordPress':
					$url        = "https://wordpress.com/press-this.php?u={$Wirakit_post_url}&t={$Wirakit_post_title}";
					$icon_class = 'fab fa-wordpress';
					break;

				case 'baidu':
					$url        = "http://cang.baidu.com/do/add?it={$Wirakit_post_title}&iu={$Wirakit_post_url}";
					$icon_class = 'fab fa-baidu';
					break;

				case 'renren':
					$url        = "http://share.renren.com/share/buttonshare.do?link={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-renren';
					break;

				case 'weibo':
					$url        = "http://service.weibo.com/share/share.php?url={$Wirakit_post_url}&title={$Wirakit_post_title}";
					$icon_class = 'fab fa-weibo';
					break;

				case 'skype':
					$url        = "https://web.skype.com/share?url={$Wirakit_post_url}&text={$Wirakit_post_title}";
					$icon_class = 'fab fa-skype';
					break;

				case 'telegram':
					$url        = "https://t.me/share/url?url={$Wirakit_post_url}&text={$Wirakit_post_title}";
					$icon_class = 'fab fa-telegram-plane';
					break;

				case 'viber':
					$url        = "viber://forward?text={$Wirakit_post_title}%20{$Wirakit_post_url}";
					$icon_class = 'fab fa-viber';
					break;

				case 'whatsapp':
					$url        = "https://api.whatsapp.com/send?text={$Wirakit_post_title}%20{$Wirakit_post_url}";
					$icon_class = 'fab fa-whatsapp';
					break;

				case 'line':
					$url        = "https://social-plugins.line.me/lineit/share?url={$Wirakit_post_url}";
					$icon_class = 'fab fa-line';
					break;

				default:
					$url        = $Wirakit_post_url_raw;
					$icon_class = 'fas fa-share-alt';
					break;
			}


			if ( ! empty( $item['icon']['value'] ) ) {
				$icon_class = $item['icon']['value'];
			}

			$label = ! empty( $item['label'] ) ? $item['label'] : ucfirst( $item['social_media'] );

			$this->add_render_attribute(
				'social_media_item' . $index,
				'class',
				array(
					'elementor-repeater-item-' . $item['_id'],
					'wkit-social-share-icon',
				)
			);
			?>
			
			<a 
			<?php
				// Safe: $data_attrs is fully escaped during construction (each value passed through esc_attr()).
				echo $this->get_render_attribute_string( 'social_media_item' . $index ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe: Elementor renders escaped attributes.
			?>
								href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
				
				<?php if ( 'icon' === $settings['choose_style'] ) : ?>
					<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
				<?php elseif ( 'text' === $settings['choose_style'] ) : ?>
					<span class="wkit-social-label"><?php echo esc_html( $label ); ?></span>
				<?php elseif ( 'both' === $settings['choose_style'] ) : ?>
					<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
					<span class="wkit-social-label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
