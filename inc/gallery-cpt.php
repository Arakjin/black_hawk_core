<?php
// Gallery stuff

// Register Custom Post Type for Galleries
function black_hawk_solutions_register_gallery_cpt() {

    $labels = array(
        'name'                  => _x('Galleries', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Gallery', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Galleries', 'text_domain'),
        'name_admin_bar'        => __('Gallery', 'text_domain'),
        'archives'              => __('Gallery Archives', 'text_domain'),
        'attributes'            => __('Gallery Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Gallery:', 'text_domain'),
        'all_items'             => __('All Galleries', 'text_domain'),
        'add_new_item'          => __('Add New Gallery', 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'new_item'              => __('New Gallery', 'text_domain'),
        'edit_item'             => __('Edit Gallery', 'text_domain'),
        'update_item'           => __('Update Gallery', 'text_domain'),
        'view_item'             => __('View Gallery', 'text_domain'),
        'view_items'            => __('View Galleries', 'text_domain'),
        'search_items'          => __('Search Galleries', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Gallery Image', 'text_domain'),
        'set_featured_image'    => __('Set gallery image', 'text_domain'),
        'remove_featured_image' => __('Remove gallery image', 'text_domain'),
        'use_featured_image'    => __('Use as gallery image', 'text_domain'),
        'insert_into_item'      => __('Insert into gallery', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this gallery', 'text_domain'),
        'items_list'            => __('Galleries list', 'text_domain'),
        'items_list_navigation' => __('Galleries list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter galleries list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Gallery', 'text_domain'),
        'description'           => __('Post Type for Galleries', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'            => array('category', 'post_tag'), // Add categories and tags if needed
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-gallery', // Optional icon for the menu
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true, // Enable archive
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'rewrite'               => array('slug' => 'galleries'),
        'show_in_rest'          => true, // Enable Gutenberg
    );
    register_post_type('gallery', $args);

}
add_action('init', 'black_hawk_solutions_register_gallery_cpt');
?>