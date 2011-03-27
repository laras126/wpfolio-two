<?php	
	$shortname = get_option('of_shortname'); 
	$output = '';

	$text_color = get_option($shortname . '_text_color');
	$hdr_color = get_option($shortname . '_hdr_color');
	$wrpr_color = get_option($shortname . '_wrpr_color');
	$typography = get_option($shortname . '_typography'); 
	$body_font = get_option($shortname . '_body_font');


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