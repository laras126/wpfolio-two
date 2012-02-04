<?php

/* These are functions specific to the included option settings and this theme */

// Commented options to possibly be implemented on updates

/*-----------------------------------------------------------------------------------*/
/* Theme Header Output - wp_head() */
/*-----------------------------------------------------------------------------------*/

// This sets up the layouts and styles selected from the options panel

if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() { 
		$shortname =  get_option('of_shortname');
	    
		//Styles
		 if(!isset($_REQUEST['style']))
		 	$style = ''; 
		 else 
	     	$style = $_REQUEST['style'];
	     if ($style != '') {
			  $GLOBALS['stylesheet'] = $style;
	          echo '<link href="'. OF_DIRECTORY .'/styles/'. $GLOBALS['stylesheet'] . '.css" rel="stylesheet" type="text/css" />'."\n"; 
	     } else { 
	          $GLOBALS['stylesheet'] = get_option('of_alt_stylesheet');
	          if($GLOBALS['stylesheet'] != '')
	               echo '<link href="'. OF_DIRECTORY .'/styles/'. $GLOBALS['stylesheet'] .'" rel="stylesheet" type="text/css" />'."\n";         
	          else
	               echo '<link href="'. OF_DIRECTORY .'/styles/default.css" rel="stylesheet" type="text/css" />'."\n";         		  
	     }       
			
		// This prints out the custom css and specific styling options
		of_options_output_css();
		of_head_css();
		
		// Get options for WebFont and default font and put into vars. Might be better to put vars in another location so you only call the function here, but fine now.
		$hdr_gfont = get_option($shortname . '_google_hdr_font' );
		$hdr_dfont = get_option($shortname . '_default_hdr_font' );
		
		gfonts_api($hdr_gfont, $hdr_dfont);
	
	}
}

add_action('wp_head', 'optionsframework_wp_head');



/*-----------------------------------------------------------------------------------*/
/* Output CSS from standarized options */
/*-----------------------------------------------------------------------------------*/

// Load Custom CSS 
function of_head_css() {

		$shortname =  get_option('of_shortname'); 
		$output = '';
		
		$custom_css = get_option('of_custom_css');
		
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}	
}


//	Load Color Options
function of_options_output_css() { 
?>
	<style type="text/css">
		/* <![CDATA[ */
	<?php $of_css_options_output = dirname( __FILE__ ) . '/style-output.php'; if( is_file( $of_css_options_output ) ) require $of_css_options_output; ?>
	
		/* ]]> */
	</style>
<?php }


// Load WebFont, called in optionsframework_wp_head
function gfonts_api($gf1, $df1) {
	global $shortname;

	$addfont = <<<ADDFONTS

<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js'></script>
<script type='text/javascript'>WebFont.load({ google: {families: [ '$gf1' ]}})</script>
<style type='text/css'>.wf-loading #blog-title a {font-family: $df1;} .wf-inactive #blog-title a {font-family: $df1;} .wf-active #blog-title a {font-family: '$gf1';}</style>

ADDFONTS;

	echo $addfont;
} 	


/*-----------------------------------------------------------------------------------*/
/* Blog Category Option
/*-----------------------------------------------------------------------------------*/



// Get all posts from category specified in the Blog Category option. This is the only category displayed on the blog page. 

function query_blog_cat()	{
	global $blog_catid;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts("cat=" . $blog_catid . "&paged=".$paged);
}

add_action('thematic_above_indexloop', 'query_blog_cat');

function wpf_comments_option() {
	global $blog_catid, $comment_option;

	if ( $comment_option == 1 || ($comment_option == 2 && in_category($blog_catid)) ) {
		thematic_comments_template();
	}
}

/*-----------------------------------------------------------------------------------*/
/* Add Body ides for Layout
/*-----------------------------------------------------------------------------------*/

// Adds a body id to indicate sidebar position - uncomment the filter and the option in theme-options.php to use it (you'll probably have to do some troubleshooting).

// add_filter('thematic_body_id','of_body_id');
 
function of_body_id($ides) {
	$shortname =  get_option('of_shortname');
	$layout = get_option($shortname .'_layout');
	
	if ($layout == '') {
		$layout = 'sidebar-r';
	}
	$ides[] = $layout;
	return $ides;
}


/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

function childtheme_favicon() {
		$shortname =  get_option('of_shortname'); 
		if (get_option($shortname . '_custom_favicon') != '') {
	        echo '<link rel="shortcut icon" href="'.  get_option('of_custom_favicon')  .'"/>'."\n";
	    }
		else { ?>
			<link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/admin/images/favicon.ico" />
<?php }
}

