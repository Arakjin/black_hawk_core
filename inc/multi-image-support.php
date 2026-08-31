<?php
// Custom Multi-Image Control Class for Customizer// Define the custom control class
function black_hawk_solutions_custom_controls() {
    class WP_Customize_Multi_Image_Control extends WP_Customize_Control {
        public $type = 'multi_image';

        public function enqueue() {
            wp_enqueue_media();
        }

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <div class="multi-image-wrapper">
                    <ul class="multi-image-list">
                        <!-- Selected images will be displayed here -->
                    </ul>
                    <button type="button" class="button multi-image-add"><?php esc_html_e('Add Images'); ?></button>
                    <button type="button" class="button multi-image-clear"><?php esc_html_e('Clear All'); ?></button>
                    <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
                </div>
            </label>
            <?php
        }
    }
}
add_action('customize_register', 'black_hawk_solutions_custom_controls', 1); // Priority 1 to ensure class is available early

