<?php

namespace Zenchef\Widget\Backoffice;

use function array_key_exists;

const TYPE_TEMPLATE = [
    'text' => 'backoffice/form/text_input',
    'number' => 'backoffice/form/number_input',
    'select' => 'backoffice/form/select_input',
];

/**
 * @param string $type
 * @return string
 */
function resolve_field_type_template($type)
{
    if (!array_key_exists($type, TYPE_TEMPLATE)) {
        $type = 'text';
    }

    return TYPE_TEMPLATE[$type];
}
