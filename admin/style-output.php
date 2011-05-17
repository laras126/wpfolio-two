<?php	

$shortname = get_option('of_shortname'); 
$output = '';

// Variables for style values
$wpr_bdr = get_option($shortname . '_wpr_border');
$wpr_bg_color = get_option($shortname . '_wpr_bg_color');
$body_bg_color = get_option($shortname . '_body_bg_color');

$body_text = get_option($shortname . '_body_text');

$p_text = get_option($shortname . '_p_typography'); 
$h1_text = get_option($shortname . '_h1_typography'); 

// Output styles
if ($output <> '') {
	$output = "/* Custom Styling */\n\t" . $output;
}

// Pull Styles from Dynamic StylesSheet (Look in /css/ )
$wpf_coloroptions = STYLESHEETPATH . '/css/wpf-styles.php'; if( is_file( $wpf_coloroptions ) ) 
require $wpf_coloroptions;

// Echo Optional Styles
echo $output;
	
// Function to test options output
function echo_test() {
	$shortname = get_option('of_shortname'); 
	$wpr_border = get_option($shortname . '_wpr_border');
	print_r ($wpr_border);
}	
//add_action('thematic_post', 'echo_test');

?>