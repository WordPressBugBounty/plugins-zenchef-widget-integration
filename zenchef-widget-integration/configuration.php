<?php

namespace Zenchef\Widget;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

/** The key used to store settings data in database, and also used as HTML form name attribute. */
const SETTINGS_OPTION_NAME = 'zenchef_widget_parameters';

const SETTINGS_GROUP_SLUG = 'zenchef.widget.settings_group';

const ROOT_PATH = __DIR__ . '/';

/** Absolute path to the plugin bootstrap file, for APIs keyed on the plugin basename. */
const PLUGIN_FILE = __DIR__ . '/zenchef-widget-integration.php';
