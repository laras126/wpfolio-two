<?php

////////////////////////////////////
// ENTRY META AND UTILITY FILTERS //
////////////////////////////////////

// Create entry date for post meta
function wpf_postmeta_entrydate() {
    $entrydate = '<span class="entry-date"><abbr class="published" title="';
    $entrydate .= get_the_time(thematic_time_title()) . '">';
    $entrydate .= get_the_time(thematic_time_display());
    $entrydate .= '</abbr></span>';
    
    return apply_filters('thematic_post_meta_entrydate', $entrydate);
   
} // end postmeta_entrydate()

// do we need this?!
// Remove post header edit link
function wpf_postmeta_editlink() {
} 

add_filter('thematic_postmeta_editlink','wpf_postmeta_editlink');// end postmeta_editlink

function wpf_postheader_postmeta() {
    $postmeta = '<div class="entry-meta">';
    $postmeta .= wpf_postmeta_entrydate();
    $postmeta .= wpf_postmeta_editlink();
    $postmeta .= "</div><!-- .entry-meta -->\n";
    
    return apply_filters('wpf_postheader_postmeta',$postmeta); 

} // end postheader_postmeta

function wpf_postfooter_postcomments() {
    if (comments_open()) {
        $postcommentnumber = get_comments_number();
        if ($postcommentnumber > '1') {
            $postcomments = ' <span class="comments-link"><a href="' . apply_filters('the_permalink', get_permalink()) . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= get_comments_number() . __(' Comments', 'thematic') . '</a></span>';
        } elseif ($postcommentnumber == '1') {
            $postcomments = ' <span class="comments-link"><a href="' . apply_filters('the_permalink', get_permalink()) . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= get_comments_number() . __(' Comment', 'thematic') . '</a></span>';
        } elseif ($postcommentnumber == '0') {
            $postcomments = ' <span class="comments-link"><a href="' . apply_filters('the_permalink', get_permalink()) . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= __('Leave a comment', 'thematic') . '</a></span>';
        }
    } else {
        $postcomments = ' <span class="comments-link comments-closed-link">' . __('Comments closed', 'thematic') .'</span>';
    }
    // Display edit link
    if (current_user_can('edit_posts')) {
        $postcomments .= thematic_postfooter_posteditlink();
    }               
    return apply_filters('wpf_postfooter_postcomments',$postcomments); 
    
}

// Filter post footer for News and Portfolio classes. Display usual entry-utility on news posts and remove it from portfolio posts.
function wpf_postfooter() {

    global $id, $post, $postfooter;
    $shortname = get_option('of_shortname');
	$cat_option = get_option($shortname.'_cats_in_blog');

	if ( in_category($cat_option) ) {
	    if ($post->post_type == 'page' && current_user_can('edit_posts')) { /* For logged-in "page" search results */
	        $postfooter = '<div class="entry-utility">' . thematic_postfooter_posteditlink();
	        $postfooter .= "</div><!-- .entry-utility -->\n";    
	    } elseif ($post->post_type == 'page') { /* For logged-out "page" search results */
	        $postfooter = '';
	    } else {
	        if (is_single()&& current_user_can('edit_posts')) {
	            $postfooter = '<div class="entry-utility">' . thematic_postfooter_postcategory() . thematic_postfooter_posttags() . thematic_postfooter_posteditlink(); 
	        } else {
	            $postfooter = '<div class="entry-utility">' . thematic_postfooter_postcategory() . thematic_postfooter_posttags() . wpf_postfooter_postcomments();
	        }
	        $postfooter .= "</div><!-- .entry-utility -->\n";    
	    }
	} else {
		if (current_user_can('edit_posts')) { /* For logged-in "page" search results */
	        $postfooter = '<div class="entry-utility">' . thematic_postfooter_posteditlink();
	        $postfooter .= "</div><!-- .entry-utility -->\n";    
	    } elseif ($post->post_type == 'page') { /* For logged-out "page" search results */
	        $postfooter = '';
	    } else {
	        if (is_single()) {
	            $postfooter = '';	
	        } else {
	            $postfooter = '<div class="entry-utility">' . thematic_postfooter_postcategory() . thematic_postfooter_posttags() . wpf_postfooter_postcomments();
	            $postfooter .= "</div><!-- .entry-utility -->\n";    
	        }
	        
	    }
	}   
    // Put it on the screen
    echo apply_filters( 'thematic_postfooter', $postfooter ); // Filter to override default post footer
} // end postfooter


	
?>