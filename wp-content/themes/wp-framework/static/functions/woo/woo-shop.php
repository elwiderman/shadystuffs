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
    echo "<pre>";
    var_dump($category);
    echo "</pre>";

    // You can add your custom content or elements here
    echo '<div class="custom-subcategory-content">Custom Content Goes Here</div>';
}
add_action( 'woocommerce_before_subcategory_title', 'custom_before_subcategory_title', 10, 1 );
