<?php	

$shortname = get_option('of_shortname'); 
$output = '';

// Variables for style values
$wpr_bg_color = get_option($shortname . '_wpr_bg_color');
$body_bg_color = get_option($shortname . '_body_bg_color');
$body_text = get_option($shortname . '_body_text');
$prim_clr = get_option($shortname . '_primary_font_color');
$sec_clr = get_option($shortname . '_secondary_font_color');
$menu_clr = get_option($shortname.'_menu_hover_color');

// Conditional styles for the logo option. Not using this now. 
function title_option() {
	$shortname = get_option('of_shortname'); 
	$show_title = get_option($shortname . '_title_choice');
	
	if ( $show_title == 0 ) {
		echo '#blog-title a {float:right;}#header img{margin-top:10px; float:left;}#blog-description {margin-top: 15px;}';
	} 
}	

// Output styles
if ($output <> '') {
	$output = "/* Custom Styling */\n\t" . $output;
}

// Pull Styles from Dynamic StylesSheet (Look in /css/ )
$wpf_styleoptions = TEMPLATEPATH . '/admin/css/wpf-styles.php'; if( is_file( $wpf_styleoptions ) ) 
require $wpf_styleoptions;

// Echo Optional Styles
echo $output;
	
?>