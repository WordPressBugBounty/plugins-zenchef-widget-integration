<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function register_setting;
use const Zenchef\Widget\SETTINGS_GROUP_SLUG;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

/**
 * @return void
 */
function register_settings()
{
    register_setting(SETTINGS_GROUP_SLUG, SETTINGS_OPTION_NAME);
}
