<?php

namespace Zenchef\Widget\Widget;

/**
 * Builds the map of data-* attributes to emit on the .zc-widget-config element,
 * given the plugin's settings array. Attributes for optional features are only
 * included when explicitly enabled, so the SDK falls back to its own defaults
 * (and to the Zenchef OS restaurant configuration) when the admin hasn't set
 * anything.
 *
 * @param array $settings normalised settings (already sanitized)
 * @return array<string, string>
 */
function build_widget_data_attributes(array $settings)
{
    $attributes = [
        'data-restaurant' => (string) ($settings['restaurant_id'] ?? ''),
        'data-position'   => (string) ($settings['position'] ?? 'right'),
    ];

    $language = (string) ($settings['language'] ?? '');
    if ($language !== '') {
        $attributes['data-lang'] = $language;
    }

    $use_default_color = ($settings['use_default_color'] ?? '1') === '1';
    $primary_color = (string) ($settings['primary_color'] ?? '');
    if (!$use_default_color && $primary_color !== '') {
        $attributes['data-primary-color'] = $primary_color;
    }

    if (($settings['hide_button'] ?? '0') === '1') {
        $attributes['data-hide-default-button'] = 'true';
    }

    $auto_open = ($settings['auto_open'] ?? '1') === '1';
    if (!$auto_open) {
        $attributes['data-open'] = 'false';
    } else {
        $attributes['data-open'] = (string) ($settings['open_delay'] ?? 3000);
    }

    if (($settings['disable_gtm'] ?? '0') === '1') {
        $attributes['data-disable-gtm'] = 'true';
    }
    if (($settings['disable_ga4'] ?? '0') === '1') {
        $attributes['data-disable-ga4'] = 'true';
    }

    return $attributes;
}
