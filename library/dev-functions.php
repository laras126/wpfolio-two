<?php

///////////////////
// DEV FUNCTIONS //
///////////////////


// Test the options output. This is set to print the Blog Category - ncomment add_action to use and change variables accordingly to print different options.
function echotest() {
	$shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');
	$cat = get_cat_ID($cat_option);
	print_r($cat_option);
}
//add_action('thematic_belowheader', 'echotest');


// Shortcode to add lorem ipsum 
function add_lorem ($atts, $content = null) {
	return 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
}
add_shortcode("lorem", "add_lorem");


// Add link for WPFolio options to the admin bar
function my_admin_bar_link() {
	global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() )
			return;
	$wp_admin_bar->add_menu( array(
			'id' => 'new_link',
			'parent' => false,
			'title' => __( 'WPFolio 2 Options'),
			'href' => admin_url( 'themes.php?page=optionsframework' )
	));
}
add_action('admin_bar_menu', 'my_admin_bar_link');


// Create a widget for feedback - contains a contact form
// http://safalra.com/programming/php/contact-feedback-form/
function feedback_dashboard_widget_function(){
	echo 'send us your feedback!'; 
}

// If the user hasn't reordered their widgets, move this one to the top
function add_feedback_dashboard_widget() {
	wp_add_dashboard_widget('feedback_dashboard_widget', 'What do you think of WPFolio Pro?', 'feedback_dashboard_widget_function');
	
	global $wp_meta_boxes;

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	
	$example_widget_backup = array('example_dashboard_widget' => $normal_dashboard['feedback_dashboard_widget']);
	unset($normal_dashboard['feedback_dashboard_widget']);

	$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

add_action('wp_dashboard_setup', 'add_feedback_dashboard_widget');

?>