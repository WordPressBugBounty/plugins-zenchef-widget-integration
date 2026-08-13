<?php

namespace Zenchef\Widget\Widget;

use function Zenchef\Widget\View\render;

/**
 * @return string
 */
function load_script_template_file()
{
    if (widget_shortcode_was_rendered()) {
        return '';
    }

    // Without this the configuration element would still be emitted when the SDK
    // has been suppressed, leaving dead markup on the page.
    if (!widget_should_load()) {
        return '';
    }

    $settings = get_widget_settings();

    return render(
        'main',
        [
            'restaurant_id'   => $settings['restaurant_id'],
            'data_attributes' => build_widget_data_attributes($settings),
        ]
    );
}
