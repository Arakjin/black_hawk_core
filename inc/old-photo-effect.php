<?php
/**
 * Old Photo Effect Gutenberg block bundled with the theme.
 */

function black_hawk_old_photo_effect_editor_assets() {
    wp_enqueue_script(
        'black-hawk-old-photo-effect',
        get_template_directory_uri() . '/js/old-photo-effect.js',
        array('wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element'),
        filemtime(get_template_directory() . '/js/old-photo-effect.js'),
        true
    );

    wp_enqueue_style(
        'black-hawk-old-photo-effect-editor',
        get_template_directory_uri() . '/css/old-photo-effect.css',
        array(),
        filemtime(get_template_directory() . '/css/old-photo-effect.css'),
        'all'
    );
}
add_action('enqueue_block_editor_assets', 'black_hawk_old_photo_effect_editor_assets');

function black_hawk_old_photo_effect_frontend_assets() {
    wp_enqueue_style(
        'black-hawk-old-photo-effect',
        get_template_directory_uri() . '/css/old-photo-effect.css',
        array(),
        filemtime(get_template_directory() . '/css/old-photo-effect.css'),
        'all'
    );
}
add_action('wp_enqueue_scripts', 'black_hawk_old_photo_effect_frontend_assets');
