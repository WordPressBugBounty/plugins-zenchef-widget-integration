<?php if (!defined('WPINC')) { die; } ?>
<input
    type="text"
    class="zc-color-picker"
    id="<?php echo $id ?>"
    name="<?php echo \Zenchef\Widget\SETTINGS_OPTION_NAME ?>[<?php echo $id ?>]"
    value="<?php echo esc_attr($value) ?>"
    data-default-color=""
/>

<?php if ($description !== ''): ?>
    <p class='description'><?php echo $description ?></p>
<?php endif; ?>
