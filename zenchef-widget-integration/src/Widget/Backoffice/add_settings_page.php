<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function _x;
use function add_options_page;
use function add_settings_field;
use function add_settings_section;
use function array_merge;
use function Zenchef\Widget\Backoffice\resolve_field_type_template;
use function Zenchef\Widget\View\render;
use function Zenchef\Widget\Widget\get_widget_settings;
use const Zenchef\Widget\SETTINGS_GROUP_SLUG;
use const Zenchef\Widget\SETTINGS_OPTION_NAME;

/**
 * @return void
 */
function add_settings_page()
{
    $page_slug = 'zenchef.widget.settings_page';

    add_options_page(
        _x('Zenchef widget settings', 'widget.backoffice.settings_page.title', 'zenchef-widget-integration'),
        _x('Zenchef widget', 'widget.backoffice.settings_page.menu_label', 'zenchef-widget-integration'),
        'manage_options',
        $page_slug,
        static function () use ($page_slug) {
            return render('backoffice/settings_page', [
                'settings_group_slug' => SETTINGS_GROUP_SLUG,
                'page_slug' => $page_slug,
            ]);
        }
    );

    $sections = build_settings_sections();
    $current_settings_values = get_widget_settings();

    foreach ($sections as $section_id => $section) {

        add_settings_section(
            $section_id,
            $section['title'],
            static function () {},
            $page_slug
        );

        foreach ($section['fields'] as $id => $field) {
            $template = resolve_field_type_template($field['type']);

            $template_parameters = array_merge(
                ['description' => '', 'checkbox_label' => ''],
                $field['template_parameters'],
                [
                    'id'    => $id,
                    'value' => $current_settings_values[$id],
                ]
            );

            add_settings_field(
                $id,
                $field['label'],
                static function () use ($template, $template_parameters) {
                    return render($template, $template_parameters);
                },
                $page_slug,
                $section_id
            );
        }
    }
}

/**
 * @return array
 */
