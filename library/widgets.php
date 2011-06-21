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
	$widgetareas = array ('index-insert', 'single-insert', 'single-bottom', 'single-top', 'index-bottom','index-top', 'page-top', 'page-bottom');
	
	foreach ( $widgetareas as &$area ) {
		unregister_sidebar($area);
	}
}
add_action( 'admin_init', 'child_remove_widget_area');


// Testing to see if the PHP version is up to date. If it is, add a WPFolio RSS feed widget, and if it's not, add a widget prompting an upgrade.

if (version_compare(PHP_VERSION, '5.2.4', '>=')) {

	// Add WPFolio Wiki site as a Dashboard Feed 
	// Thanks to bavotasan.com: http://bavotasan.com/tutorials/display-rss-feed-with-php/ 
	
	function custom_dashboard_widget() {
	
		$rss = new DOMDocument();
		$rss->load('http://wpfolio.visitsteve.com/wiki/feed');
		$feed = array();
		foreach ($rss->getElementsByTagName('item') as $node) {
			$item = array ( 
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				// 'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
				);
			array_push($feed, $item);
		}
		$limit = 5; // change how many posts to display here
		echo '<ul>'; // wrap in a ul
		for($x=0;$x<$limit;$x++) {
			$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
			$link = $feed[$x]['link'];
			// $description = $feed[$x]['desc'];
			$date = date('l F d, Y', strtotime($feed[$x]['date']));
			echo '<li><p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong>';
			echo ' - '.$date.'</p></li>';
			// echo '<p>'.$description.'</p>';
		}
		echo '</ul>';
		echo '<p class="textright"><a href="http://wpfolio.visitsteve.com/wiki/category/news" class="button">View all</a></p>'; // link to site
		
	}
		
	function add_custom_dashboard_widget() {
		wp_add_dashboard_widget('custom_dashboard_widget', 'WPFolio News', 'custom_dashboard_widget');
		
		// If the user hasn't reordered their widgets, move this one to the top
		global $wp_meta_boxes;
	
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		
		$example_widget_backup = array('custom_dashboard_widget' => $normal_dashboard['custom_dashboard_widget']);
		unset($normal_dashboard['feedback_dashboard_widget']);
	
		$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
	
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	
	}
	add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');
	
} else {

	function print_php_error() {
	$error = "<p style='color:red; font-size: 1.5em;'>You are using an outdated version of PHP.  WordPress doesn't support it and neither does WPFolio!  Upgrade to the latest version of PHP.</p>";
		echo $error;
	}
	
	function add_error_widget() {
		wp_add_dashboard_widget('error_widget', 'IMPORTANT!', 'print_php_error');	
	} 
	
	add_action('wp_dashboard_setup', 'add_error_widget' );
}

?>