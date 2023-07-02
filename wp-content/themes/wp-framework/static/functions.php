<?php
// installer
// require_once(get_template_directory().'/functions/install-activate.php');

// Required plugins
// require_once(get_template_directory().'/functions/required_plugins.php');

// ACF
require_once(get_template_directory().'/functions/acf.php');

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/cleanup.php');

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php');

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php');

// Register Sidebar
require_once(get_template_directory().'/functions/sidebar.php');

// Pagination
require_once(get_template_directory().'/functions/page-navi.php');

// Image size
require_once(get_template_directory().'/functions/image.php');

// Theme options
// require_once(get_template_directory().'/functions/theme-options.php');

// Cpt
require_once(get_template_directory().'/functions/cpt.php');

// Metabox
// require_once(get_template_directory().'/functions/metabox.php');

// Ajax
require_once(get_template_directory().'/functions/ajax.php');

// Widget
require_once(get_template_directory().'/functions/widget.php');

// Shortcode
//require_once(get_template_directory().'/functions/shortcode.php');

// Custom theme functions
require_once(get_template_directory().'/functions/theme-functions.php');
