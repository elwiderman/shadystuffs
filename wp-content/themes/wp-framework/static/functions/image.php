<?php
if ( function_exists ( 'add_image_size' ) ) {

/*  SLIDER
------------------------------------*/
	add_image_size( 'slider-home-large', 1920, 1080, true );
	add_image_size( 'slider-home-alt', 1920, 800, true );

/*  GENERAL
------------------------------------*/
	add_image_size( 'gallery', 300 , 300, true );

/* Special for theme
------------------------------------*/
    add_image_size( 'single-featured', 1140, 472, true);
    add_image_size( 'generic-thumb', 360, 260, true);
    add_image_size( 'archive-thumb', 850, 430, true);

}
?>
