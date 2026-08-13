<?php

namespace Zenchef\Widget\View;

use function extract;
use const Zenchef\Widget\ROOT_PATH;

/**
 * Templates carry a .php extension rather than .phtml because `wp i18n make-pot`
 * only parses *.php. Under .phtml the translatable strings inside them never
 * reached translate.wordpress.org, so no locale could translate them.
 *
 * @param string $path
 * @param array<string, mixed> $variables
 * @return string
 */
function render($path, array $variables = [])
{
    extract($variables);

    return include ROOT_PATH . 'views/' . $path . '.php';
}
