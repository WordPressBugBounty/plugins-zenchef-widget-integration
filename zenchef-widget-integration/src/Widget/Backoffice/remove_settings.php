<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function delete_option;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

/**
 * @return void
 */
function remove_settings()
{
    delete_option(SETTINGS_OPTION_NAME);
}
