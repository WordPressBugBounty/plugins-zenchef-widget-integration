<?php if (!defined('WPINC')) { die; } ?>
<div class="wrap">
    <h2><?php echo _x('Zenchef widget settings', 'widget.backoffice.settings_page.title', 'zenchef-widget-integration') ?></h2>
    <form action="options.php" method="POST">
        <?php settings_fields($settings_group_slug); ?>
        <?php do_settings_sections($page_slug) ?>
        <?php submit_button() ?>
    </form>

    <div class="card" style="max-width: 800px;">
        <h2><?php echo _x('Per-page shortcode', 'widget.backoffice.settings_page.shortcode_section_title', 'zenchef-widget-integration') ?></h2>
        <p>
            <?php echo _x('Drop the shortcode into any post or page to render the widget inline. Without attributes, it uses the settings above:', 'widget.backoffice.settings_page.shortcode_intro', 'zenchef-widget-integration') ?>
        </p>
        <p><code>[zenchef_widget]</code></p>
        <p>
            <?php echo _x('Every setting above can be overridden per-page. Useful for sites managing several restaurants or for landing pages with custom styling:', 'widget.backoffice.settings_page.shortcode_overrides_intro', 'zenchef-widget-integration') ?>
        </p>
        <p><code>[zenchef_widget restaurant_id="367219" language="fr" primary_color="#cc0000" position="center" auto_open="0" hide_button="1"]</code></p>

        <h3><?php echo _x('Available attributes', 'widget.backoffice.settings_page.shortcode_attributes_title', 'zenchef-widget-integration') ?></h3>
        <table class="widefat striped" style="max-width: 760px;">
            <thead>
                <tr>
                    <th style="width: 30%;"><?php echo _x('Attribute', 'widget.backoffice.settings_page.shortcode_table.attribute_header', 'zenchef-widget-integration') ?></th>
                    <th><?php echo _x('Accepted values', 'widget.backoffice.settings_page.shortcode_table.values_header', 'zenchef-widget-integration') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr><td><code>restaurant_id</code></td><td><?php echo _x('Your Zenchef restaurant ID. Falls back to the value set above.', 'widget.backoffice.settings_page.shortcode_table.restaurant_id', 'zenchef-widget-integration') ?></td></tr>
                <tr><td><code>language</code></td><td><code>en</code>, <code>fr</code>, <code>es</code>, <code>it</code>, <code>de</code>, <code>pt</code>, <code>nl</code></td></tr>
                <tr><td><code>primary_color</code></td><td><?php echo _x('Hex colour, e.g.', 'widget.backoffice.settings_page.shortcode_table.primary_color_prefix', 'zenchef-widget-integration') ?> <code>#cc0000</code> (<?php echo _x('only applied when', 'widget.backoffice.settings_page.shortcode_table.primary_color_condition', 'zenchef-widget-integration') ?> <code>use_default_color="0"</code>)</td></tr>
                <tr><td><code>use_default_color</code></td><td><code>1</code> (<?php echo _x('use Zenchef OS colour', 'widget.backoffice.settings_page.shortcode_table.use_default_color_on', 'zenchef-widget-integration') ?>) <?php echo _x('or', 'widget.backoffice.settings_page.shortcode_table.or', 'zenchef-widget-integration') ?> <code>0</code> (<?php echo _x('use the primary_color above', 'widget.backoffice.settings_page.shortcode_table.use_default_color_off', 'zenchef-widget-integration') ?>)</td></tr>
                <tr><td><code>position</code></td><td><code>left</code>, <code>center</code>, <code>right</code></td></tr>
                <tr><td><code>auto_open</code></td><td><code>1</code> (<?php echo _x('open automatically', 'widget.backoffice.settings_page.shortcode_table.auto_open_on', 'zenchef-widget-integration') ?>) <?php echo _x('or', 'widget.backoffice.settings_page.shortcode_table.or', 'zenchef-widget-integration') ?> <code>0</code> (<?php echo _x('only on click', 'widget.backoffice.settings_page.shortcode_table.auto_open_off', 'zenchef-widget-integration') ?>)</td></tr>
                <tr><td><code>open_delay</code></td><td><?php echo _x('Delay in milliseconds before auto-opening. Only applies when', 'widget.backoffice.settings_page.shortcode_table.open_delay', 'zenchef-widget-integration') ?> <code>auto_open="1"</code></td></tr>
                <tr><td><code>hide_button</code></td><td><code>1</code> (<?php echo _x('hide the floating button', 'widget.backoffice.settings_page.shortcode_table.hide_button_on', 'zenchef-widget-integration') ?>) <?php echo _x('or', 'widget.backoffice.settings_page.shortcode_table.or', 'zenchef-widget-integration') ?> <code>0</code></td></tr>
                <tr><td><code>disable_gtm</code></td><td><code>1</code> <?php echo _x('or', 'widget.backoffice.settings_page.shortcode_table.or', 'zenchef-widget-integration') ?> <code>0</code></td></tr>
                <tr><td><code>disable_ga4</code></td><td><code>1</code> <?php echo _x('or', 'widget.backoffice.settings_page.shortcode_table.or', 'zenchef-widget-integration') ?> <code>0</code></td></tr>
            </tbody>
        </table>

        <h3><?php echo _x('Triggering the widget from a custom button', 'widget.backoffice.settings_page.custom_button_title', 'zenchef-widget-integration') ?></h3>
        <p>
            <?php echo _x('The widget can be opened from any clickable element on the page (Elementor button, Gutenberg button, custom HTML, etc.) using one of the three SDK-native methods:', 'widget.backoffice.settings_page.custom_button_intro', 'zenchef-widget-integration') ?>
        </p>
        <ul style="list-style: disc; padding-left: 1.5em;">
            <li><code>&lt;button data-zc-action="open"&gt;Book a table&lt;/button&gt;</code></li>
            <li><code>&lt;a href="#zc-action-open"&gt;Book a table&lt;/a&gt;</code></li>
            <li><code>ZenchefWidget.open()</code> / <code>.close()</code> / <code>.toggle()</code></li>
        </ul>

        <p class="description">
            <?php echo _x('Tip: in the Gutenberg block editor, insert the shortcode in a "Shortcode" block (Add Block / Shortcode) rather than a Paragraph block, so that quote characters are not auto-formatted.', 'widget.backoffice.settings_page.shortcode_gutenberg_tip', 'zenchef-widget-integration') ?>
        </p>
    </div>
</div>
