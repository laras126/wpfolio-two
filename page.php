<?php get_header(); ?>    
<!-- begin page -->    
<?php 	if (! empty($display_stats) ) { 		get_stats(1); 		echo "<br />"; 	} 	else if (($posts & empty($display_stats)) ) : foreach ($posts as $post) : start_wp(); ?> 

<div class="pages"> 
<div class="<?php wp_title('',true,''); ?>">

<?php if (is_page('home')) { echo ""; } else if (is_page("")) {
	 echo the_title('<h2>','</h2>');
	}
?>


<?php the_content(); ?>    
<?php edit_post_link('edit this entry', '<br /><span class="adminuser">', '</span>'); ?>
</div> 		    
</div>
   

<!-- <?php trackback_rdf(); ?> -->    

<?php endforeach; else: ?> 
<?php _e('Sorry, no posts matched your criteria.'); ?>
<?php endif; ?>    


<!-- end page -->     

<?php get_footer(); ?> 