<?php

//
//  WPFolio 3000:
//  Custom Child Theme Functions
//

// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
function childtheme_menu_args($args) {
    $args = array(
        'show_home' => 'Home',
        'sort_column' => 'menu_order',
        'menu_class' => 'menu',
        'echo' => true
    );
	return $args;
}
add_filter('wp_page_menu_args','childtheme_menu_args');

// Unleash the power of Thematic's dynamic classes

define('THEMATIC_COMPATIBLE_BODY_CLASS', true);
define('THEMATIC_COMPATIBLE_POST_CLASS', true);

// Unleash the power of Thematic's comment form
define('THEMATIC_COMPATIBLE_COMMENT_FORM', true);

// Unleash the power of Thematic's feed link functions
define('THEMATIC_COMPATIBLE_FEEDLINKS', true);


// Require files in library/
require_once("library/widgets.php");
require_once("library/images.php");
require_once("library/portfolio-cat.php");
require_once("library/portfolio-post.php");

// Will require files with a loop - not working yet
/*$dir = 'library';
$files = glob($dir . '/*.php');

foreach ($files as $file) {
    require_once($file);   
}*/

//require_once("library/page-margins.php");


////////////////////
// FILTER CONTENT //
////////////////////

function override_content() {
	if ( is_page() ){
		add_filter('thematic_content', 'add_wide_margins'); 
	} 
}
//add_filter('thematic_content', 'override_content');


// Shortcode to add wide margins to a post page - works as is, but is applied in post lists

function wide_margins_shortcode ($atts, $content = null) {
	return '<div class="widemargins">' . do_shortcode($content) . '</div>';
}
add_shortcode('margin', 'wide_margins_shortcode');

////////////////////
// ADD BODY CLASS //
////////////////////

// Add portfolio body class to anything that isn't the blog	
function portfolio_body_class($class) {
	if ( !is_home() ) {
		$class[] = 'portfolio';
		return $class;
	} 
}
add_filter('thematic_body_class','portfolio_body_class');


/////////////
// SIDEBAR //
/////////////

