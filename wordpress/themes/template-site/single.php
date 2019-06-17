<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Template_Site
 */

get_header();
$post_data = false;
while ( have_posts() ) :
    $id = get_the_ID();
    // all other data are accessable with the id
    $cat = get_the_category($id);
    $post_data = array(
        "title" => get_the_title($id),
        "content" => wpautop(get_the_content(null, true)),
        "link" => get_the_permalink($id),
        "date" => get_the_date('j/n/Y', $id),
    );
    break;
endwhile; // End of the loop.
?>


<?php
get_sidebar();
get_footer();
