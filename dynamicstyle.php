
<?php
use BlackHawkSolutions\hex_to_rgb;
use BlackHawkSolutions\generate_css_filter;

$navbar_toggler_icon_data_url = static function ($color, $opacity) {
    $rgb = \BlackHawkSolutions\hex_to_rgb($color);
    $opacity = is_numeric($opacity) ? max(0, min(1, (float) $opacity)) : 1;

    if (!$rgb) {
        $rgb = array(255, 255, 255);
    }

    $stroke = sprintf('rgba(%d, %d, %d, %s)', $rgb[0], $rgb[1], $rgb[2], $opacity);
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path stroke="' . $stroke . '" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"/></svg>';

    return 'data:image/svg+xml,' . rawurlencode($svg);
};
?>
<style>
    :root {
        --header-height: <?php echo esc_attr(get_theme_mod('header_height', '750px')); ?>;
        --hero-logo-size: <?php echo esc_attr(get_theme_mod('masthead_logo_size', '10em')); ?>;
        --hero-heading-font-size: <?php echo esc_attr(get_theme_mod('masthead_heading_size', '4em')); ?>;
        --hero-subheading-font-size: <?php echo esc_attr(get_theme_mod('masthead_subheading_size', '4em')); ?>;
        --hero-padding: <?php echo esc_attr(get_theme_mod('masthead_gap_size', '0.5em')); ?>;

        --header-text-color: <?php echo esc_attr(get_theme_mod('header_text_color', '#FFFFFF')); ?>;

        --navbar-logo-size: <?php echo esc_attr(get_theme_mod('navbar_logo_size', '2em')); ?>;
        --navbar-heading-font-size: <?php echo esc_attr(get_theme_mod('navbar_heading_size', '4em')); ?>;
        --navbar-subheading-font-size: <?php echo esc_attr(get_theme_mod('navbar_subheading_size', '4em')); ?>;
        --navbar-padding: <?php echo esc_attr(get_theme_mod('navbar_gap_size', '0.5em')); ?>;
        --navbar-shrink-ratio: <?php echo esc_attr(get_theme_mod('navbar_shrink_ratio', 75)); ?>;

        --bs-navbar-bg-rgb: <?php echo esc_attr(get_theme_mod('navbar_background', 'rgba(0,0,0,1)')); ?>;
        --bs-navbar-shrink-bg-rgb: <?php echo esc_attr(get_theme_mod('navbar_shrink_background', 'rgba(0,0,0,0.8)')); ?>;

        /* Navbar Text Colors */
        --bs-navbar-emphasis-color-rgb: <?php 
            $rgb = \BlackHawkSolutions\hex_to_rgb(get_theme_mod('navbar_text_color', '#ffffff'));
            echo esc_attr($rgb ? implode(', ', $rgb) : '255, 255, 255'); 
        ?>;
        --bs-navbar-shrink-emphasis-color-rgb: <?php 
            $rgb = \BlackHawkSolutions\hex_to_rgb(get_theme_mod('navbar_shrink_text_color', '#ffffff'));
            echo esc_attr($rgb ? implode(', ', $rgb) : '255, 255, 255'); 
        ?>;
        --bs-navbar-toggler-icon-bg-custom: url("<?php echo esc_attr($navbar_toggler_icon_data_url(
            get_theme_mod('navbar_toggler_icon_color', '#ffffff'),
            get_theme_mod('navbar_toggler_icon_opacity', 1)
        )); ?>");
        --bs-navbar-shrink-toggler-icon-bg-custom: url("<?php echo esc_attr($navbar_toggler_icon_data_url(
            get_theme_mod('navbar_shrink_toggler_icon_color', '#ffffff'),
            get_theme_mod('navbar_shrink_toggler_icon_opacity', 1)
        )); ?>");

        <?php
        $color_navbar = get_theme_mod('color_navbar_logo', false); // Default to false
        if ($color_navbar):
            $navbar_logo_color = get_theme_mod('navbar_logo_color', '#ffffff');
            $navbar_shrink_logo_color = get_theme_mod('navbar_shrink_logo_color', '#ffffff');

            $navbar_logo_filter = \BlackHawkSolutions\generate_css_filter($navbar_logo_color) ?: 'none';
            $navbar_shrink_logo_filter = \BlackHawkSolutions\generate_css_filter($navbar_shrink_logo_color) ?: 'none';
        
            // Output CSS variables
            echo "--navbar-logo-filter: {$navbar_logo_filter};";
            echo "--navbar-shrink-logo-filter: {$navbar_shrink_logo_filter};";
        endif;
        ?>
        
        --category-heading-font-size: <?php echo esc_attr(get_theme_mod('category_heading_font_size', '1em')); ?>;
        --default-link-color: <?php echo esc_attr(get_theme_mod('default_link_color', '#FF6a00')); ?>;

        
        --default-link-color-rgb: <?php 
            $rgb = \BlackHawkSolutions\hex_to_rgb(get_theme_mod('default_link_color', '#FF6a00'));
            echo esc_attr($rgb ? implode(', ', $rgb) : '255, 106, 0'); 
        ?>;
        
        --section-text-color: <?php echo esc_attr(get_theme_mod('section_text_color', '#FFFFFF')); ?>;
        --default-hover-color: <?php echo esc_attr(get_theme_mod('default_hover_color', '#be4f00')); ?>;
        --default-active-color: <?php echo esc_attr(get_theme_mod('default_active_color', '#FF6a00')); ?>;
        --default-disabled-color: <?php echo esc_attr(get_theme_mod('default_disabled_color', '#973f00')); ?>;
        --default-link-border-color: <?php echo esc_attr(get_theme_mod('default_link_border_color', '#FF6a00')); ?>;
        --default-hover-border-color: <?php echo esc_attr(get_theme_mod('default_hover_border_color', '#be4f00')); ?>;
        --default-active-border-color: <?php echo esc_attr(get_theme_mod('default_active_border_color', '#FF6a00')); ?>;
        --default-disabled-border-color: <?php echo esc_attr(get_theme_mod('default_disabled_border_color', '#753100')); ?>;

        --bs-body-color: <?php echo esc_attr(get_theme_mod('bs_body_color', '#212529')); ?>;

        --header-shadow: <?php echo esc_attr(get_theme_mod('header_shadow', '0px 0px 2px black;')); ?>;

    }

    .btn-primary {
        --bs-btn-color: <?php echo esc_attr(get_theme_mod('bs_btn_color', '#fff')); ?>;
        --bs-btn-bg: <?php echo esc_attr(get_theme_mod('bs_btn_bg', '#FF6a00')); ?>;
        --bs-btn-border-color: <?php echo esc_attr(get_theme_mod('bs_btn_border_color', '#FF6a00')); ?>;
        --bs-btn-hover-color: <?php echo esc_attr(get_theme_mod('bs_btn_hover_color', '#fff')); ?>;
        --bs-btn-hover-bg: <?php echo esc_attr(get_theme_mod('bs_btn_hover_bg', '#be4f00')); ?>;
        --bs-btn-hover-border-color: <?php echo esc_attr(get_theme_mod('bs_btn_hover_border_color', '#be4f00')); ?>;
        --bs-btn-active-color: <?php echo esc_attr(get_theme_mod('bs_btn_active_color', '#fff')); ?>;
        --bs-btn-active-bg: <?php echo esc_attr(get_theme_mod('bs_btn_active_bg', '#FF6a00')); ?>;
        --bs-btn-active-border-color: <?php echo esc_attr(get_theme_mod('bs_btn_active_border_color', '#FF6a00')); ?>;
        --bs-btn-disabled-color: <?php echo esc_attr(get_theme_mod('bs_btn_disabled_color', '#fff')); ?>;
        --bs-btn-disabled-bg: <?php echo esc_attr(get_theme_mod('bs_btn_disabled_bg', '#973f00')); ?>;
        --bs-btn-disabled-border-color: <?php echo esc_attr(get_theme_mod('bs_btn_disabled_border_color', '#973f00')); ?>;
    }
</style>
