<?php
function black_hawk_solutions_customize_gallery($wp_customize) {
    // Add Gallery Section under the Theme Options Panel
    $wp_customize->add_section('black_hawk_solutions_gallery_options', array(
        'title'    => __('Gallery', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel', // Associate this section with the Theme Options panel
        'priority' => 40,
    ));
    // Gallery settings    
    // Add setting to control the number of columns for the gallery
    $wp_customize->add_setting('gallery_columns', array(
        'default'           => 3, // Default to 3 columns
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    // Add control for the number of columns
    $wp_customize->add_control('gallery_columns_control', array(
        'label'    => __('Number of Columns', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_gallery_options',
        'settings' => 'gallery_columns',
        'type'     => 'select',
        'choices'  => array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            6 => '6',
        ),
        'description' => __('Choose the number of columns for the gallery posts layout.', 'black_hawk_solutions_theme'),
    ));
    
    // Add setting to hide/show the featured image
    $wp_customize->add_setting('gallery_show_featured_image', array(
        'default'           => true, // Show featured image by default
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    // Add control to hide/show the featured image
    $wp_customize->add_control('gallery_show_featured_image_control', array(
        'label'    => __('Show Featured Image', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_gallery_options',
        'settings' => 'gallery_show_featured_image',
        'type'     => 'checkbox',
        'description' => __('Check to show the featured image in the gallery.', 'black_hawk_solutions_theme'),
    ));
}
?>
