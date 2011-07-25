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
	            
	            /// **** WPFolio remove page title
	            // displays the page title
				//thematic_page_title();
				
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
	
	                        wp_link_pages('before=<div class="page-link">' .__('Pages:', 'thematic') . '&after=</div>');
	                        
	                        ?>
	                        
					</div><!-- .entry-content -->
	                
					<?php
	                
	                // *** WPFolio remove postfooter in attachment page
	                // creating the post footer
	                //thematic_postfooter();
	                
	                ?>
	                
				</div><!-- #post -->
	
	            <?php
	            
	            thematic_belowpost();
	            
	            ///*** Adding WPFolio attachment navigation ?>
	            
				<div class="navigation">
					<div class="nav-previous"><?php previous_image_link( 0, '&larr; Previous' ); ?></div>
					<div class="nav-next"><?php next_image_link( 0, 'Next &rarr;' ); ?></div> 
				</div> <!--.prevnext --> 
	            
	            <?php 
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