function build_settings_sections()
{
    return [
        'zenchef.widget.restaurant_section' => [
            'title' => _x('Restaurant', 'widget.backoffice.settings_page.restaurant_section_title', 'zenchef-widget-integration'),
            'fields' => [
                'restaurant_id' => [
                    'label' => _x('Restaurant ID', 'widget.backoffice.settings_page.restaurant_input_label', 'zenchef-widget-integration'),
                    'type' => 'text',
                    'template_parameters' => [
                        'description' => _x(
                            'ID of your Zenchef restaurant. You can find this ID in the Zenchef dashboard.',
                            'widget.backoffice.settings_page.restaurant_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
                'language' => [
                    'label' => _x('Language', 'widget.backoffice.settings_page.language_input_label', 'zenchef-widget-integration'),
                    'type' => 'select',
                    'template_parameters' => [
                        'description' => _x(
                            'Force a language for the booking widget. Leave on "Use Zenchef OS default" to follow the restaurant\'s configured language.',
                            'widget.backoffice.settings_page.language_input_description',
                            'zenchef-widget-integration'
                        ),
                        'options' => [
                            ''   => _x('Use Zenchef OS default', 'widget.backoffice.settings_page.language.default_option_label', 'zenchef-widget-integration'),
                            'en' => 'English',
                            'fr' => 'Français',
                            'es' => 'Español',
                            'it' => 'Italiano',
                            'de' => 'Deutsch',
                            'pt' => 'Português',
                            'nl' => 'Nederlands',
                        ],
                    ],
                ],
            ],
        ],
        'zenchef.widget.appearance_section' => [
            'title' => _x('Appearance', 'widget.backoffice.settings_page.appearance_section_title', 'zenchef-widget-integration'),
            'fields' => [
                'use_default_color' => [
                    'label' => _x('Brand colour', 'widget.backoffice.settings_page.use_default_color_input_label', 'zenchef-widget-integration'),
                    'type' => 'checkbox',
                    'template_parameters' => [
                        'checkbox_label' => _x('Use the brand colour set in Zenchef OS', 'widget.backoffice.settings_page.use_default_color_checkbox_label', 'zenchef-widget-integration'),
                        'description' => _x(
                            'When unchecked, the colour selected below overrides the colour set in your Zenchef OS dashboard.',
                            'widget.backoffice.settings_page.use_default_color_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
                'primary_color' => [
                    'label' => _x('Custom colour', 'widget.backoffice.settings_page.primary_color_input_label', 'zenchef-widget-integration'),
                    'type' => 'color',
                    'template_parameters' => [
                        'description' => _x(
                            'Hex colour used for the booking widget\'s primary buttons and accents (only applied when "Use the brand colour set in Zenchef OS" is unchecked).',
                            'widget.backoffice.settings_page.primary_color_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
                'position' => [
                    'label' => _x('Widget position', 'widget.backoffice.settings_page.widget_position_input_label', 'zenchef-widget-integration'),
                    'type' => 'select',
                    'template_parameters' => [
                        'description' => _x('Select the position of the widget on the page.', 'widget.backoffice.settings_page.widget_position_input_description', 'zenchef-widget-integration'),
                        'options' => [
                            'center' => _x('Center', 'widget.backoffice.settings_page.widget_position.center_option_label', 'zenchef-widget-integration'),
                            'left' => _x('Left', 'widget.backoffice.settings_page.widget_position.left_option_label', 'zenchef-widget-integration'),
                            'right' => _x('Right', 'widget.backoffice.settings_page.widget_position.right_option_label', 'zenchef-widget-integration'),
                        ],
                    ],
                ],
            ],
        ],
        'zenchef.widget.behaviour_section' => [
            'title' => _x('Behaviour', 'widget.backoffice.settings_page.behaviour_section_title', 'zenchef-widget-integration'),
            'fields' => [
                'auto_open' => [
                    'label' => _x('Auto-open', 'widget.backoffice.settings_page.auto_open_input_label', 'zenchef-widget-integration'),
                    'type' => 'checkbox',
                    'template_parameters' => [
                        'checkbox_label' => _x('Open the booking widget automatically when the page loads', 'widget.backoffice.settings_page.auto_open_checkbox_label', 'zenchef-widget-integration'),
                        'description' => _x(
                            'When disabled, the widget only opens when the visitor clicks the floating button or any element that triggers it (e.g. a button with data-zc-action="open").',
                            'widget.backoffice.settings_page.auto_open_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
                'open_delay' => [
                    'label' => _x('Open delay (in ms)', 'widget.backoffice.settings_page.open_input_label', 'zenchef-widget-integration'),
                    'type' => 'number',
                    'template_parameters' => [
                        'description' => _x('The delay in milliseconds before the widget opens automatically. Only applies when auto-open is enabled.', 'widget.backoffice.settings_page.open_input_description', 'zenchef-widget-integration'),
                    ],
                ],
                'hide_button' => [
                    'label' => _x('Floating button', 'widget.backoffice.settings_page.hide_button_input_label', 'zenchef-widget-integration'),
                    'type' => 'checkbox',
                    'template_parameters' => [
                        'checkbox_label' => _x('Hide the default floating booking button', 'widget.backoffice.settings_page.hide_button_checkbox_label', 'zenchef-widget-integration'),
                        'description' => _x(
                            'Useful when you trigger the widget from your own buttons (e.g. an Elementor button with data-zc-action="open") and don\'t want the default floating button.',
                            'widget.backoffice.settings_page.hide_button_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
            ],
        ],
        'zenchef.widget.analytics_section' => [
            'title' => _x('Analytics', 'widget.backoffice.settings_page.analytics_section_title', 'zenchef-widget-integration'),
            'fields' => [
                'disable_gtm' => [
                    'label' => _x('Google Tag Manager', 'widget.backoffice.settings_page.disable_gtm_input_label', 'zenchef-widget-integration'),
                    'type' => 'checkbox',
                    'template_parameters' => [
                        'checkbox_label' => _x('Disable the widget\'s GTM integration', 'widget.backoffice.settings_page.disable_gtm_checkbox_label', 'zenchef-widget-integration'),
                        'description' => _x(
                            'Enable this if your site already tracks bookings through its own GTM container and you want to avoid duplicate events.',
                            'widget.backoffice.settings_page.disable_gtm_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
                'disable_ga4' => [
                    'label' => _x('Google Analytics 4', 'widget.backoffice.settings_page.disable_ga4_input_label', 'zenchef-widget-integration'),
                    'type' => 'checkbox',
                    'template_parameters' => [
                        'checkbox_label' => _x('Disable the widget\'s GA4 integration', 'widget.backoffice.settings_page.disable_ga4_checkbox_label', 'zenchef-widget-integration'),
                        'description' => _x(
                            'Enable this if your site already sends booking events to GA4 and you want to avoid duplicate events.',
                            'widget.backoffice.settings_page.disable_ga4_input_description',
                            'zenchef-widget-integration'
                        ),
                    ],
                ],
            ],
        ],
    ];
}
