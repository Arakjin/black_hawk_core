<?php
// Enqueue frontend styles and scripts
function black_hawk_solutions_scripts() {
    wp_enqueue_style(
        'bootstrap-css', // Handle
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', // Source URL
        array(), // Dependencies (none in this case)
        '5.3.3', // Version
        'all' // Media type
    );
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v6.3.0/css/all.css');
    wp_enqueue_style('black_hawk-solutions-style', get_stylesheet_uri()); // Main theme stylesheet

    wp_enqueue_script(
        'bootstrap-js', // Handle
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', // Source URL
        array(), // Dependencies (none in this case)
        '5.3.3', // Version
        true // Load in footer
    );
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);

    // Localize container type setting for frontend scripts
    wp_localize_script('theme-scripts', 'bhSolutionsSettings', array(
        'containerType' => get_theme_mod('container_type', 'container'),
    ));
}
add_action('wp_enqueue_scripts', 'black_hawk_solutions_scripts');

// Enqueue editor-specific styles and scripts (for Gutenberg editor)
function black_hawk_solutions_editor_assets() {
    // Enqueue Bootstrap CSS in the editor
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

    // Enqueue editor-specific stylesheet
    wp_enqueue_style(
        'black_hawk-solutions-editor-styles',
        get_template_directory_uri() . '/css/editor-styles.css',
        array('bootstrap-css'), // Ensure Bootstrap CSS is loaded before editor styles
        filemtime(get_template_directory() . '/css/editor-styles.css')
    );

    // Enqueue the JavaScript file for extending the image block
    wp_enqueue_script(
        'media-img-customizer',
        get_template_directory_uri() . '/js/media-img-customizer.js',
        array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
        filemtime(get_template_directory() . '/js/media-img-customizer.js'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'black_hawk_solutions_editor_assets');


// WooCommerce support
function theme_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'theme_woocommerce_support');


//enqueue fonts.css
function black_hawk_solutions_enqueue_fonts() {
    // Enqueue the fonts.css file
    wp_enqueue_style('black_hawk_solutions-fonts', get_template_directory_uri() . '/css/fonts.css', array(), null);
}

add_action('wp_enqueue_scripts', 'black_hawk_solutions_enqueue_fonts');

function enqueue_customizer_scripts() {
    wp_enqueue_script(
        'customizer-multi-image-control',
        get_template_directory_uri() . '/js/customizer-multi-image-control.js', // Adjust path as needed
        array('jquery', 'customize-controls', 'wp-mediaelement'),
        null,
        true
    );

    wp_enqueue_style(
        'customizer-multi-image-control-style',
        get_template_directory_uri() . '/css/customizer-multi-image-control.css', // Optional CSS for styling
        array(),
        null
    );
}
add_action('customize_controls_enqueue_scripts', 'enqueue_customizer_scripts');

?>
