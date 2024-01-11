<?php 
// all ajax goes here 


// update the cart via ajax
add_action('wp_ajax_ajax_update_cart', 'shady_update_cart_quantity');
add_action('wp_ajax_nopriv_ajax_update_cart', 'shady_update_cart_quantity');

function shady_update_cart_quantity() {
    check_ajax_referer('update_cart_nonce', 'security');

    if (isset($_POST['cart_item_key']) && isset($_POST['quantity'])) :
        $cart_item_key = sanitize_text_field(wp_unslash($_POST['cart_item_key']));
        $quantity = intval($_POST['quantity']);

        WC()->cart->set_quantity($cart_item_key, $quantity);
        WC()->cart->calculate_totals();

        wp_send_json([
            'success' => true,
            // 'cart_totals' => WC()->cart->get_totals(),
        ]);
    endif;

    wp_die();
}