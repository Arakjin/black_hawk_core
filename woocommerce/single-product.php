<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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
				<div class="col-md-2 border-right pt-3">
					<aside id="shop-sidebar" class="widget-area">
						<?php dynamic_sidebar('shop-sidebar-1'); ?>
					</aside><!-- #shop-sidebar-1 -->
				</div>
			<?php endif; ?>

			<!-- Main Content Section -->
			<div class="<?php echo esc_attr($main_content_class); ?> pt-3">
				<?php
					/**
					 * woocommerce_before_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 */
					do_action( 'woocommerce_before_main_content' );
				?>

					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>

						<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php
					/**
					 * woocommerce_after_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>
			</div>

			<!-- Render Sidebar 2 if active -->
			<?php if ($sidebar2_active) : ?>
				<div class="col-md-2 border-left pt-3">
					<aside id="shop-sidebar" class="widget-area">
						<?php dynamic_sidebar('shop-sidebar-2'); ?>
					</aside><!-- #shop-sidebar-2 -->
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer('small');
