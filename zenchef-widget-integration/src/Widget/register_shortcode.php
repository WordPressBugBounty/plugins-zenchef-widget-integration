<?php

namespace Zenchef\Widget\Widget;

use function add_shortcode;
use function is_array;
use function ob_get_clean;
use function ob_start;
use function shortcode_atts;
use function Zenchef\Widget\View\render;

/**
 * @return void
 */
function register_widget_shortcode()
{
    add_shortcode('zenchef_widget', __NAMESPACE__ . '\\render_widget_shortcode');
}

/**
 * Tracks whether the shortcode rendered at least one widget on this request, so
 * the global wp_footer injector can avoid emitting a duplicate widget on the page.
 *
 * @param bool|null $mark Pass true to mark as rendered; null to read current state.
 * @return bool
 */
function widget_shortcode_was_rendered($mark = null)
{
    static $rendered = false;
    if ($mark === true) {
        $rendered = true;
    }
    return $rendered;
}

/**
 * @param array|string $atts
 * @return string
 */
function render_widget_shortcode($atts)
{
    $defaults = get_widget_settings();

    $atts = shortcode_atts(
        [
            'restaurant_id'     => $defaults['restaurant_id'],
            'language'          => $defaults['language'],
            'primary_color'     => $defaults['primary_color'],
            'use_default_color' => $defaults['use_default_color'],
            'position'          => $defaults['position'],
            'auto_open'         => $defaults['auto_open'],
            'open_delay'        => $defaults['open_delay'],
            'hide_button'       => $defaults['hide_button'],
            'disable_gtm'       => $defaults['disable_gtm'],
            'disable_ga4'       => $defaults['disable_ga4'],
        ],
        is_array($atts) ? $atts : [],
        'zenchef_widget'
    );

    $restaurant_id = sanitize_restaurant_id($atts['restaurant_id']);
    if ($restaurant_id === null || $restaurant_id === '') {
        return '';
    }

    if (!widget_should_load()) {
        return '';
    }

    $settings = [
        'restaurant_id'     => $restaurant_id,
        'language'          => sanitize_language($atts['language']),
        'primary_color'     => sanitize_primary_color($atts['primary_color']),
        'use_default_color' => sanitize_boolean($atts['use_default_color']),
        'position'          => sanitize_position($atts['position']),
        'auto_open'         => sanitize_boolean($atts['auto_open']),
        'open_delay'        => sanitize_open_delay($atts['open_delay']),
        'hide_button'       => sanitize_boolean($atts['hide_button']),
        'disable_gtm'       => sanitize_boolean($atts['disable_gtm']),
        'disable_ga4'       => sanitize_boolean($atts['disable_ga4']),
    ];

    widget_shortcode_was_rendered(true);
    enqueue_widget_sdk();

    ob_start();
    render('main', [
        'restaurant_id'   => $restaurant_id,
        'data_attributes' => build_widget_data_attributes($settings),
    ]);
    return (string) ob_get_clean();
}
