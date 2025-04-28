<?php

namespace Zenchef\Widget\View;

use function extract;
use const Zenchef\Widget\ROOT_PATH;

/**
 * @param string $path
 * @param array<string, mixed> $variables
 * @return string
 */
function render($path, array $variables = [])
{
    extract($variables);

    return include ROOT_PATH . 'views/' . $path . '.phtml';
}
