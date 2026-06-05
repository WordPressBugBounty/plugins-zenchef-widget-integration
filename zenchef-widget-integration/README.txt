=== Zenchef widget integration ===
Contributors: zenchef
Tags: reservation, restaurant, food
Requires at least: 4.6
Tested up to: 7.0
Stable tag: 1.2.0
Requires PHP: 5.6
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

= Read more =

* [Zenchef](https://www.zenchef.com/).
* [Terms of Use](https://www.zenchef.com/terms-conditions)
* [Privacy policy](https://www.zenchef.com/privacy-policy)
