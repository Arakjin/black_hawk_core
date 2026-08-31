<?php
function black_hawk_solutions_customize_footer_background($wp_customize) {
    // Add Footer Section under the "Theme Options" Panel
    $wp_customize->add_section('black_hawk_solutions_footer_options', array(
        'title'       => __('Footer settings', 'black_hawk_solutions_theme'),
        'panel'       => 'black_hawk_solutions_theme_panel',
        'priority'    => 30,
        'description' => __('Customize the footer section of your theme.', 'black_hawk_solutions_theme'),
    ));

    // Add a toggle setting for Footer Background Settings
    $wp_customize->add_setting("footer_background_toggleable", array(
        'default'           => 'closed', // Default to 'closed'
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    // Add a custom button to toggle visibility
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_background_toggle_control", array(
        'section'     => 'black_hawk_solutions_footer_options',
        'type'        => 'hidden',
        'label'       => __('Footer Background Settings', 'black_hawk_solutions_theme'),
        'description' => '<strong style="cursor:pointer;" id="toggle-footer-background" class="button">Toggle Background Settings</strong>
                          <script>
                              jQuery(document).ready(function($) {
                                  $("#toggle-footer-background").on("click", function() {
                                      var currentState = wp.customize("footer_background_toggleable").get();
                                      var newState = currentState === "open" ? "closed" : "open";
                                      wp.customize("footer_background_toggleable").set(newState);
                                  });
                              });
                          </script>',
        'settings'    => "footer_background_toggleable",
    )));

    // Enable/Disable Footer Gradient Setting
    $wp_customize->add_setting('footer_enable_gradient', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('footer_enable_gradient_control', array(
        'label'    => __('Enable Footer Background Gradient', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_enable_gradient',
        'type'     => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod("footer_background_toggleable", 'closed') === 'open';
        },
    ));

    // Footer Background Color
    $wp_customize->add_setting('footer_background_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_background_color_control', array(
        'label'    => __('Footer Background Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_background_color',
        'active_callback' => function() {
            return get_theme_mod("footer_background_toggleable", 'closed') === 'open';
        },
    )));

    // Footer Gradient Color
    $wp_customize->add_setting('footer_gradient_color', array(
        'default'           => '#101010',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_gradient_color_control', array(
        'label'    => __('Footer Gradient Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'footer_gradient_color',
        'active_callback' => function() {
            return get_theme_mod("footer_background_toggleable", 'closed') === 'open';
        },
    )));

    // Enable/Disable Copyright Gradient Setting
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
        'active_callback' => function() {
            return get_theme_mod("footer_background_toggleable", 'closed') === 'open';
        },
    ));

    // Copyright Background Color
    $wp_customize->add_setting('copyright_background_color', array(
        'default'           => '#101010',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_background_color_control', array(
        'label'    => __('Copyright Background Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'copyright_background_color',
        'active_callback' => function() {
            return get_theme_mod("footer_background_toggleable", 'closed') === 'open';
        },
    )));

    // Copyright Gradient Color
    $wp_customize->add_setting('copyright_gradient_color', array(
        'default'           => '#151515',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_gradient_color_control', array(
        'label'    => __('Copyright Gradient Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_footer_options',
        'settings' => 'copyright_gradient_color',
        'active_callback' => function() {
            return get_theme_mod("footer_background_toggleable", 'closed') === 'open';
        },
    )));
}

add_action('customize_register', 'black_hawk_solutions_customize_footer_background');


?>