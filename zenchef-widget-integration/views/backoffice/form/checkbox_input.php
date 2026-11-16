<?php if (!defined('WPINC')) { die; } ?>
<label>
    <input
        type="checkbox"
        id="<?php echo esc_attr($id) ?>"
        name="<?php echo esc_attr(\Zenchef\Widget\SETTINGS_OPTION_NAME) ?>[<?php echo esc_attr($id) ?>]"
        value="1"
        <?php checked($value, '1') ?>
    />
    <?php if (isset($checkbox_label) && $checkbox_label !== ''): ?>
        <?php echo esc_html($checkbox_label) ?>
    <?php endif; ?>
</label>

<?php if ($description !== ''): ?>
    <p class='description'><?php echo esc_html($description) ?></p>
<?php endif; ?>
