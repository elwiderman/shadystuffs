<?php
/* 
    setup the acf to save the jsons for syncing between intallations
*/
// set the row indices for the repeaters to start with 0
add_filter('acf/settings/row_index_offset', '__return_zero');

// save point
add_filter('acf/settings/save_json', 'shady_acf_json_save_point');
 
function shady_acf_json_save_point( $path ) {
    
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
        
    // return
    return $path;
    
}

// load point
add_filter('acf/settings/load_json', 'shady_acf_json_load_point');
 
function shady_acf_json_load_point( $path ) {
    // Remove original path
    unset( $path[0] );
    
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
        
    // return
    return $path;   
}


// allow addition of iframes
add_filter( 'wp_kses_allowed_html', 'shady_acf_add_allowed_iframe_tag', 10, 2 );
function shady_acf_add_allowed_iframe_tag( $tags, $context ) {
    if ( $context === 'post' ) {
        $tags['iframe'] = array(
            'src'             => true,
            'height'          => true,
            'width'           => true,
            'frameborder'     => true,
            'allowfullscreen' => true,
        );
    }

    return $tags;
}


/* add theme option pages */
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'position'      => 61
    ));    
}


// generate the choices for the icon list of prod single from theme settings
add_filter('acf/load_field/key=field_66b4353103394', 'adhq_acf_fetch_icon_list_from_settings');
function adhq_acf_fetch_icon_list_from_settings($field) {
    // reset choices
    $field['choices']   = array();

    if (have_rows('prod_iconlist_repeater', 'option')) :
        while(have_rows('prod_iconlist_repeater', 'option')) : the_row();
            $info       = wp_strip_all_tags(get_sub_field('label_text'));
            $index      = get_row_index();
            // append to choices
            $field['choices'][$index] = $info;
        endwhile;
    endif;

    // return the field
    return $field;   
}