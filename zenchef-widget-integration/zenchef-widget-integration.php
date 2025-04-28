<?php
/**
 * Plugin Name: Zenchef widget integration
 * Description: Easily integrates Zenchef widget into all pages of the site.
 * Version: 1.0.1
 * Author: Zenchef
 * Author URI: https://zenchef.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * PHP Version: 5.6
 * Text Domain: zenchef-widget-integration
 * Domain Path: /languages
 */

use function Zenchef\Widget\Widget\register_global_hooks;
use function Zenchef\Widget\Widget\Backoffice\register_backoffice_hooks;
use const Zenchef\Widget\ROOT_PATH;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

require_once __DIR__ . '/configuration.php';
require_once ROOT_PATH . 'src/register_global_hooks.php';
require_once ROOT_PATH . 'src/register_backoffice_hooks.php';

register_global_hooks();
register_backoffice_hooks();
