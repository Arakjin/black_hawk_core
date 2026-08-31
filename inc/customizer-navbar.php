<?php
function black_hawk_solutions_customize_navbar($wp_customize)
{
    // Add Navbar Section under the Theme Options Panel
    $wp_customize->add_section('black_hawk_solutions_navbar_options', array(
        'title'    => __('Navbar', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel', // Associate this section with the Theme Options panel
        'priority' => 40,
    ));

    // Fixed Navbar Setting
    $wp_customize->add_setting('set_fixed_navbar', array(
        'default'           => true, // Default to fixed navbar
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('set_fixed_navbar_control', array(
        'label'    => __('Set navbar as fixed on top', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_navbar_options',
        'settings' => 'set_fixed_navbar',
        'type'     => 'checkbox', // Checkbox for true/false
    ));

    // Navbar Background Setting
    $wp_customize->add_setting('navbar_background', array(
        'default'           => 'rgba(0, 0, 0, 1)', // Default navbar background
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_background_control', array(
        'label'       => __('Navbar Background', 'black_hawk_solutions_theme'),
        'description' => __('Enter a valid CSS background value for the navbar.', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_background',
        'type'        => 'text', // Text field for CSS
    ));

    // Navbar Shrink Background Setting
    $wp_customize->add_setting('navbar_shrink_background', array(
        'default'           => 'rgba(0, 0, 0, 0.8)', // Default navbar-shrink background
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_shrink_background_control', array(
        'label'       => __('Navbar Shrink Background', 'black_hawk_solutions_theme'),
        'description' => __('Enter a valid CSS background value for the navbar when it shrinks.', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_shrink_background',
        'type'        => 'text', // Text field for CSS
    ));

    // Navbar Logo Size Setting (accepts full CSS values)
    $wp_customize->add_setting('navbar_logo_size', array(
        'default'           => '2em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_logo_size_control', array(
        'label'       => __('Navbar Logo Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_logo_size',
        'type'        => 'text',
    ));
    // Navbar Heading Size Setting (accepts full CSS values)
    $wp_customize->add_setting('navbar_heading_size', array(
        'default'           => '2em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_heading_size_control', array(
        'label'       => __('Navbar Heading Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_heading_size',
        'type'        => 'text',
    ));

    // Navbar Subheading Size Setting (accepts full CSS values)
    $wp_customize->add_setting('navbar_subheading_size', array(
        'default'           => '1.5em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_subheading_size_control', array(
        'label'       => __('Navbar Subheading Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_subheading_size',
        'type'        => 'text',
    ));

    // Navbar Gap Setting (accepts full CSS values)
    $wp_customize->add_setting('navbar_gap_size', array(
        'default'           => '2em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_gap_size_control', array(
        'label'       => __('Navbar Gap Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_gap_size',
        'type'        => 'text',
    ));

    // Navbar Shrink Ratio Setting (percentage) - controls logo, heading, and subheading
    $wp_customize->add_setting('navbar_shrink_ratio', array(
        'default'           => '75',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('navbar_shrink_ratio_control', array(
        'label'       => __('Navbar Shrink Ratio (%)', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_shrink_ratio',
        'type'        => 'range',
        'input_attrs' => array(
            'min'   => 50,
            'max'   => 100,
            'step'  => 1,
        ),
    ));

    // Navbar Text Color Setting
    $wp_customize->add_setting('navbar_text_color', array(
        'default'           => '#ffffff', // Default text color (HEX format)
        'sanitize_callback' => 'sanitize_hex_color', // Sanitize HEX input
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_text_color_control', array(
        'label'       => __('Navbar Text Color', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_text_color',
    )));

    // Navbar Shrink Text Color Setting
    $wp_customize->add_setting('navbar_shrink_text_color', array(
        'default'           => '#ffffff', // Default shrink text color (HEX format)
        'sanitize_callback' => 'sanitize_hex_color', // Sanitize HEX input
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_shrink_text_color_control', array(
        'label'       => __('Navbar Shrink Text Color', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_shrink_text_color',
    )));

    // Color navbar logo settings
    $wp_customize->add_setting('color_navbar_logo', array(
        'default'           => true, // Default to fixed navbar
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('color_navbar_logo_control', array(
        'label'    => __('Set navbar logo to use filter colors', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_navbar_options',
        'settings' => 'color_navbar_logo',
        'type'     => 'checkbox', // Checkbox for true/false
    ));

    // Navbar Logo Color Setting
    $wp_customize->add_setting('navbar_logo_color', array(
        'default'           => '#ffffff', // Default logo color (HEX format)
        'sanitize_callback' => 'sanitize_hex_color', // Sanitize HEX input
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_logo_color_control', array(
        'label'       => __('Navbar Logo Color', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_logo_color',
    )));

    // Navbar Shrink Logo Color Setting
    $wp_customize->add_setting('navbar_shrink_logo_color', array(
        'default'           => '#ffffff', // Default shrink logo color (HEX format)
        'sanitize_callback' => 'sanitize_hex_color', // Sanitize HEX input
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_shrink_logo_color_control', array(
        'label'       => __('Navbar Shrink Logo Color', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_navbar_options',
        'settings'    => 'navbar_shrink_logo_color',
    )));
}