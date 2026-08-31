<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" />

    <!-- Open Graph meta tags -->
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?>" />
    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <meta property="og:url" content="<?php echo esc_url(home_url()); ?>" />
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/your-image.jpg" />
    <meta property="og:type" content="website" />
    <?php wp_head(); ?>
    <?php require_once(get_template_directory() . '/dynamicstyle.php'); ?>

</head>

<body id="main-page-top">
    <?php

    $show_logo = get_theme_mod('show_header_logo', true); // Default to true
    $show_text = get_theme_mod('show_subheaders', true); // Default to true
    $show_logo_and_texts = get_theme_mod('show_header_and_text_logo', true); // Default to true
    $show_main_header = get_theme_mod('show_main_header', true);
    $set_fixed_navbar = get_theme_mod('set_fixed_navbar', true);
    ?>
    <nav class="navbar navbar-expand-md <?php echo $set_fixed_navbar ? 'navbar-fixed' : ''; ?> p-3 container" id="mainNav">

        <a class="navbar-brand d-flex align-items-center justify-content-center">
            <?php
            $header_logo = get_theme_mod('header_logo');
            if ($header_logo) {
                echo '<img class="navbar-logo d-inline-block align-text-top pe-3" src="' . esc_url($header_logo) . '" />';
            }
            ?>
            <div class="d-flex flex-column text-center">
                <span class="navbar-heading">
                    <?php
                    if ($show_main_header):
                        $navbar_heading = get_theme_mod('heading_text');
                        echo $navbar_heading ? esc_html($navbar_heading) : bloginfo('name');
                    endif;
                    ?>
                </span>
                <span class="navbar-subheading">
                    <?php
                    if ($show_text):
                        $navbar_subheading = get_theme_mod('subheading_text');
                        echo $navbar_subheading ? esc_html($navbar_subheading) : bloginfo('description');
                    endif;
                    ?>
                </span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'dropdown-menu-start',
                'sub_menu_class' => 'dropdown-menu-dark',
                'fallback_cb' => '__return_false',
                'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
                'depth' => 2,
                'walker' => new bootstrap_5_wp_nav_menu_walker()
            ));
            ?>
        </div>
    </nav>

    <?php if ($set_fixed_navbar): ?>
        <div class="spacer container" id="navbarSpacer"></div>
    <?php endif; ?>