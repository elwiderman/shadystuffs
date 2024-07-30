<?php
// add_action('woocommerce_before_shop_loop_item_title', 'shady_woo_template_loop_product_thumbnail', 10);
// function shady_woo_template_loop_product_thumbnail() {
//     global $product;
//     $title = $product->get_title();

//     echo "<h4 class='title'>{$title}</h4>";
// }

/**
 * Change the strength requirement for WooCommerce passwords
 *
 * @author Misha Rudrastyh
 * @url https://rudrastyh.com/woocommerce/password-strength-meter.html#change-minimum-strength
 *
 * Strength Settings
 * 4 = Strong
 * 3 = Medium (default) 
 * 2 = Also Weak but a little bit stronger 
 * 1 = Password should be at least Weak
 * 0 = Very Weak / Anything
 */
add_filter( 'woocommerce_min_password_strength', 'shady_change_password_strength' );

function shady_change_password_strength( $strength ) {
    return 3;
}

add_filter( 'loop_shop_per_page', 'shady_redefine_products_per_page', 9999 );
function shady_redefine_products_per_page( $per_page ) {
    $per_page = 32;
    return $per_page;
}

// thumb wrapper and starting of content wrap
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

add_action('woocommerce_before_shop_loop_item_title', 'shady_woo_loop_thumb_modifier', 9);
function shady_woo_loop_thumb_modifier() {
	global $product;
	?>
	<figure class="product__image">
        <?php
            $img_size = 'prod-thumb';
            $attr = array(
                'class' =>'img-fluid',
                'alt'   => $product->get_name()
            );

            if (has_post_thumbnail()) :
                echo $product->get_image($img_size, $attr);
            else :
                $src = product_placeholder($img_size);

                echo "<img src='{$src['url']}' class='img-fluid'>";
            endif;
        ?>

		
	</figure>
	<?php
}

add_action('woocommerce_shop_loop_item_title', 'shady_woo_loop_wrap_title_price_start', 9);
function shady_woo_loop_wrap_title_price_start() {
    echo "<div class='product__meta'>";
}

add_action('woocommerce_after_shop_loop_item_title', 'shady_woo_loop_wrap_title_price_end', 11);
function shady_woo_loop_wrap_title_price_end() {
    echo "</div>";
}


// add the wishlist and the quick view buttons
add_action('woocommerce_after_shop_loop_item', 'shady_woo_loop_thumb_wishlist_quickview', 6);
function shady_woo_loop_thumb_wishlist_quickview() {
    global $product;
    ?>
    <div class="product__reveal">
        <div class="product__reveal--wishlist">
            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]');?>
        </div>
        <div class="product__reveal--quickview d-none">
            <a class="yith-wcqv-button btn-square-white" data-product_id="<?php echo $product->get_id();?>" href="#">
                <i class="fas fa-search-plus"></i>
            </a>
        </div>
    </div>
    <?php
}

// remove add to cart from loop
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);