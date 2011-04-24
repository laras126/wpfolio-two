<?php	

$shortname = get_option('of_shortname'); 
$output = '';

// Variables for style values
$hdr_bg_color = get_option($shortname . '_hdr_bg_color');
$body_bg_color = get_option($shortname . '_body_bg_color');
$ftr_bg_color = get_option($shortname . '_ftr_bg_color');

$body_text = get_option($shortname . '_body_text');

$text_color = get_option($shortname . '_text_color');
$typography = get_option($shortname . '_typography'); 

$hdr_type = get_option($shortname . '_hdr_typograpy');
$bdy_type = get_option($shortname . '_bdy_typograpy');  
$ftr_type = get_option($shortname . '_ftr_typograpy');

$font_text = get_option($shortname . '_typograpy'); // Or whatever the name of option is

// Output styles
if ($output <> '') {
	$output = "/* Custom Styling */\n\t" . $output;
}

/*function footer_test() {
	global $hdr_bg_color;
	$myText = print_r($hdr_bg_color,true);

	echo $myText;
}

add_action('thematic_header','footer_test'); */

// Pull Styles from Dynamic StylesSheet (Look in /css/ )
$wpf_coloroptions = STYLESHEETPATH . '/css/wpf-styles.php'; if( is_file( $wpf_coloroptions ) ) 
require $wpf_coloroptions;

// Echo Optional Styles
echo $output;
	
?>