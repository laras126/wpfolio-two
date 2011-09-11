<?php

// Add support for post thumbnails of 250px square
// Add custom image size for cat thumbnails
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 270, 270, true );
	add_image_size('wpf-thumb', 270, 270, true);
}

////////////////
// THUMBNAILS //
////////////////

// http://www.kingrosales.com/how-to-display-your-posts-first-image-thumbnail-automatically-in-wordpress/ -- (although this link is now dead, and function has been significantly hacked, it's worth a credit.)


// Get post attachments
function wpf_get_attachments() {
	global $post;
	return get_posts( 
		array(
			'post_parent' => get_the_ID(), 
			'post_type' => 'attachment', 
			'post_mime_type' => 'image') 
		);
}

// Get the URL of the first attachment image - called in wpf-category.php. If no attachments, display default-thumb.png
function wpf_get_first_thumb_url() {

	$attr = array( 
		'class'	=> "attachment-post-thumbnail wp-post-image");

	$imgs = wpf_get_attachments();
	if ($imgs) {
		$keys = array_reverse($imgs);
		$num = $keys[0];
		$url = wp_get_attachment_image($num->ID, 'wpf-thumb', true,$attr);
		print $url;
	} else {
		echo '<img src=http://notlaura.com/default-thumb.png alt="no attachments here!" title="default thumb" class="attachment-post-thumbnail wp-post-image">';
	}
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