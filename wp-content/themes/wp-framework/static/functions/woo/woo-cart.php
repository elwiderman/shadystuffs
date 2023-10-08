<?php
/* all overrides for the woo cart page */

// move the cross sells after the cart
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_cart_contents', 'woocommerce_cross_sell_display');


// change thumb size in woo cart
add_filter('woocommerce_cart_item_thumbnail', 'shady_custom_cart_thumbnail_size_filter', 10, 3);
function shady_custom_cart_thumbnail_size_filter($thumbnail, $cart_item, $cart_item_key) {
    // Get the product ID from the cart item
    $product_id = $cart_item['product_id'];

    // Get the custom image size for the thumbnail
    $thumbnail_size = 'custom-cart-thumbnail'; // Replace with your custom image size name

    // Get the custom thumbnail HTML
    $custom_thumbnail = get_the_post_thumbnail($product_id, $thumbnail_size);

    // Modify the thumbnail HTML as needed
    $modified_thumbnail = '<figure class="product-image__thumb mb-0">' . $custom_thumbnail . '</figure>';

    return $modified_thumbnail;
}



/* overrdie the checkout page */

// remove the billing company
add_filter('woocommerce_checkout_fields', 'shady_remove_billing_fields');
function shady_remove_billing_fields($fields) {
    unset($fields['billing']['billing_company']);
    return $fields;
}
