=== Zenchef widget integration ===
Contributors: zenchef
Tags: reservation, restaurant, food
Requires at least: 4.6
Tested up to: 7.1
Stable tag: 1.3.0
Requires PHP: 7.4
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to integrate your restaurant's Zenchef reservation widget directly on all pages of your website.

== Description ==

This plugin allows you to integrate your restaurant's Zenchef reservation widget directly on all pages of your website, allowing your customers to take reservations directly without having to switch page.
You can also customize the integration according to your needs.

== Installation ==

1. Upload the plugin to your WordPress plugins directory, or install the plugin through your website dashboard, under _Plugins / Add new_ page.
2. Activate the plugin through your website dashboard, under _Plugins_.
3. Set your restaurant's ID on the new settings page that have been added to your dashboard, under _Settings / Zenchef widget_.

== Usage ==

= Default (global) widget =

Once your restaurant's ID is set, the widget is added automatically to every page of your website, with a floating booking button positioned according to the settings.

= Shortcode =

You can also place the widget inline on a specific page or post using the `[zenchef_widget]` shortcode. With no attributes, it uses the same settings as the global widget:

`[zenchef_widget]`

You can override any of the settings per-page (useful for sites managing several restaurants):

`[zenchef_widget restaurant_id="367219" open_delay="0" position="center"]`

All of the settings from the admin page can be overridden as shortcode attributes:

`[zenchef_widget restaurant_id="367219" language="fr" primary_color="#cc0000" hide_button="1" auto_open="0" disable_gtm="1" disable_ga4="1"]`

When the shortcode is used on a page, the floating global widget is not also injected, so there is never a duplicate.

**Tip for the Gutenberg editor**: Insert the shortcode using a _Shortcode_ block (Add Block / Shortcode), not a Paragraph block — Paragraph blocks can auto-format quotes and break the attributes. The widget only renders on the front-end of your site; Gutenberg does not preview shortcodes inside the editor.

== Frequently Asked Questions ==

= Where can I find my restaurant's ID? =

Your restaurant's ID is the number displayed on the top of your [Zenchef dashboard](https://app.zenchef.com/).

= How can I open the booking widget from a custom button (Elementor, Gutenberg, Divi...)? =

As long as the plugin is active and a restaurant ID is set, you can trigger the booking widget from any clickable element on your page. The Zenchef SDK natively supports three ways to do this:

1. **Add a data attribute to any button or link:**

   `<button data-zc-action="open">Book a table</button>`

   This works with HTML widgets in Elementor, custom HTML blocks in Gutenberg, or anywhere you can edit raw HTML.

2. **Use a hash-based link** (useful when the page builder only lets you set an URL):

   `<a href="#zc-action-open">Book a table</a>`

3. **Call the JavaScript API** from your own scripts:

   `ZenchefWidget.open()` — opens the widget
   `ZenchefWidget.close()` — closes it
   `ZenchefWidget.toggle()` — toggles it

== Support ==

