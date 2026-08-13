<?php if (!defined('WPINC')) { die; } ?>
<label>
    <input
        type="checkbox"
        id="<?php echo $id ?>"
        name="<?php echo \Zenchef\Widget\SETTINGS_OPTION_NAME ?>[<?php echo $id ?>]"
        value="1"
        <?php checked($value, '1') ?>
    />
    <?php if (isset($checkbox_label) && $checkbox_label !== ''): ?>
        <?php echo $checkbox_label ?>
    <?php endif; ?>
</label>

<?php if ($description !== ''): ?>
    <p class='description'><?php echo $description ?></p>
<?php endif; ?>
