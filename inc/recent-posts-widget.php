<?php
// Register the custom posts widget
function register_posts_widget() {
    register_widget('Posts_Widget');
}
add_action('widgets_init', 'register_posts_widget');

// Define the widget class for default posts
class Posts_Widget extends WP_Widget {
    // Constructor
    public function __construct() {
        parent::__construct(
            'posts_widget', // Base ID
            __('Black Hawk Latest Blog Posts', 'text_domain'), // Name
            array('description' => __('A widget that displays the latest blog posts with options to show image, excerpt, and date, and filter by category.', 'text_domain'))
        );
    }

    // Widget frontend
    public function widget($args, $instance) {
        echo $args['before_widget'];
        $title = ! empty($instance['title']) ? $instance['title'] : __('Latest Blog Posts', 'text_domain');
        echo $args['before_title'] . $title . $args['after_title'];

        // Fetch widget settings
        $num_posts = ! empty($instance['num_posts']) ? $instance['num_posts'] : 5;
        $show_image = ! empty($instance['show_image']) ? $instance['show_image'] : false;
        $show_excerpt = ! empty($instance['show_excerpt']) ? $instance['show_excerpt'] : false;
        $show_date = ! empty($instance['show_date']) ? $instance['show_date'] : false;
        $category = ! empty($instance['category']) ? $instance['category'] : '';

        // Query arguments
        $query_args = array(
            'post_type' => 'post', // Default post type
            'posts_per_page' => $num_posts,
            'category__not_in' => array(get_cat_ID('Gallery')), // Exclude "Gallery" category by default
        );

        if (!empty($category)) {
            $query_args['cat'] = $category; // Filter by selected category
        }

        $post_query = new WP_Query($query_args);

        if ($post_query->have_posts()) :
            echo '<ul class="posts-list list-group bg-dark">';
            while ($post_query->have_posts()) : $post_query->the_post();
                echo '<li class="list-group-item bg-dark">';

                // Show post image if option is enabled
                if ($show_image && has_post_thumbnail()) {
                    echo '<a href="' . get_the_permalink() . '">';
                    echo get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('class' => 'img-fluid mb-2'));
                    echo '</a>';
                }

                // Show post title
                echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';

                // Show date if option is enabled
                if ($show_date) {
                    echo '<div class="post-date text-white">' . get_the_date() . '</div>';
                }

                // Show excerpt or first few words of the post content
                if ($show_excerpt) {
                    if (has_excerpt()) {
                        echo '<p class="text-white">' . get_the_excerpt() . '</p>';
                    } else {
                        echo '<p class="text-white">' . wp_trim_words(get_the_content(), 20, '...') . '</p>';
                    }
                }

                echo '</li>';
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p class="text-white">' . __('No posts found.', 'text_domain') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    // Widget settings form in the admin
    public function form($instance) {
        $title = ! empty($instance['title']) ? $instance['title'] : __('Latest Blog Posts', 'text_domain');
        $num_posts = ! empty($instance['num_posts']) ? $instance['num_posts'] : 5;
        $show_image = ! empty($instance['show_image']) ? (bool) $instance['show_image'] : false;
        $show_excerpt = ! empty($instance['show_excerpt']) ? (bool) $instance['show_excerpt'] : false;
        $show_date = ! empty($instance['show_date']) ? (bool) $instance['show_date'] : false;
        $category = ! empty($instance['category']) ? $instance['category'] : '';

        // Fetch all categories except "Gallery"
        $categories = get_categories(array('exclude' => get_cat_ID('Gallery')));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"><?php _e('Number of Posts:'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('num_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('num_posts')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($num_posts); ?>" size="3">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_image); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" />
            <label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show post image?'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_excerpt); ?> id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" />
            <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show post excerpt?'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show post date?'); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php _e('Category:'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
                <option value=""><?php _e('All Categories'); ?></option>
                <?php
                foreach ($categories as $cat) {
                    echo '<option value="' . esc_attr($cat->term_id) . '" ' . selected($category, $cat->term_id, false) . '>' . esc_html($cat->name) . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['num_posts'] = (! empty($new_instance['num_posts'])) ? intval($new_instance['num_posts']) : 5;
        $instance['show_image'] = ! empty($new_instance['show_image']) ? (bool) $new_instance['show_image'] : false;
        $instance['show_excerpt'] = ! empty($new_instance['show_excerpt']) ? (bool) $new_instance['show_excerpt'] : false;
        $instance['show_date'] = ! empty($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
        $instance['category'] = (! empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
        return $instance;
    }
}
?>