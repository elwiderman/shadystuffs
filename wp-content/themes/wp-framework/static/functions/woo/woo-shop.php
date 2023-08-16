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

function custom_before_subcategory_title( $category ) {
    if ($category) :
        $id_for_acf = $category->taxonomy . "_" . $category->term_id;
        $thumb      = get_field('archive_thumb_img', $id_for_acf);

        $thumbnail  = $thumb ? $thumb['sizes']['shop-taxo'] : placeholder_src('shop-taxo')['url'];

        echo "<figure class='product-category__thumb'>
        <img class='img-fluid' src='{$thumbnail}' alt='{$thumb['alt']}'>
        </figure>";
    endif;
}
add_action( 'woocommerce_before_subcategory_title', 'custom_before_subcategory_title', 10, 1 );
