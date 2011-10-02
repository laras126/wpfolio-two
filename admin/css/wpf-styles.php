#wrapper, .menu a, ul.sub-menu a { background-color:<?php echo $wpr_bg_color; ?>; }
body {background-color:<?php echo $body_bg_color.';font-family:'.$body_text ?>}
h1,h2,h3,h4,h5,h6,p,#comments h3{font-family:<?php echo $body_text ?>}
.entry-content h2,.entry-title,textarea,input{font-family:<?php echo $body_text ?>}
p, #blog-title a, .entry-title a, .entry-content, h3.widgettitle, h1, h2, h3, h4{color: <?php echo $prim_clr ?>}
#access a, #blog-description, #siteinfo p, .aside a, .aside, .entry-meta, .entry-utility, .entry-utility a, input#s, .navigation a, #blog-title a:hover, .textwidget p {color: <?php echo $sec_clr ?>}
#footer, .news h2.entry-title, img.attachment-post-thumbnail, .single h1.entry-title, .gallery-icon {border-color:<?php echo $sec_clr ?>}
#access a:hover {background-color:<?php echo $menu_clr ?>}

<?php // If a logo was uploaded, check title option
	// if (!empty($logo)): title_option(); endif; ?>