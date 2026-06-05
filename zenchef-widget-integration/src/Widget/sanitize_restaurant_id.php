<?php

namespace Zenchef\Widget\Widget;

use function preg_match;
use function trim;

/**
 * Trims and validates a restaurant ID against the two supported formats:
 *  - legacy numeric ID (e.g. "367219")
 *  - new prefixed ID (e.g. "rpid_CTF3YNH3")
 *
 * Returns the trimmed value if valid or empty, or null if a non-empty value is invalid.
 *
 * @param mixed $value
 * @return string|null
 */
function sanitize_restaurant_id($value)
{
    $trimmed = trim((string) $value);

    if ($trimmed === '') {
        return '';
    }

    if (preg_match('/^(\d+|rpid_[A-Za-z0-9]+)$/', $trimmed) !== 1) {
        return null;
    }

    return $trimmed;
}
