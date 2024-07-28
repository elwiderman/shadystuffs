<?php
if ( function_exists ( 'register_sidebar' ) ) {

	register_sidebar ( array (
		'name'			=> 'Generic Sidebar',
		'id'			=> 'generic-sidebar',
		'description'   => 'Generic Sidebar with common data',
		'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>'
	));

	// register more sidebars here
	register_sidebar ( array (
		'name'			=> 'Shop Sidebar',
		'id'			=> 'shop',
		'description'   => 'Sidebar in shop pages',
		'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>'
	));

	// widget area for menu-cart
	register_sidebar ( array (
		'name'			=> 'Main menu Cart area',
		'id'			=> 'menu-cart',
		'description'   => 'Widget area in the main menu to display the mini-cart',
		'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>'
	));
}