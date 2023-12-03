<?php
function framework_scripts() {

    $path = get_template_directory_uri();

    // Load site libs js files in footer
    wp_deregister_script('bootstrap'); // to prevent clash with plugins calling bootstrap 3

    // Adding scripts file in the footer
    wp_enqueue_script('site-scripts', $path . '/assets/scripts/app.min.js', '', '', false);

    if (is_front_page()) {
        wp_localize_script('site-scripts', 'WPURLS', array(
            'ajaxurl'   => admin_url('admin-ajax.php'),
        ));
    }

    if (is_archive()) {
        global $wp_query;
        wp_localize_script('site-scripts', 'WPURLS', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'posts' => json_encode($wp_query->query_vars),
            'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
            'max_page' => $wp_query->max_num_pages
        ));
    }
}

function framework_styles() {
    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
    $path = get_template_directory_uri();

    // Register Custom Font
    // wp_enqueue_style('site-font', '//fonts.googleapis.com/css?family=Montserrat:400,700|Roboto:300&display=swap', '', '');

    // Register main stylesheet
    wp_enqueue_style('site-fontawesome', '//use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '', 'all');
    wp_enqueue_style('site-css', $path . '/assets/css/app.min.css', array(), '', 'all');
}

add_action('wp_enqueue_scripts', 'framework_styles', 1000);

add_action('wp_enqueue_scripts', 'framework_scripts', 1000);
