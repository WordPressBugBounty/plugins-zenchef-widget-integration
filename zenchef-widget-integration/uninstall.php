<?php

use function Zenchef\Widget\uninstall_plugin;
use const Zenchef\Widget\ROOT_PATH;

if (!defined('WP_UNINSTALL_PLUGIN') || WP_UNINSTALL_PLUGIN !== 'zenchef-widget-integration/zenchef-widget-integration.php') {
    die;
}

require_once __DIR__ . '/configuration.php';
require_once ROOT_PATH . 'src/uninstall_plugin.php';

uninstall_plugin();
