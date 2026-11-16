<?php

namespace Zenchef\Widget\Widget\Backoffice;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

use function _x;
use function add_settings_error;
use function esc_html;
use function get_option;
use function is_array;
use function register_setting;
use function trim;
use function Zenchef\Widget\Widget\get_widget_settings;
use function Zenchef\Widget\Widget\is_lowercase_restaurant_public_id;
use function Zenchef\Widget\Widget\is_numeric_restaurant_id;
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
    // Fully qualified literal rather than __NAMESPACE__ . '\\sanitize_settings': the
    // two resolve to the same callable, but a static reviewer cannot follow a runtime
    // concatenation, and the wordpress.org review flagged this call as having no
    // sanitize_callback because of it. The literal brandizes with every other
    // namespace reference in the plugin.
    register_setting(SETTINGS_GROUP_SLUG, SETTINGS_OPTION_NAME, [
        'type'              => 'array',
        'sanitize_callback' => 'Zenchef\\Widget\\Widget\\Backoffice\\sanitize_settings',
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

    $raw_restaurant_id       = trim((string) ($input['restaurant_id'] ?? ''));
    $sanitized_restaurant_id = sanitize_restaurant_id($raw_restaurant_id);
    if ($sanitized_restaurant_id === null) {
        add_settings_error(
            SETTINGS_OPTION_NAME,
            'invalid_restaurant_id',
            is_lowercase_restaurant_public_id($raw_restaurant_id)
                ? _x(
                    'Invalid restaurant ID: after "rpid_", the public restaurant ID only contains capital letters and digits (for example rpid_AB12CD34). Please copy it exactly as it appears in your Zenchef dashboard.',
                    'widget.backoffice.settings_page.lowercase_restaurant_id_error',
                    'zenchef-widget-integration'
                )
                : _x(
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

/**
 * Invites restaurants still on a numeric ID to switch to their public ID, without
 * rejecting it: numeric IDs keep working until public routes stop accepting them.
 *
 * Hooked on the settings page only, so it shows both right after saving a numeric
 * ID and on installs that saved one before public IDs existed. Printed directly
 * rather than through add_settings_error(): on older WordPress a pending settings
 * error stops the "Settings saved." notice from being added.
 *
 * @return void
 */
function render_numeric_restaurant_id_notice()
{
    $restaurant_id = (string) (get_widget_settings()['restaurant_id'] ?? '');
    if (!is_numeric_restaurant_id($restaurant_id)) {
        return;
    }

    echo '<div class="notice notice-warning"><p>' . esc_html(
        _x(
            'Your widget uses a numeric restaurant ID. It still works for now, but please replace it with your public restaurant ID, which starts with "rpid_". You will find it in your Zenchef dashboard, under Settings > Widget > Embed.',
            'widget.backoffice.settings_page.numeric_restaurant_id_warning',
            'zenchef-widget-integration'
        )
    ) . '</p></div>';
}
