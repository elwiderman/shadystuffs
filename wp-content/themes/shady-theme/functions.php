<?php
// installer
// require_once(get_template_directory().'/inc/install-activate.php');

// Required plugins
// require_once(get_template_directory().'/inc/required_plugins.php');

// ACF
require_once(get_template_directory().'/inc/acf.php');

// WP Head and other cleanup functions
require_once(get_template_directory().'/inc/cleanup.php');

// Register scripts and stylesheets
require_once(get_template_directory().'/inc/enqueue-scripts.php');

// Register custom menus and menu walkers
require_once(get_template_directory().'/inc/menu.php');

// Register Sidebar
require_once(get_template_directory().'/inc/sidebar.php');

// Pagination
require_once(get_template_directory().'/inc/page-navi.php');

// Image size
require_once(get_template_directory().'/inc/image.php');

// Cpt
require_once(get_template_directory().'/inc/cpt.php');

// Ajax
require_once(get_template_directory().'/inc/ajax.php');

// Widget
require_once(get_template_directory().'/inc/widget.php');

// Shortcode
//require_once(get_template_directory().'/inc/shortcode.php');

// Custom theme functions
require_once(get_template_directory().'/inc/theme-functions.php');

// woo functions
require_once(get_template_directory().'/inc/woo-functions.php');
