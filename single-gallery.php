<?php
/*
Template Name: Gallery
*/ 
get_header('small'); ?>

<!-- Main Single Post Section -->
<section class="container page-section">
    <?php
    // Determine the column class based on the active sidebars
    $main_content_class = 'col-md-12'; // Default full width if no sidebars
    $sidebar1_active = is_active_sidebar('gallery-sidebar-1');
    $sidebar2_active = is_active_sidebar('gallery-sidebar-2');

    if ($sidebar1_active && $sidebar2_active) {
        $main_content_class = 'col-md-8'; // Both sidebars are active
    } elseif ($sidebar1_active || $sidebar2_active) {
        $main_content_class = 'col-md-10'; // One sidebar is active
    }
    ?>

    <div class="row">
        
        <!-- Render Sidebar 1 if active -->
        <?php if ($sidebar1_active) : ?>
            <div class="col-md-2 border-end">
                <aside id="main-sidebar" class="widget-area">
                    <?php dynamic_sidebar('gallery-sidebar-1'); ?>
                </aside>
            </div>
        <?php endif; ?>

        <!-- Main Content Section -->
        <div class="<?php echo esc_attr($main_content_class); ?>">
            <?php
            // The Loop to display the single gallery content
            if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <!-- Display the gallery title -->
                        <h1 class="entry-title mb-3"><?php the_title(); ?></h1>
                        
                        <!-- Display the featured image if set and if the customizer option allows it -->
                        <?php if (get_theme_mod('gallery_show_featured_image', true) && has_post_thumbnail()) : ?>
                            <div class="post-thumbnail main-gradient">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?> <!-- Add Bootstrap's img-fluid class -->
                            </div>
                        <?php endif; ?>

                        
                        <!-- Display gallery content -->
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>

                        <!-- Optionally display categories and tags -->
                        <div class="post-categories">
                            <p>Categories: <?php the_category(', '); ?></p>
                        </div>
                        <div class="post-tags">
                            <p><?php the_tags(); ?></p>
                        </div>
                        
                        <?php
                        // Display comments if enabled
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>

                    </article>
                <?php endwhile;
            else :
                echo '<p>No gallery found.</p>';
            endif;
            ?>
        </div>

        <!-- Render Sidebar 2 if active -->
        <?php if ($sidebar2_active) : ?>
            <div class="col-md-2 border-start">
                <aside id="secondary-sidebar" class="widget-area">
                    <?php dynamic_sidebar('gallery-sidebar-2'); ?>
                </aside>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php get_footer('small'); ?>
