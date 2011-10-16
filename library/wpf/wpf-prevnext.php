<?php

/////////////////
// PREV / NEXT //
/////////////////

function wpf_navigation_below() {
	do_action('wpf_navigation_below');
} // end thematic_navigation_below

function wpf_nav_below() {

	$shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');
	$cat = get_cat_ID($cat_option);

	if ( is_single() ) { 
		
		// Only show .post-bottom-title if not in blog category or if attachment
		if ( !in_category($cat) ) { ?>
			<div class="post-bottom-title navigation">   
				<a href="<?php the_permalink() ?>" title="Permalink for <?php the_title_attribute(); ?>"><?php the_title(); ?></a> | <?php the_time('Y') ?> | <?php the_category(', '); ?> 
			</div><!-- .post-bottom-title -->
	<?php } ?>
	
		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php wpf_previous_post_link() ?></div>
			<div class="nav-next"><?php wpf_next_post_link() ?></div>
		</div> <!-- .nav-below -->

<?php
	} elseif ( is_category($cat) ){ ?>
	
		<div id="nav-below" class="navigation">
            <?php if(function_exists('wp_pagenavi')) { ?>
            <?php wp_pagenavi(); ?>
            <?php } else { ?>  
			<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'thematic')) ?></div>
			<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'thematic')) ?></div>
			<?php } ?>
		</div>	

<?php
	} else { ?>
	
		<div id="nav-below" class="navigation">
            <?php if(function_exists('wp_pagenavi')) { ?>
            <?php wp_pagenavi(); ?>
            <?php } else { ?>  
			<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Previous', 'thematic')) ?></div>
			<div class="nav-next"><?php previous_posts_link(__('Next <span class="meta-nav">&rarr;</span>', 'thematic')) ?></div>
			<?php } ?>
		</div>	

<?php
	}

} // end nav_below

add_action('wpf_navigation_below', 'wpf_nav_below', 2);

// Change text of previous post link
function wpf_previous_post_link(){
	$args = array ( 'format' => '%link',
					'link' => '<span class="meta-nav">&larr;</span> Previous',
					'in_same_cat' => TRUE,
					'excluded_categories' => '');
	$args = apply_filters('wpf_previous_post_link_args', $args );
			previous_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
}

// Change text of next post link
function wpf_next_post_link(){
	$args = array ( 'format' => '%link',
					'link' => 'Next <span class="meta-nav">&rarr;</span>',
					'in_same_cat' => TRUE,
					'excluded_categories' => '');
	$args = apply_filters('wpf_next_post_link_args', $args );
			next_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
}


?>