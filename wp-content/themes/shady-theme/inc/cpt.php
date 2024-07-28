<?php
// custom rewrite rule product single
add_action('init', 'shady_custom_product_rewrite_rules');
function shady_custom_product_rewrite_rules() {
    add_rewrite_rule(
        '^store/([^/]+)/([^/]+)/([^/]+)/?$',
        'index.php?product=$matches[3]&product_cat=$matches[1]&collection=$matches[2]',
        'top'
    );
}

// custom rewrite rule collections archive page
add_action('init', 'shady_custom_collections_archive_rewrite_rules');
function shady_custom_collections_archive_rewrite_rules() {
    add_rewrite_rule(
        '^collections/?$',
        'index.php?pagename=collections',
        'top'
    );
}


// adding collections to the permalink
function shady_custom_product_permalink_structure($post_link, $post) {
    if ('product' === $post->post_type) {
        $collection_terms = wp_get_object_terms($post->ID, 'collection');

        if (!empty($collection_terms)) {
            $post_link = str_replace('%collection%', $collection_terms[0]->slug, $post_link);
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'shady_custom_product_permalink_structure', 10, 2);



/* 
    DEBUGGER for custom rewrite rules !!
*/
function shady_debug_rewrite_rules() {
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
// add_action( 'wp_head', 'shady_debug_rewrite_rules' );

// flush_rewrite_rules(true);
// wp_cache_flush();