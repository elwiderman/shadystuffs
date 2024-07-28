<?php
$images = rwmb_meta( "lf_galleria", "type=image&size=large" );
if (!empty($images)) :
    echo <<<GALLERY
            <div class="gallery row">
GALLERY;
    foreach ($images as $image) :
        $thumb = wp_get_attachment_image_src($image['ID'], 'full');
        $thumb_sm = wp_get_attachment_image_src($image['ID'], 'gallery');
        $alt_text = get_post_meta($image['ID'], '_wp_attachment_image_alt', true);
        // If not, Use the Caption
        if (empty($alt_text)) {
            $attachment = get_post($image['ID']);
            $alt_text = trim(strip_tags($attachment->post_excerpt));
        }
        // Finally, use the title
        if (empty($alt_text)) {
            $attachment = get_post($image['ID']);
            $alt_text = trim(strip_tags($attachment->post_title));
        }

        echo <<<LiGHTBOX
                <a class="gallery-img-url col-md-3 col-xs-6" href="{$thumb[0]}"
                   data-lightbox="gallery-set" data-title="{$alt_text}">
                    <img class="gallery-img img-responsive" src="{$thumb_sm[0]}" alt=""/>
                </a>
LiGHTBOX;
    endforeach;
    echo "</div>";
endif;
?>