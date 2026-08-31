<?php
get_header('small'); 

// Fetch the default image URL from the theme options set in the card widget settings
$default_image = get_theme_mod('theme_posts_default_image', '');
?>

<!-- Main Page Section -->
<section class="container page-section">
    <h1>
        <?php
        // Check if the Customizer option to display the site name is enabled
        $site_name = get_theme_mod('display_site_name_in_title', true) ? get_bloginfo('name') . ' - ' : '';

        if (is_home()) {
            // Blog page title with or without the site name
            echo $site_name . get_theme_mod('blog_page_title', __('Blog', 'black_hawk_solutions_theme'));
        } elseif (is_search()) {
            // Search results title
            printf(__('Tulokset hakusanalle: %s', 'black_hawk_solutions_theme'), get_search_query());
        } elseif (is_archive()) {
            // Default WordPress archive title
            the_archive_title();
        } elseif (is_single()) {
            // Single post title
            the_title();
        } else {
            // Default fallback title with or without the site name
            echo $site_name . get_bloginfo('name');
        }
        ?>
    </h1>

    <?php
    // Initialize a counter for alternating layout
    $counter = 0;

    // Loop to display blog posts
    if (have_posts()) :
        while (have_posts()) : the_post(); 
            // Determine if the current post should have the image on the left or right
            $reverse_layout = $counter % 2 !== 0; // True for odd, False for even
            $sticky_class = is_sticky() ? 'sticky-post' : '';
            ?>
            <div <?php post_class($sticky_class); ?>>
                <article id="post-<?php the_ID(); ?>" <?php post_class('row mb-4 align-items-start'); ?>>
                    <!-- Display the image and text in alternating order -->
                    <?php if ($reverse_layout) : ?>
                        <!-- Text First, then Image -->
                        <div class="col-md-8">
                            <h2 class="entry-title mb-3">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="entry-meta">
                                <p>Posted on <?php the_time('F j, Y'); ?> by <?php the_author(); ?></p>
                            </div>
                            <div class="entry-content">
                                <?php
                                $excerpt = wp_trim_words(get_the_content(), 40, '...');
                                echo '<p>' . $excerpt . '</p>';
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="<?php the_permalink(); ?>" class="d-block image-container main-gradient">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['class' => 'img-fluid', 'style' => 'aspect-ratio: 4/3; object-fit: cover; width: 100%; height: auto;']); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($default_image); ?>" class="img-fluid" style="aspect-ratio: 4/3; object-fit: cover; width: 100%; height: auto;" alt="Default Image">
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <!-- Image First, then Text -->
                        <div class="col-md-4">
                            <a href="<?php the_permalink(); ?>" class="d-block image-container main-gradient">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['class' => 'img-fluid', 'style' => 'aspect-ratio: 4/3; object-fit: cover; width: 100%; height: auto;']); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($default_image); ?>" class="img-fluid" style="aspect-ratio: 4/3; object-fit: cover; width: 100%; height: auto;" alt="Default Image">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col-md-8">
                            <h2 class="entry-title mb-3">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="entry-meta">
                                <p>Posted on <?php the_time('F j, Y'); ?> by <?php the_author(); ?></p>
                            </div>
                            <div class="entry-content">
                                <?php
                                $excerpt = wp_trim_words(get_the_content(), 40, '...');
                                echo '<p>' . $excerpt . '</p>';
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </article>
            </div>
            <?php 
            $counter++; // Increment counter for alternating layout
        endwhile; ?>

        <!-- Display pagination -->
        <div class="pagination">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('« Previous', 'text_domain'),
                'next_text' => __('Next »', 'text_domain'),
            ));
            ?>
        </div>

    <?php else : ?>
        <!-- Display a message if no posts are found -->
        <p>No posts found.</p>
    <?php endif; ?>
</section>

<?php get_footer('small'); ?>



<?php
get_header('small'); ?>

<!-- Main Page Section -->
<section class="container page-section">
    <?php
    // Basic WordPress loop to display the content of the current page
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Display the page title -->
                <h1 class="entry-title mb-3"><?php the_title(); ?></h1>
                <!-- Display the page content -->
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile;
    else :
        // Display a message if no content is found
        echo '<p>No content found.</p>';
    endif;
    ?>
</section>

<?php get_footer('small'); ?>
