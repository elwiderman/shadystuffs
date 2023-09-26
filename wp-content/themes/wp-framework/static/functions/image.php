<?php
if ( function_exists ( 'add_image_size' ) ) :
	add_image_size( 'prod-thumb', 350, 525, true );
	add_image_size( 'shop-banner', 800, 200, true);
	add_image_size( 'shop-taxo', 460, 600, true);
	add_image_size( 'shop-taxo', 460, 600, true);
	add_image_size( 'prod-single', 600, 900, false);
	add_image_size( 'prod-single-thumb', 200, 250, true);
endif;