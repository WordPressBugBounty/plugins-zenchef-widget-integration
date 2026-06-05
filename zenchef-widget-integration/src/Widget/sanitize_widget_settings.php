<?php

namespace Zenchef\Widget\Widget;

use function in_array;
use function max;
use function preg_match;
use function trim;

const SUPPORTED_LANGUAGES = ['en', 'es', 'it', 'de', 'fr', 'pt', 'nl'];
const SUPPORTED_POSITIONS = ['left', 'center', 'right'];

/**
 * Normalises a language code: accepts only SDK-supported values, anything else
 * is treated as "no preference" (empty).
 *
 * @param mixed $value
 * @return string
 */
function sanitize_language($value)
{
    $trimmed = trim((string) $value);

    if ($trimmed === '' || !in_array($trimmed, SUPPORTED_LANGUAGES, true)) {
        return '';
    }

    return $trimmed;
}

/**
 * Validates a 6-digit hex color. Empty or invalid returns ''.
 *
 * @param mixed $value
 * @return string
 */
function sanitize_primary_color($value)
{
    $trimmed = trim((string) $value);

    if ($trimmed === '' || preg_match('/^#[A-Fa-f0-9]{6}$/', $trimmed) !== 1) {
        return '';
    }

    return $trimmed;
}

/**
 * Whitelists position; defaults to 'right' when invalid (matches SDK default).
 *
 * @param mixed $value
 * @return string
 */
function sanitize_position($value)
{
    $trimmed = trim((string) $value);

    if (!in_array($trimmed, SUPPORTED_POSITIONS, true)) {
        return 'right';
    }

    return $trimmed;
}

/**
 * Coerces a boolean-ish value to '1' (true) or '0' (false). Unchecked checkboxes
 * are absent from $_POST so missing/empty input becomes '0'.
 *
 * @param mixed $value
 * @return string
 */
function sanitize_boolean($value)
{
    return !empty($value) && $value !== '0' ? '1' : '0';
}

/**
 * Casts an open delay to a non-negative integer.
 *
 * @param mixed $value
 * @return int
 */
function sanitize_open_delay($value)
{
    return max(0, (int) $value);
}
