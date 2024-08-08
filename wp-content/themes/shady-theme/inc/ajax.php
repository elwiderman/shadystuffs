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



// get woo products on sidebar filter
add_action('wp_ajax_shady_woo_filter', 'shady_woo_filter_shop');
add_action('wp_ajax_nopriv_shady_woo_filter', 'shady_woo_filter_shop');

function shady_woo_filter_shop() {
    if (!isset($_POST['shady_shop_check']) || !wp_verify_nonce($_POST['shady_shop_check'], 'shady_woo_filter')) :
        print 'Sorry, your nonce did not verify.';
    exit;
    else :
        // process form data
        $paged      = (isset($_POST['page']) && $_POST['page'] !== '') ? $_POST['page'] : 1;
        $ppp        = $_POST['per_page'];
        $tax_query  = [['relation'  => 'AND']];
        $args       = [
            'post_type'         => 'product',
            'posts_per_page'    => $ppp,
            'paged'             => $paged,
            'post_status'       => 'publish',
        ];

        if (isset($_POST['collection'])) :
            array_push($tax_query, [
                'taxonomy'      => 'collection',
                'field'         => 'slug',
                'terms'         => $_POST['collection'] 
            ]);
        endif;
        if (isset($_POST['size'])) :
            array_push($tax_query, [
                'taxonomy'      => 'pa_size',
                'field'         => 'slug',
                'terms'         => $_POST['size'] 
            ]);
        endif;
        if (isset($_POST['color'])) :
            array_push($tax_query, [
                'taxonomy'      => 'pa_color',
                'field'         => 'slug',
                'terms'         => $_POST['color'] 
            ]);
        endif;

        if (sizeof($tax_query) > 1) :
            $args['tax_query']  = $tax_query;
        endif;

        if (isset($_POST['stock'])) :
            $args['meta_query'] = [
                [
                    'key'       => '_stock_status',
                    'value'     => $_POST['stock']
                ]
            ];
        endif;

        $prod_query = new WP_Query($args);

        $html   = '';

        ob_start();
        if ($prod_query->have_posts()) :
            while ($prod_query->have_posts()) : $prod_query->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            wp_reset_postdata();
        else :
            $shop   = get_permalink(wc_get_page_id('shop'));
            echo "<h6>Oops! we couldn't find what you were looking for.<br>You can try with different filters or go to the <a href='{$shop}'>Shady Store</a></h6>";
        endif;

        $html   = ob_get_contents();
        ob_end_clean();

        $result = [
            'content'       => $html,
            'current_page'  => $paged,
            'ppp'           => $ppp,
            'count'         => $prod_query->post_count,
            'max'           => $prod_query->max_num_pages,
            'found'         => $prod_query->found_posts,
            'collections'   => $_POST['collection'],
            'sizes'         => $_POST['size'],
            'colors'        => $_POST['color'],
            'tax'           => $tax_query,
            'arggs'         => $args,
            'stock'         => $_POST['stock']
        ];
        wp_send_json($result);
        
    endif;
}


// get woo products on loadmore
add_action('wp_ajax_shady_load_more_products', 'shady_load_more_products_shop');
add_action('wp_ajax_nopriv_shady_load_more_products', 'shady_load_more_products_shop');

function shady_load_more_products_shop() {
    if (!isset($_POST['shady_woo_loadmore']) || !wp_verify_nonce($_POST['shady_woo_loadmore'], 'shady_woo_loadmore')) :
        print 'Sorry, your nonce did not verify.';
    exit;
    else :
        // process form data
        $ppp        = $_POST['per_page'];
        $paged      = isset($_POST['current_page']) ? (int)$_POST['current_page'] + 1 : 1;
        $tax_query  = [['relation'  => 'AND']];
        $args       = [
            'post_type'         => 'product',
            'posts_per_page'    => $ppp,
            'paged'             => $paged,
            'post_status'       => 'publish',
        ];

        if (isset($_POST['collections']) && $_POST['collections'] !== '') :
            array_push($tax_query, [
                'taxonomy'      => 'collection',
                'field'         => 'slug',
                'terms'         => explode('&', $_POST['collections'])
            ]);
        endif;
        if (isset($_POST['sizes']) && $_POST['sizes'] !== '') :
            array_push($tax_query, [
                'taxonomy'      => 'pa_size',
                'field'         => 'slug',
                'terms'         => explode('&', $_POST['sizes'])
            ]);
        endif;
        if (isset($_POST['colors']) && $_POST['colors'] !== '') :
            array_push($tax_query, [
                'taxonomy'      => 'pa_color',
                'field'         => 'slug',
                'terms'         => explode('&', $_POST['colors'])
            ]);
        endif;
        if (isset($_POST['stock']) && $_POST['stock'] !== '') :
            $args['meta_query'] = [
                [
                    'key'       => '_stock_status',
                    'value'     => $_POST['stock']
                ]
            ];
        endif;

        if (sizeof($tax_query) > 1) :
            $args['tax_query']  = $tax_query;
        endif;

        $prod_query = new WP_Query($args);

        $html   = '';

        ob_start();
        if ($prod_query->have_posts()) :
            while ($prod_query->have_posts()) : $prod_query->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            wp_reset_postdata();
        else :
            $shop   = get_permalink(wc_get_page_id('shop'));
            echo "<h6>Oops! we couldn't find what you were looking for.<br>You can try with different filters or go to the <a href='{$shop}'>Shady Store</a></h6>";
        endif;

        $html   = ob_get_contents();
        ob_end_clean();

        $result = [
            'content'       => $html,
            'current_page'  => $paged,
            'ppp'           => $ppp,
            'max'           => $prod_query->max_num_pages,
            'count'         => $prod_query->post_count,
            'found'         => $prod_query->found_posts,
            'collections'   => $_POST['collections'],
            'sizes'         => $_POST['sizes'],
            'colors'        => $_POST['colors'],
            'stock'         => $_POST['stock'],
            'tax'           => $tax_query,
            'arggs'         => $args
        ];
        wp_send_json($result);
        
    endif;
}

