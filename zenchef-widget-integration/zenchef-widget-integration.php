<?php
/**
 * Plugin Name: Zenchef widget integration
 * Description: Easily integrates Zenchef widget into all pages of the site.
 * Version: 1.3.0
 * Requires at least: 4.6
 * Requires PHP: 7.4
 * Author: Zenchef
 * Author URI: https://zenchef.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
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
