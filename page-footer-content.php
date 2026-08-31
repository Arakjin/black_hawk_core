<?php
/*
Template Name: Footer Content
*/

// Basic WordPress loop to fetch and display the page content
if (have_posts()) :
    while (have_posts()) : the_post();
        // Display the content of the page
        the_content();
    endwhile;
else :
    // Optional: Display a message if no content is found
    echo '<p>No content available for the footer.</p>';
endif;
?>
