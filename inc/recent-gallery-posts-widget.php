<?php
// Register the custom gallery widget
function register_gallery_widget()
{
    register_widget('Gallery_Posts_Widget');
}
add_action('widgets_init', 'register_gallery_widget');

// Define the widget class
class Gallery_Posts_Widget extends WP_Widget
{
    // Constructor
    public function __construct()
    {
        parent::__construct(
            'gallery_posts_widget', // Base ID
            __('Black Hawk Latest Gallery Posts', 'text_domain'), // Name
            array('description' => __('A widget that displays the latest gallery posts.', 'text_domain'))
        );
    }

    // Widget frontend
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        $title = ! empty($instance['title']) ? $instance['title'] : __('Latest Galleries', 'text_domain');
        echo $args['before_title'] . $title . $args['after_title'];

        // Fetch gallery posts
        $num_posts = ! empty($instance['num_posts']) ? $instance['num_posts'] : 5;
        $gallery_query = new WP_Query(array(
            'post_type' => 'gallery', // Custom post type 'gallery'
            'posts_per_page' => $num_posts,
        ));

        if ($gallery_query->have_posts()) :
            echo '<ul class="gallery-posts-list list-group bg-dark">';
            while ($gallery_query->have_posts()) : $gallery_query->the_post();
                echo '<li class="list-group-item bg-dark">';
                echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                echo '</li>';
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p class="text-white">' . __('No galleries found.', 'text_domain') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    // Widget settings form in the admin
    public function form($instance)
    {
        $title = ! empty($instance['title']) ? $instance['title'] : __('Latest Galleries', 'text_domain');
        $num_posts = ! empty($instance['num_posts']) ? $instance['num_posts'] : 5;
?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"><?php _e('Number of Galleries:'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('num_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('num_posts')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($num_posts); ?>" size="3">
        </p>
<?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['num_posts'] = (! empty($new_instance['num_posts'])) ? intval($new_instance['num_posts']) : 5;
        return $instance;
    }
}
?>