<?php
// the hooks for the accounts section
add_filter('woocommerce_account_menu_items', 'shady_custom_woocommerce_account_menu_items');
function shady_custom_woocommerce_account_menu_items($items) {
    unset($items['downloads']);
    return $items;
}