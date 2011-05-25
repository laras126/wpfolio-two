<?php

// Translate font size to em for IE 
$title_size = title/16;
$psize = $p_text["size"]/16;
$h1size = $h1_text["size"]/16;

//#blog-title {color: <?php echo $title_color ; font-size: $title_size}
//background-image: <?php echo 'url(\"'$bg_texture'\")';
?>

#wrapper {border: <?php echo $wpr_bdr["width"].'px '.$wpr_bdr["style"].' '.$wpr_bdr["size"]; ?>; background-color: <?php echo $wpr_bg_color ?>;}
.menu a {background-color:<?php echo $wpr_bg_color; ?>;}
body {background-color:<?php echo $body_bg_color.';font-family:'.$body_text; ?>;}
.entry-title,textarea,input,#respond h3{font-family:<?php echo $body_text;?>;}