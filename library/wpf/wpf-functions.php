<?php

//
//
//  WPFolio Two Primary functions
//  
//

// Require files in library/
require_once("wpf-widgets.php");
require_once("wpf-thumbs.php");
require_once("wpf-attachmentmeta.php");
require_once("wpf-category.php");
require_once("wpf-postmeta.php");
require_once("wpf-prevnext.php");
require_once("dev-functions.php");



/////////////////////////////////
// PORTFOLIO/NEWS BODY CLASSES //
/////////////////////////////////

// Add portfolio body class to anything that isn't the blog	
function portfolio_body_class($class) {

	global $post;
	$shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');
	
	if ( in_category($cat_option) || is_home() ) {
		$class[] = 'news';
		return $class;
	} else {
		$class[] = 'portfolio';
		return $class;	
	}
}

add_filter('body_class','portfolio_body_class');


/////////////
// SIDEBAR //
/////////////

// Filter thematic_sidebar() .. remove from everything except the blog (category chosen in theme options).
function remove_sidebar() {
	
	$shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');
	
	if ( $cat_option != 'Select a Category:' ) {
		if ( in_category($cat_option) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	} elseif ( !is_home() ) {
		return FALSE;
	} else {
		return TRUE;
	}
}

add_filter('thematic_sidebar', 'remove_sidebar');



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
	wp_enqueue_style('custom_meta_css', THEMELIB . '/wpf/custom/meta.css');
}

$prefix = 'wpf_';
$mb = new WPAlchemy_MetaBox(array
(
    'id' => '_custom_meta', // underscore prefix hides fields from the custom fields area
    'title' => 'Artwork Info',
    'template' => THEMELIB . '/wpf/custom/artwork-meta.php',
    'context' => 'normal',
));

// Display Artwork Info fields in post
// Thanks to http://wordpress.stackexchange.com/questions/15516/conditionally-echo-br-in-meta-box-data-loop/15520#15520

function display_artwork_info() {

	global $mb;
		
	$mb->the_meta();
	$values = array('medium','collabs','dimen','additional'); 
	
	echo the_content();	 
	echo '<div id="artwork-meta"><em>';

	if ($mb->get_the_value('title') != ''){
		$mb->the_value('title');
		echo '</em><br />';
	}

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


////////////
// IMAGES //
////////////

// Thumbnail functions in wpf-thumbs.php

// Set max width of images to 900px
$content_width = 900;

/*----- CUSTOM HEADER IMAGE -----*/
// Also covered in the Options Panel

define('NO_HEADER_TEXT', true );
define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/default_header.jpg'); // %s is the template dir uri
define('HEADER_IMAGE_WIDTH', 960); // use width and height appropriate for your theme
define('HEADER_IMAGE_HEIGHT', 198);

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
// END - Custom Header

//------ Stuff that doesn't work but is necessary from 1.7? ------//

// This sets the Large image size to 900px
if ( ! isset( $content_width ) ) 
	$content_width = 900; 

// Remove inline styles on gallery shortcode
function wpfolio_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
//add_filter( 'gallery_style', 'wpfolio_remove_gallery_css' );

// END - Remove inline styles on gallery shortcode



////////////////
// SHORTCODES //
////////////////

// Shortcode to add wide margins to a post page - works as is, but is applied in post lists

function wide_margins_shortcode ($atts, $content = null) {
	return '<div class="widemargins">' . do_shortcode($content) . '</div>';
} 
add_shortcode('margin', 'wide_margins_shortcode');



/////////////////////
// ADMIN INTERFACE //
/////////////////////

// Customize admin footer text to add WPFolio to links
function wpfolio_admin_footer() {
	echo 'Thank you for creating with <a href="http://wordpress.org/" target="_blank">WordPress</a>. | <a href="http://codex.wordpress.org/" target="_blank">Documentation</a> | <a href="http://wordpress.org/support/forum/4" target="_blank">Feedback</a> | <a href="http://wpfolio.visitsteve.com/">Theme by WPFolio</a>';
} 
add_filter('admin_footer_text', 'wpfolio_admin_footer');


