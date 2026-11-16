<?php

namespace Zenchef\Widget\Widget\Backoffice;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

use function delete_option;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

/**
 * @return void
 */
function remove_settings()
{
    delete_option(SETTINGS_OPTION_NAME);
}
