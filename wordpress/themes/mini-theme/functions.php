<?php
require_once("wp-php-lib/wp-php-lib.php");
$d_flag = 0;

/**************************************/
/* Hook Section 1: wp_enqueue_scripts */
/**************************************/
function my_enqueue_bs_assets() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), null);
    //wp_enqueue_script('fa-script','https://use.fontawesome.com/releases/v5.0.1/js/all.js', array(), null);
    //wp_enqueue_style('google-font', 'https://fonts.googleapis.com/css?family=Raleway:800', array(), null);
    //wp_enqueue_style('common-css', get_template_directory_uri() . '/css/common.css', array('bootstrap-css'), null);
    //wp_enqueue_style('header-footer-css', get_template_directory_uri() . '/css/header-footer.css', array('common-css'), null);
    

    wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), null, true);
    wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery-js'), null, true);
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array('popper-js'), null, true);
    wp_enqueue_script('layout-js', get_template_directory_uri() . '/js/layout.js', array('jquery-js'), null, true);
    //wp_enqueue_script('header-footer-js', get_template_directory_uri() . '/js/header-footer.js', array('m-layout-js', 'layout-js'), null, true);

    if (get_current_template() == 'index.php') {
        wp_enqueue_style('index-style', get_template_directory_uri() . '/css/index.css', array(), null);
        wp_enqueue_script('index-js', get_template_directory_uri() . '/js/index.js', array('m-layout-js'), null, true);
        // no specific script
    } //elseif (get_current_template() == 'archive-projects.php') { 
       // wp_enqueue_script('vue-js', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), null);
    //} elseif (get_current_template() == 'single-projects.php'){
    //    wp_enqueue_style('index-style', get_template_directory_uri() . '/css/single-projects.css', array(), null);
    //}
        //elseif (get_current_template() == 'single-product.php') {
       // wp_enqueue_style('product-details-style', get_template_directory_uri() . '/css/product_details.css', array(), null);
        //wp_enqueue_script('product-details-js', get_template_directory_uri() . '/js/product_details.js', array(), null, true);
    //} //elseif {
       
    //}
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_bs_assets' );

/**************************************/
/* Hook Section 2: add_image_size     */
/**************************************/
// define image size
add_image_size( 'home_slider_desktop', '1750', '464', [ "center", "bottom"] ); 
add_image_size( 'home_slider_pad', '768', '464', [ "center", "bottom"] ); 
add_image_size( 'home_slider_phone', '576', '350', [ "center", "bottom"] );

/**************************************/
/* Hook Section 3: register_nav_menu  */
/**************************************/
function register_my_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
    register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_my_menu' );

/**************************************/
/* Hook Section 4: Register widget    */
/**************************************/
function reg_widget_areas() {
    register_sidebar( array(
        'name' => 'Theme Sidebar',
        'id' => 'mat-sidebar',
        'description' => 'this is a widget example',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
    ));
}
add_action( 'widgets_init', 'reg_widget_areas' );

/**************************************/
/* Hook Section 5: Enable svg upload  */
/**************************************/
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

?>