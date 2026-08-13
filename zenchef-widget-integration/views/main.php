<?php if (!defined('WPINC')) { die; } ?>
<?php if ($restaurant_id !== ''): ?>
<div class='zc-widget-config'
<?php foreach ($data_attributes as $name => $value): ?>
    <?php echo esc_attr($name) ?>="<?php echo esc_attr($value) ?>"
<?php endforeach; ?>
></div>
<?php endif; ?>
