<?php
/* all woo hooks for the product single page */

// add category and collection below the title
add_action('woocommerce_single_product_summary', 'shady_add_category_collection_below_title', 5);
function shady_add_category_collection_below_title() {
    global $product;

    echo "<div class='product-meta-top'>";
    // get the collections
    echo get_the_term_list(
        $product->get_id(), 
        'collection', 
        '<div class="product-meta-top__collection">', 
        ', ', 
        '</div>');


    // get the product categories
    echo wc_get_product_category_list( 
        $product->get_id(), 
        ', ',
        '<div class="product-meta-top__category">',
        '</div>');

    echo "</div>";
}



// 1. Show plus minus buttons
add_action( 'woocommerce_after_quantity_input_field', 'shady_display_quantity_plus' );
  
function shady_display_quantity_plus() {
   echo '<button type="button" class="plus quantity__btn"><i class="fas fa-plus"></i></button>';
}
  
add_action( 'woocommerce_before_quantity_input_field', 'shady_display_quantity_minus' );
  
function shady_display_quantity_minus() {
   echo '<button type="button" class="minus quantity__btn"><i class="fas fa-minus"></i></button>';
}
  
// -------------
// 2. Trigger update quantity script
  
add_action( 'wp_footer', 'shady_add_cart_quantity_plus_minus' );  
function shady_add_cart_quantity_plus_minus() {
 
   if ( ! is_product() && ! is_cart() ) return;
    
   wc_enqueue_js( "   
           
      $(document).on( 'click', 'button.plus, button.minus', function() {
  
         var qty = $( this ).parent( '.quantity' ).find( '.qty' );
         var val = parseFloat(qty.val());
         var max = parseFloat(qty.attr( 'max' ));
         var min = parseFloat(qty.attr( 'min' ));
         var step = parseFloat(qty.attr( 'step' ));
 
         if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
               qty.val( max ).change();
            } else {
               qty.val( val + step ).change();
            }
         } else {
            if ( min && ( min >= val ) ) {
               qty.val( min ).change();
            } else if ( val > 1 ) {
               qty.val( val - step ).change();
            }
         }
 
      });
        
   " );
}



// setting max and min quantity input
add_filter( 'woocommerce_quantity_input_max', 'shady_woo_quantity_input_max' );
function shady_woo_quantity_input_max( $max ){
    $max = 10;
    return $max;
}
add_filter( 'woocommerce_quantity_input_min', 'shady_woo_quantity_input_min', 10, 2 );
function shady_woo_quantity_input_min( $min, $product ){
    $min = 1;
    return $min;
}



// add wishlist button after the add to cart button
add_action('woocommerce_single_product_summary', 'shady_add_wishlist_after_add_to_cart_shop_sinlge', 31);
function shady_add_wishlist_after_add_to_cart_shop_sinlge() {
    global $product;

    echo '<div class="wishlist">';
	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    echo '</div>';
}


// remove the product tabs from default location
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');


// add the product tabs to the right section below the share
add_action('woocommerce_single_product_summary', 'shady_custom_product_accordions', 51);
function shady_custom_product_accordions() {
    global $product;

    wc_get_template('single-product/tabs/tabs.php');
}

// add custom product tab for the product spec
add_filter('woocommerce_product_tabs', 'shady_add_custom_product_tabs');
function shady_add_custom_product_tabs($tabs) {
    global $product;

    $pid = $product->get_id();

    // rename product description
    $tabs['description']['title'] = __('Design Inspiration', 'shady');

    if (get_field('show_product_spec_bool', $pid)) :
        $title  = get_field('product_spec_title_text', $pid);
        // Add a custom tab
        $tabs['additional_information'] = array(
            'title'     => $title,
            'priority'  => 20,
            'callback'  => 'shady_woo_product_spec_table_tab'
        );
    endif;

    return $tabs;
}

// render the product specs table 
function shady_woo_product_spec_table_tab() {
    wc_get_template('single-product/tabs/specs.php');
}

// set custom image for user in the comments 
remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar');

add_action('woocommerce_review_before', 'shady_display_review_gravatar', 10);
function shady_display_review_gravatar($comment) {
    // Get the comment author's email
    $comment_author_email = $comment->comment_author_email;

    // Get the Gravatar image URL
    $gravatar_url       = get_avatar_url($comment_author_email, array('size' => 64));
    if (!$gravatar_url) {
        $placeholder    = get_field('user_placeholder_img', 'option');
        $gravatar_url   = $placeholder['url'];
    }
    $thumb              = esc_url($gravatar_url);

    // Output custom Gravatar markup
    echo "
    <div class='comment-wrap__img'>
        <figure class='user-img'>
            <img class='img-fluid user-img__thumb' src='{$thumb}'>
        </figure>
    </div>
    ";
}


// render the size chart here
add_action('woocommerce_before_add_to_cart_quantity', 'shady_size_chart_before_quantity');
function shady_size_chart_before_quantity() {
    global $product;
    $size_chart_pid = get_field('select_size_chart_post', $product->get_id());

    // get the size chart images
    if ($size_chart_pid && get_field('show_size_chart_bool', $product->get_id())) :
        $desk       = get_field('size_chart_for_desktops', $size_chart_pid);
        $mob        = get_field('size_chart_for_mobiles', $size_chart_pid);
        ?>
        
        <div class="sizechart-wrap">
            <a href="#" class="sizechart-wrap__trigger-sizechart" data-toggle="modal" data-target="#sizeChartPop">
                <?php _e('See size chart', 'shady');?>
            </a>
    
            <div class="modal fade" id="sizeChartPop" tabindex="-1" aria-labelledby="sizeChartPopLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="icon-x"></i>
                        </button>
                        <div class="modal-body">
                            <figure class="size-chart mb-0 d-none d-lg-block">
                                <img src="<?php echo $desk['url'];?>" alt="<?php echo $desk['alt'];?>" class="img-fluid">
                            </figure>
                            <figure class="size-chart mb-0 d-lg-none">
                                <img src="<?php echo $mob['url'];?>" alt="<?php echo $mob['alt'];?>" class="img-fluid">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endif;
}



/* the image section */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

add_action('woocommerce_before_single_product_summary', 'shady_woo_custom_product_images', 20);
function shady_woo_custom_product_images() {
    if (is_product()) {
        get_template_part('woocommerce/single-product/custom-images');
    }
}