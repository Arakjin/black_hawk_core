<?php

// Apply custom styles based on the Customizer settings
function black_hawk_solutions_background_styles()
{
    // Retrieve theme mod values with fallbacks

    // Retrieve the color with a fallback and ensure the '#' prefix is present
    $background_color = get_theme_mod('background_color', '#ffffff');
    $background_image = get_theme_mod('background_image', '');
    $background_repeat = get_theme_mod('background_image_repeat', 'no-repeat');
    $background_size = get_theme_mod('background_image_size', 'cover');
    // Build CSS with validated values
    $custom_css = "
        body {
            background-color: {$background_color};
            " . ($background_image ? "background-image: url('" . esc_url($background_image) . "');" : '') . "
            background-repeat: {$background_repeat};
            background-size: {$background_size};
        }
    ";

    // Ensure the correct style handle is used
    wp_add_inline_style('black_hawk-solutions-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'black_hawk_solutions_background_styles', 30);

?>