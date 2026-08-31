<?php get_header('small'); ?>

<!-- Main Page Section -->
<section class="container page-section">
    <?php if ( is_active_sidebar( 'topbar-1' ) ) : ?>
        <aside id="secondary" class="widget-area">
            <?php dynamic_sidebar( 'topbar-1' ); ?>
        </aside>
    <?php endif; ?>

    <?php
        $show_title = get_theme_mod('display_site_header', true);

    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Display title for posts or pages -->
                <?php
                    if($show_title):
                        echo '<h1 class="entry-title mb-3">'. get_the_title() .'</h1>';
                    endif;
                ?>
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
