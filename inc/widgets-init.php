<?php
// Register widget areas
function black_hawk_solutions_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Left side Side bar', 'black_hawk_solutions'),
        'id'            => 'sidebar-1',
        'description'   => __('Left side side bar that appears on the left in main pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Right side Side bar', 'black_hawk_solutions'),
        'id'            => 'sidebar-2',
        'description'   => __('Right side side bar that appears on the right in main pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Top bar', 'black_hawk_solutions'),
        'id'            => 'topbar-1',
        'description'   => __('Main top bar that appears on the index page, Mainly used as "News" section.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));    
    register_sidebar(array(
        'name'          => __('Bottom bar', 'black_hawk_solutions'),
        'id'            => 'bottom-1',
        'description'   => __('Main bottom bar that appears on the index page, Mainly used as "News" section.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Left side Gallery Side bar', 'black_hawk_solutions'),
        'id'            => 'gallery-sidebar-1',
        'description'   => __('Left side sidebar that appears on the left in gallery pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Right side Gallery Side bar', 'black_hawk_solutions'),
        'id'            => 'gallery-sidebar-2',
        'description'   => __('Right side sidebar that appears on the right in gallery pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Left side shop Side bar', 'black_hawk_solutions'),
        'id'            => 'shop-sidebar-1',
        'description'   => __('Left side sidebar that appears on the left in certain pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Right side shop Side bar', 'black_hawk_solutions'),
        'id'            => 'shop-sidebar-2',
        'description'   => __('Right side sidebar that appears on the Right in certain pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Shop Top bar', 'black_hawk_solutions'),
        'id'            => 'shop-topbar-1',
        'description'   => __('Top bar that appears on the top of Shop pages.', 'black_hawk_solutions'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'black_hawk_solutions_widgets_init');
?>