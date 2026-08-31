<?php
/*
Template Name: Small
*/ 
get_header('nohead'); ?>

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
