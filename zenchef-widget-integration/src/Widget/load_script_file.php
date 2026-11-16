<?php

namespace Zenchef\Widget\Widget;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

/**
 * @return void
 */
function load_script_file()
{
    $settings = get_widget_settings();

    if ($settings['restaurant_id'] === '') {
        return;
    }

    enqueue_widget_sdk();
}
