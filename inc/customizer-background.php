<?php
function black_hawk_solutions_customize_background($wp_customize) {
    // Add Background Section under the Theme Options Panel
    $wp_customize->add_section('black_hawk_solutions_background_options', array(
        'title'    => __('Background', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel', // Associate this section with the Theme Options panel
        'priority' => 10, // Adjust priority to place it appropriately within the Theme Options panel
    ));

    // Background settings:
    $wp_customize->add_setting('background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'BlackHawkSolutions\black_hawk_solutions_sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_color_control', array(
        'label'    => __('Background Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_background_options',
        'settings' => 'background_color',
    )));

    // Background Image Setting
    $wp_customize->add_setting('background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'background_image_control', array(
        'label'    => __('Background Image', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_background_options', // Move under the Background section
        'settings' => 'background_image',
    )));

    // Background Image Repeat Option
    $wp_customize->add_setting('background_image_repeat', array(
        'default'           => 'no-repeat',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('background_image_repeat_control', array(
        'label'    => __('Background Image Repeat', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_background_options', // Move under the Background section
        'settings' => 'background_image_repeat',
        'type'     => 'select',
        'choices'  => array(
            'no-repeat' => 'No Repeat',
            'repeat'    => 'Repeat',
            'repeat-x'  => 'Repeat Horizontally',
            'repeat-y'  => 'Repeat Vertically',
        ),
    ));

    // Background Image Size Option
    $wp_customize->add_setting('background_image_size', array(
        'default'           => 'cover',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('background_image_size_control', array(
        'label'    => __('Background Image Size', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_background_options', // Move under the Background section
        'settings' => 'background_image_size',
        'type'     => 'select',
        'choices'  => array(
            'auto'    => 'Auto',
            'cover'   => 'Cover (Stretch)',
            'contain' => 'Contain',
        ),
    ));
    

    // Page Section Background Color (RGB) Setting
    $wp_customize->add_setting('section_bg_color', array(
        'default'           => '#000000', // Default black color
        'sanitize_callback' => 'BlackHawkSolutions\black_hawk_solutions_sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'section_bg_color_control', array(
        'label'    => __('Page Section Background Color', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_background_options',
        'settings' => 'section_bg_color',
    )));

    // Page Section Background Opacity Setting
    $wp_customize->add_setting('section_bg_opacity', array(
        'default'           => 1, // Default to fully opaque
        'sanitize_callback' => 'black_hawk_solutions_sanitize_opacity',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('section_bg_opacity_control', array(
        'label'    => __('Page Section Background Opacity', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_background_options',
        'settings' => 'section_bg_opacity',
        'type'     => 'number',
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1,
            'step'  => 0.1,
        ),
    ));
}
add_action('customize_register', 'black_hawk_solutions_customize_background');

// Sanitize opacity value
function black_hawk_solutions_sanitize_opacity($opacity) {
    if (is_numeric($opacity) && $opacity >= 0 && $opacity <= 1) {
        return $opacity;
    }
    return 1; // Default to fully opaque if out of bounds
}

// Output custom styles to use the selected RGBA color in CSS
function black_hawk_solutions_customize_css() {
    $section_bg_color = get_theme_mod('section_bg_color', '#000000');
    $section_bg_opacity = get_theme_mod('section_bg_opacity', 1);

    // Convert HEX color to RGB
    list($r, $g, $b) = sscanf($section_bg_color, "#%02x%02x%02x");

    echo "<style type='text/css'>
        :root {
            --section-bg-color: $r, $g, $b;
            --section-bg-opacity: $section_bg_opacity;
        }
    </style>";
}
add_action('wp_head', 'black_hawk_solutions_customize_css');
?>