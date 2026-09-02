<?php

// Centralized font choices array
$black_hawk_font_choices = array(
    'Arial, sans-serif' => 'Arial',
    'Times New Roman, serif' => 'Times New Roman',
    'Georgia, serif' => 'Georgia',
    'Verdana, sans-serif' => 'Verdana',
    'Tahoma, sans-serif' => 'Tahoma',
    'Courier New, monospace' => 'Courier New',
    'Orbitron, sans-serif' => 'Orbitron',
    'Orbitron Bold, sans-serif' => 'Orbitron Bold',
    'Bert Sans, sans-serif' => 'Bert Sans',
    'Alumni Sans Bold, sans-serif' => 'Alumni Sans Bold',
    'Alumni Sans, sans-serif' => 'Alumni Sans'
);

// Helper function to add font controls
function black_hawk_solutions_add_font_control($wp_customize, $id, $label, $default, $choices, $section = 'black_hawk_solutions_font_options') {
    // Add setting
    $wp_customize->add_setting($id, array(
        'default'           => $default,
        'sanitize_callback' => 'black_hawk_sanitize_font_choice',
        'transport'         => 'refresh',
    ));
    
    // Add control
    $wp_customize->add_control($id . '_control', array(
        'label'    => __($label, 'black_hawk_solutions_theme'),
        'section'  => $section,
        'settings' => $id,
        'type'     => 'select',
        'choices'  => $choices,
    ));
}

// Function to register custom font options in the WordPress Customizer
function black_hawk_solutions_customize_fonts($wp_customize) {
    global $black_hawk_font_choices;

    // Add the fonts section
    $wp_customize->add_section('black_hawk_solutions_font_options', array(
        'title'    => __('Fonts', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel',
        'priority' => 30,
    ));

    // Add font controls using the helper function
    black_hawk_solutions_add_font_control($wp_customize, 'body_font_family', 'Body Font Family', 'Arial, sans-serif', $black_hawk_font_choices);
    black_hawk_solutions_add_font_control($wp_customize, 'heading_font_family', 'Heading Font Family', 'Georgia, serif', $black_hawk_font_choices);
    black_hawk_solutions_add_font_control($wp_customize, 'navbar_font_family', 'Navbar Font Family', 'Arial, sans-serif', $black_hawk_font_choices);
    black_hawk_solutions_add_font_control($wp_customize, 'header_font_family', 'Header Font Family', 'Arial, sans-serif', $black_hawk_font_choices);
    black_hawk_solutions_add_font_control($wp_customize, 'description_font_family', 'Description Font Family', 'Arial, sans-serif', $black_hawk_font_choices);
}

add_action('customize_register', 'black_hawk_solutions_customize_fonts');

// Sanitization callback for font choices
function black_hawk_sanitize_font_choice($input) {
    // Strip HTML tags, but allow basic characters needed for font-family
    return preg_replace("/[^a-zA-Z0-9, '\"\-]/", '', $input);
}

// Output custom CSS variables based on Customizer settings
function black_hawk_solutions_customizer_css_variables() {
    ?>
    <style type="text/css">
        :root {
            --body-font-family: <?php echo esc_attr(get_theme_mod('body_font_family', 'Arial, sans-serif')); ?>;
            --heading-font-family: <?php echo esc_attr(get_theme_mod('heading_font_family', 'Georgia, serif')); ?>;
            --navbar-font-family: <?php echo esc_attr(get_theme_mod('navbar_font_family', 'Arial, sans-serif')); ?>;
            --header-font-family: <?php echo esc_attr(get_theme_mod('header_font_family', 'Arial, sans-serif')); ?>;
            --description-font-family: <?php echo esc_attr(get_theme_mod('description_font_family', 'Arial, sans-serif')); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'black_hawk_solutions_customizer_css_variables');

function black_hawk_customize_latest_posts_title_size($wp_customize) {
    // Add the setting
    $wp_customize->add_setting('category_heading_font_size', array(
        'default'           => '1em', // Default value
        'sanitize_callback' => 'sanitize_text_field', // Sanitize input
        'transport'         => 'refresh', // Reload the page on change
    ));

    // Add the control
    $wp_customize->add_control('category_heading_font_size_control', array(
        'label'    => __('Category Heading Font Size', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_font_options', // Customize section
        'settings' => 'category_heading_font_size', // Links to the setting
        'type'     => 'text', // Allows full CSS values like '16px', '1.5em', etc.
    ));
}
add_action('customize_register', 'black_hawk_customize_latest_posts_title_size');
