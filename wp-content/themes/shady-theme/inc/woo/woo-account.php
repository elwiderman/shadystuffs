<?php
/* 
    the hooks for the accounts section
*/

// registering the custom end-points for the my accounts sub pages
add_filter('woocommerce_get_query_vars', 'shady_custom_woocommerce_endpoints');
function shady_custom_woocommerce_endpoints($endpoints) {
    $endpoints['wishlist']  = 'wishlist';

    return $endpoints;
}

// rendering the custom endpoints in the my accounts page
add_filter('woocommerce_account_menu_items', 'shady_custom_woocommerce_account_menu_items');
function shady_custom_woocommerce_account_menu_items($items) {
    unset($items['downloads']);
    $items['edit-address'] = __('Address book', 'shady');

    $pos_of_orders      = array_search('orders', array_keys($items));
    $pos_of_wishlist    = $pos_of_orders + 1;

    // refer for adding the wishlist after the orders - https://stackoverflow.com/a/3354804/4993211

    $updated_items      = array_slice($items, 0, $pos_of_wishlist, true) +
                          array('wishlist' => __('Wishlist', 'shady')) +
                          array_slice($items, $pos_of_wishlist, count($items) - 1, true);

    return $updated_items;
}

// adding the custom templates to the new endpoints
add_action('woocommerce_account_wishlist_endpoint', 'shady_dati_profilo_content');
function shady_dati_profilo_content() {
    wc_get_template('myaccount/myaccount-wishlist.php'); // Load the custom template file.
}