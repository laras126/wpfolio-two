<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "of";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
//$categories_tmp = array_unshift($of_categories, "Select a Category:");  
//Use unshift_array with a dropdown - makes the first selection a description not acknowledged in array

       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
//$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
//See above comment in Access Categories

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

// Testing arrays, for Example Options
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

// Stylesheets Reader, see Theme Stylesheet in Styling Options 
// Could this be used for switching around stylesheets for resume, etc.
/*$alt_stylesheet_path = STYLESHEETPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
} */


//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Set the Options Array
$options = array();


//*-------------* GENERAL SETTINGS *-------------*//
// Options for Custom Logo, Custom Favicon. 
// Commented out: Post cat excluded from blog (not complete, just visible option), Tracking code for Analytics, 
$options[] = array( "name" => "General Settings",
                    "type" => "heading");
					
$options[] = array( "name" => "Exclude Categories from Blog",
					"desc" => "Select the categories that will be excluded from the blog page.",
					"id" => $shortname."_cats_in_blog",
					"std" => "",
					"type" => "select",
					"options" => $of_categories);

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");
					
$url =  OF_DIRECTORY . '/admin/images/';
$options[] = array( "name" => "Main Layout",
					"desc" => "Select main content and sidebar alignment.",
					"id" => $shortname."_layout",
					"std" => "layout-2cr",
					"type" => "images",
					"options" => array(
						'layout-2cr' => $url . '2cr.png',
						'layout-2cl' => $url . '2cl.png')
					);
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 

// Not using now, will be hacked to apply blog template to specified categories. Checkboxes or something.
// As of now: choose a post category to be excluded from the front page and to be shown on blog template - courtesy of AutoFocus+ 					
/*$options[] = array( "name" => __('Blog Category','thematic'),
					"desc" => __('Select a post category to be shown in the Blog Template and excluded from the Front Page.','thematic'),
					"id" => $shortname."_blog_cat",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $of_categories);
                                               
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");*/                                                    
    
    
//*-------------* STYLE OPTIONS *-------------*//
// Options for Header and Body background colors, Body Font, Text field for short custom CSS
// About Body Font: should use type => "typography", but is just an array right now 
// Commented out: Theme Stylesheet, Header Text Color (no rule for this in wpf-styles.php)
// Note: to use Theme Stylesheet, uncomment $alt_stylesheet_path...; lines 45-56

$options[] = array( "name" => "Styling Options",
					"type" => "heading");
					
/*$options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets); */
										
$options[] = array( "name" => "Header Font",
					"desc" => "Choose a font from the <a href='http://google.com/webfonts'>Google WebFont Directory</a> and type its name in the text field.",
					"id" => $shortname."_google_hdr_font",
					"std" => "Lobster",
					"type" => "text");
				
// Will be under same header as above - not working right now						
/*$options[] = array( "name" => "Default Header Font",
					"desc" => "Select a font to be used if the WebFont does not load.",
					"id" => $shortname."_default_hdr_font",
					"std" => "Arial",
		            "type" => "select",
		            "options" => array(
			            "Arial, Helvetica Neue, Helvetica, sans-serif", 
			            "Courier New, Courier, monospace",
			            "Georgia, Palatino, Palatino Linotype, Times, Times New Roman, serif",
			            "Gill Sans, Calibri, Trebuchet MS, sans-serif", 
			            "Helvetica Neue, Arial, Helvetica, sans-serif", 
			            "Lucida Sans, Lucida Grande, Lucida Sans Unicode, sans-serif", 
			            "Palatino, Palatino Linotype, Georgia, Times, Times New Roman, serif", 
			            "Times, Times New Roman, Georgia, serif", 
			            "Verdana, Geneva, Tahoma, sans-serif"  
			            )); */

					
$options[] = array( "name" => "Header Background Color",
					"desc" => "",
					"id" => $shortname."_hdr_bg_color",
					"std" => "#2098a8",
					"type" => "color");	

$options[] = array( "name" => "Body Background Color",
					"desc" => "",
					"id" => $shortname."_body_bg_color",
					"std" => "#2098a8",
					"type" => "color");		

$options[] = array( "name" => "Footer Background Color",
					"desc" => "",
					"id" => $shortname."_ftr_bg_color",
					"std" => "#2098a8",
					"type" => "color");

