<?php

namespace Zenchef\Widget\Widget;

// Prevent unsecure access to this file.
if (!defined('WPINC')) {
    die;
}

use function apply_filters;
use function determine_locale;
use function dirname;
use function function_exists;
use function get_locale;
use function glob;
use function is_file;
use function load_plugin_textdomain;
use function load_textdomain;
use function plugin_basename;
use function sort;
use function strtok;
use const Zenchef\Widget\PLUGIN_FILE;
use const Zenchef\Widget\ROOT_PATH;

const TEXT_DOMAIN = 'zenchef-widget-integration';

/**
 * Loads the translations the plugin ships in languages/, ahead of any
 * translate.wordpress.org language pack.
 *
 * WordPress looks in wp-content/languages/plugins/ first and only falls back to
 * the plugin's own directory when no pack exists there. The packs it finds there
 * are community translations that covered 13 of the 60 strings when we started
 * bundling our own, so leaving WordPress to choose would show a mostly English
 * settings page to exactly the sites a bundled file is meant for. Loading the
 * bundled file directly marks the domain as loaded, so the just-in-time loader
 * never reaches the pack.
 *
 * A locale with no bundled file of its own borrows one for the same language
 * (es_MX gets es_ES, de_DE_formal gets de_DE), because WordPress does not fall
 * back between regional variants and would otherwise show English. A language we
 * do not ship at all is left to WordPress, so community packs still apply there.
 *
 * @return void
 */
function load_translations()
{
    // determine_locale() is WordPress 5.0+, and it is what core resolves a plugin's
    // locale with: the admin user's own language in wp-admin, the site's elsewhere.
    $locale = function_exists('determine_locale') ? determine_locale() : get_locale();
    /** This filter is documented in wp-includes/l10n.php */
    $locale = apply_filters('plugin_locale', $locale, TEXT_DOMAIN); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core's own filter, applied as load_plugin_textdomain() does.
    $mofile = find_bundled_translation($locale);

    if ($mofile !== null) {
        load_textdomain(TEXT_DOMAIN, $mofile, $locale);
        return;
    }

    // Relative to WP_PLUGIN_DIR: WordPress prefixes this argument with it, so an
    // absolute path here resolves to a directory that does not exist.
    load_plugin_textdomain(TEXT_DOMAIN, false, dirname(plugin_basename(PLUGIN_FILE)) . '/languages');
}

/**
 * The bundled .mo for a locale: its own if shipped, otherwise the one shipped for
 * its language, otherwise null.
 *
 * @param string $locale
 * @return string|null
 */
function find_bundled_translation($locale)
{
    $prefix = ROOT_PATH . 'languages/' . TEXT_DOMAIN . '-';

    if (is_file($prefix . $locale . '.mo')) {
        return $prefix . $locale . '.mo';
    }

    $language   = strtok($locale, '_');
    $candidates = glob($prefix . $language . '_*.mo') ?: [];
    sort($candidates);

    return $candidates[0] ?? null;
}
