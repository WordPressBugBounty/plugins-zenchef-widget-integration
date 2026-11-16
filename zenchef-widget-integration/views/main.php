<?php if (!defined('WPINC')) { die; } ?>
<?php if ($restaurant_id !== ''): ?>
<div class='zc-widget-config'
<?php foreach ($data_attributes as $name => $value): // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- render() includes this template inside a function, so these are function-scoped, not globals ?>
    <?php echo esc_attr($name) ?>="<?php echo esc_attr($value) ?>"
<?php endforeach; ?>
></div>
<?php endif; ?>
