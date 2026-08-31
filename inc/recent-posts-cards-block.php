<?php

function register_recent_posts_block()
{
    wp_register_script(
        'recent-posts-block-script',
        get_template_directory_uri() . '/js/recent-posts-block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element', 'wp-i18n', 'wp-data'),
        filemtime(get_template_directory() . '/js/recent-posts-block.js')
    );

    register_block_type('black-hawk-solutions/recent-posts', array(
        'editor_script'    => 'recent-posts-block-script',
        'render_callback'  => 'render_recent_posts_block',
        'attributes'       => array(
            'postsToShow' => array(
                'type'    => 'number',
                'default' => 4,
            ),
            'showExcerpt' => array(
                'type'    => 'boolean',
                'default' => true,
            ),
            'postCategory' => array(
                'type'    => 'string',
                'default' => 'all',
            ),
            'enableGradient' => array(
                'type'    => 'boolean',
                'default' => false, // Enable by default
            ),
            'enableRoundedBottom' => array(
                'type'    => 'boolean',
                'default' => false, // Enable by default
            ),
            'roundedBottomSize' => array(
                'type'    => 'number',
                'default' => 4,
            ),
            'enableBorders' => array(
                'type'    => 'boolean',
                'default' => true, // Enable by default
            ),
            'borderWidth' => array(
                'type'    => 'number',
                'default' => 2,
            ),
            'useButton' => array(
                'type'    => 'boolean',
                'default' => true, // Default to use button
            ),
        ),
    ));
}
add_action('init', 'register_recent_posts_block');

function render_recent_posts_block($attributes)
{
    $posts_per_page = isset($attributes['postsToShow']) ? $attributes['postsToShow'] : 4;
    $show_excerpt   = isset($attributes['showExcerpt']) ? $attributes['showExcerpt'] : true;
    $excerpt_word_count = isset($attributes['selectExcerptWordCount']) ? $attributes['selectExcerptWordCount'] : 20;
    $post_category  = isset($attributes['postCategory']) ? $attributes['postCategory'] : 'all';
    $enable_gradient = isset($attributes['enableGradient']) ? $attributes['enableGradient'] : true;
    $enable_rounded_bottom = isset($attributes['enableRoundedBottom']) ? $attributes['enableRoundedBottom'] : true;
    $enable_borders = isset($attributes['enableBorders']) ? $attributes['enableBorders'] : true;
    $border_width         = isset($attributes['borderWidth']) ? $attributes['borderWidth'] : 2;
    $rounded_bottom_size  = isset($attributes['roundedBottomSize']) ? $attributes['roundedBottomSize'] : 4;
    $use_button  = isset($attributes['useButton']) ? $attributes['useButton'] : true;
    // Generate dynamic classes
    $gradient_class       = $enable_gradient ? 'darkening-gradient' : '';
    $rounded_bottom_class = $enable_rounded_bottom ? "rounded-bottom-$rounded_bottom_size" : '';
    $border_classes = $enable_borders ? "border border-$border_width border-dark" : 'border border-0';

    // Determine the post type and category filter
    if ($post_category === 'galleries') {
        $post_type = 'gallery';
        $query_args = array(
            'post_type'      => 'gallery',
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
        );
    } else {
        $post_type = 'post';
        $query_args = array(
            'post_type'      => 'post',
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
        );
        // Add category filter if not 'all'
        if ($post_category !== 'all') {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $post_category,
                ),
            );
        }
    }

    // Query recent posts or galleries
    $recent_posts = new WP_Query($query_args);

    // Handle no posts found
    if (!$recent_posts->have_posts()) {
        return '<p>No posts or galleries found.</p>';
    }

    // Get the default image from Customizer settings
    $default_image = get_theme_mod('theme_posts_default_image', '');
    $column_class = get_column_class($posts_per_page);
    $output = '<div class="row">';

    while ($recent_posts->have_posts()) {
        $recent_posts->the_post();
        $post_title = get_the_title();
        $post_excerpt = wp_trim_words(get_the_excerpt(), $excerpt_word_count);
        $post_link = get_permalink();
        $post_image = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: esc_url($default_image);

        $output .= '
        <div class="' . esc_attr($column_class) . '">
            <div class="card bg-dark h-100 ' . esc_attr(trim($gradient_class . ' ' . $border_classes)) . '">';
    
    if ($use_button) {
        // Layout with "Read More" button
        $output .= '
                <div class="card-img-container"> <!-- Parent container to control image size -->
                    <img src="' . esc_url($post_image) . '" class="card-img-top ' . esc_attr($rounded_bottom_class) . '" alt="' . esc_attr($post_title) . '">
                </div>
                <div class="card-body bg-dark">
                    <h5 class="card-title">
                        <a href="' . esc_url($post_link) . '" class="text-decoration-none text-white">
                            ' . esc_html($post_title) . '
                        </a>
                    </h5>';
    
        if ($show_excerpt) {
            $output .= '<p class="card-text text-white">' . esc_html($post_excerpt) . '</p>';
        }
    
        $output .= '
                    <a href="' . esc_url($post_link) . '" class="btn btn-primary mt-auto">Lue lisää</a> <!-- Custom "Read More" text -->
                </div>';
    } else {
        // Layout with image and title as links
        $output .= '
                <a href="' . esc_url($post_link) . '" class="card-img-container"> <!-- Parent container to control image size -->
                    <img src="' . esc_url($post_image) . '" class="card-img-top ' . esc_attr($rounded_bottom_class) . '" alt="' . esc_attr($post_title) . '">
                </a>
                <div class="card-body bg-dark">
                    <h5 class="card-title">
                        <a href="' . esc_url($post_link) . '" class="text-decoration-none">
                            ' . esc_html($post_title) . '
                        </a>
                    </h5>';
    
        if ($show_excerpt) {
            $output .= '<p class="card-text text-white">' . esc_html($post_excerpt) . '</p>';
        }
    
        $output .= '
                </div>';
    }
    
    $output .= '
            </div>
        </div>';
    
    }

    $output .= '</div>';
    wp_reset_postdata();

    return $output;
}

// Helper function to determine the column class based on the number of posts per page
function get_column_class($posts_per_page)
{
    switch ($posts_per_page) {
        case 1:
            return 'col-md-12'; // Full-width for one post
        case 2:
            return 'col-md-6'; // Two posts per row
        case 3:
            return 'col-md-4'; // Three posts per row
        case 4:
            return 'col-md-3'; // Four posts per row
        case 6:
            return 'col-md-2'; // Six posts per row
        case 12:
            return 'col-md-1'; // Twelve posts per row
        default:
            return 'col-md-3'; // Default to four posts per row if unspecified
    }
}
