<?php

// Translate font size to em for IE 
$title_size = title/16;
$psize = $p_text["size"]/16;
$h1size = $h1_text["size"]/16;

//#blog-title {color: <?php echo $title_color ; font-size: $title_size}
?>

#wrapper {border: <?php echo $wpr_bdr["width"].'px '.$wpr_bdr["style"].' '.$wpr_bdr["size"]; ?>; background-color: <?php echo $wpr_bg_color; ?>}
body {background-color:<?php echo $body_bg_color.';font-family:'.$body_text; ?>;}
#footer {background-color:<?php echo $ftr_bg_color; ?>;}