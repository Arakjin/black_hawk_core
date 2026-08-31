<?php
get_header('small'); ?>

<!-- Main Single Post Section -->
<section class="container page-section">
    <?php
    // Determine the column class based on the active sidebars
    $main_content_class = 'col-md-12'; // Default full width if no sidebars
    $sidebar1_active = is_active_sidebar('sidebar-1');
    $sidebar2_active = is_active_sidebar('sidebar-2');
    $show_title = get_theme_mod('display_site_header', true);

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
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </aside>
            </div>
        <?php endif; ?>

        <!-- Main Content Section -->
        <div class="<?php echo esc_attr($main_content_class); ?>">

            <?php
            // The Loop to display the single post content
            if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <!-- Display the post title -->
                        <?php
                            if($show_title):
                                echo '<h1 class="entry-title mb-3">'. the_title() .'</h1>';
                            endif;
                        ?>                        
                        <!-- Display the featured image if set and if the customizer option allows it -->
                        <?php if (get_theme_mod('single_post_show_featured_image', true) && has_post_thumbnail()) : ?>
                            <div class="post-thumbnail main-gradient">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Display post metadata (date, author) -->
                        <div class="entry-meta">
                            <?php if (get_theme_mod('display_post_date', true)) : ?>
                                <p>Posted on <?php the_time('F j, Y'); ?></p>
                            <?php endif; ?>

                            <?php if (get_theme_mod('display_post_author', true)) : ?>
                                <p>by <?php the_author(); ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- Display the post content -->
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        <!-- Display post categories and tags -->
                        <?php if (get_theme_mod('display_post_categories', true)) : ?>
                            <div class="post-categories">
                                <p>Categories: <?php the_category(', '); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (get_theme_mod('display_post_tags', true)) : ?>
                            <div class="post-tags">
                                <p><?php the_tags(); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Check if commenting is allowed globally or for this specific post
                        $show_comments = get_option('default_comment_status') === 'open' && (comments_open() || get_comments_number());

                        // Display comments if enabled
                        if ($show_comments) :
                            comments_template();
                        endif;
                        ?>
                    </article>
            <?php endwhile;
            else :
                echo '<p>No post found.</p>';
            endif;

            ?>
        </div>

        <!-- Render Sidebar 2 if active -->
        <?php if ($sidebar2_active) : ?>
            <div class="col-md-2 border-start">
                <aside id="secondary-sidebar" class="widget-area">
                    <?php dynamic_sidebar('sidebar-2'); ?>
                </aside>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php get_footer('small'); ?>