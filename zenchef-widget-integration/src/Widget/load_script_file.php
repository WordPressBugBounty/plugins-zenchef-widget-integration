<?php

namespace Zenchef\Widget\Widget;

use function get_option;
use function plugins_url;
use function wp_enqueue_script;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

/**
 * @return void
 */
function load_script_file()
{
    $parameters = get_option(SETTINGS_OPTION_NAME, [
        'restaurant_id' => '',
        'open_delay' => 3000,
        'position' => 'right',
    ]);

    if ($parameters['restaurant_id'] === '') {
        return;
    }

    wp_enqueue_script(
        'zenchef-widget-integration',
        plugins_url('../../js/main.js', __FILE__),
        [],
        '1.0.0',
        true
    );
}
