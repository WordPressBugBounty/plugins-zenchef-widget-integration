<?php

namespace Zenchef\Widget\Widget;

use function apply_filters;
use function array_values;
use function esc_attr;
use function strpos;
use function wp_enqueue_script;
use function wp_register_script;

/** Script handle under which the Zenchef SDK is registered with WordPress. */
const SDK_SCRIPT_HANDLE = 'zenchef-sdk';

/**
 * Handle used up to 1.2.0, when the plugin enqueued a local loader script that
 * injected the SDK at runtime. Kept as an alias so a theme that declared it as a
 * dependency still resolves to the SDK.
 *
 * @deprecated 1.3.0 Use SDK_SCRIPT_HANDLE.
 */
const LEGACY_SCRIPT_HANDLE = 'zenchef-widget-integration';

/** The SDK is enqueued by its real URL so consent plugins can see and block it. */
const SDK_SCRIPT_URL = 'https://sdk.zenchef.com/v1/sdk.min.js';

/**
 * The id attribute the SDK requires on its own script element.
 *
 * The SDK locates itself with document.getElementById() to derive its stylesheet
 * URL from its own src, and throws if it cannot. WordPress would otherwise emit the
 * handle suffixed with "-js", so the id is set explicitly.
 */
const SDK_SCRIPT_ELEMENT_ID = 'zenchef-sdk';

/**
 * Enqueues the Zenchef SDK.
 *
 * The SDK is enqueued by its public URL rather than through a local loader script,
 * so that consent management platforms which block third-party scripts by URL can
 * detect it in the page HTML. A site owner can suppress it entirely through the
 * zenchef_widget_should_load filter.
 *
 * @return bool whether the SDK was enqueued
 */
function enqueue_widget_sdk()
{
    if (!widget_should_load()) {
        return false;
    }

    // No version is appended: a ?ver= query string on a third-party URL is
    // meaningless for cache busting and defeats exact-URL script blockers.
    wp_enqueue_script(SDK_SCRIPT_HANDLE, SDK_SCRIPT_URL, [], null, true);

    // A dependency-only alias, so it costs no extra request.
    wp_register_script(LEGACY_SCRIPT_HANDLE, false, [SDK_SCRIPT_HANDLE], null, true);

    return true;
}

/**
 * Whether the widget should be loaded on the current request at all.
 *
 * Lets a site owner or a consent plugin suppress both the SDK and the widget
 * configuration element, for instance until the visitor has given consent.
 *
 * @return bool
 */
function widget_should_load()
{
    return (bool) apply_filters('zenchef_widget_should_load', true);
}

/**
 * Rebuilds the SDK script tag from a filterable map of attributes.
 *
 * This carries the async loading the SDK needs, and gives site owners a way to add
 * whatever attributes their consent banner blocks on (commonly type="text/plain"
 * plus a vendor-specific data-* attribute) without us writing per-vendor code.
 *
 * The tag is rebuilt rather than appended to: WordPress below 6.4 emits
 * type="text/javascript", so appending a caller-supplied type would produce a
 * duplicate attribute in exactly the case this filter exists to support.
 *
 * @param string $tag    the complete script tag built by WordPress
 * @param string $handle the script handle
 * @param string $src    the script source URL
 * @return string
 */
function filter_widget_sdk_script_tag($tag, $handle, $src)
{
    if ($handle !== SDK_SCRIPT_HANDLE) {
        return $tag;
    }

    $attributes = apply_filters(
        'zenchef_widget_script_attributes',
        [
            'src'   => $src,
            'id'    => SDK_SCRIPT_ELEMENT_ID,
            'async' => true,
        ],
        $handle,
        $src
    );

    // Re-asserted after the filter: the SDK locates itself by this id and throws if
    // it cannot, so a filter that returns a fresh map rather than merging into the
    // one it was given would otherwise stop the widget rendering at all. src stays
    // filterable, because moving it to data-src is how several banners block a script.
    $attributes['id'] = SDK_SCRIPT_ELEMENT_ID;

    return build_script_tag($attributes);
}

/**
 * Drops the SDK host from WordPress's resource hints when the widget is suppressed.
 *
 * WordPress adds a dns-prefetch hint for the host of every external script it
 * enqueues. That hint is a separate <link> element, so it survives the script being
 * dequeued and would have the visitor's browser resolve a Zenchef domain on a page
 * where the site owner asked for no widget at all.
 *
 * @param array  $urls          the URLs WordPress is about to hint at
 * @param string $relation_type the hint type being assembled
 * @return array
 */
function filter_widget_sdk_resource_hints($urls, $relation_type)
{
    if ($relation_type !== 'dns-prefetch' || widget_should_load()) {
        return $urls;
    }

    foreach ($urls as $index => $url) {
        if (strpos((string) $url, 'sdk.zenchef.com') !== false) {
            unset($urls[$index]);
        }
    }

    return array_values($urls);
}

/**
 * Renders a script tag from an attribute map.
 *
 * True renders a boolean attribute, false and null omit it entirely, anything else
 * is escaped and rendered as a quoted value.
 *
 * @param array<string, string|bool|null> $attributes
 * @return string
 */
function build_script_tag(array $attributes)
{
    $rendered = '';

    foreach ($attributes as $name => $value) {
        if ($value === false || $value === null) {
            continue;
        }

        $rendered .= $value === true
            ? ' ' . esc_attr($name)
            : ' ' . esc_attr($name) . '="' . esc_attr($value) . '"';
    }

    return '<script' . $rendered . '></script>' . "\n";
}
