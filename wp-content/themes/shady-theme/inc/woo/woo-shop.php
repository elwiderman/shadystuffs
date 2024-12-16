<?php

// function custom_subcategory_thumbnail( $category ) {
//     $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
    
//     if ( $thumbnail_id ) {
//         $thumbnail = wp_get_attachment_image( $thumbnail_id, 'thumbnail' );
//         echo '<div class="custom-subcategory-thumbnail">' . $thumbnail . '</div>';
//     }
// }
// add_action( 'woocommerce_before_subcategory_title', 'custom_subcategory_thumbnail', 9, 1 );



remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail');

function shady_custom_banner_before_subcategory_title($category) {
    if ($category) :
        $id_for_acf = $category->taxonomy . "_" . $category->term_id;
        $thumb      = get_field('banner_for_the_archive_pages_img', $id_for_acf);

        $thumbnail  = $thumb ? $thumb['url'] : placeholder_src('shop-banner')['url'];

        echo "<figure class='product-category__thumb'>
        <img class='img-fluid' src='{$thumbnail}' alt='{$thumb['alt']}'>
        </figure>";
    endif;
}
add_action( 'woocommerce_before_subcategory_title', 'shady_custom_banner_before_subcategory_title', 10, 1 );


/* modifying the breadcrumbs */
// remove the default store from the crumbs
// add_filter( 'woocommerce_get_breadcrumb', 'shady_remove_home_crumb', 20, 2 );
function shady_remove_home_crumb($crumbs, $breadcrumb) {
    foreach( $crumbs as $key => $crumb ){
        // remove home from the breadcrumb
        if ($crumb[0] === 'Home') {
            // unset($crumbs[$key]);
            $crumbs[$key] = __('Store', 'shady');
        }

    }
    echo '<pre>';
    var_dump($crumbs);
    echo '</pre>';
    return $crumbs;
}

// replace the home to be the store
// add_filter('woocommerce_breadcrumb_defaults', 'shady_woocommerce_breadcrumbs');
// function shady_woocommerce_breadcrumbs($defaults) {
//     $defaults['home'] = __('Store', 'shady');
//     return $defaults;
// }

// switch the home url to be the shop page
// add_filter( 'woocommerce_breadcrumb_home_url', 'shady_woo_custom_breadrumb_home_url' );
// function shady_woo_custom_breadrumb_home_url() {
//     return get_permalink(wc_get_page_id('shop'));
// }

add_filter('woocommerce_get_breadcrumb', 'shady_woo_breadcrumb_orverride', 10, 2 );
function shady_woo_breadcrumb_orverride($crumbs, $breadcrumb) {
    $shop_page_id = wc_get_page_id('shop'); //Get the shop page ID
    if ($shop_page_id > 0 && !is_shop()) { //Check we got an ID (shop page is set). Added check for is_shop to prevent Home / Shop / Shop as suggested in comments
        $new_breadcrumb = [
            _x( 'Store', 'breadcrumb', 'shady' ), //Title
            get_permalink(wc_get_page_id('shop')) // URL
        ];
        array_splice($crumbs, 1, 0, [$new_breadcrumb]); //Insert a new breadcrumb after the 'Home' crumb
    }

    // add link to the collection text if the tax is colleciton
    if (is_tax('collection')) {
        foreach ($crumbs as $key => $crumb) {
            if ($crumb[0] === 'Collections') {
                $crumbs[$key][1] = get_permalink(get_page_by_path('collections')); // for now its hardcoded to collections
            }
        }
    }
    return $crumbs;
}



// adding custom order status for managing the doc uploads to the orders
add_filter( 'woocommerce_register_shop_order_post_statuses', 'shady_register_custom_order_status' );
function shady_register_custom_order_status( $order_statuses ) {
    // Status must start with "wc-"!
    $order_statuses['wc-shipped'] = array(
        'label'                     => 'Shipped',
        'public'                    => false,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'shady'),
    );
   return $order_statuses;
}
 
add_filter( 'wc_order_statuses', 'shady_show_custom_order_status_single_order_dropdown' );
function shady_show_custom_order_status_single_order_dropdown( $order_statuses ) {
    $order_statuses['wc-shipped']   = 'Shipped';
    return $order_statuses;
}



/* 
    custom email template for sending shipping info
*/
add_filter( 'woocommerce_email_classes', 'shady_register_wc_custom_email_class' );
function shady_register_wc_custom_email_class( $email_classes ) {
    // Include the email class file
    include_once 'class-wc-shipped-email.php';

    // Register the email class
    $email_classes['WC_Shipped_Email'] = new WC_Shipped_Email();

    return $email_classes;
}
// register this custom email so that WooCommerce recognizes it.
add_filter( 'woocommerce_email_actions', 'shady_add_wc_custom_email_action' );
function shady_add_wc_custom_email_action( $email_actions ) {
    $email_actions[] = 'woocommerce_order_status_changed';
    return $email_actions;
}