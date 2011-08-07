<?php

//
//
// WPFolio Two:
// Custom Child theme functions
//
//



///////////////////////
//// POST FORMATS /////
///////////////////////

// Thanks to this thread:
// http://wordpress.stackexchange.com/questions/12420/post-format-selector-in-thematic-child-theme-post-class

// Enable post formats
add_theme_support('post-formats', array( 'link', 'aside', 'gallery', 'image', 'video' ));

// Add the format selector to post_class
function post_format_class( $classes = array() ) {
  $format = get_post_format();
  if ( '' == $format )
    $format = 'standard';
  $classes[] = 'format-' . $format;

  return $classes;
}

add_filter( 'post_class', 'post_format_class' );

?>