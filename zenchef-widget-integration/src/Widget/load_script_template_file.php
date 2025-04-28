<?php

namespace Zenchef\Widget\Widget;

use function get_option;
use function Zenchef\Widget\View\render;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

/**
 * @return string
 */
function load_script_template_file()
{
    /** @var array{
     *     restaurant_id: string,
     *     open_delay: int,
     *     position: "center"|"left"|"right",
     * } $parameters
     */
    $parameters = get_option(SETTINGS_OPTION_NAME, [
        'restaurant_id' => '',
        'open_delay' => 3000,
        'position' => 'right',
    ]);

    return render(
        'main',
        [
            'restaurant_id' => $parameters['restaurant_id'],
            'open_delay' => $parameters['open_delay'],
            'position' => $parameters['position'],
        ]
    );
}
