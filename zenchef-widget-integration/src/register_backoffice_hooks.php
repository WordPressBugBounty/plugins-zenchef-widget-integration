<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function add_action;
use function Zenchef\Widget\Widget\Backoffice\add_settings_page;
use function Zenchef\Widget\Widget\Backoffice\load_settings_page_assets;
use function Zenchef\Widget\Widget\Backoffice\register_settings;
use const Zenchef\Widget\ROOT_PATH;

/**
 * @return void
 */
function register_backoffice_hooks()
{
    require_once ROOT_PATH . 'src/Backoffice/resolve_field_type_template.php';
    require_once ROOT_PATH . 'src/Widget/Backoffice/add_settings_page.php';
    require_once ROOT_PATH . 'src/Widget/Backoffice/register_settings.php';
    require_once ROOT_PATH . 'src/Widget/Backoffice/load_settings_page_assets.php';

    add_action('admin_init', 'Zenchef\Widget\Widget\Backoffice\register_settings');
    add_action('admin_menu', 'Zenchef\Widget\Widget\Backoffice\add_settings_page');
    add_action('admin_enqueue_scripts', 'Zenchef\Widget\Widget\Backoffice\load_settings_page_assets');
}
