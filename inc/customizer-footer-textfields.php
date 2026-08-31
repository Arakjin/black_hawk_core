<?php
function black_hawk_solutions_customize_footer_textfields($wp_customize)
{
    // Dropdown for number of text fields in Set 1
    $wp_customize->add_setting('footer_set1_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('footer_set1_count_control', array(
        'label'    => __('Number of Text Fields (Set 1)', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_set1_count',
        'type'     => 'select',
        'choices'  => array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
        ),
    ));

    $number_of_fields_set1 = get_theme_mod('footer_set1_count', 3);

    for ($i = 1; $i <= $number_of_fields_set1; $i++) {

        // Add a toggle setting (this will act as the state for the visibility toggle)
        $wp_customize->add_setting("footer_set1_toggleable_$i", array(
            'default'           => 'closed', // Default to 'closed'
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        // Add a custom button to toggle visibility
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_set1_toggle_control_$i", array(
            'section'     => 'black_hawk_solutions_footer_options',
            'type'        => 'hidden',
            'label'       => __("Field $i", 'black_hawk_solutions_theme'),
            'description' => '<strong style="cursor:pointer;" id="toggle-field-set1-' . $i . '" class="button">Toggle Field ' . $i . ' settings</strong>
                            <script>
                                jQuery(document).ready(function($) {
                                    $("#toggle-field-set1-' . $i . '").on("click", function() {
                                        var currentState = wp.customize("footer_set1_toggleable_' . $i . '").get();
                                        var newState = currentState === "open" ? "closed" : "open";
                                        wp.customize("footer_set1_toggleable_' . $i . '").set(newState);
                                    });
                                });
                            </script>',
            'settings'    => "footer_set1_toggleable_$i", 
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i;
            },
        )));

        // Icon Size (Font Awesome)
        $wp_customize->add_setting("footer_set1_icon_size_$i", array(
            'default'           => '1x',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set1_icon_size_control_$i", array(
            'label'    => __("Text Field $i Icon Size", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set1_icon_size_$i",
            'type'     => 'select',
            'choices'  => array(
                '1x' => 'Normal',
                '2x' => '2x',
                '3x' => '3x',
                '4x' => '4x',
                '5x' => '5x',
            ),
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i && get_theme_mod("footer_set1_toggleable_$i", 'open') === 'open';
            },
        ));

        // Icon selection (Font Awesome)
        $wp_customize->add_setting("footer_set1_icon_$i", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set1_icon_control_$i", array(
            'label'    => __("Text Field $i Icon (Font Awesome Class)", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set1_icon_$i",
            'type'     => 'text',
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i && get_theme_mod("footer_set1_toggleable_$i", 'open') === 'open';
            },
        ));

        // Header size selection (if applicable)
        $wp_customize->add_setting("footer_set1_header_$i", array(
            'default'           => 'h3',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set1_header_control_$i", array(
            'label'    => __("Text Field $i Header Size", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set1_header_$i",
            'type'     => 'select',
            'choices'  => array(
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
            ),
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i && get_theme_mod("footer_set1_toggleable_$i", 'open') === 'open';
            },
        ));

        // Text content for the field
        $wp_customize->add_setting("footer_set1_text_$i", array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set1_text_control_$i", array(
            'label'    => __("Text Field $i Content", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set1_text_$i",
            'type'     => 'textarea',
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i && get_theme_mod("footer_set1_toggleable_$i", 'open') === 'open';
            },
        ));

        // Link type selection
        $wp_customize->add_setting("footer_set1_link_type_$i", array(
            'default'           => 'none',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set1_link_type_control_$i", array(
            'label'    => __("Link Type for Text Field $i", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set1_link_type_$i",
            'type'     => 'select',
            'choices'  => array(
                'none' => 'None',
                'icon' => 'Icon',
                'text' => 'Text',
                'both' => 'Both',
            ),
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i && get_theme_mod("footer_set1_toggleable_$i", 'open') === 'open';
            },
        ));

        // Link for the field
        $wp_customize->add_setting("footer_set1_link_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set1_link_control_$i", array(
            'label'    => __("Text Field $i Link", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set1_link_$i",
            'type'     => 'url',
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set1_count', 3) >= $i && get_theme_mod("footer_set1_toggleable_$i", 'open') === 'open';
            },
        ));
    }

    // Dropdown for number of text fields in Set 2
    $wp_customize->add_setting('footer_set2_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('footer_set2_count_control', array(
        'label'    => __('Number of Text Fields (Set 2)', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_set2_count',
        'type'     => 'select',
        'choices'  => array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
        ),
    ));

    $number_of_fields_set2 = get_theme_mod('footer_set2_count', 3);

    for ($i = 1; $i <= $number_of_fields_set2; $i++) {
        // Add a toggle setting (this will act as the state for the visibility toggle)
        $wp_customize->add_setting("footer_set2_toggleable_$i", array(
            'default'           => 'closed', // Default to 'closed'
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
    
        // Add a custom button to toggle visibility
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_set2_toggle_control_$i", array(
            'section'     => 'black_hawk_solutions_footer_options',
            'type'        => 'hidden',
            'label'       => __("Field $i", 'black_hawk_solutions_theme'),
            'description' => '<strong style="cursor:pointer;" id="toggle-field-set2-' . $i . '" class="button">Toggle Field ' . $i . ' settings</strong>
                              <script>
                                  jQuery(document).ready(function($) {
                                      $("#toggle-field-set2-' . $i . '").on("click", function() {
                                          var currentState = wp.customize("footer_set2_toggleable_' . $i . '").get();
                                          var newState = currentState === "open" ? "closed" : "open";
                                          wp.customize("footer_set2_toggleable_' . $i . '").set(newState);
                                      });
                                  });
                              </script>',
            'settings'    => "footer_set2_toggleable_$i", 
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i;
            },
        )));
    
        // Icon Size (Font Awesome)
        $wp_customize->add_setting("footer_set2_icon_size_$i", array(
            'default'           => '1x',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set2_icon_size_control_$i", array(
            'label'    => __("Text Field $i Icon Size", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set2_icon_size_$i",
            'type'     => 'select',
            'choices'  => array(
                '1x' => 'Normal',
                '2x' => '2x',
                '3x' => '3x',
                '4x' => '4x',
                '5x' => '5x',
            ),
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i && get_theme_mod("footer_set2_toggleable_$i", 'open') === 'open';
            },
        ));
    
        // Icon selection (Font Awesome)
        $wp_customize->add_setting("footer_set2_icon_$i", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set2_icon_control_$i", array(
            'label'    => __("Text Field $i Icon (Font Awesome Class)", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set2_icon_$i",
            'type'     => 'text',
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i && get_theme_mod("footer_set2_toggleable_$i", 'open') === 'open';
            },
        ));
    
        // Header size selection (if applicable)
        $wp_customize->add_setting("footer_set2_header_$i", array(
            'default'           => 'h3',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set2_header_control_$i", array(
            'label'    => __("Text Field $i Header Size", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set2_header_$i",
            'type'     => 'select',
            'choices'  => array(
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
            ),
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i && get_theme_mod("footer_set2_toggleable_$i", 'open') === 'open';
            },
        ));
    
        // Text content for the field
        $wp_customize->add_setting("footer_set2_text_$i", array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set2_text_control_$i", array(
            'label'    => __("Text Field $i Content", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set2_text_$i",
            'type'     => 'textarea',
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i && get_theme_mod("footer_set2_toggleable_$i", 'open') === 'open';
            },
        ));
    
        // Link type selection
        $wp_customize->add_setting("footer_set2_link_type_$i", array(
            'default'           => 'none',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set2_link_type_control_$i", array(
            'label'    => __("Link Type for Text Field $i", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set2_link_type_$i",
            'type'     => 'select',
            'choices'  => array(
                'none' => 'None',
                'icon' => 'Icon',
                'text' => 'Text',
                'both' => 'Both',
            ),
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i && get_theme_mod("footer_set2_toggleable_$i", 'open') === 'open';
            },
        ));
    
        // Link for the field
        $wp_customize->add_setting("footer_set2_link_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("footer_set2_link_control_$i", array(
            'label'    => __("Text Field $i Link", 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_footer_options',
            'settings' => "footer_set2_link_$i",
            'type'     => 'url',
            'active_callback' => function () use ($i) {
                return get_theme_mod('footer_set2_count', 3) >= $i && get_theme_mod("footer_set2_toggleable_$i", 'open') === 'open';
            },
        ));
    }
    
}

add_action('customize_register', 'black_hawk_solutions_customize_footer_textfields');
