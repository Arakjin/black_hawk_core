<?php
// Register navigation menu and add image sizes
function black_hawk_solutions_setup()
{
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'black_hawk_solutions_theme'),
        'shop_menu' => __('Shop Menu', 'black_hawk_solutions_theme'),
    ));

    // Add theme support for post thumbnails (if not already added)
    add_theme_support('post-thumbnails');

    // Add custom image sizes
    add_image_size('custom-thumbnail', 150, 150, true);  // Cropped thumbnail size
    add_image_size('custom-medium', 300, 300, false);    // Medium size, not cropped
}
add_action('after_setup_theme', 'black_hawk_solutions_setup');

// Make custom image sizes available in the media editor
function black_hawk_solutions_custom_sizes($sizes) {
    return array_merge($sizes, array(
        'thumbnail' => __('Thumbnail'),
        'medium'    => __('Medium'),
        'custom-thumbnail' => __('Custom Thumbnail'),
        'custom-medium'    => __('Custom Medium'),
    ));
}
add_filter('image_size_names_choose', 'black_hawk_solutions_custom_sizes');

// Register Custom Navigation Walker
function register_navwalker()
{
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');
?>