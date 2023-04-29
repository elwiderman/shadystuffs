<?php
if (function_exists('register_post_type')) {

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // CPT Example --------------------------------------------------------------------------------------------*/
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*$labels = array(
        'name' => _x('Example name', 'post type general name', 'jtlb'),
        'singular_name' => _x('Example name', 'post type singular name', 'jtlb'),
        'add_new' => _x('Add new example', 'example', 'jtlb'),
        'add_new_item' => __('Add new example', 'jtlb'),
        'edit_item' => __('Edit example', 'jtlb'),
        'new_item' => __('New example', 'jtlb'),
        'view_item' => __('View example', 'jtlb'),
        'search_items' => __('Search example', 'jtlb'),
        'not_found' => __('No Prexampleess found', 'jtlb'),
        'not_found_in_trash' => __('No example found in trash', 'jtlb'),
        'parent_item_colon' => '',
        'menu_name' => 'Example'
    );
    //args for the cpt
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => false, //this rewrites the url to make use
        'has_archive' => false, //takes the url of the archive page(in wp-admin) for the cpt
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-megaphone',
        'hierarchical' => true,
        'menu_position' => null,
        'supports' => array('thumbnail', 'title', 'editor', 'excerpt'),
        'taxonomies' => array( 'category', 'tags' )
    );
    register_post_type('example', $args);

    // cpt custom taxonomy
    register_taxonomy( 'example-category', // register custom taxonomy - category
        'example',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => 'Example categories',
                'singular_name' => 'Example category',
            )
        )
    );*/

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // CPT SLIDER ---------------------------------------------------------------------------------------------- */
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /* $labels = array(
        'name' => _x('Slider', 'post type general name', 'jtlb'),
        'singular_name' => _x('Slider', 'post type singular name', 'jtlb'),
        'add_new' => _x('Add new slide', 'slider', 'jtlb'),
        'add_new_item' => __('Add new slide', 'jtlb'),
        'edit_item' => __('Modify slide', 'jtlb'),
        'new_item' => __('New slide', 'jtlb'),
        'view_item' => __('View slide', 'jtlb'),
        'search_items' => __('Search slide', 'jtlb'),
        'not_found' => __('No slides found', 'jtlb'),
        'not_found_in_trash' => __('No slide found in trash', 'jtlb'),
        'parent_item_colon' => '',
        'menu_name' => 'Slider'
    );
    //viene escluso dalla ricerca frontend
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array('thumbnail', 'title', 'editor', 'excerpt')
    );
    register_post_type('slider', $args); */

}



/* 
    DEBUGGER for custom rewrite rules !!
*/
function jeet_debug_rewrite_rules() {
    global $wp, $template, $wp_rewrite;

    echo '<pre style="margin: 120px 0 0 150px;">';
    echo 'Request: ';
    echo empty($wp->request) ? 'None' : esc_html($wp->request) . PHP_EOL;
    echo 'Matched Rewrite Rule: ';
    echo empty($wp->matched_rule) ? 'None' : esc_html($wp->matched_rule) . PHP_EOL;
    echo 'Matched Rewrite Query: ';
    echo empty($wp->matched_query) ? 'None' : esc_html($wp->matched_query) . PHP_EOL;
    echo 'Loaded Template: ';
    echo basename($template);
    echo '</pre>' . PHP_EOL;

    echo '<pre>';
    print_r($wp_rewrite->rules);
    echo '</pre>';
}
// add_action( 'wp_head', 'jeet_debug_rewrite_rules' );

// flush_rewrite_rules(true);
// wp_cache_flush();