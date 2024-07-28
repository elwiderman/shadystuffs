<?php
/*
    Hooks, actions and custom helper functions for everything related to the woo loop
    Author: Ajasra Das
*/

add_action('woocommerce_before_shop_loop', 'shady_woo_before_shop_loop_start', 9);
function shady_woo_before_shop_loop_start() {
    echo '<div class="row"><div class="col-12">';
}

add_action('woocommerce_before_shop_loop', 'shady_woo_before_shop_loop_end', 31);
function shady_woo_before_shop_loop_end() {
    echo '</div></div>';

    echo '<div class="row">';

    echo '<!-- shop loop start -->';

    echo '<div class="col-md-9">';
}
add_action('woocommerce_after_shop_loop', 'shady_woo_after_shop_loop', 31);
function shady_woo_after_shop_loop() {
    echo '</div>';
    echo '<!-- shop loop end -->';

    wc_get_template('global/sidebar.php');
}

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);




add_action('woocommerce_before_main_content', 'shady_woo_before_main_content_start', 9);
function shady_woo_before_main_content_start() {
    echo '<div class="container-fluid"><div class="row"><div class="col-12">';
}
add_action('woocommerce_before_main_content', 'shady_woo_before_main_content_end', 29);
function shady_woo_before_main_content_end() {
    echo '</div></div></div>';
    echo '<!-- main loop start -->';
    echo '<div class="container"><div class="row"><div class="col-12">';
}



add_action('woocommerce_after_main_content', 'shady_woo_after_main_content', 11);
function shady_woo_after_main_content() {
    echo '</div></div></div>';
    echo '<!-- main loop end -->';
}



// remove loop rating
// remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating');


// move quick view button in the loop
// if( class_exists('YITH_WCQV_Frontend')){
// 	remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend(), 'yith_add_quick_view_button'), 15);
// }


/*
	Category archive loop
	----------------------
*/
// add wrap to category thumb
// add_action('woocommerce_before_subcategory', 'shady_add_wrap_to_product_cat_term', 9);
function shady_add_wrap_to_product_cat_term() {
	echo '<div class="cat-wrap">';
}

// close wrap to category thumb
// add_action('woocommerce_after_subcategory', 'shady_close_wrap_to_product_cat_term', 10);
function shady_close_wrap_to_product_cat_term() {
	echo '</div>';
}

// remove name of category
// remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);


// remove the original thumb to insert the new one
// remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
// get the full image size for terms
// add_action('woocommerce_before_subcategory_title', 'shady_override_thumb_image_of_subcategories', 10);
function shady_override_thumb_image_of_subcategories($category) {
	$thumb_id = get_term_meta($category->term_id, 'thumbnail_id', true);
	$thumb = wp_get_attachment_image_src($thumb_id, 'full')[0];

	echo '<img src="'.$thumb.'" class="img-fluid">';
}


/* Override grid/list toggle plugin class to remove buggy excerpt from shop archive items */
// if (class_exists('WC_List_Grid')) {
// 	class shady_WC_List_Grid extends WC_List_Grid {

// 		function setup_gridlist() {
// 			if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
// 				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);
// 			}
// 		}
// 	}

// 	$WC_List_Grid = new shady_WC_List_Grid();
// }



// generic function to check if page is a product subcategory
function is_product_subcategory() {
	$cat = get_query_var( 'product_cat' );
	$category = get_term_by( 'slug', $cat, 'product_cat' );
	return ( $category->parent !== 0 );
}