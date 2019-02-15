
<?php
function template_site_scripts() {

    //wp_enqueue_style('fontawesome-css', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css', array(), null);
    //wp_enqueue_style('fontawesome-css', get_template_directory_uri() . '/node_modules/@fortawesome/fontawesome-free/css/all.css', array(), null);
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), null);
    //wp_enqueue_style('google-font', 'https://fonts.googleapis.com/css?family=Raleway:800', array(), null);
    wp_enqueue_style('common-css', get_template_directory_uri() . '/css/common.css', array('bootstrap-css'), null);
    wp_enqueue_style('header-css', get_template_directory_uri() . '/css/header.css', array('common-css'), null);
    wp_enqueue_style('footer-css', get_template_directory_uri() . '/css/footer.css', array('common-css'), null);
    wp_enqueue_style('part-sample-css', get_template_directory_uri() . '/css/part-sample.css', array('common-css'), null);
    
    wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), null, true);
    wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery-js'), null, true);
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('popper-js'), null, true);
    //wp_enqueue_script('layout-js', get_template_directory_uri() . '/js/layout.js', array('jquery-js'), null, true);
    // there may or may not have js for header and footer
    // wp_enqueue_script('header-js', get_template_directory_uri() . '/js/header.js', array('layout-js'), null, true);
    // wp_enqueue_script('footer-js', get_template_directory_uri() . '/js/footer.js', array('layout-js'), null, true);

    if (get_current_template() == 'index.php') {
        //wp_enqueue_style('index-css', get_template_directory_uri() . '/css/index.css', array('header-footer-jscommon-css'), null);
    } elseif (get_current_template() == 'page-home.php') {
        wp_enqueue_style('home-css', get_template_directory_uri() . '/css/home.css', array('common-css'), null);
    } elseif (get_current_template() == 'page-sample.php') {
        wp_enqueue_style('page-sample-css', get_template_directory_uri() . '/css/page-sample.css', array('common-css'), null);
    }
}
add_action( 'wp_enqueue_scripts', 'template_site_scripts' );

?>