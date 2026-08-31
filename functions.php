<?php
// Register custom widgets and other stuff
foreach (glob(get_template_directory() . '/inc/*.php') as $file) {
    require_once $file;
}

add_filter('block_categories_all', function( $categories, $post ) {
    // Add a new category for 'black-hawk'
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'black-hawk',
                'title' => __( 'Black Hawk', 'text-domain' ),
            ),
        )
    );
}, 10, 2);

function black_hawk_solutions_customize_register($wp_customize) {
    // Add Main Theme Options Panel
    $wp_customize->add_panel('black_hawk_solutions_theme_panel', array(
        'title'       => __('Theme Options', 'black_hawk_solutions_theme'),
        'description' => __('Customize the appearance of your theme.', 'black_hawk_solutions_theme'),
        'priority'    => 30, // Adjust priority to place this panel appropriately in the Customizer
    ));

    // Call each modular function
    black_hawk_solutions_customize_colors($wp_customize);
    black_hawk_solutions_customize_background($wp_customize);
    black_hawk_solutions_customize_navbar($wp_customize);
    black_hawk_solutions_customize_header($wp_customize);
    black_hawk_solutions_customize_gallery($wp_customize);
    black_hawk_solutions_customize_metadata($wp_customize);
    black_hawk_solutions_customize_footer_background($wp_customize);
    black_hawk_solutions_customize_footer_textfields($wp_customize); // Call the footer text fields customizer
}

add_action('customize_register', 'black_hawk_solutions_customize_register');

?>