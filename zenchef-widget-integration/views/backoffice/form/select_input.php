<?php if (!defined('WPINC')) { die; } ?>
<select id="<?php echo esc_attr($id) ?>" name="<?php echo esc_attr(\Zenchef\Widget\SETTINGS_OPTION_NAME) ?>[<?php echo esc_attr($id) ?>]">
    <?php foreach ($options as $option_value => $option_label): // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- render() includes this template inside a function, so these are function-scoped, not globals ?>
        <option value="<?php echo esc_attr($option_value) ?>"<?php echo selected($value, $option_value, false) ?>><?php echo esc_html($option_label) ?></option>
    <?php endforeach; ?>
</select>

<?php if($description !== ''): ?>
    <p class='description'><?php echo esc_html($description) ?></p>
<?php endif; ?>
