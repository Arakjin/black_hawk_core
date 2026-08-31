<?php
function black_hawk_solutions_customize_general($wp_customize) {
    // Add General Section under the Theme Options Panel
    $wp_customize->add_section('black_hawk_solutions_general_options', array(
        'title'    => __('General Settings', 'black_hawk_solutions_theme'),
        'panel'    => 'black_hawk_solutions_theme_panel',
        'priority' => 10,
    ));

	// Default Card Widget Image Setting
	$wp_customize->add_setting('theme_posts_default_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Image_control($wp_customize, 'theme_posts_default_image_control', array(
		'label'    => __('Set Default Image for Posts and Card Widget', 'black_hawk_solutions_theme'),
		'section'  => 'black_hawk_solutions_general_options',
		'settings' => 'theme_posts_default_image',
		'description' => __('Set a default image for posts and card widgets when no featured image is available.', 'black_hawk_solutions_theme'),
	)));
	
    // Container Type Setting (Switch between container and container-fluid)
    $wp_customize->add_setting('container_type', array(
        'default'           => 'container', // Defaults to fixed-width (container)
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('container_type_control', array(
        'label'    => __('Container Type', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_general_options',
        'settings' => 'container_type',
        'type'     => 'radio',
        'choices'  => array(
            'container'       => __('Fixed Width (Container)', 'black_hawk_solutions_theme'),
            'container-fluid' => __('Full Width (Container-fluid)', 'black_hawk_solutions_theme'),
        ),
    ));
        // Add setting to toggle the header in the page
        $wp_customize->add_setting('display_site_header', array(
            'default'           => true, // Default to true (show site name)
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'refresh',
        ));
    
        $wp_customize->add_control('display_site_header_control', array(
            'label'    => __('Display Site Header in Page', 'black_hawk_solutions_theme'),
            'section'  => 'black_hawk_solutions_general_options',
            'settings' => 'display_site_header',
            'type'     => 'checkbox',
            'description' => __('Show or hide the site name before the blog title.', 'black_hawk_solutions_theme'),
        ));

    // Add setting to toggle the site name in the page title
    $wp_customize->add_setting('display_site_name_in_title', array(
        'default'           => true, // Default to true (show site name)
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('display_site_name_in_title_control', array(
        'label'    => __('Display Site Name in Title', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_general_options',
        'settings' => 'display_site_name_in_title',
        'type'     => 'checkbox',
        'description' => __('Show or hide the site name before the blog title.', 'black_hawk_solutions_theme'),
    ));
    
    // Add setting to hide/show the featured image in single posts
    $wp_customize->add_setting('single_post_show_featured_image', array(
        'default'           => true, // Default to show the featured image
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('single_post_show_featured_image_control', array(
        'label'    => __('Show Featured Image in Single Post', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_general_options',
        'settings' => 'single_post_show_featured_image',
        'type'     => 'checkbox',
        'description' => __('Check to show the featured image in single posts.', 'black_hawk_solutions_theme'),
    ));

    // Blog Page Title Setting
    $wp_customize->add_setting('blog_page_title', array(
        'default'           => __('Blog', 'black_hawk_solutions_theme'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('blog_page_title_control', array(
        'label'    => __('Blog Page Title', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_general_options',
        'settings' => 'blog_page_title',
        'type'     => 'text',
    ));

    // Archive Page Title Setting
    $wp_customize->add_setting('archive_page_title', array(
        'default'           => __('Archives', 'black_hawk_solutions_theme'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('archive_page_title_control', array(
        'label'    => __('Archive Page Title', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_general_options',
        'settings' => 'archive_page_title',
        'type'     => 'text',
    ));

    // Gallery Page Title Setting
    $wp_customize->add_setting('gallery_page_title', array(
        'default'           => __('Galleries', 'black_hawk_solutions_theme'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('gallery_page_title_control', array(
        'label'    => __('Gallery Page Title', 'black_hawk_solutions_theme'),
        'section'  => 'black_hawk_solutions_general_options',
        'settings' => 'gallery_page_title',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'black_hawk_solutions_customize_general');
?>
