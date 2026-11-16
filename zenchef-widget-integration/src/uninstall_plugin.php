<?php

namespace Zenchef\Widget;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

use function Zenchef\Widget\Widget\Backoffice\remove_settings;

/**
 * @return void
 */
function uninstall_plugin()
{
    require_once ROOT_PATH . 'src/Widget/Backoffice/remove_settings.php';

    remove_settings();
}
