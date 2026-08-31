<!-- Footer-->
<footer class="container footer text-center" style="background: <?php echo esc_attr(get_theme_mod('footer_enable_gradient', true) ? "linear-gradient(0deg, " . get_theme_mod('footer_gradient_color', '#101010') . " 0%, " . get_theme_mod('footer_background_color', '#000000') . " 100%)" : get_theme_mod('footer_background_color', '#000000')); ?>; color: #fff;">

    <?php
    $set1_count = get_theme_mod('footer_set1_count', 3);
    if ($set1_count > 0): ?>
        <div class="row justify-content-center">
            <?php
            for ($i = 1; $i <= $set1_count; $i++) :
                $col_class = get_footer_column_class($set1_count); // Get dynamic column class
                $header_size = get_theme_mod("footer_set1_header_$i", 'h3');
                $link_type = get_theme_mod("footer_set1_link_type_$i", 'none'); // Link type (none, icon, text, or both)
                $icon = get_theme_mod("footer_set1_icon_$i", '');
                $icon_size = get_theme_mod("footer_set1_icon_size_$i", '1x'); // Get the icon size
                $text = get_theme_mod("footer_set1_text_$i", '');
                $text_size = get_theme_mod("footer_set1_text_size_$i", '16px'); // Get the text size
                $link = get_theme_mod("footer_set1_link_$i", '');

                // Prepare the icon and text with link based on selection
                $icon_html = !empty($icon) ? "<i class='" . esc_attr($icon) . " fa-$icon_size mb-2'></i>" : '';
                $text_html = wpautop(esc_html($text));

                // Handle link wrapping logic
                if ($link_type == 'both') {
                    $content_html = "<a href='" . esc_url($link) . "'>" . $icon_html . " " . $text_html . "</a>";
                } elseif ($link_type == 'icon') {
                    $content_html = "<a href='" . esc_url($link) . "'>" . $icon_html . "</a> " . $text_html;
                } elseif ($link_type == 'text') {
                    $content_html = $icon_html . " <a href='" . esc_url($link) . "'>" . $text_html . "</a>";
                } else {
                    $content_html = $icon_html . " " . $text_html;
                }
            ?>
                <div class="<?php echo esc_attr($col_class); ?>">
                    <<?php echo esc_attr($header_size); ?>>
                        <?php echo $content_html; ?>
                    </<?php echo esc_attr($header_size); ?>>
                </div>
            <?php endfor; ?>
        </div>
    <?php endif; ?>


    <?php
    $set2_count = get_theme_mod('footer_set2_count', 3);
    if ($set2_count > 0): ?>
        <div class="row justify-content-center">
            <?php
            for ($i = 1; $i <= $set2_count; $i++) :
                $col_class = get_footer_column_class($set2_count); // Get dynamic column class
                $header_size = get_theme_mod("footer_set2_header_$i", 'h3');
                $link_type = get_theme_mod("footer_set2_link_type_$i", 'none'); // Link type (none, icon, text, or both)
                $icon = get_theme_mod("footer_set2_icon_$i", '');
                $icon_size = get_theme_mod("footer_set2_icon_size_$i", '1x'); // Get the icon size
                $text = get_theme_mod("footer_set2_text_$i", '');
                $text_size = get_theme_mod("footer_set2_text_size_$i", '16px'); // Get the text size
                $link = get_theme_mod("footer_set2_link_$i", '');

                // Prepare the icon and text with link based on selection
                $icon_html = !empty($icon) ? "<i class='" . esc_attr($icon) . " fa-$icon_size mb-2'></i>" : '';
                $text_html = wpautop(esc_html($text));

                // Handle link wrapping logic
                if ($link_type == 'both') {
                    $content_html = "<a href='" . esc_url($link) . "'>" . $icon_html . " " . $text_html . "</a>";
                } elseif ($link_type == 'icon') {
                    $content_html = "<a href='" . esc_url($link) . "'>" . $icon_html . "</a> " . $text_html;
                } elseif ($link_type == 'text') {
                    $content_html = $icon_html . " <a href='" . esc_url($link) . "'>" . $text_html . "</a>";
                } else {
                    $content_html = $icon_html . " " . $text_html;
                }
            ?>
                <div class="<?php echo esc_attr($col_class); ?>">
                    <<?php echo esc_attr($header_size); ?>>
                        <?php echo $content_html; ?>
                    </<?php echo esc_attr($header_size); ?>>
                </div>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</footer>

<div class="container copyright py-4 text-center" style="background: <?php echo esc_attr(get_theme_mod('copyright_enable_gradient', true) ? "linear-gradient(0deg, " . get_theme_mod('copyright_gradient_color', '#151515') . " 0%, " . get_theme_mod('copyright_background_color', '#101010') . " 100%)" : get_theme_mod('copyright_background_color', '#101010')); ?>;">
    <div class="row">
        <small class="col-6">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></small>
        <small class="col-6">Webdesign by: <a href="https://blackhawksolutions.fi/">Black Hawk Solutions</a></small>
    </div>
</div>

<?php wp_footer(); ?>
</body>

</html>