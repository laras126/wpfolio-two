<?php

/////////////////
// PREV / NEXT //
/////////////////

$shortname = get_option('of_shortname');
$cat_option = get_option($shortname.'_cats_in_blog');
$cat = get_cat_ID($cat_option);


// Get rid of navigation links above
function childtheme_override_nav_above() {
} 

// Change text of below navigation links in archives
function childtheme_override_nav_below() {
	if (is_single()) { ?>
	
			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php thematic_previous_post_link() ?></div>
				<div class="nav-next"><?php thematic_next_post_link() ?></div>
			</div>

<?php
	} else { ?>

		<div id="nav-below" class="navigation">
            <?php if(function_exists('wp_pagenavi')) { ?>
            <?php wp_pagenavi(); ?>
            <?php } else { ?>  
			<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Earlier', 'thematic')) ?></div>
			<div class="nav-next"><?php previous_posts_link(__('Later <span class="meta-nav">&rarr;</span>', 'thematic')) ?></div>
			<?php } ?>
		</div>	
	
<?php
	}
}

// Change text of previous post link
function childtheme_override_previous_post_link(){
	$args = array ( 'format' => '%link',
					'link' => '<span class="meta-nav">&larr;</span> Earlier',
					'in_same_cat' => FALSE,
					'excluded_categories' => '');
	$args = apply_filters('thematic_previous_post_link_args', $args );
			previous_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
}

// Change text of next post link
function childtheme_override_next_post_link(){
	$args = array ( 'format' => '%link',
					'link' => 'Later <span class="meta-nav">&rarr;</span>',
					'in_same_cat' => FALSE,
					'excluded_categories' => '');
	$args = apply_filters('thematic_next_post_link_args', $args );
			next_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
}


?>