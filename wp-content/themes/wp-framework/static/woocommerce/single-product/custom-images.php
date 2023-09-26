<?php
// the images section for the single product
global $product;

$post_thumbnail_id  = $product->get_image_id();
$attachment_ids     = $product->get_gallery_image_ids();
// add the main post thumb id to the start of the attachment_ids
array_unshift($attachment_ids, (int)$post_thumbnail_id);
?>

<div class="product-img-wrap">
    <div class="product-img-wrap__inner">
        <div class="product-carousel" id="productSingleCarouselMain">
            <?php
            foreach ($attachment_ids as $att_id) :
                $thumb          = wp_get_attachment_image_url($att_id, 'prod-single');
                $thumb_xl       = wp_get_attachment_image_url($att_id, 'full');
                $thumb_srcset   = wp_get_attachment_image_srcset($att_id, ['prod-single-thumb', 'full']);
                $thumb_alt      = get_post_meta($att_id, '_wp_attachment_image_alt', true);
    
                echo "
                <div>
                    <div class='product-slide'>
                        <a href='{$thumb_xl}' data-fancybox='product-imgs>
                            <figure class='product-slide__img mb-0'>
                                <img src='{$thumb}' srcset='{$thumb_srcset}' alt='{$thumb_alt}' class='img-fluid'>
                            </figure>
                        </a>
                    </div>
                </div>
                ";
            endforeach;
            ?>
        </div>
    
        <div class="product-nav" id="productSingleCarouselNav">
            <?php
            foreach ($attachment_ids as $att_id) :
                $thumb          = wp_get_attachment_image_url($att_id, 'prod-single-thumb');
                $thumb_alt      = get_post_meta($att_id, '_wp_attachment_image_alt', true);
    
                echo "
                <div>
                    <div class='product-slide'>
                        <figure class='product-slide__img mb-0'>
                            <img src='{$thumb}' alt='{$thumb_alt}' class='img-fluid'>
                        </figure>
                    </div>
                </div>
                ";
            endforeach;
            ?>
        </div>
    </div>
</div>