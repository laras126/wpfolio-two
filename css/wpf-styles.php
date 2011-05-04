<?php

// Translate font size to em for IE 
$psize = $p_text["size"]/16;
$h1size = $h1_text["size"]/16;

?>

#header {background-color: <?php echo $hdr_bg_color ?>;}
body {background-color:<?php echo $body_bg_color ?>;}
h2{font: <?php echo $h1_text["style"].' '.$h1size.'em '.$h1_text["face"].'; color:'.$h1_text["color"].';' ?>}
p{font: <?php echo $p_text["style"].' '.$psize.'em '.$p_text["face"].'; color:'.$p_text["color"].';' ?>}
#footer {background-color:<?php echo $ftr_bg_color; ?>;}