<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function _x;
use function add_settings_error;
use function get_option;
use function is_array;
use function register_setting;
use function Zenchef\Widget\Widget\sanitize_boolean;
use function Zenchef\Widget\Widget\sanitize_language;
use function Zenchef\Widget\Widget\sanitize_open_delay;
use function Zenchef\Widget\Widget\sanitize_position;
use function Zenchef\Widget\Widget\sanitize_primary_color;
use function Zenchef\Widget\Widget\sanitize_restaurant_id;
use const Zenchef\Widget\ROOT_PATH;
use const Zenchef\Widget\SETTINGS_GROUP_SLUG;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

require_once ROOT_PATH . 'src/Widget/sanitize_restaurant_id.php';
require_once ROOT_PATH . 'src/Widget/sanitize_widget_settings.php';

/**
 * @return void
 */
function register_settings()
{
    register_setting(SETTINGS_GROUP_SLUG, SETTINGS_OPTION_NAME, [
        'sanitize_callback' => __NAMESPACE__ . '\\sanitize_settings',
    ]);
}

/**
 * Sanitization callback for the plugin's option array.
 *
 * @param mixed $input
 * @return array
 */
function sanitize_settings($input)
{
    $previous = get_option(SETTINGS_OPTION_NAME, []);
    if (!is_array($previous)) {
        $previous = [];
    }
    if (!is_array($input)) {
        return $previous;
    }

    $sanitized = $previous;

    $sanitized_restaurant_id = sanitize_restaurant_id($input['restaurant_id'] ?? '');
    if ($sanitized_restaurant_id === null) {
        add_settings_error(
            SETTINGS_OPTION_NAME,
            'invalid_restaurant_id',
            _x(
                'Invalid restaurant ID. Please copy the ID exactly as it appears in your Zenchef dashboard.',
                'widget.backoffice.settings_page.invalid_restaurant_id_error',
                'zenchef-widget-integration'
            ),
            'error'
        );
        $sanitized['restaurant_id'] = $previous['restaurant_id'] ?? '';
    } else {
        $sanitized['restaurant_id'] = $sanitized_restaurant_id;
    }

    $sanitized['language']          = sanitize_language($input['language'] ?? '');
    $sanitized['primary_color']     = sanitize_primary_color($input['primary_color'] ?? '');
    $sanitized['position']          = sanitize_position($input['position'] ?? 'right');
    $sanitized['open_delay']        = sanitize_open_delay($input['open_delay'] ?? 3000);
    $sanitized['use_default_color'] = sanitize_boolean($input['use_default_color'] ?? null);
    $sanitized['auto_open']         = sanitize_boolean($input['auto_open'] ?? null);
    $sanitized['hide_button']       = sanitize_boolean($input['hide_button'] ?? null);
    $sanitized['disable_gtm']       = sanitize_boolean($input['disable_gtm'] ?? null);
    $sanitized['disable_ga4']       = sanitize_boolean($input['disable_ga4'] ?? null);

    return $sanitized;
}
