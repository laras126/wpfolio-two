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
			'title' => __( 'WPFolio Two Options'),
			'href' => admin_url( 'themes.php?page=optionsframework' )
	));
}
add_action('admin_bar_menu', 'my_admin_bar_link');

// Function to test options output
function echo_test() {
	$shortname = get_option('of_shortname'); 
	$show_title = get_option($shortname . '_title_choice');

	if ( $show_title == 1 ) {
		echo '#blog_title{float:right;}';
	} else {
		echo '';
	} 	
}	
//add_action('thematic_post', 'echo_test');



?>