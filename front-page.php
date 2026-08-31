<?php get_header(); ?>

<!-- Main Page Section -->
<section class="container page-section">
    <?php if ( is_active_sidebar( 'topbar-1' ) ) : ?>
        <aside id="secondary" class="widget-area">
            <?php dynamic_sidebar( 'topbar-1' ); ?>
        </aside>
    <?php endif; ?>

    <?php
    $show_title = get_theme_mod('display_site_header', true);
    // Basic WordPress loop to display the content of the current page
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Display the page content -->
                <?php
                    if($show_title):
                        echo '<h1 class="entry-title mb-3">'. get_the_title() .'</h1>';
                    endif;
                ?>
                <div class="entry-content">
                    <!-- Display the post title -->
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile;
    else :
        // Display a message if no content is found
        echo '<p>No content found.</p>';
    endif;
    ?>
    <?php if ( is_active_sidebar( 'bottombar-1' ) ) : ?>
        <aside id="secondary" class="widget-area">
            <?php dynamic_sidebar( 'bottombar-1' ); ?>
        </aside>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
