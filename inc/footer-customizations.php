<?php

// Helper function to determine the column class based on the number of text fields
function get_footer_column_class($text_fields_count) {
    switch ($text_fields_count) {
        case 1:
            return 'col-md-12'; // Full-width for one field
        case 2:
            return 'col-md-6';  // Two fields per row
        case 3:
            return 'col-md-4';  // Three fields per row
        case 4:
            return 'col-md-3';  // Four fields per row
        case 6:
            return 'col-md-2';  // Six fields per row
        default:
            return 'col-md-4';  // Default to three fields per row
    }
}

function black_hawk_solutions_customize_footer_options($wp_customize) {
    // Add setting and control for the footer background color
    $wp_customize->add_setting('footer_background_color', array(
        'default'           => '#000000', // Default color
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_background_color_control', array(
        'label'    => __('Footer Background Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_background_color',
    )));

    // Add setting and control for the footer gradient color
    $wp_customize->add_setting('footer_gradient_color', array(
        'default'           => '#101010', // Default gradient color
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_gradient_color_control', array(
        'label'    => __('Footer Gradient Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_gradient_color',
    )));

    // Add setting and control for enabling/disabling the gradient
    $wp_customize->add_setting('footer_enable_gradient', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('footer_enable_gradient_control', array(
        'label'    => __('Enable Footer Gradient', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_enable_gradient',
        'type'     => 'checkbox',
    ));

    // Add Customizer settings for copyright gradient
    $wp_customize->add_setting('copyright_enable_gradient', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('copyright_enable_gradient_control', array(
        'label'    => __('Enable Copyright Gradient', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'copyright_enable_gradient',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('copyright_gradient_color', array(
        'default'           => '#151515',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_gradient_color_control', array(
        'label'    => __('Copyright Gradient Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'copyright_gradient_color',
    )));

    $wp_customize->add_setting('copyright_background_color', array(
        'default'           => '#101010',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_background_color_control', array(
        'label'    => __('Copyright Background Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'copyright_background_color',
    )));
}
add_action('customize_register', 'black_hawk_solutions_customize_footer_options');

function black_hawk_solutions_footer_custom_styles() {
    // Get the customizer settings
    $footer_background_color = get_theme_mod('footer_background_color', '#000000');
    $footer_gradient_color = get_theme_mod('footer_gradient_color', '#101010');
    $footer_enable_gradient = get_theme_mod('footer_enable_gradient', true);
    $copyright_background_color = get_theme_mod('copyright_background_color', '#101010');

    // Generate the CSS for the footer background and gradient
    $footer_background = $footer_enable_gradient
        ? "linear-gradient(0deg, {$footer_gradient_color} 0%, {$footer_background_color} 100%)"
        : $footer_background_color;

    // Output dynamic CSS
    ?>
    <style type="text/css">
        .footer {
            background: <?php echo esc_attr($footer_background); ?>;
            color: #fff; /* Keep the text color white */
        }

        .copyright {
            background-color: <?php echo esc_attr($copyright_background_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'black_hawk_solutions_footer_custom_styles');
?>
