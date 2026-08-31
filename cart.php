<?php
/*
Template Name: Cart
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
        <div class="row">
            <!-- Main Content Section -->
            <div class="col-12 pt-3">
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
        </div>
    </div>
</section>

<?php get_footer('small'); ?>