For plugin support, please visit the [support center](https://help.zenchef.com/hc/en-gb).

== Screenshots ==

1. The Zenchef widget displayed on your website.
2. The Zenchef widget settings page.

== Changelog ==

= 1.3.0 =

* Tested with WordPress 7.1 (release candidate 3) and 7.0.3.
* The declared PHP requirement was wrong. The readme claimed PHP 5.6, but the plugin has used PHP 7.0 syntax since 1.2.0 and would fail to load with a parse error on anything older. It now declares PHP 7.4 (what WordPress itself requires from 6.0 onward), and declares it in the plugin header as well, so WordPress refuses activation with a clear message instead of breaking the site. Sites on PHP older than 7.4 will no longer be offered plugin updates.
* All settings-page strings are now available to translators on translate.wordpress.org. Previously 19 of them — the whole per-page shortcode reference — sat in `.phtml` templates that the WordPress string extractor skips, so they could not be translated in any language. The translation template now covers 59 strings instead of 16. Translating them is a separate, ongoing effort.
* The Zenchef SDK is now loaded by its real URL instead of through a local loader script. Cookie consent platforms that block third-party scripts by URL can now detect and block it, which previously was not possible.
* Registers with the WP Consent API (https://wordpress.org/plugins/wp-consent-api/) and declares the storage the booking widget writes, so compatible consent plugins can list it accurately.
* New filters for consent integration: `zenchef_widget_should_load`, `zenchef_widget_script_attributes` and `zenchef_widget_consent_category`.
* The privacy section of the documentation now describes what the booking widget stores on the visitor's device, and when.
* Existing installs are unaffected — the widget behaves exactly as before unless one of the new filters is used.

= 1.2.0 =

* Tested with WordPress 7.0.
* Settings page expanded with language, custom brand colour (with "use the colour set in Zenchef OS" mode and a colour picker), hide-floating-button, explicit auto-open toggle, and disable-GTM / disable-GA4 options. Reorganised into four sections (Restaurant, Appearance, Behaviour, Analytics).
* All new settings can be overridden per-page through the `[zenchef_widget]` shortcode.
* In-admin shortcode reference card with the full attribute list added below the settings form.
* Existing installs are unaffected — defaults preserve the previous behaviour.

= 1.1.0 =

* Restaurant ID is now trimmed and validated on save, so a stray space copy-pasted from the Zenchef dashboard no longer silently breaks the widget. Invalid values are rejected with a clear error notice instead of being saved.
* New `[zenchef_widget]` shortcode for inline embedding and per-page configuration overrides (useful for multi-restaurant sites).
* Documented how to trigger the booking widget from a custom button in Elementor, Gutenberg, or any other page builder.

= 1.0 =

* Initial release of the plugin.
* Basic widget integration and admin settings.

== Privacy policy ==

Our reservation widget plugin relies on the Zenchef service to enable restaurants to manage table reservations directly from their website. It requires a subscription to Zenchef.

= Purpose =

The Zenchef service is integrated into our plugin to provide a reservation widget on the restaurant's website, allowing customers to reserve tables online seamlessly.

= Data Transmission =

User data is transmitted to Zenchef when a customer makes a reservation or updates their reservation details through the widget.

= What is stored on the visitor's device =

The plugin itself sets no cookies and uses no local storage. However, it loads the Zenchef SDK from https://sdk.zenchef.com/v1/sdk.min.js, which embeds the booking widget in an iframe served from bookings.zenchef.com. That iframe writes to the visitor's device as soon as the page loads, before the visitor interacts with the widget:

* `aws-waf-token` (cookie) - distinguishes visitors from automated traffic
* `awswaf_session_storage`, `awswaf_token_refresh_timestamp` (local storage) - distinguishes visitors from automated traffic
* `unleash:repository:sessionId`, `unleash:repository:repo` (local storage) - keeps feature rollouts consistent across visits
* `bugsnag-anonymous-id` (local storage) - groups error reports from the same device

Note that local storage counts as storage on terminal equipment under ePrivacy Article 5(3) (and §25 TDDDG in Germany), just as cookies do.

The rest is written only once the visitor does something:

* `formDataFromCookies` (cookie) - written when the guest ticks "Save the information for my next reservations" and books. Holds their name, email, phone, country and postcode so the form can be pre-filled next time. Cleared when the browser closes, and deleted if the box is unticked.
* `zc_popup_*` (local storage, on your own domain) - written when the visitor dismisses a widget popup, so it is not shown again for 14 days.
* `adyen-checkout__checkout-attempt-id` (local storage) - written at a payment step, at restaurants that take payment through Adyen.
* `__stripe_mid`, `__stripe_sid` (cookies) - written at a payment step, at restaurants that take payment through Stripe.

If your restaurant takes prepayments or card imprints, the payment step also loads your payment provider's own scripts, and Adyen's checkout includes a Google Pay button loaded from pay.google.com. That does not happen anywhere else in the flow.

Your own analytics are separate. If you enter a Google Analytics, Google Tag Manager or Meta Pixel ID under Guest analytics in Zenchef OS, those load inside the widget too, using your own tracking properties, and set their usual cookies (`_ga`, `_fbp`, and so on). The plugin cannot tell whether you have configured them, so it does not declare them to your consent plugin - treat them the same way you treat the analytics on the rest of your site.

Depending on your jurisdiction and how you use the widget, you may need to obtain the visitor's consent before this happens. The plugin is built to make that possible:

* The SDK is loaded by its real URL, so consent platforms that block third-party scripts by URL can detect and block it without any configuration from us.
* The plugin registers with the WP Consent API (https://wordpress.org/plugins/wp-consent-api/) and declares the storage above, so compatible consent plugins can list it accurately.
* The filters documented under Hooks let you suppress loading or add whatever attributes your consent banner blocks on.

Because the SDK is an external script, WordPress also emits a `dns-prefetch` hint for sdk.zenchef.com. That resolves the domain ahead of time but transfers no data and stores nothing on the visitor's device. It is removed automatically when `zenchef_widget_should_load` returns false; note that it is *not* removed when a consent platform blocks the script by URL, since the hint is a separate element the platform does not touch.

This is a matter for your own legal assessment; the above is a description of the plugin's behaviour, not legal advice.

= Hooks =

* `zenchef_widget_should_load` (bool) - return false to suppress the SDK, the widget configuration element and the DNS prefetch hint entirely, for instance until consent has been given.
* `zenchef_widget_script_attributes` (array) - attributes of the SDK script tag. Add whatever your consent banner blocks on. Passed $attributes, $handle, $src. The `id` attribute is re-applied afterwards and cannot be changed - the SDK locates its own script element by that id and will not start without it.
* `zenchef_widget_consent_category` (string) - the WP Consent API category the widget's non-essential storage is declared under. Defaults to `statistics`.

Suppress the widget until your own code decides otherwise:

`add_filter( 'zenchef_widget_should_load', function () {
    return my_visitor_has_consented();
} );`

Mark the script for a banner that blocks by attribute:

`add_filter( 'zenchef_widget_script_attributes', function ( $attributes ) {
    $attributes['type'] = 'text/plain';
    $attributes['data-cookieconsent'] = 'statistics';

    return $attributes;
} );`

= Read more =

* [Zenchef](https://www.zenchef.com/).
* [Terms of Use](https://www.zenchef.com/terms-conditions)
* [Privacy policy](https://www.zenchef.com/privacy-policy)
