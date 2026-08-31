<?php
// Enqueue custom JavaScript for the block editor
function custom_register_latest_posts_variation() {
    wp_enqueue_script(
        'custom-latest-posts-variation',
        get_template_directory_uri() . '/js/custom-latest-posts-variation.js',
        array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
        filemtime(get_template_directory() . '/js/custom-latest-posts-variation.js'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'custom_register_latest_posts_variation');

// Modify core/latest-posts block to add a custom attribute
function custom_latest_posts_modify($settings, $name) {
    // Check if the block is the 'core/latest-posts' block
    if ($name === 'core/latest-posts') {
        // Add a custom attribute
        $settings['attributes']['hideTitle'] = array(
            'type' => 'boolean',
            'default' => false,
        );
    }

    return $settings;
}
add_filter('register_block_type_args', 'custom_latest_posts_modify', 10, 2);

// Add a "hide-post-titles" class to the block's output
function custom_latest_posts_add_class($block_content, $block) {
    // Ensure this is the 'core/latest-posts' block and the attribute is set
    if ($block['blockName'] === 'core/latest-posts' && !empty($block['attrs']['hideTitle'])) {
        // Inject the "hide-post-titles" class into the ul element
        $block_content = str_replace(
            'class="wp-block-latest-posts__list',
            'class="wp-block-latest-posts__list hide-post-titles',
            $block_content
        );
    }
    return $block_content;
}
add_filter('render_block', 'custom_latest_posts_add_class', 10, 2);

function custom_latest_posts_add_hr($block_content, $block) {
    // Ensure this is the 'core/latest-posts' block
    if ($block['blockName'] === 'core/latest-posts') {
        // Add <hr> before the closing </li> tag in each list item
        $block_content = preg_replace(
            '/<\/li>/',
            '<hr /></li>',
            $block_content
        );
    }

    return $block_content;
}
add_filter('render_block', 'custom_latest_posts_add_hr', 10, 2);

?>