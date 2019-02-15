<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Template_Site
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri() . "/favicon.png"; ?>"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
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
$mItem = wpse_nav_menu_2_tree('Menu Sample');
$results = '';
getNav($mItem, $results);
?>
<nav>
	<?php echo $results; ?>
</nav>


