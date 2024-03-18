<?php 
// all ajax goes here 


// update the cart via ajax
add_action('wp_ajax_shady_ajax_update_cart', 'shady_update_cart_quantity');
add_action('wp_ajax_nopriv_shady_ajax_update_cart', 'shady_update_cart_quantity');

function shady_update_cart_quantity() {
    check_ajax_referer('update_cart_nonce', 'security');

    if (isset($_POST['cart_item_key']) && isset($_POST['quantity'])) :
        $cart_item_key = sanitize_text_field(wp_unslash($_POST['cart_item_key']));
        $quantity = intval($_POST['quantity']);

        // Update item quantity
        WC()->cart->set_quantity($cart_item_key, $quantity);
  
        WC()->cart->calculate_totals();


        $response = [
            'cart_items'    => [],
            'subtotal'      => wc_price(WC()->cart->subtotal),
            'total'         => wc_price(WC()->cart->total)
        ];

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            array_push($response['cart_items'], [
                'key'       => $cart_item['key'],
                'subtotal'  => wc_price($cart_item['line_subtotal']),
                'total'     => wc_price($cart_item['line_total'])
            ]);
        }

        // Trigger WooCommerce notice
        wc_add_notice('Your notice message here.', 'notice');

        wp_send_json($response);
    endif;

    wp_die();
}