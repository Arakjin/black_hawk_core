<?php
function black_hawk_solutions_customize_metadata($wp_customize) {
    // Add a section for Post Metadata
    $wp_customize->add_section('post_metadata_options', array(
        'title'    => __('Post Metadata Options', 'black_hawk_solutions_theme'),
        'priority' => 35, // Adjust the priority as needed
        'panel'    => 'black_hawk_solutions_theme_panel', // Attach to the main theme options panel
    ));
    // Metadata settings
    // Add setting and control to toggle post date visibility
    $wp_customize->add_setting('display_post_date', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('display_post_date_control', array(
        'label'    => __('Display Post Date', 'black_hawk_solutions_theme'),
        'section'  => 'post_metadata_options',
        'settings' => 'display_post_date',
        'type'     => 'checkbox',
    ));

    // Add setting and control to toggle post author visibility
    $wp_customize->add_setting('display_post_author', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('display_post_author_control', array(
        'label'    => __('Display Post Author', 'black_hawk_solutions_theme'),
        'section'  => 'post_metadata_options',
        'settings' => 'display_post_author',
        'type'     => 'checkbox',
    ));

    // Add setting and control to toggle post categories visibility
    $wp_customize->add_setting('display_post_categories', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('display_post_categories_control', array(
        'label'    => __('Display Post Categories', 'black_hawk_solutions_theme'),
        'section'  => 'post_metadata_options',
        'settings' => 'display_post_categories',
        'type'     => 'checkbox',
    ));

    // Add setting and control to toggle post tags visibility
    $wp_customize->add_setting('display_post_tags', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('display_post_tags_control', array(
        'label'    => __('Display Post Tags', 'black_hawk_solutions_theme'),
        'section'  => 'post_metadata_options',
        'settings' => 'display_post_tags',
        'type'     => 'checkbox',
    ));
}
?>
