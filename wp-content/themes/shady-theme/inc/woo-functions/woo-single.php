<?php
/*
    Hooks, actions and custom helper functions for product single pages
    Author: Ajasra Das
*/

// Remove sidebar if shop single prodcut page and show breadcrumb  only in single page
if (is_product()) {
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
}

/*
    Update shop sinlge breadcrumb according to wireframe
    -----------------------------------------------------
*/
// add_action('woocommerce_before_main_content', 'shady_override_woo_breadcrumb', 20);
function shady_override_woo_breadcrumb($bread) {
    if (is_product()) : ?>
        <section class="section-block section-shop-breadcrubs">
            <div class="container">
                <div class="row justify-content-start">
                    <div class="col-12">
                        <?php
                        echo woocommerce_breadcrumb(array(
                            'home'      => __('I nostri caffe', 'shady'),
                            'delimiter' => '<span class="red">|</span>'
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </section>
<?php endif;
}

// add custom home page url for woo breadcrumbs
add_filter( 'woocommerce_breadcrumb_home_url', 'shady_woo_custom_breadrumb_home_url' );
function shady_woo_custom_breadrumb_home_url() {
    if (is_product()) {
        return get_permalink(wc_get_page_id('shop'));
    } else {
        return false;
    }
}


// show custom meta unit quantity underneath the title
// add_action('woocommerce_single_product_summary', 'shady_show_unit_qty_under_title_in_single', 6);
function shady_show_unit_qty_under_title_in_single() {
    global $product;

    $unit_qty = get_post_meta($product->get_id(), 'shady_woo_product_unit_qty', true);

    if ($unit_qty) {
        echo "<p class='unit-qty'>{$unit_qty}</p>";
    }
}


// add wishlist button after the add to cart button
// add_action('woocommerce_single_product_summary', 'shady_add_wishlist_after_add_to_cart_shop_sinlge', 41);
function shady_add_wishlist_after_add_to_cart_shop_sinlge() {
    global $product;

    echo '<div class="wishlist">';
	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    echo '</div>';
}


// remove the stuffs
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
// remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
// remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// move the short description after add to cart
// add_action('woocommerce_single_product_summary', 'shady_move_single_short_desc_after_add_to_cart', 31);
function shady_move_single_short_desc_after_add_to_cart() {
    wc_get_template_part('single-product/short-description');
}


// move description from out to the summary wrap to inside of the wrapper
// remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

// add_action('woocommerce_single_product_summary', 'shady_move_product_data_tabs_within_summary_wrapp', 61);
function shady_move_product_data_tabs_within_summary_wrapp() {
    wc_get_template_part('single-product/tabs/description');
};


// single flex slide
// define the woocommerce_single_product_carousel_options callback
function filter_woocommerce_single_product_carousel_options( $array ) {

    $default_options = array(
        'rtl' => is_rtl(),
        'animation' => 'slide',
        'smoothHeight' => false,
        'directionNav' => false,
        'controlNav' => 'thumbnails',
        'slideshow' => false,
        'animationSpeed' => 500,
        'animationLoop' => false,
    );

    // $array['slideshow'] = true;
    $array['smoothHeight'] = true;
    $array['animationLoop'] = true;
    // $array['controlNav'] = false;
    // $array['sync'] = '#helloworld';
    // $array['prevText'] = '<i class="fas fa-chevron-left"></i>';
    // $array['nextText'] = '<i class="fas fa-chevron-right"></i>';
    return $array;
};

// add the filter
add_filter('woocommerce_single_product_carousel_options', 'filter_woocommerce_single_product_carousel_options', 10, 1);
