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

// Template for portfolio category loop - excerpts are post thumbnails only
function childtheme_override_category_loop(){
	$shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');
	$cat = get_cat_ID($cat_option);
	
	if ( ! is_category($cat_option) ) {
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
					<a href="<?php the_permalink();?>"><img src="<?php get_post_thumbnail(); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail" width="150" height="150" /></a> 
	 				<?php } ?></a>
	   				<h4 class="thumb-title"><?php the_title(); ?></h4>
					
				</div><!-- #post -->
			</span> <!-- .thumb-list -->
	
		<?php 
			thematic_belowpost();
		endwhile;
	} else {
		while (have_posts()) : the_post(); 
		
				thematic_abovepost(); ?>
	
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
     				thematic_postheader(); ?>
					<div class="entry-content">
<?php thematic_content(); ?>
	
					</div><!-- .entry-content -->
					<?php thematic_postfooter(); ?>
				</div><!-- #post -->

			<?php 
		
				thematic_belowpost();
		
		endwhile;
	} // end category_loop conditional
	
} // end child_theme_override_category_loop

?>