<?php

/////////////////////////////
// PORTFOLIO CATEGORY LOOP //
/////////////////////////////	

// Filter page title - get rid of 'Category Archive:' text in title

function wpf_page_title(){
	if( is_category() )	{
		echo '<h1 class=entry-title>';
		single_cat_title();
		echo '</h1>';
	} 
} // end wpf_page_title


// Template for portfolio category loop - excerpts are post thumbnails only

function wpf_category_loop(){
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
	
} // end wpf_category_loop


// WPF Alterations to doctitle

function wpf_doctitle() {
	$site_name = get_bloginfo('name');
    $separator = '|';
        	
    if ( is_single() ) {
      $content = single_post_title('', FALSE);
    }
    elseif ( is_home() || is_front_page() ) { 
      $content = get_bloginfo('description');
    }
    elseif ( is_page() ) { 
      $content = single_post_title('', FALSE); 
    }
    elseif ( is_search() ) { 
      $content = __('Search Results for:', 'thematic'); 
      $content .= ' ' . esc_html(stripslashes(get_search_query()));
    }
    elseif ( is_category() ) {
      $content = __('', 'thematic');
      $content .= ' ' . single_cat_title("", false);;
    }
    elseif ( is_tag() ) { 
      $content = __('Tag Archives:', 'thematic');
      $content .= ' ' . thematic_tag_query();
    }
    elseif ( is_404() ) { 
      $content = __('Not Found', 'thematic'); 
    }
    else { 
      $content = get_bloginfo('description');
    }

    if (get_query_var('paged')) {
      $content .= ' ' .$separator. ' ';
      $content .= 'Page';
      $content .= ' ';
      $content .= get_query_var('paged');
    }

    if($content) {
      if ( is_home() || is_front_page() ) {
          $elements = array(
            'site_name' => $site_name,
            'separator' => $separator,
            'content' => $content
          );
      }
      else {
          $elements = array(
            'content' => $content
          );
      }  
    } else {
      $elements = array(
        'site_name' => $site_name
      );
    }

    // Filters should return an array
    $elements = apply_filters('thematic_doctitle', $elements);
	
    // But if they don't, it won't try to implode
    if(is_array($elements)) {
      $doctitle = implode(' ', $elements);
    }
    else {
      $doctitle = $elements;
    }
    
    $doctitle = "\t" . "<title>" . $doctitle . "</title>" . "\n\n";
    
    echo $doctitle;
} // end wpf_doctitle

?>