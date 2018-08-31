

<?php get_header(); ?>

<?php 
d("index.php");

$p = "pass to parts template";
include( locate_template( 'parts-templates/parts-test.php', false, false ) );
?>

<?php get_footer(); ?>