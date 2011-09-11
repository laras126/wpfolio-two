<?php

// Add support for post thumbnails of 250px square
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 250, 250, true );
}

////////////////
// THUMBNAILS //
////////////////

// http://www.kingrosales.com/how-to-display-your-posts-first-image-thumbnail-automatically-in-wordpress/ -- (although this link is now dead)
// Get the URL of the first attachment image - called in wpf-category.php

function get_post_thumbnail() {
	$files = get_children('post_parent='.get_the_ID().'&post_type=attachment&post_mime_type=image');
	if($files) :
		$keys = array_reverse(array_keys($files));
		$j = 0;
		$num = $keys[$j];
/*		$image = wp_get_attachment_image($num);
		$imagepieces = explode('"', $image);
		$imagepath = $imagepieces[1];*/
		$thumb = wp_get_attachment_thumb_url($num);
		print $thumb;
	else:
		echo 'http://notlaura.com/default-thumb.png';
	endif;
}

// END - get attachment function

// Make featured image thumbnail a permalink
add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );
function my_post_image_html( $html, $post_id, $post_image_id ) {
	$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
	return $html;
}


/*----- GET FEATURED IMAGE (1.7 function)----*/
// Thumbnail Function - this creates a default featured image if one is not specified
/*function get_thumb ($post_ID){
    $thumbargs = array(
    'post_type' => 'attachment',
    'numberposts' => 1,
    'post_status' => null,
    'post_parent' => $post_ID
    );
    $thumb = get_posts($thumbargs);
    if ($thumb) {
        return wp_get_attachment_image($thumb[0]->ID);
    }
} 
//add_action('thematic_content', 'check_thumb');

function check_thumb() {		
	global $post;
			
	if( !has_post_thumbnail() ) {		
		echo get_thumb($post->ID); 
	}
}*/



?>