<?php

namespace Zenchef\Widget;

use function Zenchef\Widget\Widget\Backoffice\remove_settings;

/**
 * @return void
 */
function uninstall_plugin()
{
    require_once ROOT_PATH . 'src/Widget/Backoffice/remove_settings.php';

    remove_settings();
}
