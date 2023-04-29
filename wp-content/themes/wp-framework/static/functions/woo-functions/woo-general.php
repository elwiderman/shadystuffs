<?php
/*
    Hooks, actions and custom helper functions for usage everywhere
    Author: Ajasra Das
*/


/*
    Change thumbnail size
** Refer - https://docs.woocommerce.com/document/image-sizes-theme-developers/
*/
// add_filter('single_product_archive_thumbnail_size', function( $size ) {
//     return 'archive-thumb';
// });





/*
    Custom funtions for theme
    ---------------------------
*/
function jeet_return_products_from_category_slug($slug, $limit) {
    if(!function_exists('wc_get_products')) {
        return;
    }

    $args = array(
        'tax_query'            => array(
			array(
				'relation'	   => 'AND'
			),
            array(
                'taxonomy'     => 'product_cat',
                'field'        => 'slug',
                'terms'        => array($slug)
			),
			array(
				'taxonomy' 	   => 'product_visibility',
				'field'    	   => 'name',
				'terms'    	   => 'featured',
				'operator' 	   => 'IN', // or 'NOT IN' to exclude feature products
			)
        ),
        'meta_key'             => 'total_sales',
        'order_by'             => 'meta_value_num',
        'return'               => 'ids', // most important - this fellow gets the stuff done
        'limit'                => $limit,
        'status'               => 'publish'
    );

    $term_products_query = wc_get_products($args);

    return $term_products_query;
}



/*
    My account overrides
    ---------------------
*/
// add_filter('woocommerce_account_menu_items', 'jeet_remove_my_account_links');
function jeet_remove_my_account_links($menu_links) {
	// unset( $menu_links['edit-address'] ); // Addresses
	//unset( $menu_links['dashboard'] ); // Dashboard
	//unset( $menu_links['payment-methods'] ); // Payment Methods
	//unset( $menu_links['orders'] ); // Orders
	unset( $menu_links['downloads'] ); // Downloads
	//unset( $menu_links['edit-account'] ); // Account details
	//unset( $menu_links['customer-logout'] ); // Logout

	return $menu_links;
}

// add new link
// add_filter('woocommerce_account_menu_items', 'jeet_add_one_more_link');
function jeet_add_one_more_link($menu_links) {

	// we will hook "anyuniquetext123" later
	$new = array('my-wishlist' => 'Wishlist');

	// or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

	// array_slice() is good when you want to add an element between the other ones
	$menu_links = array_slice( $menu_links, 0, 1, true )
	+ $new
	+ array_slice( $menu_links, 1, NULL, true );

	return $menu_links;
}


// fix and add the newly added link to acc menu items
// add_filter ('woocommerce_account_menu_items', 'jee_fix_woo_my_account_order');
function jee_fix_woo_my_account_order() {
	$myorder = array(
		'dashboard'          => __( 'Dashboard', 'woocommerce' ),
		'orders'             => __( 'Orders', 'woocommerce' ),
		'my-wishlist'      	 => __( 'Lista dei desideri', 'woocommerce' ),
		'edit-account'       => __( 'Modifica account', 'woocommerce' ),
		'edit-address'       => __( 'Addresses', 'woocommerce' ),
		'customer-logout'    => __( 'Logout', 'woocommerce' ),
	);
	return $myorder;
}



/*
 * Step 1. Add Link to My Account menu
 */
// add_filter('woocommerce_account_menu_items', 'jeet_recent_quotes_link', 40);
function jeet_recent_quotes_link( $menu_links ){

	$menu_links = array_slice( $menu_links, 0, 5, true )
	+ array( 'my-wishlist' => 'Lista dei desideri' )
	+ array_slice( $menu_links, 5, NULL, true );

	return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'jeet_add_endpoint' );
function jeet_add_endpoint() {

	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'my-wishlist', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_my-wishlist_endpoint', 'jeet_my_account_endpoint_content' );
function jeet_my_account_endpoint_content() {

	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
	echo '<div class="page-wishlist-wrap">';
	echo do_shortcode('[yith_wcwl_wishlist]');
	echo '</div>';
}
/*
* Step 4. update page title without disturbing the menu title
*/
// add_filter( 'the_title', 'jeet_hook_my_account_title' );

function jeet_hook_my_account_title( $title ) {

	global $wp_query;

	if (isset( $wp_query->query_vars['my-wishlist'] ) && $title == 'My account' && in_the_loop()) {
		return 'Wishlist';
	}

	return $title;
}



// Rename page title for search results page title using the woocommerce_page_title callback
// add_filter('woocommerce_page_title', 'jeet_filter_woocommerce_page_title', 10, 1);
function jeet_filter_woocommerce_page_title($page_title) {
    if (is_search()) {
        $page_title = '<span>' . __('Risultati della ricerca : ', 'woocommerce') . '</span>"' . ucfirst(get_search_query()) . '"';
    }
    return $page_title;
}



// add_action('wp_footer', 'jeet_woo_quantity_wp_footer');
function jeet_woo_quantity_wp_footer() {
	if (is_product()) { ?>
		<script>
			woo.init();
		</script>
	<?php
	}
}


/*
	show only products from certain categories
	// the process is to hack the main query using pre get posts
*/
// add_action( 'pre_get_posts', 'jeet_show_certain_categories_in_shop_page' );

function jeet_show_certain_categories_in_shop_page( $q ) {

	if ( !$q->is_main_query() ) return;
	if ( !$q->is_post_type_archive() ) return;

	if(!is_admin() && is_shop()) {
		$tax_query = (array) $q->get( 'tax_query' );

		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'cialde' , 'capsule' , 'caffe-in-grani', 'caffe-macinato' ), // Don't display products in the other categories on the shop page.
			'operator' => 'IN'
		);


		$q->set( 'tax_query', $tax_query );
	}

}



function jeet_yith_get_picked_up_message( $data, $pattern = '' ) {
	if ( ! isset( $pattern ) || ( 0 == strlen ( $pattern ) ) ) {
		$pattern = get_option ( 'ywot_order_tracking_text' );
		
	}
	
	//  Retrieve additional information to be shown
	$order_tracking_code = isset( $data['ywot_tracking_code'] ) ? $data['ywot_tracking_code'] : '';
	$order_carrier_name  = isset( $data['ywot_carrier_name'] ) ? $data['ywot_carrier_name'] : '';
	$order_pick_up_date  = isset( $data['ywot_pick_up_date'] ) ? $data['ywot_pick_up_date'] : '';
	
	$message = str_replace (
		array( "[carrier_name]", "[pickup_date]", "[track_code]" ),
		array(
			$order_carrier_name,
			date_i18n ( get_option ( 'date_format' ), strtotime ( $order_pick_up_date ) ),
			$order_tracking_code,
		),
		$pattern );
	
	return $message;
}
