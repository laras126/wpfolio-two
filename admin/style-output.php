<?php	

$shortname = get_option('of_shortname'); 
$output = '';

// Variables for style values
$hdr_bg_color = get_option($shortname . '_hdr_bg_color');
$body_bg_color = get_option($shortname . '_body_bg_color');
$body_font = get_option($shortname . '_body_font');

$text_color = get_option($shortname . '_text_color');
$typography = get_option($shortname . '_typography'); 
$hdr_gfont = get_option($shortname . '_google_hdr_font');


// Output styles
if ($output <> '') {
	$output = "/* Custom Styling */\n\t" . $output;
}

// Pull Styles from Dynamic StylesSheet (Look in /css/ )
$wpf_coloroptions = STYLESHEETPATH . '/css/wpf-styles.php'; if( is_file( $wpf_coloroptions ) ) 
require $wpf_coloroptions;

// Echo Optional Styles
echo $output;
	
?>