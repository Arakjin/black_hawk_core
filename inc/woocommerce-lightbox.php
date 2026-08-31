<?php

add_action( 'after_setup_theme', 'enable_woocommerce_gallery_features', 99 );
function enable_woocommerce_gallery_features() {
    // Lisää tuen WooCommercen gallerian lightboxille, zoomille ja liukusäätimelle
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

?>