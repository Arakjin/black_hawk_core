<?php
/*
Template Name: Shop
*/
get_header('small'); ?>

<!-- Main Page Section -->
<section class="container page-section">
    <div class="woocommerce">

        <div class="row border-bottom">
            <div class="col-6">
            <?php if ( has_nav_menu( 'shop_menu' ) ) : ?>
                    <nav class="container navbar navbar-expand-lg navbar-shrink" id="shopNav">
                        <button class="navbar-toggler text-uppercase font-weight-bold main-gradient text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#shopNavbarResponsive" aria-controls="shopNavbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                            Kauppa
                            <i class="fas fa-bars"></i>
                        </button>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'shop_menu',
                            'container' => false,
                            'menu_class' => 'dropdown-menu-start',
                            'sub_menu_class' => 'dropdown-menu-dark',
                            'fallback_cb' => '__return_false',
                            'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
                            'depth' => 2,
                            'walker' => new bootstrap_5_wp_nav_menu_walker()
                        ));
                        ?>
                    </nav>                
                <?php endif; ?>
            </div>
            <div class="col-6">
                <?php if (is_active_sidebar('shop-topbar-1')) : ?>
                    <aside id="shop-topbar" class="widget-area">
                        <?php dynamic_sidebar('shop-topbar-1'); ?>
                    </aside><!-- #shop-topbar -->
                <?php endif; ?>
            </div>
        </div>

        <?php
        // Determine the column class based on the active sidebars
        $main_content_class = 'col-md-12'; // Default full width if no sidebars
        $sidebar1_active = is_active_sidebar('shop-sidebar-1');
        $sidebar2_active = is_active_sidebar('shop-sidebar-2');

        if ($sidebar1_active && $sidebar2_active) {
            $main_content_class = 'col-md-8'; // Both sidebars are active
        } elseif ($sidebar1_active || $sidebar2_active) {
            $main_content_class = 'col-md-10'; // One sidebar is active
        }
        ?>

        <div class="row">
            <!-- Render Sidebar 1 if active -->
            <?php if ($sidebar1_active) : ?>
                <div class="col-md-2 border-end pt-3">
                    <aside id="shop-sidebar" class="widget-area">
                        <?php dynamic_sidebar('shop-sidebar-1'); ?>
                    </aside><!-- #shop-sidebar-1 -->
                </div>
            <?php endif; ?>

            <!-- Main Content Section -->
            <div class="<?php echo esc_attr($main_content_class); ?> pt-3">
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
            </div>

            <!-- Render Sidebar 2 if active -->
            <?php if ($sidebar2_active) : ?>
                <div class="col-md-2 border-start pt-3">
                    <aside id="shop-sidebar" class="widget-area">
                        <?php dynamic_sidebar('shop-sidebar-2'); ?>
                    </aside><!-- #shop-sidebar-2 -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer('small'); ?>
