<?php

namespace Zenchef\Widget\Widget;

use function add_action;
use function add_filter;
use function apply_filters;
use function home_url;
use function plugin_basename;
use function wp_add_cookie_info;
use const Zenchef\Widget\PLUGIN_FILE;

/**
 * Storage written by the booking widget, declared to consent plugins.
 *
 * The plugin itself writes nothing. Almost everything here is set by the
 * bookings.zenchef.com iframe the SDK creates, which is why the domain defaults to
 * that iframe's origin rather than the site's own; zc_popup_* is the exception and
 * overrides it with 'domain' => 'SITE'. Note that localStorage counts as storage on
 * terminal equipment under §25 TDDDG and ePrivacy Art. 5(3) just as cookies do, so
 * it is declared here too.
 *
 * The category is null for entries that follow the configurable widget category,
 * and a literal string for entries whose classification does not depend on it.
 *
 * Not listed here: Google Analytics, Google Tag Manager and the Meta Pixel. Those
 * load inside the widget only when the restaurant enters its own IDs under Guest
 * analytics in Zenchef OS, using the restaurant's own tracking properties. The
 * plugin cannot tell whether they are configured, and declaring them unconditionally
 * would list trackers most sites do not run. They belong in the site's own cookie
 * policy alongside its other analytics; see the readme.
 *
 * Keep this list in step with what the booking application actually stores. Verified
 * against a full booking walkthrough on 12 August 2026.
 */
const WIDGET_STORAGE = [
    // Written as soon as the widget loads, before the visitor interacts with it.
    [
        'name'     => 'aws-waf-token',
        'category' => 'functional',
        'expires'  => '4 days',
        'function' => 'Distinguishes visitors from automated traffic (bot protection)',
        'data'     => '',
        'type'     => 'HTTP',
        'domain'   => null,
    ],
    [
        'name'     => 'awswaf_session_storage',
        'category' => 'functional',
        'expires'  => 'persistent',
        'function' => 'Distinguishes visitors from automated traffic (bot protection)',
        'data'     => '',
        'type'     => 'LOCALSTORAGE',
        'domain'   => null,
    ],
    [
        'name'     => 'awswaf_token_refresh_timestamp',
        'category' => 'functional',
        'expires'  => 'persistent',
        'function' => 'Times the refresh of the bot protection token',
        'data'     => '',
        'type'     => 'LOCALSTORAGE',
        'domain'   => null,
    ],
    [
        'name'     => 'unleash:repository:sessionId',
        'category' => null,
        'expires'  => 'persistent',
        'function' => 'Keeps feature rollouts consistent across visits',
        'data'     => 'Randomly generated device identifier',
        'type'     => 'LOCALSTORAGE',
        'domain'   => null,
    ],
    [
        'name'     => 'unleash:repository:repo',
        'category' => null,
        'expires'  => 'persistent',
        'function' => 'Caches the feature rollout configuration',
        'data'     => '',
        'type'     => 'LOCALSTORAGE',
        'domain'   => null,
    ],
    [
        'name'     => 'bugsnag-anonymous-id',
        'category' => null,
        'expires'  => 'persistent',
        'function' => 'Groups error reports coming from the same device',
        'data'     => 'Randomly generated device identifier',
        'type'     => 'LOCALSTORAGE',
        'domain'   => null,
    ],

    // Written only once the visitor acts. Declared anyway, because a consent plugin
    // lists storage up front rather than at the moment it is written.
    [
        'name'     => 'formDataFromCookies',
        'category' => 'preferences',
        'expires'  => 'session',
        'function' => 'Remembers the guest\'s contact details to pre-fill the booking form next time. Written only when the guest ticks "Save the information for my next reservations"; unticking it deletes the cookie.',
        'data'     => 'Name, title, email address, phone number, country and postcode',
        'type'     => 'HTTP',
        'domain'   => null,
    ],
    [
        'name'     => 'zc_popup_*',
        'category' => 'preferences',
        'expires'  => '14 days',
        'function' => 'Remembers that the visitor dismissed a widget popup, so it is not shown again',
        'data'     => '',
        'type'     => 'LOCALSTORAGE',
        // The one entry written by the SDK on the site's own origin rather than
        // inside the iframe.
        'domain'   => 'SITE',
    ],

    // Written only at a payment step, and only for restaurants that take
    // prepayments or card imprints. Which of the two providers applies depends on
    // the restaurant's Zenchef configuration. Adyen (Zenchef Pay) is what nearly
    // every restaurant now uses; the Stripe entries cover the remaining holdovers
    // and are kept because omitting them would under-declare for those sites. The
    // Stripe expiries come from Stripe's own documentation rather than observation.
    [
        'name'     => 'adyen-checkout__checkout-attempt-id',
        'category' => 'functional',
        'expires'  => 'session',
        'function' => 'Correlates the steps of a single payment attempt (Adyen)',
        'data'     => '',
        'type'     => 'LOCALSTORAGE',
        'domain'   => null,
    ],
    [
        'name'     => '__stripe_mid',
        'category' => 'functional',
        'expires'  => '1 year',
        'function' => 'Fraud prevention during payment (Stripe)',
        'data'     => 'Randomly generated device identifier',
        'type'     => 'HTTP',
        'domain'   => null,
    ],
    [
        'name'     => '__stripe_sid',
        'category' => 'functional',
        'expires'  => '30 minutes',
        'function' => 'Fraud prevention during payment (Stripe)',
        'data'     => 'Randomly generated session identifier',
        'type'     => 'HTTP',
        'domain'   => null,
    ],
];

