<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>

<ul class="woocommerce-error" role="alert">
    <?php foreach ( $notices as $notice ) : ?>
        <li<?php echo wc_get_notice_data_attr( $notice ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php 
            // Capture the error content
            $error_content = wc_kses_notice( $notice['notice'] );

            // Check if the content has a button and add the 'btn' class dynamically
            if ( strpos( $error_content, '<a' ) !== false ) {
                $error_content = preg_replace( '/<a(.*?)class="(.*?)"/', '<a$1class="$2 btn"', $error_content );
                $error_content = preg_replace( '/<a(?!.*class=")/', '<a class="btn"', $error_content );
            }

            // Output the modified content
            echo $error_content; 
            ?>
        </li>
    <?php endforeach; ?>
</ul>

