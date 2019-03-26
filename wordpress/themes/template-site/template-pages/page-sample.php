<?php
/*Template Name: Sample Page

*/
?>



<?php get_header(); ?>

<?php
if(have_posts()) { 
    while (have_posts() ) { the_post();
        $id = get_the_ID();
        // all other data are accessable with the id
        break;
	}
	wp_reset_postdata();
}

?>
<h1>This is a Sample Page - Page id = <?php echo $id;?></h1>
<?php get_footer(); ?>  