$options[] = array( "name" => "Body p Typography",
					"desc" => "Specify the font properties for your site's header. This will not effect the title WebFont.",
					"id" => $shortname."_typography",
					"std" => array('size' => '1','unit' => 'em','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
					"type" => "typography");

/*$options[] = array( "name" => "Footer Typography",
					"desc" => "Specify the font properties for your site's footer.",
					"id" => $shortname."ftr_typography",
					"std" => array('size' => '16','unit' => 'em','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
					"type" => "typography");*/

/*$options[] = array( "name" => "Body Font",
					"desc" => "",
		            "id" => $shortname."_body_text",
		            "type" => "select",
		            "std" => "Helvetica",
		            "options" => array(
			            "Arial, Helvetica Neue, Helvetica, sans-serif", 
			            "Courier New, Courier, monospace",
			            "Georgia, Palatino, Palatino Linotype, Times, Times New Roman, serif",
			            "Gill Sans, Calibri, Trebuchet MS, sans-serif", 
			            "Helvetica Neue, Arial, Helvetica, sans-serif", 
			            "Lucida Sans, Lucida Grande, Lucida Sans Unicode, sans-serif", 
			            "Palatino, Palatino Linotype, Georgia, Times, Times New Roman, serif", 
			            "Times, Times New Roman, Georgia, serif", 
			            "Verdana, Geneva, Tahoma, sans-serif"  
		            )); */
														
$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
                    
                    
//*-------------* FOOTER OPTIONS *-------------*//
// None of these work. I think will need footer-options.php which is here from TwentyTen- started working on it, and will contine later
            
$options[] = array( "name" => "Footer Options",
					"type" => "heading");      

$options[] = array( "name" => "Enable Custom Footer (Left)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_left",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Left)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_left_text",
					"std" => "",
					"type" => "textarea");
						
$options[] = array( "name" => "Enable Custom Footer (Right)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_right",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Right)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_right_text",
					"std" => "",
					"type" => "textarea");

//*-------------* WPFolio Community *-------------*//					
// need to find some "type" that is static text or make one
$options[] = array( "name" => "WPFolio Community",
					"type" => "heading");
					
