<?php
function black_hawk_solutions_customize_colors($wp_customize) {
    // Add Colors Section under the Theme Options Panel
    $wp_customize->add_section('black_hawk_solutions_color_options', array(
        'title'    => __('Colors', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel', // Associate this section with the Theme Options panel
        'priority' => 50,
    ));

    // Add settings and controls for each color variable
    $color_settings = [
        // Body and Section Text Colors
        'separator_body_section' => null,
        'bs_body_color' => [
            'label' => __('Body Text Color', 'black_hawk_solutions_theme'),
            'default' => '#212529',
        ],
        'section_text_color' => [
            'label' => __('Section Text Color', 'black_hawk_solutions_theme'),
            'default' => '#FFFFFF',
        ],

        // Separator: Default Link Colors
        'separator_link_colors' => null,
        'default_link_color' => [
            'label' => __('Default Link Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'default_hover_color' => [
            'label' => __('Default Hover Color', 'black_hawk_solutions_theme'),
            'default' => '#be4f00',
        ],
        'default_active_color' => [
            'label' => __('Default Active Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'default_disabled_color' => [
            'label' => __('Default Disabled Color', 'black_hawk_solutions_theme'),
            'default' => '#973f00',
        ],

        // Separator: Default Link Border Colors
        'separator_link_border_colors' => null,
        'default_link_border_color' => [
            'label' => __('Default Link Border Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'default_hover_border_color' => [
            'label' => __('Default Hover Border Color', 'black_hawk_solutions_theme'),
            'default' => '#be4f00',
        ],
        'default_active_border_color' => [
            'label' => __('Default Active Border Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'default_disabled_border_color' => [
            'label' => __('Default Disabled Border Color', 'black_hawk_solutions_theme'),
            'default' => '#753100',
        ],

        // Separator: Button Text Colors
        'separator_button_text_colors' => null,
        'bs_btn_color' => [
            'label' => __('Button Text Color', 'black_hawk_solutions_theme'),
            'default' => '#fff',
        ],
        'bs_btn_hover_color' => [
            'label' => __('Button Hover Text Color', 'black_hawk_solutions_theme'),
            'default' => '#fff',
        ],
        'bs_btn_active_color' => [
            'label' => __('Button Active Text Color', 'black_hawk_solutions_theme'),
            'default' => '#fff',
        ],
        'bs_btn_disabled_color' => [
            'label' => __('Button Disabled Text Color', 'black_hawk_solutions_theme'),
            'default' => '#fff',
        ],

        // Separator: Button Background Colors
        'separator_button_background_colors' => null,
        'bs_btn_bg' => [
            'label' => __('Button Background Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'bs_btn_hover_bg' => [
            'label' => __('Button Hover Background Color', 'black_hawk_solutions_theme'),
            'default' => '#be4f00',
        ],
        'bs_btn_active_bg' => [
            'label' => __('Button Active Background Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'bs_btn_disabled_bg' => [
            'label' => __('Button Disabled Background Color', 'black_hawk_solutions_theme'),
            'default' => '#973f00',
        ],

        // Separator: Button Border Colors
        'separator_button_border_colors' => null,
        'bs_btn_border_color' => [
            'label' => __('Button Border Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'bs_btn_hover_border_color' => [
            'label' => __('Button Hover Border Color', 'black_hawk_solutions_theme'),
            'default' => '#be4f00',
        ],
        'bs_btn_active_border_color' => [
            'label' => __('Button Active Border Color', 'black_hawk_solutions_theme'),
            'default' => '#FF6a00',
        ],
        'bs_btn_disabled_border_color' => [
            'label' => __('Button Disabled Border Color', 'black_hawk_solutions_theme'),
            'default' => '#973f00',
        ],
    ];

    foreach ($color_settings as $setting => $config) {
        if (strpos($setting, 'separator') === 0) {
            $wp_customize->add_setting($setting, array(
                'sanitize_callback' => 'wp_filter_nohtml_kses', // Sanitization (no HTML)
                'transport'         => 'refresh',
            ));

            $wp_customize->add_control(new WP_Customize_Control($wp_customize, $setting . '_control', array(
                'label'       => '', // No label
                'description' => '<hr style="border: 1px solid #ccc;"/>', // HTML for a horizontal rule
                'section'     => 'black_hawk_solutions_color_options',
                'settings'    => $setting,
                'type'        => 'hidden', // Hidden input type
            )));
            continue;
        }

        $sanitize_callback = (strpos($setting, 'rgb') !== false) ? 'sanitize_text_field' : 'sanitize_hex_color';

        $wp_customize->add_setting($setting, array(
            'default'           => $config['default'],
            'sanitize_callback' => $sanitize_callback,
            'transport'         => 'refresh',
        ));

        if ($sanitize_callback === 'sanitize_text_field') {
            $wp_customize->add_control($setting . '_control', array(
                'label'       => $config['label'],
                'section'     => 'black_hawk_solutions_color_options',
                'settings'    => $setting,
                'type'        => 'text',
                'description' => __('Enter CSS variable or value (e.g., var(--default-link-color))', 'black_hawk_solutions_theme'),
            ));
        } else {
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting . '_control', array(
                'label'       => $config['label'],
                'section'     => 'black_hawk_solutions_color_options',
                'settings'    => $setting,
            )));
        }
    }
}
add_action('customize_register', 'black_hawk_solutions_customize_colors');