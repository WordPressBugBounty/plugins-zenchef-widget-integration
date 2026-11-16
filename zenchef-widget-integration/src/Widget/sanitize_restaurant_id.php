<?php

namespace Zenchef\Widget\Widget;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

use function preg_match;
use function trim;

/**
 * Trims and validates a restaurant ID against the two supported formats:
 *  - public ID (e.g. "rpid_CTF3YNH3"), the one restaurants should now use
 *  - legacy numeric ID (e.g. "367219"), still accepted for existing installs
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

    if (!is_numeric_restaurant_id($trimmed) && !is_restaurant_public_id($trimmed)) {
        return null;
    }

    return $trimmed;
}

/**
 * The booking app resolves only uppercase public IDs and the SDK passes the value
 * through untouched, so lowercase is rejected rather than silently uppercased.
 *
 * @param string $value
 * @return bool
 */
function is_restaurant_public_id($value)
{
    return preg_match('/^rpid_[0-9A-Z]{8}$/', $value) === 1;
}

/**
 * @param string $value
 * @return bool
 */
function is_numeric_restaurant_id($value)
{
    return preg_match('/^\d+$/', $value) === 1;
}

/**
 * Whether a rejected value is a public ID typed in the wrong case, so the settings
 * screen can say so instead of showing the generic error.
 *
 * @param string $value
 * @return bool
 */
function is_lowercase_restaurant_public_id($value)
{
    return !is_restaurant_public_id($value) && preg_match('/^rpid_[0-9A-Za-z]{8}$/', $value) === 1;
}
