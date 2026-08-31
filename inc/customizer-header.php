<?php
function black_hawk_solutions_customize_header($wp_customize) {
    // Add Header Section under the Theme Options Panel
    $wp_customize->add_section('black_hawk_solutions_header_options', array(
        'title'    => __('Header', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel',
        'priority' => 20,
    ));
    // Header Logo Setting
    $wp_customize->add_setting('header_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo_control', array(
        'label'    => __('Header Logo', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'header_logo',
    )));

        // Custom Gradient/CSS Background Setting
    $wp_customize->add_setting('masthead_background', array(
        'default'           => 'linear-gradient(0deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 1) 100%)',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('masthead_background_control', array(
        'label'       => __('Masthead Background (CSS)', 'black_hawk_solutions_theme'),
        'description' => __('Enter any valid CSS background value, such as a linear-gradient, solid color (e.g., rgba or hex), or other CSS background types.', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'masthead_background',
        'type'        => 'text',
    ));

    // Navbar Shrink Text Color Setting
    $wp_customize->add_setting('header_text_color', array(
        'default'           => '#ffffff', // Default shrink text color (HEX format)
        'sanitize_callback' => 'BlackHawkSolutions\sanitize_hex_color', // Sanitize HEX input
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_text_color_control', array(
        'label'       => __('Header Text Color', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'header_text_color',
    )));  
	
    // Header Shadow Setting
    $wp_customize->add_setting('header_shadow', array(
        'default'           => '1px 1px 2px pink', // Default shadow value
        'sanitize_callback' => 'sanitize_text_field', // Sanitize user input
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('header_shadow_control', array(
        'label'       => __('Header Shadow', 'black_hawk_solutions_theme'),
        'description' => __('Enter a valid CSS box-shadow value (e.g., 1px 1px 2px pink)', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'header_shadow',
        'type'        => 'text',
    ));
	
    // Header Logo and Text Visibility Setting
    $wp_customize->add_setting('show_header', array(
        'default'           => true, // Default to showing the logo
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('show_header_control', array(
        'label'    => __('Show Header', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'show_header',
        'type'     => 'checkbox', // Checkbox for true/false
    ));

    // Header Logo and Text Visibility Setting
    $wp_customize->add_setting('show_header_and_text_logo', array(
        'default'           => true, // Default to showing the logo
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('show_header_and_text_logo_control', array(
        'label'    => __('Show Header Logo and Texts', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'show_header_and_text_logo',
        'type'     => 'checkbox', // Checkbox for true/false
    ));

    // Header Logo Visibility Setting
    $wp_customize->add_setting('show_header_logo', array(
        'default'           => true, // Default to showing the logo
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('show_header_logo_control', array(
        'label'    => __('Show Header Logo', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'show_header_logo',
        'type'     => 'checkbox', // Checkbox for true/false
    ));

    // Header Logo and Text Visibility Setting
    $wp_customize->add_setting('show_main_header', array(
        'default'           => true, // Default to showing the logo
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('show_main_header_control', array(
        'label'    => __('Show Header Text', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'show_main_header',
        'type'     => 'checkbox', // Checkbox for true/false
    ));
    
    // Header Text Visibility Setting
    $wp_customize->add_setting('show_subheaders', array(
        'default'           => true, // Default to showing the text
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('show_subheaders_control', array(
        'label'    => __('Show Or Hide Subheader', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'show_subheaders',
        'type'     => 'checkbox', // Checkbox for true/false
    ));

    // Add a separator before a section
    $wp_customize->add_setting('separator1', array(
        'sanitize_callback' => 'wp_filter_nohtml_kses', // Sanitization (no HTML)
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'separator1_control', array(
        'label'       => '', // No label
        'description' => '<hr style="border: 1px solid #ccc;"/>', // HTML for a horizontal rule
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'separator1',
        'type'        => 'hidden', // Hidden input type
    )));

    // Add carousel option checkbox
    $wp_customize->add_setting('use_carousel', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('use_carousel_control', array(
        'label'    => __('Use Carousel for Header', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'type'     => 'checkbox',
        'settings' => 'use_carousel',
    ));

    // Add setting for carousel images
    $wp_customize->add_setting('header_carousel_images', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    // Add custom control for carousel images
    $wp_customize->add_control(new WP_Customize_Multi_Image_Control($wp_customize, 'header_carousel_images_control', array(
        'label'       => __('Header Carousel Images', 'black_hawk_solutions_theme'),
        'description' => __('Select multiple images for the carousel. Hold down the Ctrl key (or Cmd key on Mac) while clicking images to select more than one.', 'black_hawk_solutions_theme'),        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'header_carousel_images',
    )));

    // Header Height Setting
    $wp_customize->add_setting('header_height', array(
        'default'           => '750px', // Default value
        'sanitize_callback' => 'sanitize_text_field', // Sanitize user input
        'transport'         => 'refresh', // This ensures that the changes happen immediately without a page reload
    ));

    $wp_customize->add_control('header_height_control', array(
        'label'    => __('Header Height', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'header_height',
        'type'     => 'text', // Text input for the user to input any CSS value
    ));

    // Header Height Setting
    $wp_customize->add_setting('small_header_height', array(
        'default'           => '325px', // Default value
        'sanitize_callback' => 'sanitize_text_field', // Sanitize user input
        'transport'         => 'refresh', // This ensures that the changes happen immediately without a page reload
    ));

    $wp_customize->add_control('small_header_height_control', array(
        'label'    => __('Header Height', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_header_options',
        'settings' => 'small_header_height',
        'type'     => 'text', // Text input for the user to input any CSS value
    ));

    // Add a separator before a section
    $wp_customize->add_setting('separator2', array(
        'sanitize_callback' => 'wp_filter_nohtml_kses', // Sanitization (no HTML)
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'separator2_control', array(
        'label'       => '', // No label
        'description' => '<hr style="border: 1px solid #ccc;"/>', // HTML for a horizontal rule
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'separator2',
        'type'        => 'hidden', // Hidden input type
    )));

    // Masthead Heading Text
    $wp_customize->add_setting('heading_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('heading_text_control', array(
        'label'       => __('Masthead Heading Text', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'heading_text',
        'type'        => 'text',
    ));

    // Masthead Subheading Text
    $wp_customize->add_setting('subheading_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('subheading_text_control', array(
        'label'       => __('Masthead Subheading Text', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'subheading_text',
        'type'        => 'text',
    ));

    // Add a separator before a section
    $wp_customize->add_setting('separator3', array(
        'sanitize_callback' => 'wp_filter_nohtml_kses', // Sanitization (no HTML)
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'separator3_control', array(
        'label'       => '', // No label
        'description' => '<hr style="border: 1px solid #ccc;"/>', // HTML for a horizontal rule
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'separator3',
        'type'        => 'hidden', // Hidden input type
    )));

    // Masthead Logo Size Setting (accepts full CSS values)
    $wp_customize->add_setting('masthead_logo_size', array(
        'default'           => '10em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('masthead_logo_size_control', array(
        'label'       => __('Masthead Logo Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'masthead_logo_size',
        'type'        => 'text',
    ));

    // Masthead Heading Size Setting (accepts full CSS values)
    $wp_customize->add_setting('masthead_heading_size', array(
        'default'           => '4em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('masthead_heading_size_control', array(
        'label'       => __('Masthead Heading Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'masthead_heading_size',
        'type'        => 'text',
    ));

    // Masthead Subheading Size Setting (accepts full CSS values)
    $wp_customize->add_setting('masthead_subheading_size', array(
        'default'           => '2em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('masthead_subheading_size_control', array(
        'label'       => __('Masthead Subheading Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'masthead_subheading_size',
        'type'        => 'text',
    ));

    // Masthead Gap Setting (accepts full CSS values)
    $wp_customize->add_setting('masthead_gap_size', array(
        'default'           => '2em',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('masthead_gap_size_control', array(
        'label'       => __('Masthead Gap Size', 'black_hawk_solutions_theme'),
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'masthead_gap_size',
        'type'        => 'text',
    ));
	
    // Add a separator before a section
    $wp_customize->add_setting('separator4', array(
        'sanitize_callback' => 'wp_filter_nohtml_kses', // Sanitization (no HTML)
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'separator4_control', array(
        'label'       => '', // No label
        'description' => '<hr style="border: 1px solid #ccc;"/>', // HTML for a horizontal rule
        'section'     => 'black_hawk_solutions_header_options',
        'settings'    => 'separator4',
        'type'        => 'hidden', // Hidden input type
    )));

}
add_action('customize_register', 'black_hawk_solutions_customize_header');

function black_hawk_solutions_custom_background_css() {
    $background = get_theme_mod('masthead_background', 'linear-gradient(0deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 1) 100%)');
    echo "<style>.masthead::before { background: {$background}; }</style>";
}
add_action('wp_head', 'black_hawk_solutions_custom_background_css');

?>
