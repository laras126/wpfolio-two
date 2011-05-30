<?php

/////////////
// WIDGETS //
/////////////

// http://themeshaper.com/forums/topic/something-new-bout-widgetized-areas#post-6601


// Rename some widget areas
function rename_widgetized_area($content) {
	$content['Single Bottom']['args']['name'] = 'After Single Post';
	$content['Single Top']['args']['name'] = 'Before Single Post';
	$content['1st Subsidiary Aside']['args']['name'] = 'Footer Left'; 
	$content['2nd Subsidiary Aside']['args']['name'] = 'Footer Middle'; 
	$content['3rd Subsidiary Aside']['args']['name'] = 'Footer Right';
	$content['Index Bottom']['args']['name'] = 'Posts Page Bottom';
	$content['Index Top']['args']['name'] = 'Posts Page Top';
	return $content;
}
add_filter('thematic_widgetized_areas', 'rename_widgetized_area');

// Remove some widget areas
// Add the name of the widget area you want to remove to the $widgetareas array / remove name of area you want to add
function child_remove_widget_area() {
	$widgetareas = array ('index-insert', 'single-insert', 'single-bottom', 'single-top', 'index-bottom', 'index-top', 'page-top', 'page-bottom');
	
	foreach ( $widgetareas as &$area ) {
		unregister_sidebar($area);
	}
}
add_action( 'admin_init', 'child_remove_widget_area');

/**********************************/
/*** Create Below Footer Widget ***/
/**********************************/

//http://themeshaper.com/forums/topic/adding-a-simple-widget-area-at-thematic_belowheader
// Create the widget area
function my_widgets_init() {
    register_sidebar(array(
       	'name' => 'Below Footer',
       	'id' => 'below-footer',
/*       	'before_widget' => '<li id="%1$s" class="widgetcontainer %2$s">',
       	'after_widget' => "\n",
		'before_title' => "<h3 class=\"widgettitle\">",
		'after_title' => "</h3>\n", */
    ));

}
add_action( 'init', 'my_widgets_init' );

// Adding the widget area to your child theme
function below_footer_widget() {
	if ( function_exists('dynamic_sidebar') && is_active_sidebar('below-footer') ) {
	    echo '<div id="below-footer" class="aside">'. "\n" . '<ul class="xoxo">' . "\n";
	    dynamic_sidebar('below-footer');
		echo '' . "\n" . ''. "\n";
	    echo '' . "\n" . '</div><!-- #below-footer .aside -->'. "\n";
	}
}

?>