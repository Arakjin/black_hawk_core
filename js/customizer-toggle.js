jQuery(document).ready(function ($) {
    $('#footer-background-toggle').on('click', function () {
        $('[data-group="footer_colors"]').toggle(); // Target all elements with the same data-group
    });
});
