<?php

/////////////////////////////
// PORTFOLIO CATEGORY LOOP //
/////////////////////////////	

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
				}  
				if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
  					the_post_thumbnail();
				} else { ?>
				<a href="href="<?php the_permalink();?>""><img src="<?php get_post_thumbnail(); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail" width="150" height="150" />
 				<?php } ?>
   				<h4 class="thumb-title"><?php the_title(); ?></h4></a>
				
			</div><!-- #post -->
		</span> <!-- .thumb-list -->

	<?php 
		thematic_belowpost();
endwhile;
}

?>