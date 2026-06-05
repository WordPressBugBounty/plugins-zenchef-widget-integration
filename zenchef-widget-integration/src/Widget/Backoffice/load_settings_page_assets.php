<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function wp_add_inline_script;
use function wp_enqueue_script;
use function wp_enqueue_style;

const SETTINGS_PAGE_HOOK_SUFFIX = 'settings_page_zenchef.widget.settings_page';

/**
 * @param string $hook_suffix
 * @return void
 */
function load_settings_page_assets($hook_suffix)
{
    if ($hook_suffix !== SETTINGS_PAGE_HOOK_SUFFIX) {
        return;
    }

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    $inline_js = <<<'JS'
jQuery(function ($) {
    var $defaultToggle = $('#use_default_color');
    var $colorField = $('.zc-color-picker');

    if ($colorField.length === 0) {
        return;
    }

    $colorField.wpColorPicker({
        change: function () {},
        clear: function () {}
    });

    function syncPickerState() {
        var useDefault = $defaultToggle.is(':checked');
        var $wrap = $colorField.closest('.wp-picker-container');
        // Disable inputs + the toggle button so the picker is non-interactive
        $wrap.find('input, button').prop('disabled', useDefault);
        $wrap.toggleClass('zc-color-picker--disabled', useDefault);
    }

    if ($defaultToggle.length) {
        syncPickerState();
        $defaultToggle.on('change', syncPickerState);
    }
});
JS;

    wp_add_inline_script('wp-color-picker', $inline_js);
}
