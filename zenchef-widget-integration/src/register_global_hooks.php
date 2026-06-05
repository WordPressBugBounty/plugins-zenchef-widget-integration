<?php

namespace Zenchef\Widget\Widget;

use function add_action;
use function Zenchef\Widget\Widget\load_script_file;
use function Zenchef\Widget\Widget\load_script_template_file;
use function Zenchef\Widget\Widget\register_widget_shortcode;
use const Zenchef\Widget\ROOT_PATH;

/**
 * @return void
 */
function register_global_hooks()
{
    require_once ROOT_PATH . 'src/View/render.php';
    require_once ROOT_PATH . 'src/Widget/sanitize_restaurant_id.php';
    require_once ROOT_PATH . 'src/Widget/sanitize_widget_settings.php';
    require_once ROOT_PATH . 'src/Widget/get_widget_settings.php';
    require_once ROOT_PATH . 'src/Widget/build_widget_data_attributes.php';
    require_once ROOT_PATH . 'src/Widget/load_translations.php';
    require_once ROOT_PATH . 'src/Widget/load_script_template_file.php';
    require_once ROOT_PATH . 'src/Widget/load_script_file.php';
    require_once ROOT_PATH . 'src/Widget/register_shortcode.php';

    add_action('init', 'Zenchef\Widget\Widget\load_translations');
    add_action('wp_footer', 'Zenchef\Widget\Widget\load_script_template_file');
    add_action('wp_enqueue_scripts', 'Zenchef\Widget\Widget\load_script_file');

    register_widget_shortcode();
}
