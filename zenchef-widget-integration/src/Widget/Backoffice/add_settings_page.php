<?php

namespace Zenchef\Widget\Widget\Backoffice;

use function _x;
use function add_options_page;
use function add_settings_field;
use function add_settings_section;
use function array_merge;
use function Zenchef\Widget\Backoffice\resolve_field_type_template;
use function Zenchef\Widget\View\render;
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

    $sections = [
        'zenchef.widget.parameters_settings_section' => [
            'title' => _x('Widget parameters', 'widget.backoffice.settings_page.widget_parameters_section_title', 'zenchef-widget-integration'),
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
                'open_delay'=> [
                    'label' => _x('Open delay (in ms)', 'widget.backoffice.settings_page.open_input_label', 'zenchef-widget-integration'),
                    'type' => 'number',
                    'template_parameters' => [
                        'description' => _x('The delay in milliseconds before the widget opens automatically.', 'widget.backoffice.settings_page.open_input_description', 'zenchef-widget-integration'),
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
        ]
    ];

    /** @var array{
     *     restaurant_id: string,
     *     open_delay: int,
     *     position: "center"|"left"|"right",
     * } $current_settings_values
     */
    $current_settings_values = get_option(SETTINGS_OPTION_NAME, [
        'restaurant_id' => '',
        'open_delay' => 3000,
        'position' => 'right',
    ]);

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
                $field['template_parameters'],
                [
                    'id' => $id,
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