// Filter thematic_sidebar() .. remove from everything except the blog (category chosen in theme options).
function remove_sidebar() {
	
	$shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');
	$cat = get_cat_ID($cat_option);
	
	if ($cat != '') {
		if ( is_category($cat) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else if ( !is_home()){
		return FALSE;
	} else {
		return TRUE;
	}
}
add_filter('thematic_sidebar', 'remove_sidebar');



//////////////////////////////////////
//// OPTIONS FRAMEWORK FUNCTIONS /////
//////////////////////////////////////

// Options Framework by Devin at WPTheming, based on WooThemes. http://wptheming.com/2010/12/options-framework/

/* Set the file path based on whether the Options Framework is in a parent theme or child theme */

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OF_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
	define('OF_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}

/* These files build out the options interface.  Likely won't need to edit these. */

require_once (OF_FILEPATH . '/admin/admin-functions.php');		// Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/* These files build out the theme specific options and associated functions. */

require_once (OF_FILEPATH . '/admin/theme-options.php'); 		// Options panel settings and custom settings
require_once (OF_FILEPATH . '/admin/theme-functions.php'); 	// Theme actions based on options settings



///////////////////////
//// POST FORMATS /////
///////////////////////

// Thanks to this thread:
// http://wordpress.stackexchange.com/questions/12420/post-format-selector-in-thematic-child-theme-post-class

// Enable post formats
add_theme_support('post-formats', array( 'link', 'aside', 'gallery', 'image', 'video' ));

// Add the format selector to post_class
function post_format_class( $classes = array() ) {
  $format = get_post_format();
  if ( '' == $format )
    $format = 'standard';
  $classes[] = 'format-' . $format;

  return $classes;
}

add_filter( 'post_class', 'post_format_class' );


///////////////////////
// WPALCHEMY METABOX //
///////////////////////

// Dimas' WPAlchemy Meta Box PHP Class: http://www.farinspace.com/wpalchemy-metabox/

// custom constant (opposite of TEMPLATEPATH)
define('_TEMPLATEURL', WP_CONTENT_URL . '/' . stristr(TEMPLATEPATH, 'themes'));

include_once 'WPAlchemy/MetaBox.php';
 
// stylesheet used by all similar meta boxes
if (is_admin()) 
{
	wp_enqueue_style('custom_meta_css', STYLESHEETPATH . 'custom/meta.css');
}

$prefix = 'wpf_';
$mb = new WPAlchemy_MetaBox(array
(
    'id' => '_custom_meta', // underscore prefix hides fields from the custom fields area
    'title' => 'Artwork Info',
    'template' => STYLESHEETPATH . '/custom/artwork-meta.php',
    'context' => 'normal',
));

// Display Artwork Info fields in post
function display_artwork_info() {

	global $mb;
		
	$mb->the_meta();
	$values = array('title','medium','collabs','dimen','additional'); 
	
	echo the_content();	 
	echo '<div id="artwork-meta">';

	foreach ($values as $val) {
	    if ($mb->get_the_value($val) != ''){
	        $mb->the_value($val);
	        echo '<br />';
	    }
	}  
	
	echo '</div>';
} 

add_action('thematic_post', 'display_artwork_info');


/////////////////////
// MEDIUM TAXONOMY //
/////////////////////

// Disabled. Added Medium field to metabox instead - may make more sense. 

// Enable a taxonomy for Medium

/* function wpfolio_create_taxonomies() { // uncomment this function to enable
register_taxonomy('medium', 'post', array( 
	'label' => 'Medium',
	'hierarchical' => false,  
	'query_var' => true, 
	'rewrite' => true,
	'public' => true,
	'show_ui' => true,
	'show_tagcloud' => true,
	'show_in_nav_menus' => true,));
} 
add_action('init', 'wpfolio_create_taxonomies', 0); */


/////////////////////
// ADMIN INTERFACE //
/////////////////////


// Customize admin footer text to add WPFolio to links
function wpfolio_admin_footer() {
	echo 'Thank you for creating with <a href="http://wordpress.org/" target="_blank">WordPress</a>. | <a href="http://codex.wordpress.org/" target="_blank">Documentation</a> | <a href="http://wordpress.org/support/forum/4" target="_blank">Feedback</a> | <a href="http://wpfolio.visitsteve.com/">Theme by WPFolio</a>';
} 
add_filter('admin_footer_text', 'wpfolio_admin_footer');


// Add WPFolio Wiki site as a Dashboard Feed 
// Thanks to bavotasan.com: http://bavotasan.com/tutorials/display-rss-feed-with-php/ 

function custom_dashboard_widget() {

	$rss = new DOMDocument();
	$rss->load('http://wpfolio.visitsteve.com/wiki/feed');
	$feed = array();
	foreach ($rss->getElementsByTagName('item') as $node) {
		$item = array ( 
			'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
			// 'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
			'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
			'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
			);
		array_push($feed, $item);
	}
	$limit = 5; // change how many posts to display here
	echo '<ul>'; // wrap in a ul
	for($x=0;$x<$limit;$x++) {
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		// $description = $feed[$x]['desc'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		echo '<li><p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong>';
		echo ' - '.$date.'</p></li>';
		// echo '<p>'.$description.'</p>';
	}
	echo '</ul>';
	echo '<p class="textright"><a href="http://wpfolio.visitsteve.com/wiki/category/news" class="button">View all</a></p>'; // link to site
	
}
	
function add_custom_dashboard_widget() {
	wp_add_dashboard_widget('custom_dashboard_widget', 'WPFolio News', 'custom_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');


///////////////////
// DEV FUNCTIONS //
///////////////////

// Shortcode to add lorem ipsum 
function add_lorem ($atts, $content = null) {
	return 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
}
add_shortcode("lorem", "add_lorem");


// Add link for WPFolio options to the admin bar
function my_admin_bar_link() {
	global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() )
			return;
	$wp_admin_bar->add_menu( array(
			'id' => 'new_link',
			'parent' => false,
			'title' => __( 'Options'),
			'href' => admin_url( 'themes.php?page=optionsframework' )
	));
}
add_action('admin_bar_menu', 'my_admin_bar_link');
?>