<?php
require_once("wp-php-lib/wp-php-lib.php");
$d_flag = 0;
// call wpse_nav_menu_2_tree to build a tree of nav
/* 
// define a getNav like below
// $menu is the return value of wpse_nav_menu_2_tree
// $result is the html doc to echo

function getNav($menu, &$result) {
    $result .= '<ul>';
    foreach ($menu as $v) {
        $result .= "<li><a href='{$v->url}'>{$v->title}</a></li>";
        if (isset($v->wpse_children)) {
            printTree($v->wpse_children, $result);
        }
    }
    $result .= '</ul>';
}

$mItem = wpse_nav_menu_2_tree('Menu 1');
$retult = '';
getNav($mItem, $retult);
echo $retult;
*/

function buildTree( array &$elements, $parentId = 0 ) {
    $branch = array();
    foreach ( $elements as &$element ) {
        if ( $element->menu_item_parent == $parentId ) {
            $children = buildTree( $elements, $element->ID );
            if ( $children ) {
                $element->wpse_children = $children;
            }

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}
function wpse_nav_menu_2_tree( $menu_id )
{
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? buildTree( $items, 0 ) : null;
}

/**
 * Get Current Theme Template Filename
 *
 * Get's the name of the current theme template file being used
 *
 * @global $current_theme_template Defined using define_current_template()
 * @param $echo Defines whether to return or print the template filename
 * @return The name of the template filename, including .php
 */
function get_current_template( $echo = false ) {
    if ( !isset( $GLOBALS['current_theme_template'] ) ) {
        trigger_error( '$current_theme_template has not been defined yet', E_USER_WARNING );
        return false;
    }
    if ( $echo ) {
        echo $GLOBALS['current_theme_template'];
    }
    else {
        return $GLOBALS['current_theme_template'];
    }
}

/*
 * add define current_theme_template in $GLOBALS as the theme template name called 
 */
function define_current_template( $template ) {
    //trigger_error( 'define_current_template called', E_USER_WARNING );
    $GLOBALS['current_theme_template'] = basename($template);

    return $template;
}
add_filter('template_include', 'define_current_template', 1000);


/*
 * add js, css to head and footer
 */

function my_enqueue_bs_assets() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), null);
    //wp_enqueue_script('fa-script','https://use.fontawesome.com/releases/v5.0.1/js/all.js', array(), null);
    //wp_enqueue_style('google-font', 'https://fonts.googleapis.com/css?family=Raleway:800', array(), null);
    //wp_enqueue_style('header-footer', get_template_directory_uri() . '/css/header_footer.css', array('bootstrap-css'), null);

    wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), null, true);
    wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery-js'), null, true);
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array('popper-js'), null, true);
    wp_enqueue_script('layout-js', get_template_directory_uri() . '/js/layout.js', array('jquery-js'), null, true);
	//wp_enqueue_script('m-layout-hf', get_template_directory_uri() . '/js/header_footer.js', array('m-layout-js', 'bootstrap-js'), null, true);

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

// define image size
//add_image_size( 'home_slider_desktop', '1750', '464', [ "center", "bottom"] ); 
//add_image_size( 'home_slider_pad', '768', '464', [ "center", "bottom"] ); 
//add_image_size( 'home_slider_phone', '576', '350', [ "center", "bottom"] );

// register menu
function register_my_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
    register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_my_menu' );

// register widget
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

// upload svg
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

?>