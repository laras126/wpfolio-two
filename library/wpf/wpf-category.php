<?php

/////////////////////////////
// PORTFOLIO CATEGORY LOOP //
/////////////////////////////	

// Filter page title - get rid of 'Category Archive:' text in title

function wpf_page_title(){
	
	global $post;
	$content = '';

	if( is_category() )	{
		echo '<h1 class=entry-title>';
		single_cat_title();
		echo '</h1>';
	} else if ( is_attachment() ) {
		$content .= '<h1 class="post-title"><a href="';
		$content .= apply_filters('the_permalink',get_permalink($post->post_parent));
		$content .= '">';
		$content .= get_the_title($post->post_parent);
		$content .= '</a></h1>';
	}
	echo apply_filters('wpf_page_title', $content);
} // end wpf_page_title


// Template for portfolio category loop - excerpts are post thumbnails only

function wpf_category_loop(){

	global $blog_catid;

	if ( ! is_category($blog_catid) ) {
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
						<a href="<?php the_permalink();?>"><?php wpf_get_first_thumb_url(); ?></a> 
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
					<?php wpf_postfooter(); ?>
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
      $content =  $site_name . ' | '. single_post_title('', FALSE);
    }
    elseif ( is_home() || is_front_page() ) { 
      $content = get_bloginfo('description');
    }
    elseif ( is_page() ) { 
      $content = $site_name . ' | ' . single_post_title('', FALSE); 
    }
    elseif ( is_search() ) { 
      $content = __('Search Results for:', 'thematic'); 
      $content .= ' ' . esc_html(stripslashes(get_search_query()));
    }
    elseif ( is_category() ) {
      $content =  $site_name . ' | ' . single_cat_title("", false);
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