add_action('wp_head', 'childtheme_favicon');

/*-----------------------------------------------------------------------------------*/
/* Replace Blog Title With Logo
/*-----------------------------------------------------------------------------------*/

// If a logo is uploaded, unhook the page title and description

function add_childtheme_logo() {
	$shortname =  get_option('of_shortname');
	$logo = get_option($shortname . '_logo');
	$show_title = get_option($shortname . '_title_choice');
	if (!empty($logo) && $show_title == 1) {
        remove_action('thematic_header','thematic_blogtitle', 3);
        remove_action('thematic_header','thematic_blogdescription',5);
        add_action('thematic_header','childtheme_logo', 3);
    } else if (!empty($logo) && $show_title == 0) {
        add_action('thematic_header','childtheme_logo', 3);
        remove_action('thematic_header','thematic_blogdescription',5);
    }
}

add_action('init','add_childtheme_logo');


// Displays the logo
function childtheme_logo() {
	$shortname =  get_option('of_shortname');
	$logo = get_option($shortname . '_logo');
	
    $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';?>
    <div id="header">
	<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
    <img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>"/>
	</a>
    </div>
<?php }


/*-----------------------------------------------------------------------------------*/
/* Show name, date, and licensing in footer */
/*-----------------------------------------------------------------------------------*/

// called in extensions/footer-extensions.php line 86, thematic_siteinfo()
function wpf_license_option() {

	$shortname =  get_option('of_shortname');
	$li_type = get_option($shortname .'_li_type');
	$li_symbol_show = get_option($shortname .'_li_symbol_show');
	$li_name = get_option($shortname .'_li_name');
	$li_date = get_option($shortname .'_li_date') . ' - ' . date('Y');
	$li_optxt = get_option($shortname .'_li_optional_text');
	$credits = get_option($shortname .'_credits');

	if ($li_type != "Select a License:" ) {
	?>

		<p id="license">
		<?php
		
		// Show license symbol:
		if ( $li_symbol_show == 0) {
			 if ( $li_type == "CC Attribution" ) {
			 	echo '<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img id="lisym" alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/us/80x15.png" /></a>' . ' ' . $li_date . ' ' . $li_name . ' ' . $li_optxt;
			 } else if( $li_type == "CC Attribution-Share Alike" ) {
			 	echo '<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img id="lisym" alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/us/80x15.png" /></a>' . ' ' . $li_date . ' ' . $li_name . ' ' . $li_optxt;
			 } else if( $li_type == "CC Attribution-No Derivative Works" ) {
			 	echo '<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img id="lisym" alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nd/3.0/us/80x15.png" /></a>' . ' ' .  $li_date . ' ' . $li_name . ' ' . $li_optxt;
			 } else if( $li_type == "CC Attribution-Noncommercial" ) {
			 	echo '<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img id="lisym" alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/us/80x15.png" /></a>' . ' ' . $li_date . ' ' . $li_name . ' ' . $li_optxt;
			 } else if( $li_type == "CC Attribution-Noncommercial-Share Alike" ) {
			 	echo '<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img id="lisym" alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/us/80x15.png" /></a>' . ' ' .  $li_date . ' ' . $li_name . ' ' . $li_optxt;
			 } else if( $li_type == "CC Attribution-Noncommercial-No Derivative" ) {
			 	echo '<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img id="lisym" alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/us/80x15.png" /></a>' . ' ' . $li_date . ' ' . $li_name . ' ' . $li_optxt;
			 } else {
				echo '&copy; '. $li_date . ' ' . $li_name . ' ' . $li_optxt;
			}
			
		} else if ( $li_symbol_show == 1 ) {
			echo $li_type . ' ' . $li_date . ' ' . $li_name . ' ' . $li_optxt;
		} ?> 

		</p> <!-- #license -->
		<p id="credits">

		<?php
		
		if ( $credits == 0 ) {
			echo "Proudly Powered by <a href='http://wordpress.org'>WordPress</a>. Theme <a href='http://notlaura.com/wpfolio-two/'>WPFolio Two</a>.";
		}
		?>
		</p> <!-- #credits -->
		</span> <!-- #siteinfo --> <?php
	} 
}

/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

/*function childtheme_analytics(){
	$shortname =  get_option('of_shortname');
	$output = get_option($shortname . '_google_analytics');
	if ( $output <> "" ) 
		echo stripslashes($output) . "\n";
}
add_action('wp_footer','childtheme_analytics');*/



?>