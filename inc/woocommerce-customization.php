<?php
namespace BlackHawkSolutions;

// Rekisteröi WooCommerce-kustomoinnit, kun WooCommerce on ladattu
add_action( 'woocommerce_init', __NAMESPACE__ . '\\init_woocommerce_customizations' );

/**
 * Rekisteröi tarvittavat filttereiden callbackit.
 */
function init_woocommerce_customizations() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // 1) WC:n wc_get_button_html() -napit
    add_filter(
        'woocommerce_get_button_html_args',
        __NAMESPACE__ . '\\add_btn_class_to_wc_buttons',
        20,
        1
    );

    // 2) Loopin add-to-cart -linkit
    add_filter(
        'woocommerce_loop_add_to_cart_args',
        __NAMESPACE__ . '\\add_btn_to_loop_add_to_cart',
        20,
        2
    );

    // 3) Single-product -napin <button> luokat
    add_filter(
        'woocommerce_product_add_to_cart_class',
        __NAMESPACE__ . '\\add_btn_to_product_add_to_cart_class',
        20,
        2
    );

        // 4) Määräkentän luokka (uusi hook)
    remove_filter(
        'woocommerce_quantity_input_args',
        __NAMESPACE__ . '\add_form_control_to_quantity_input',
        20
    );
    add_filter(
        'woocommerce_quantity_input_classes',
        __NAMESPACE__ . '\add_form_control_to_quantity_input_classes',
        20,
        2
    );
}

/**
 * Lisää 'form-control' määräkentän CSS-luokkiin.
 */
function add_form_control_to_quantity_input_classes( array $classes, $product ): array {
    $classes[] = 'form-control';
    return $classes;
}/** Lisää 'btn' wc_get_button_html() -nappeihin. */
function add_btn_class_to_wc_buttons( array $args ): array {
    $args['class'] = trim( $args['class'] . ' btn' );
    return $args;
}

/** Lisää 'btn' loopin add-to-cart -linkkeihin. */
function add_btn_to_loop_add_to_cart( array $args, $product ): array {
    $args['class'] = trim( $args['class'] . ' btn' );
    return $args;
}

/** Lisää 'btn' single-product -sivun <button> luokkaan. */
function add_btn_to_product_add_to_cart_class( string $class, $product ): string {
    return trim( $class . ' btn' );
}

/** Lisää 'form-control' määräkenttään. */
function add_form_control_to_quantity_input( array $args, $product ): array {
    if ( empty( $args['input_class'] ) || ! is_array( $args['input_class'] ) ) {
        $args['input_class'] = [];
    }
    $args['input_class'][] = 'form-control';
    return $args;
}

// JS-fallback kovakoodatuille nappeille
add_action( 'wp_footer', __NAMESPACE__ . '\\add_btn_js_fallback' );
function add_btn_js_fallback() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectors = ['.button', '.add_to_cart_button', '.single_add_to_cart_button'];
        selectors.forEach(function(sel) {
            document.querySelectorAll(sel).forEach(function(el) {
                if (!el.classList.contains('btn')) {
                    el.classList.add('btn');
                }
            });
        });
    });
    </script>
    <?php
}
