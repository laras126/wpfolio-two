<?php

//
//  Custom Child Theme Functions
//

// More ideas can be found on "A Guide To Customizing The Thematic Theme Framework" 
// http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/

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




////////////
// IMAGES //
////////////

// This sets the Large image size to 900px

if ( ! isset( $content_width ) ) 
	$content_width = 900;

// Remove inline styles on gallery shortcode

function wpfolio_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
add_filter( 'gallery_style', 'wpfolio_remove_gallery_css' );

// END - Remove inline styles on gallery shortcode


// Thumbnail Function - this creates a default thumbnail if one is specified
function get_thumb ($post_ID){
    $thumbargs = array(
    'post_type' => 'attachment',
    'numberposts' => 1,
    'post_status' => null,
    'post_parent' => $post_ID
    );
    $thumb = get_posts($thumbargs);
    if ($thumb) {
        return wp_get_attachment_image($thumb[0]->ID);
    }
} 

// This adds support for post thumbnails of 150px square
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 150, 150,true );

// END - Thumbnail Function




//////////////////////////////////////
//// OPTIONS FRAMEWORK FUNCTIONS /////
//////////////////////////////////////

// Options Framework by Devin at WPTheming, based on WooThemes. http://wptheming.com/2010/12/options-framework/

// Do we want to include separate templates for header/footer options? Might be overkill
//include_once (STYLESHEETPATH . '/admin/footer-options.php');	
//include_once (STYLESHEETPATH . '/admin/header-options.php');	

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
// not enabled as of yet





///////////////////////
// WPALCHEMY METABOX //
///////////////////////

// Dimas' excellent meta box class WPAlchemy: http://www.farinspace.com/wpalchemy-metabox/

// custom constant (opposite of TEMPLATEPATH)
define('_TEMPLATEURL', WP_CONTENT_URL . '/' . stristr(TEMPLATEPATH, 'themes'));

include_once 'WPAlchemy/MetaBox.php';
 
// include css to style the custom meta boxes, this should be a global
// stylesheet used by all similar meta boxes
if (is_admin()) 
{
	wp_enqueue_style('custom_meta_css', STYLESHEETPATH . 'custom/meta.css');
}

$artworkinfo_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta', // underscore prefix hides fields from the custom fields area
	'title' => 'Artwork Info',
	'template' => STYLESHEETPATH . '/custom/artwork-meta.php',
	'context' => 'normal',
));

// Display artwork info in post, below post content -- will put this in a loop
add_filter('thematic_post', 'display_artwork_info');

function display_artwork_info() {
	
	global $artworkinfo_metabox;
	
	echo the_content();

	// get the meta data for the current post
	$artworkinfo_metabox->the_meta();
	 
	// get value directly
	echo '<div id="artwork-meta"><strong>';
	$artworkinfo_metabox->the_value('title');
	echo '</strong><br />';
	$artworkinfo_metabox->the_value('collabs');
	echo '<br />';
	$artworkinfo_metabox->the_value('dimen');
	echo '<br />';
	$artworkinfo_metabox->the_value('additional');
	echo '<br /></div>'; 

} 



///////////////////////
// ADDING A TAXONOMY //
///////////////////////

// We don't use this to it's full extent yet, but we could (will?)

// enabling a taxonomy for Medium

function wpfolio_create_taxonomies() {
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
add_action('init', 'wpfolio_create_taxonomies', 0); 


/////////////////////
// ADMIN INTERFACE //
/////////////////////


// Remove some widget areas
function child_remove_widget_area() {
	$widgetareas = array ('index-top', 'index-insert', '1st-subsidiary-aside', '2nd-subsidiary-aside', '3rd-subsidiary-aside', 'single-insert', );
	
	foreach ( $widgetareas as &$area ) {
		unregister_sidebar($area);
	}
}
add_action( 'admin_init', 'child_remove_widget_area');


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

?>