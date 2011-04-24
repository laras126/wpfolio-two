<?php

//
//  WPFolio:
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



///////////////////////
// MARGINS & SIDEBAR //
///////////////////////

// Shortcode to add wide margins to a post page - works as is, but is applied in post lists

function wide_margins_shortcode ($atts, $content = null) {
	return '<div class="widemargins">' . do_shortcode($content) . '</div>';
}
add_shortcode('margin', 'wide_margins_shortcode');

//function childtheme_override_content() {

//*---Sidebar---*//

// http://programming.thematic4you.com/2010/01/how-to-remove-the-sidebar-from-a-certain-page/

// Filter thematic_sidebar() .. remove from everything except the blog template
function remove_sidebar() {
	if ( is_page() || is_archive() || is_single() ) {
		return FALSE;
	} else {
		return TRUE;
	}
}
add_filter('thematic_sidebar', 'remove_sidebar');


/////////////
// WIDGETS //
/////////////


// http://themeshaper.com/forums/topic/something-new-bout-widgetized-areas#post-6601


// Rename some widget areas
function rename_widgetized_area($content) {
	$content['Single Bottom']['args']['name'] = 'After Single Post';
	$content['Single Top']['args']['name'] = 'Before Single Post';
	$content['1st Subsidiary Aside']['args']['name'] = 'Footer Left'; 
	$content['2nd Subsidiary Aside']['args']['name'] = 'Footer Middle'; 
	$content['3rd Subsidiary Aside']['args']['name'] = 'Footer Right';
	$content['Index Bottom']['args']['name'] = 'Posts Page Bottom';
	$content['Index Top']['args']['name'] = 'Posts Page Top';
	return $content;
}
add_filter('thematic_widgetized_areas', 'rename_widgetized_area');

// Remove some widget areas
// Add the name of the widget area you want to remove to the $widgetareas array/ remove name of area you want to add
function child_remove_widget_area() {
	$widgetareas = array ('index-insert', 'single-insert', 'single-bottom', 'single-top', 'index-bottom', 'index-top', 'page-top', 'page-bottom');
	
	foreach ( $widgetareas as &$area ) {
		unregister_sidebar($area);
	}
}
add_action( 'admin_init', 'child_remove_widget_area');



////////////
// IMAGES //
////////////


/*----- CUSTOM HEADER IMAGE -----*/
// Need to add images/default_header.jpg
// Disabled Header Text - covered by WebFonts option

define('NO_HEADER_TEXT', true );
define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/default_header.jpg'); // %s is the template dir uri
define('HEADER_IMAGE_WIDTH', 775); // use width and height appropriate for your theme
define('HEADER_IMAGE_HEIGHT', 200);

// gets included in the site header
function header_style() {
    ?><style type="text/css">
        #header {
            background: url(<?php header_image(); ?>);
        }
    </style><?php
}

// gets included in the admin header
function admin_header_style() {
	?><style type="text/css">
		#headimg {
			width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
			height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
		}
	</style><?php
}

add_custom_image_header('header_style', 'admin_header_style'); 

/*----- GET THUMBNAILS ----*/
// Thumbnail Function - this creates a default thumbnail if one is not specified
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

add_action('thematic_post', 'check_thumb');
function check_thumb() {		
	global $post;
			
	if( has_post_thumbnail() ) {
		the_post_thumbnail();
	}
	else {			
		echo get_thumb($post->ID); 
	}
}

// This adds support for post thumbnails of 150px square
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 150, 150, true );

// END - Thumbnail Function


//------Stuff that doesn't work but is necessary from 1.7------//

// This sets the Large image size to 900px
/*if ( ! isset( $content_width ) ) 
	$content_width = 900; */

// Remove inline styles on gallery shortcode
function wpfolio_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
//add_filter( 'gallery_style', 'wpfolio_remove_gallery_css' );

// END - Remove inline styles on gallery shortcode




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
// Thanks to this thread:
// http://wordpress.stackexchange.com/questions/12420/post-format-selector-in-thematic-child-theme-post-class

// Enable post formats
add_theme_support('post-formats', array( 'link', 'aside', 'gallery', 'image', 'video' ));

// Add the format selector to post_class
function my_thematic_post_format_class( $classes = array() ) {
  $format = get_post_format();
  if ( '' == $format )
    $format = 'standard';

  $classes[] = 'format-' . $format;

  return $classes;
}

add_filter( 'post_class', 'my_thematic_post_format_class' );


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
	$values = array('title','collabs','dimen','additional'); 
	
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



?>