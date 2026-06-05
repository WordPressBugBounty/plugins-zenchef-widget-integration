<?php

namespace Zenchef\Widget\Widget;

use function array_merge;
use function get_option;
use function is_array;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

const WIDGET_SETTINGS_DEFAULTS = [
    'restaurant_id'     => '',
    'language'          => '',
    'use_default_color' => '1',
    'primary_color'     => '',
    'position'          => 'right',
    'auto_open'         => '1',
    'open_delay'        => 3000,
    'hide_button'       => '0',
    'disable_gtm'       => '0',
    'disable_ga4'       => '0',
];

/**
 * Returns the plugin's settings array merged with defaults, so callers never
 * have to worry about missing keys on installs that pre-date a new field.
 *
 * @return array
 */
function get_widget_settings()
{
    $stored = get_option(SETTINGS_OPTION_NAME, []);
    if (!is_array($stored)) {
        $stored = [];
    }

    return array_merge(WIDGET_SETTINGS_DEFAULTS, $stored);
}
