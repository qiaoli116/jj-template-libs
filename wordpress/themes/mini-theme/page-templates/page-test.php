<?php

/*Template Name: Test Page
*/
d("page-test.php");
?>

<?php get_header(); ?>
<?php
// query and loop 1
if(have_posts()) { 
    while ( have_posts() ) { the_post();
        $id = get_the_ID();
        $fields = get_fields($id);
        d($fields);
        // break if single
	}
	wp_reset_postdata();
}

// query and loop 2
$args = array(
    
);
$query = new WP_Query( $args );
$_data = false;
if($query->have_posts()) { 
    $_data = array();
    while ( $query->have_posts() ) { $query->the_post();
        $id = get_the_ID();
        // break if single
	}
	wp_reset_postdata();
}
?>

<?php get_footer(); ?>