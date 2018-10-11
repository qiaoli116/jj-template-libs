<?php

/*Template Name: Test Page
*/
d("page-test.php");
?>

<?php get_header(); ?>
<?php
if(have_posts()) { 
    while ( have_posts() ) { the_post();
        $id = get_the_ID();
        $fields = get_fields($id);
        d($fields);
        // break if single
	}
	wp_reset_postdata();
}
?>

<?php get_footer(); ?>