$options[] = array( "name" => "WPFolio Community",
					"id" => $shortname."_wpfolio_community",
					"type" => "static",
					"std" => '<h3>Support Site</h3>
						<p>If you haven\'t been already, check out the <a href="http://wpfolio.visitsteve.com">WPFolio Wiki</a> for help.</p>
				
						<h3>Sign up for email updates</h3>
						<p>Receive emails when new versions of WPFolio are available and other news to help you with updating. Your information will never be shared. Messages will be sent around 1-2 times per month, often less.</p>
				
							<form action="http://scripts.dreamhost.com/add_list.cgi" method="post"> 
							<input name="list" type="hidden" value="update" />
							<input name="domain" type="hidden" value="http://wpfolio.visitsteve.com" />
							<input name="url" type="hidden" />
							<input name="unsuburl" type="hidden" />
							<input name="alreadyonurl" type="hidden" />
							<input name="notonurl" type="hidden" />
							<input name="invalidurl" type="hidden" />
							<input name="emailconfirmurl" type="hidden" />
							<input name="emailit" type="hidden" value="1" />
							Name: <input name="name" /> 
							E-mail: <input name="email" /> <br />
							<input name="submit" type="submit" value="Join Our Announcement List" />
							<input name="unsub" type="submit" value="Unsubscribe" />
							</form>
						</p>
				
						<h3>Donate to support WPFolio and Free Software</h3>
				
						<p>WPFolio is a labor of love. We make it to help you.</p>
				
						<p>WPFolio took us <em>a lot</em> of time to build, develop, and document. Did our project save you time? Save you the costs of a designer or webmaster? Would you have otherwise needed a tutor? If you met us in person, would you buy us a beer? A dinner? Would you like to see new features implemented? Please consider making a donation based on what you think WPFolio was worth to you. Although we\'ll likely never make back what we\'ve put into this, we can use your donations to offset costs of production.</p>
				
						<p>WPFolio is Free Software under the <a href="http://www.gnu.org/licenses/quick-guide-gplv3.html">GPLv3</a>. Our <a href="http://wpfolio.visitsteve.com">WPFolio Wiki</a> includes instructions to help you make the most of the WPFolio theme. You are free to modify, share, and distribute WPFolio however you like. We do all this because we want artists to have great websites using the best, free and open source software available. You can contribute by helping with the <a href="http://github.com/slambert/WPFolio/">development of the theme</a>, or by donating. </p>
				
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input name="cmd" type="hidden" value="_s-xclick" /> <input name="hosted_button_id" type="hidden" value="ZMXNTHG3LHX8Q" /> <input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> </form>
				
						<p>Thanks.</p>
						
					</div>');
					
//*-------------* EXAMPLE OPTIONS *-------------*//
// Do nothing, visual examples
					
$options[] = array( "name" => "Example Options",
					"type" => "heading"); 	   
	
$options[] = array( "name" => "Typography",
					"desc" => "This is a typographic specific option.",
					"id" => $shortname."_typography",
					"std" => array('size' => '16','unit' => 'em','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
					"type" => "typography");	
	
$options[] = array( "name" => "Border",
					"desc" => "This is a border specific option.",
					"id" => $shortname."_border",
					"std" => array('width' => '2','style' => 'dotted','color' => '#444444'),
					"type" => "border");      
					
$options[] = array( "name" => "Colorpicker (default #2098a8)",
					"desc" => "Color selected.",
					"id" => $shortname."_example_colorpicker_2",
					"std" => "#2098a8",
					"type" => "color");          
                    
$options[] = array( "name" => "Upload Basic",
					"desc" => "An image uploader without text input.",
					"id" => $shortname."_uploader",
					"std" => "",
					"type" => "upload_min");     
                                    
$options[] = array( "name" => "Input Text",
					"desc" => "A text input field.",
					"id" => $shortname."_test_text",
					"std" => "Default Value",
					"type" => "text"); 
                                        
$options[] = array( "name" => "Input Checkbox (false)",
					"desc" => "Example checkbox with false selected.",
					"id" => $shortname."_example_checkbox_false",
					"std" => "false",
					"type" => "checkbox");    
                                        
$options[] = array( "name" => "Input Checkbox (true)",
					"desc" => "Example checkbox with true selected.",
					"id" => $shortname."_example_checkbox_true",
					"std" => "true",
					"type" => "checkbox"); 
                                                                               
$options[] = array( "name" => "Input Select Small",
					"desc" => "Small Select Box.",
					"id" => $shortname."_example_select",
					"std" => "three",
					"type" => "select",
					"class" => "mini", //mini, tiny, small
					"options" => $options_select);                                                          

$options[] = array( "name" => "Input Select Wide",
					"desc" => "A wider select box.",
					"id" => $shortname."_example_select_wide",
					"std" => "two",
					"type" => "select2",
					"options" => $options_radio);    

$options[] = array( "name" => "Input Radio (one)",
					"desc" => "Radio select with default of 'one'.",
					"id" => $shortname."_example_radio",
					"std" => "one",
					"type" => "radio",
					"options" => $options_radio);
					
$url =  get_bloginfo('stylesheet_directory') . '/admin/images/';
$options[] = array( "name" => "Image Select",
					"desc" => "Use radio buttons as images.",
					"id" => $shortname."_images",
					"std" => "",
					"type" => "images",
					"options" => array(
						'warning.css' => $url . 'warning.png',
						'accept.css' => $url . 'accept.png',
						'wrench.css' => $url . 'wrench.png'));
                                        
$options[] = array( "name" => "Textarea",
					"desc" => "Textarea description.",
					"id" => $shortname."_example_textarea",
					"std" => "Default Text",
					"type" => "textarea"); 
                                        
$options[] = array( "name" => "Multicheck",
					"desc" => "Multicheck description.",
					"id" => $shortname."_example_multicheck",
					"std" => "two",
					"type" => "multicheck",
					"options" => $options_radio);
                                        
$options[] = array( "name" => "Select a Category",
					"desc" => "A list of all the categories being used on the site.",
					"id" => $shortname."_example_category",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $of_categories); 

update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
/*-----------------------------------------------------------------------------------*/
/* WPFolio Community
/*-----------------------------------------------------------------------------------*/



?>
