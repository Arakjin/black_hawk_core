<?php
// Register the WooCommerce Categories widget
function register_black_hawk_woocommerce_categories_widget() {
    register_widget('Black_Hawk_WooCommerce_Categories_Widget');
}
add_action('widgets_init', 'register_black_hawk_woocommerce_categories_widget');

// Define the widget class for WooCommerce categories
class Black_Hawk_WooCommerce_Categories_Widget extends WP_Widget {
    // Constructor
    public function __construct() {
        parent::__construct(
            'black_hawk_woocommerce_categories_widget', // Base ID
            __('Black Hawk WooCommerce Category list', 'text_domain'), // Name
            array('description' => __('A widget to display WooCommerce categories with options to show the category image, count, and link to shop pages.', 'text_domain'))
        );
    }

    // Widget frontend
    public function widget($args, $instance) {
        echo $args['before_widget'];
        $title = ! empty($instance['title']) ? $instance['title'] : __('Shop Categories', 'text_domain');
        echo $args['before_title'] . $title . $args['after_title'];

        // Fetch widget settings
        $show_image = ! empty($instance['show_image']) ? $instance['show_image'] : false;
        $show_count = ! empty($instance['show_count']) ? $instance['show_count'] : false;
        $show_empty = ! empty($instance['show_empty']) ? $instance['show_empty'] : false;

        // Get WooCommerce product categories with the option to show empty categories
        $terms = get_terms('product_cat', array('hide_empty' => !$show_empty)); // Use hide_empty based on widget setting

        if (!empty($terms)) :
            echo '<ul class="woocommerce-categories-list list-group bg-dark">';
            foreach ($terms as $term) :
                echo '<li class="list-group-item bg-dark text-white">';

                // Show category image if option is enabled
                if ($show_image) {
                    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    if ($thumbnail_id) {
                        $image = wp_get_attachment_image($thumbnail_id, 'thumbnail', false, array('class' => 'img-fluid mb-2'));
                        echo '<a href="' . esc_url(get_term_link($term)) . '">' . $image . '</a>';
                    }
                }

                // Show category name
                echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';

                // Show product count if option is enabled
                if ($show_count) {
                    echo ' (' . intval($term->count) . ')';
                }

                echo '</li>';
            endforeach;
            echo '</ul>';
        else :
            echo '<p class="text-white">' . __('No categories found.', 'text_domain') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    // Widget settings form in the admin
    public function form($instance) {
        $title = ! empty($instance['title']) ? $instance['title'] : __('Shop Categories', 'text_domain');
        $show_image = ! empty($instance['show_image']) ? (bool) $instance['show_image'] : false;
        $show_count = ! empty($instance['show_count']) ? (bool) $instance['show_count'] : false;
        $show_empty = ! empty($instance['show_empty']) ? (bool) $instance['show_empty'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_image); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" />
            <label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show category image?'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_count); ?> id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" />
            <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show product count?'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_empty); ?> id="<?php echo $this->get_field_id('show_empty'); ?>" name="<?php echo $this->get_field_name('show_empty'); ?>" />
            <label for="<?php echo $this->get_field_id('show_empty'); ?>"><?php _e('Show empty categories?'); ?></label>
        </p>
        <?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['show_image'] = ! empty($new_instance['show_image']) ? (bool) $new_instance['show_image'] : false;
        $instance['show_count'] = ! empty($new_instance['show_count']) ? (bool) $new_instance['show_count'] : false;
        $instance['show_empty'] = ! empty($new_instance['show_empty']) ? (bool) $new_instance['show_empty'] : false;
        return $instance;
    }
}
?>