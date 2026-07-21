=== Wira Kit for Elementor - Widgets & Template Builder System ===
Contributors: Wirastudio
Tags: elementor, templates, widgets, toolkit, elementor template kit
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 7.4
Requires Plugins: elementor
Stable tag: 1.0.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Wira Kit for Elementor - Widgets & Template Builder System Provides Elementor widgets, and dynamic theme builder extra functionality.

== Description ==
Wira Kit for Elementor - Widgets & Template Builder System works well with Hello Elementor Theme.

Requires Plugin:
* Elementor

Features:
* Elementor custom widgets (Blog Post, Archive Title, Team, etc.)
* Elementor Template Kits
* Extra utilities for theme builder features

== Frequently Asked Questions ==

= Does this plugin require Elementor? =
Yes. This plugin requires Elementor to provide template import and widget functionality.

= Does this plugin call external services? =
Yes. The Template Kit browser/importer can fetch kit data from a remote API when the user opens Browse Demo or imports a remote kit.

= Does this plugin install or activate other plugins automatically? =
No. If a template kit requires additional plugins, Wira Kit will only show the required plugin status and provide links to WordPress core Install/Activate screens. Installing or activating plugins is always done by the user via WordPress core.

== External services ==

This plugin connects to Wira Theme API endpoints to browse and import template kits.
This plugin connects to an external API to fetch template data.
No personal data is stored without user consent.

Service provider: Wira Theme
Service URL (kits list): `https://api.wiratheme.com/wp-json/wira/v1/kits`
Service URL (kit detail): `https://api.wiratheme.com/wp-json/wira/v1/kits/{slug}`
Service URL (kit download): `https://api.wiratheme.com/wp-json/wira/v1/download/{slug}` (used through `download_endpoint` returned by kit detail response)

Service URL (full import kits list): https://api.wiratheme.com/wp-json/wira/v1/kits
Service URL (full import kit detail): https://api.wiratheme.com/wp-json/wira/v1/kits/{slug}
Service URL (full import kit download): https://api.wiratheme.com/wp-json/wira/v1/download/{slug} (used through download_endpoint returned by kit detail response)

When requests are sent (full import):
* When the admin opens Template Kit > Full Import.
* When the admin clicks import for a full import kit.

When requests are sent:
* When the admin opens Template Kit > Browse Template Kits.
* When the admin clicks import for a remote template kit.

What is sent:
* The selected kit slug when requesting kit detail (`{slug}` endpoint).
* Standard HTTP request metadata sent by WordPress/PHP environment.

What is received:
* Kits list response can include: `slug`, `name`, `demo`, `version`, `thumbnail`, `pricing_type`.
* Kit detail response can include: `slug`, `name`, `version`, `pricing_type`, `download_endpoint`.
* Download endpoint response returns the template kit ZIP for import processing.

Why this is sent:
* To retrieve template kit metadata, determine pricing/import availability, and download template kit ZIP files for import.

Third-party terms:
* https://wiratheme.com/api-terms/
* https://wiratheme.com/terms-of-service/
* https://wiratheme.com/privacy-policy/

Post Sharer external services:
The Post Sharer widget can open third-party share endpoints when a visitor clicks a share button.

Services used (depending on user selection):
This widget can open the following third-party share endpoints:
Facebook, X/Twitter, Pinterest, LinkedIn, Tumblr, Flickr, VK, Odnoklassniki (ok.ru), Mail.ru, LiveJournal, Blogger,
Digg, Evernote, Reddit, Delicious, StumbleUpon, Pocket, Surfingbird, LiveInternet, Buffer, Instapaper,
Xing, WordPress.com, Baidu, Renren, Weibo, Skype, Telegram, Viber, WhatsApp, LINE.

When requests are sent:
* Only when a visitor clicks a share button in the Post Sharer widget.

What is sent:
* The current page URL and, where supported by the service, the page title (as query string parameters in the share URL).
* These requests are made by the visitor's browser directly to the selected share provider.

Why this is sent:
* To open the provider's share UI prefilled with the current page URL/title.

third-party terms and privacy:
* Facebook (share endpoint: https://www.facebook.com/): https://www.facebook.com/legal/terms , https://www.facebook.com/privacy/policy
* X/Twitter (share endpoint: https://twitter.com/): https://twitter.com/en/tos , https://twitter.com/en/privacy
* Pinterest (share endpoint: https://pinterest.com/): https://policy.pinterest.com/en/terms-of-service , https://policy.pinterest.com/en/privacy-policy
* LinkedIn (share endpoint: https://www.linkedin.com/): https://www.linkedin.com/legal/user-agreement , https://www.linkedin.com/legal/privacy-policy
* Reddit (share endpoint: https://www.reddit.com/): https://www.redditinc.com/policies/user-agreement , https://www.reddit.com/policies/privacy-policy
* Telegram (share endpoint: https://t.me/): https://telegram.org/tos , https://telegram.org/privacy
* LINE (share endpoint: https://social-plugins.line.me/): https://terms.line.me/line_terms?lang=en , https://privacy.line.me/line_privacy?lang=en
* Viber (share endpoint: viber://): https://www.viber.com/terms/ , https://www.viber.com/privacy/
* Skype (share endpoint: https://web.skype.com/): https://www.microsoft.com/servicesagreement , https://privacy.microsoft.com/
* WhatsApp (share endpoint: https://api.whatsapp.com/): https://www.whatsapp.com/legal/terms-of-service/ , https://www.whatsapp.com/legal/privacy-policy/
* Other providers listed above have their own terms and privacy policy, available from their respective websites.

Image License:
* https://pxhere.com/id/photo/1104511

== Installation ==
1. Upload the `wira-kit-for-elementor` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. The plugin works automatically with the most popular theme.

== Changelog ==

= 1.0.2 =
* Added extension hooks for external widget/module integrations.
* Skip free template importer when Wira Extended is active.
* Pass Wira Extended license state to the admin app.
* Show Install button for subscribe kits when Wira Extended license is active.
* Fix template reference remapping (loop/block/popup/tab) after import to keep widget selections intact.
* Open Full Import modal from "Get All Access" and link to upgrade in modal action button.

= 1.0.1 =
* Added additional widgets and full import support.
* Compliance updates for inline script removal and external services disclosure.

= 1.0.0 =
* Initial release
