<?php

///////////////
// PORTFOLIO //
///////////////

// Add portfolio body class to anything that isn't the blog	
function portfolio_body_class($class) {
	if ( !is_home() ) {
		$class[] = 'portfolio';
		return $class;
	} 
}
add_filter('thematic_body_class','portfolio_body_class');	

// Filter page title - get rid of 'Category Archive:' text in title
function cat_override_page_title(){
	if( is_category() )	{
		echo '<h1 class=entry-title>';
		single_cat_title();
		echo '</h1>';
	}
}
add_filter('thematic_page_title','cat_override_page_title');

// Template for category loop - excerpts are post thumbnails only
function childtheme_override_category_loop(){
	while (have_posts()) : the_post(); 		
		thematic_abovepost(); 
		?>
		<span class="thumb-list">
			<div id="post-<?php the_ID();
				echo '" ';
				if (!(THEMATIC_COMPATIBLE_POST_CLASS)) {
					post_class();
					echo '>';
				} else {
					echo 'class="';
					thematic_post_class();
					echo '">';
				} ?>
				
				<h4 class="thumb-title"><?php
				the_title(); 
				echo '</h4>'; 
				if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
  					the_post_thumbnail();
				} else {
					echo main_image();
				} ?>
			</div><!-- #post -->
		</span>

	<?php 
		thematic_belowpost();
endwhile;
}

?>