/**
 * Origin on which the storage above is written, unless an entry overrides it with
 * 'domain' => 'SITE'. The scheme is explicit because the consent API runs the value
 * through esc_url_raw(), which would otherwise default a bare host name to http://.
 */
const WIDGET_STORAGE_DOMAIN = 'https://bookings.zenchef.com';

/**
 * Declares the plugin to the WP Consent API.
 *
 * https://wordpress.org/plugins/wp-consent-api/ is the closest thing WordPress has
 * to a cross-plugin consent standard, and consent plugins use it to tell whether an
 * integration is consent-aware. Registration happens at bootstrap because the API
 * reads the filter while building its plugin list rather than on a late hook.
 *
 * @return void
 */
function register_consent_api()
{
    add_filter(
        'wp_consent_api_registered_' . plugin_basename(PLUGIN_FILE),
        '__return_true'
    );

    // The cookie registry is an in-memory list on an object the WP Consent API
    // builds on plugins_loaded at priority 9, so declaring storage any earlier than
    // this would be discarded.
    add_action('plugins_loaded', __NAMESPACE__ . '\\declare_widget_storage', 10);
}

/**
 * Declares what the widget stores, so a consent plugin can list it accurately
 * without the site owner having to research it.
 *
 * @return void
 */
function declare_widget_storage()
{
    // The WP Consent API is an optional third-party plugin.
    if (!function_exists('wp_add_cookie_info')) {
        return;
    }

    $category = widget_consent_category();

    foreach (WIDGET_STORAGE as $storage) {
        wp_add_cookie_info(
            $storage['name'],
            'Zenchef',
            $storage['category'] === null ? $category : $storage['category'],
            $storage['expires'],
            $storage['function'],
            $storage['data'],
            false,
            false,
            $storage['type'],
            $storage['domain'] === 'SITE' ? home_url() : WIDGET_STORAGE_DOMAIN
        );
    }
}

/**
 * The consent category the widget's non-essential storage falls under.
 *
 * Applies to the feature-flag and error monitoring identifiers in WIDGET_STORAGE —
 * the entries whose category is null. Defaults to 'statistics', the safer of the
 * readings available for device identifiers kept across visits. Filterable because
 * the correct classification is a decision for the site's data protection officer,
 * and because 'functional' becomes arguable once that storage is reduced.
 *
 * Valid values are those the WP Consent API accepts: functional, preferences,
 * statistics-anonymous, statistics, marketing.
 *
 * @return string
 */
function widget_consent_category()
{
    return (string) apply_filters('zenchef_widget_consent_category', 'statistics');
}
