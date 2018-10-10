

<?php get_header(); ?>

<?php 
d("index.php");

// the following show an exmple of calling parts-templates
$param1 = "pass 1 to parts template";
$param2 = "pass 2 to parts template";
include( get_template_directory().'/parts-templates/parts-test.php' );
// or include( locate_template( 'parts-templates/parts-test.php', false, false ) );
?>

<?php get_footer(); ?>