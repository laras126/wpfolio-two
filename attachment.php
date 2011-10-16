<?php

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container">
		
			<?php thematic_abovecontent(); ?>
		
			<div id="content">
	
	            <?php
	            
	            the_post();
	            
	            /// **** WPFolio page title
				//wpf_page_title();
				
				thematic_abovepost();
	            
	            ?>
	            
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
	                
	                // creating the post header
	                thematic_postheader();
	                
	                ?>
	                
					<div class="entry-content">
						<div class="entry-attachment"><?php 
						///*** WPFolio: $post->post_ID to $post->ID 
						the_attachment_link($post->ID, true) ?></div>
	                    
	                        <?php 
	                        
	                        the_content(more_text());
	                        global $post;
	                        get_artwork_fields_info();
	
	                        wp_link_pages('before=<div class="page-link">' .__('Pages:', 'thematic') . '&after=</div>');
				
	                        ?>
	                        
					</div><!-- .entry-content -->
	                
					<?php
	                
	                // *** WPFolio remove postfooter in attachment page
	                // creating the post footer
	                // thematic_postfooter();
	                
	                ?>
	                
				</div><!-- #post -->
	
	            <?php
	            
	            thematic_belowpost();
	            
	            ///*** Adding WPFolio navigation
	            //wpf_nav_below(); 

				$parent_cat = get_the_category($post->post_parent);
				$cat_name = get_cat_ID($parent_cat[0]->cat_name);
				$cat_link = get_category_link($cat_name);

	            ?>

	            <div class="post-bottom-title navigation">   
					<a href="<?php echo apply_filters('the_permalink',get_permalink($post->post_parent)); ?>"><?php echo get_the_title($post->post_parent); ?></a> | <?php the_time('Y') ?> | <a href="<?php echo $cat_link; ?> "><?php echo $parent_cat[0]->cat_name; ?></a>
				</div><!-- .post-bottom-title -->

				<div class="navigation">
					<div class="nav-previous"><?php previous_image_link( 0, '&larr; Previous' ); ?></div>
					<div class="nav-next"><?php next_image_link( 0, 'Next &rarr;' ); ?></div> 
				</div> <!--.prevnext -->  <?php
	           

	            ///*** WPFolio remove attachment comments 
	            // comments_template();
	            
	            ?>
	
			</div><!-- #content -->
			
			<?php thematic_belowcontent(); ?> 
			
			
		
		</div><!-- #container -->

<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    thematic_sidebar();

    // calling footer.php
    get_footer();

?>