<?php if (!defined('WPINC')) { die; } ?>
<input
    type="text"
    id="<?php echo esc_attr($id) ?>"
    name="<?php echo esc_attr(\Zenchef\Widget\SETTINGS_OPTION_NAME) ?>[<?php echo esc_attr($id) ?>]"
    value="<?php echo esc_attr($value) ?>"
/>

<?php if($description !== ''): ?>
    <p class='description'><?php echo esc_html($description) ?></p>
<?php endif; ?>
