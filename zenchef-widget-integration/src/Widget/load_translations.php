<?php

namespace Zenchef\Widget\Widget;

use function load_plugin_textdomain;
use const Zenchef\Widget\ROOT_PATH;

/**
 * @return void
 */
function load_translations()
{
    load_plugin_textdomain(
        'zenchef-widget-integration',
        false,
        ROOT_PATH . 'languages'
    );
}
