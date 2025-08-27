<?php
// partial to replace the default WooCommerce product gallery with custom thumbnails
defined( 'ABSPATH' ) || exit;
global $product;
?>

<div class="product-thumbs">
    <div class="product-thumbs__wrap" id="productThumbs">
        <?php
        // the main product image
        if (has_post_thumbnail($product->get_id())) :
            $thumb  = get_the_post_thumbnail($product->get_id(), 'full', ['class' => 'img-fluid']);
            $full   = get_the_post_thumbnail_url($product->get_id(), 'full');
            echo "
            <div class='product-thumbs__wrap--col'>
                <div class='product-thumb main-thumb'>
                    <a href='{$full}' data-fancybox='gallery'>{$thumb}</a>
                </div>
            </div>";
        endif;

        // the gallery images
        $attachment_ids = $product->get_gallery_image_ids();
        if ($attachment_ids && $product->get_image_id()) :
            foreach ($attachment_ids as $attachment_id) :

                $thumb  = wp_get_attachment_image($attachment_id, 'full', false, ['class' => 'img-fluid']);
                $full   = wp_get_attachment_image_url($attachment_id, 'full');

                echo "
                <div class='product-thumbs__wrap--col'>
                    <div class='product-thumb main-thumb'>
                        <a href='{$full}' data-fancybox='gallery'>{$thumb}</a>
                    </div>
                </div>";
            endforeach;
        endif;

        // the video if exists
        if (get_field('show_prod_video_bool')) :
            $video  = get_field('product_video')['url'];
            $thumb  = get_field('prod_video_place_img');

            echo "
            <div class='product-thumbs__wrap--col'>
                <div class='product-thumb main-thumb'>
                    <a href='{$video}' data-fancybox='gallery'>
                        <span class='tag'>Video</span>
                        <img class='img-fluid' src='{$thumb['url']}' alt='{$thumb['alt']}'>
                    </a>
                </div>
            </div>
            ";
        endif;
        ?>
    </div>
</div>