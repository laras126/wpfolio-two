<?php	
	$shortname = get_option('of_shortname'); 
	$output = '';

	//$text_color = get_option($shortname . '_text_color');
	//$link_color = get_option($shortname . '_link_color');
	$bg_color = get_option($shortname . '_bg_color');
	//$main_bg_color = get_option($shortname . '_main_bg_color')
	//$photo_color = get_option($shortname . '_photo_color');

	// Output styles
	if ($output <> '') {
		$output = "/* Custom Styling */\n\t" . $output;
	}

	// Pull Styles from Dynamic StylesSheet (Look in /css/ )
	$wpf_coloroptions = STYLESHEETPATH . '/css/wpf-styles.php'; if( is_file( $wpf_coloroptions ) ) require $wpf_coloroptions;
	
	// Echo Optional Styles
	echo $output;
?>