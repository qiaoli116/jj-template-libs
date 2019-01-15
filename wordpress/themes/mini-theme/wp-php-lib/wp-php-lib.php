<?php
/**
 * @param $line __LINE__
 * @param $function __FUNCTION__
 * @param $file __FILE__
 * @param $string any string
 * @param $flag true to log; false not to log
 * @return none
 */
function d_log ($line, $function, $file, $string, $flag) {
    //d_log(__LINE__, __FUNCTION__, __FILE__, ' text to log');
    if($flag) {
        error_log('[' . $line . '@' . $function . '@' . basename($file) .'] ' . $string);
    }
    return;
}


/**
 * @param $var any variable
 * @return string: format
 */
function var_dump_str($var) {
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

/**
 * @param $date integer of unixtimestamp format, not actual date type
 * @return string
 */
function zdateRelative($date){
    $now = time();
    $diff = $now - $date;

    if ($diff < 60){
        return sprintf($diff > 1 ? '%s seconds ago' : 'a second ago', $diff);
    }

    $diff = floor($diff/60);

    if ($diff < 60){
        return sprintf($diff > 1 ? '%s minutes ago' : 'one minute ago', $diff);
    }

    $diff = floor($diff/60);

    if ($diff < 24){
        return sprintf($diff > 1 ? '%s hours ago' : 'an hour ago', $diff);
    }

    $diff = floor($diff/24);

    if ($diff < 7){
        return sprintf($diff > 1 ? '%s days ago' : 'yesterday', $diff);
    }

    if ($diff < 30)
    {
        $diff = floor($diff / 7);

        return sprintf($diff > 1 ? '%s weeks ago' : 'one week ago', $diff);
    }

    $diff = floor($diff/30);

    if ($diff < 12){
        return sprintf($diff > 1 ? '%s months ago' : 'last month', $diff);
    }

    $diff = date('Y', $now) - date('Y', $date);

    return sprintf($diff > 1 ? '%s years ago' : 'last year', $diff);
}


/**
 * @param $sidebar_id side bar id
 * @return string: html output
 */
function get_dynamic_sidebar($sidebar_id)
{
    ob_start();
    dynamic_sidebar($sidebar_id);
    $out = ob_get_contents();
    ob_end_clean();
    return $out;
}

/**
 * reconstruct the out array of wp_get_nav_menu_items and build a tree structure
 * @param &$elements generate by wp_get_nav_menu_items()
 * @param $parentId parent menu item id of current menu item
 * @return array: menu in tree structure
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
/**
 * reconstruct the out array of wp_get_nav_menu_items and build a tree structure by calling buildTree
 * @param $menu_id name of menu
 * @return array: menu in tree structure
 */
function wpse_nav_menu_2_tree( $menu_id ){
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? buildTree( $items, 0 ) : null;
    /* Steps of using "wpse_nav_menu_2_tree" to generate a html menu

    // step 1: define a getNav like below
    // $menu is the return value of wpse_nav_menu_2_tree
    // $result is the html doc to echo
    function getNav($menu, &$result) {
        $result .= '<ul>';
        foreach ($menu as $v) {
            $result .= "<li><a href='{$v->url}'>{$v->title}</a></li>";
            if (isset($v->wpse_children)) {
                getNav($v->wpse_children, $result);
            }
        }
        $result .= '</ul>';
    }
    // step 2: call wpse_nav_menu_2_tree to build a tree of nav
    $mItem = wpse_nav_menu_2_tree('Menu 1');
    $retult = '';
    getNav($mItem, $retult);
    echo $retult;
    */
}

/**
 * Get Current Theme Template Filename
 * Get's the name of the current theme template file being used
 * @global $current_theme_template Defined using define_current_template()
 * @param $echo Defines whether to return or print the template filename
 * @return The name of the template filename, including .php
 */
function get_current_template( $echo = false ) {
    if ( !isset( $GLOBALS['current_theme_template'] ) ) {
        //trigger_error( '$current_theme_template has not been defined yet', E_USER_WARNING );
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


/**
 * Build pagenation for archive pages
 */
function build_pagenation ($page_request, $post_type, $post_per_page) {
	$page_request = intval($page_request);
	if (!post_type_exists($post_type)) {
		return false;
	}

	$pagenation = array (
		'curr_page'     => false,
		'first_page'    => false,
		'last_page'     => false,
		'prev_page'     => false,
		'next_page'     => false,
		'total_page'    => false,
		'post_per_page' => false,
		'total_post'    => false,
	);
	// step 0: get total number of post
	$pagenation['total_post'] = intval(wp_count_posts($post_type)->publish);
	// step 1: get total number of page
	$option = array(
		'posts_per_page' => $post_per_page,
		'post_type' => $post_type,
	);
	$query = new WP_Query($option);
	$pagenation['total_page'] = intval($query->max_num_pages);
	// step 2: validate $page_request
	$page_request = $page_request >= 1 && $page_request <= $pagenation['total_page'] ? $page_request : 1;
	// step 3: calculate the following
	$pagenation['curr_page'] = $page_request;
	$pagenation['first_page'] = 1;
	$pagenation['last_page'] = $pagenation['total_page'];
	$pagenation['prev_page'] = $pagenation['curr_page'] <= $pagenation['first_page'] ? -1 : $pagenation['curr_page'] - 1;
	$pagenation['next_page'] = $pagenation['curr_page'] >= $pagenation['last_page'] ? -1 : $pagenation['curr_page'] + 1;
	$pagenation['post_per_page'] = $post_per_page;
	return $pagenation;
}



?>