<?php
/*Template Name: Home Page

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

<h1>This is the Home Page - Page id = <?php echo $id;?></h1>

<h2>Call sample template</h2>
<?php
    $p1 = array("foo" => 1);
    include( get_template_directory().'/template-parts/part-sample.php' );
    unset($p1);
?>

<?php get_footer(); ?>  