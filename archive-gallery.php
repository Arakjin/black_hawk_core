<?php
get_header('small');

// Get the number of columns set in the Customizer
$gallery_columns = get_theme_mod('gallery_columns', 3); // Default to 3 columns

// Determine the Bootstrap column class based on the number of columns
switch ($gallery_columns) {
    case 1:
        $col_class = 'col-md-12'; // Full-width for one column
        break;
    case 2:
        $col_class = 'col-md-6'; // Two columns per row
        break;
    case 3:
        $col_class = 'col-md-4'; // Three columns per row
        break;
    case 4:
        $col_class = 'col-md-3'; // Four columns per row
        break;
    case 6:
        $col_class = 'col-md-2'; // Six columns per row
        break;
    default:
        $col_class = 'col-md-4'; // Default to three columns per row
}

?>

<!-- Main Page Section -->
<section class="container page-section">
    <h1><?php echo get_theme_mod('gallery_page_title', __('Galleries', 'black_hawk_solutions_theme')); ?></h1>

    <div class="row">
    <?php
    // Fetch the default image from theme options
    $default_image = get_option('card_widget_default_image', ''); 

    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <div class="<?php echo esc_attr($col_class); ?> mb-4">
                <div class="card bg-dark h-100">
                    <div class="card-img-container">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="card-img-top" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php elseif ($default_image) : ?>
                                <img class="card-img-top" src="<?php echo esc_url($default_image); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <img class="card-img-top" src="<?php echo get_template_directory_uri(); ?>/path-to-default-image.jpg" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body bg-dark">
                        <h5 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Näytä galleria</a>
                    </div>
                </div>
            </div>
    <?php endwhile;

        the_posts_pagination();
    else :
        echo '<p>No galleries found.</p>';
    endif;
    ?>
    </div>
</section>

<?php get_footer('small'); ?>
