<?php
/* all overrides for the woo cart page */

// move the cross sells after the cart
// remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
// add_action('woocommerce_cart_contents', 'woocommerce_cross_sell_display');


// change thumb size in woo cart
// add_filter('woocommerce_cart_item_thumbnail', 'shady_custom_cart_thumbnail_size_filter', 10, 3);
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

// remove the billing and shipping company
// add_filter('woocommerce_checkout_fields', 'shady_remove_billing_fields');
function shady_remove_billing_fields($fields) {
    unset($fields['billing']['billing_company']);
    unset($fields['shipping']['shipping_company']);
    return $fields;
}

// this removes the company from all 
// add_filter('woocommerce_default_address_fields', 'shady_modify_default_address_fields');
function shady_modify_default_address_fields($fields) {
    // remove the company field
    unset($fields['company']);

    // set the order of the fields
    $address_order = array(
		'address_1',
		'address_2',
		'city',
		'state',
		'country',
		'postcode'
	);

	$count = 5;
    $priority = 5;

	foreach($address_order as $order_field) {
		$count++;
		$fields[$order_field]['priority'] = $count * $priority;
	}

    // adding custom classes to the fields
    $fields['address_2']['label_class'] = [];
    $fields['city']['class']            = ['form-row-first'];
    $fields['state']['class']           = ['form-row-last'];
    $fields['country']['class']         = ['form-row-first', 'country-field'];
    $fields['postcode']['class']        = ['form-row-last'];

    return $fields;
}


  
// Hide ALL shipping rates in ALL zones when Free Shipping is available
add_filter( 'woocommerce_package_rates', 'shady_unset_shipping_when_free_is_available_all_zones', 9999, 2 );
function shady_unset_shipping_when_free_is_available_all_zones( $rates, $package ) {
    $all_free_rates = array();
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $all_free_rates[ $rate_id ] = $rate;
            break;
        }
    }
    if (empty($all_free_rates)) {
        return $rates;
    } else {
        return $all_free_rates;
    } 
}


/**
 * @snippet       Create Hooks For WooCommerce Cart Block
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 9
 * @community     https://businessbloomer.com/club/
 */
 
add_filter( 'render_block', 'shady_woocommerce_cart_block_do_actions', 9999, 2 );
function shady_woocommerce_cart_block_do_actions( $block_content, $block ) {
    $blocks = array(
        'woocommerce/cart',
        'woocommerce/filled-cart-block',
        'woocommerce/cart-items-block',
        'woocommerce/cart-line-items-block',
        'woocommerce/cart-cross-sells-block',
        'woocommerce/cart-cross-sells-products-block',
        'woocommerce/cart-totals-block',
        'woocommerce/cart-order-summary-block',
        'woocommerce/cart-order-summary-heading-block',
        'woocommerce/cart-order-summary-coupon-form-block',
        'woocommerce/cart-order-summary-subtotal-block',
        'woocommerce/cart-order-summary-fee-block',
        'woocommerce/cart-order-summary-discount-block',
        'woocommerce/cart-order-summary-shipping-block',
        'woocommerce/cart-order-summary-taxes-block',
        'woocommerce/cart-express-payment-block',
        'woocommerce/proceed-to-checkout-block',
        'woocommerce/cart-accepted-payment-methods-block',
    );
    if ( in_array( $block['blockName'], $blocks ) ) {
        ob_start();
        do_action( 'shady_before_' . $block['blockName'] );
        echo $block_content;
        do_action( 'shady_after_' . $block['blockName'] );
        $block_content = ob_get_contents();
        ob_end_clean();
    }
    return $block_content;
}

/**
 * @snippet       Add Product Block Below Cross-Sells (WooCommerce Cart Block)
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 9
 * @community     https://businessbloomer.com/club/
 */
 
add_action('shady_after_woocommerce/cart-line-items-block', function() {
    wc_get_template_part('cart/cross-sells');
});

add_action('shady_after_woocommerce/cart-order-summary-coupon-form-block', function() {
    echo do_shortcode('[wpccl_button]');
});






/*
// Adjust cart total amount
add_filter( 'woocommerce_cart_get_total', 'filter_cart_get_total', 10, 1 );
function filter_cart_get_total( $total ) {
    $tax_amount = 0;

    foreach( WC()->cart->get_fees() as $fee ) {
        if(!$fee->taxable && $fee->tax < 0) {
            $tax_amount -= $fee->tax;
        }
    }

    if( $tax_amount != 0 ) {
        $total += $tax_amount;
    }
    return $total;
}

// Adjust Fee taxes (array of tax totals)
add_filter( 'woocommerce_cart_get_fee_taxes', 'filter_cart_get_fee_taxes', 10, 1 );
function filter_cart_get_fee_taxes( $fee_taxes ) {
    $fee_taxes = array();
    
    foreach( WC()->cart->get_fees() as $fee ) {
        if( $fee->taxable ) {
            foreach( $fee->tax_data as $tax_key => $tax_amount ) {
                if( isset($fee_taxes[$tax_key]) ) {
                    $fee_taxes[$tax_key] += $tax_amount;
                } else {
                    $fee_taxes[$tax_key] = $tax_amount;
                }
            }
        }
    }
    return $fee_taxes;
}

// Displayed fees: Remove taxes from non taxable fees with negative amount
add_filter( 'woocommerce_cart_totals_fee_html', 'filter_cart_totals_fee_html', 10, 2 );
function filter_cart_totals_fee_html( $fee_html, $fee ) {
    if (!$fee->taxable && $fee->tax < 0) {
        return wc_price( $fee->total );
    }
    return $fee_html;
}

// Adjust Order fee item(s) for negative non taxable fees
add_action( 'woocommerce_checkout_create_order_fee_item', 'alter_checkout_create_order_fee_item', 10, 4 );
function alter_checkout_create_order_fee_item( $item, $fee_key, $fee, $order ) {
    if (!$fee->taxable && $fee->tax < 0) {
        $item->set_taxes(['total' => []]);
        $item->set_total_tax(0);
    }
}
*/


// add sequential discounts on total cart value
add_action('woocommerce_cart_calculate_fees', 'shady_discount_based_on_cart_total', 10, 1);
function shady_discount_based_on_cart_total($cart_object) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $cart_total = $cart_object->cart_contents_total; // Cart total
    
    if ($cart_total > 10000) {
        $discount   = -(2000 / 1.05);
    } elseif ($cart_total > 4000 && $cart_total <= 10000) {
        $discount   = -(800 / 1.05);
    } elseif ($cart_total > 3000 && $cart_total <= 4000) {
        $discount   = -(700 / 1.05);
    } elseif ($cart_total > 2100 && $cart_total <= 3000) {
        $discount   = -(500 / 1.05);
    } elseif ($cart_total > 1400 && $cart_total <= 2100) {
        $discount   = -(400 / 1.05);
    } elseif ($cart_total > 1000 && $cart_total <= 1400) {
        $discount   = -(200 / 1.05);
        // $discount = -200;
    } elseif ($cart_total > 800 && $cart_total <= 1000) {
        $discount   = -(150 / 1.05);
    } else {
        $discount   = 0;
    }

    // note the / 1.05 is to offset the tax being added on the fee by woocommerce. this will work as long the tax doesnt change :( so far this is the only possible way on the woo cart blocks

    if ($discount != 0) {
        $cart_object->add_fee(__('Shady Discount', 'shady'), $discount, false);
    }
}