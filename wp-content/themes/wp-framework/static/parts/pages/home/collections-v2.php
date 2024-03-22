<?php
// collections
if (get_field('show_collections_bool')) :
    $title      = get_field('collections_title_text');
    $cta        = get_field('collections_cta_link');
?>

<section class="section-block section-collections">
    <div class="collections-blob">
        <?php
        /* 
        <!-- <div class="shady-blob" style="--time: 30s; --amount: 6;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 747.2 726.7">
                <path d="M539.8 137.6c98.3 69 183.5 124 203 198.4 19.3 74.4-27.1 168.2-93.8 245-66.8 76.8-153.8 136.6-254.2 144.9-100.6 8.2-214.7-35.1-292.7-122.5S-18.1 384.1 7.4 259.8C33 135.6 126.3 19 228.5 2.2c102.1-16.8 213.2 66.3 311.3 135.4z"></path>
            </svg>
        </div> -->        
        */
        ?>
        <lottie-player src="https://lottie.host/09e6f70e-a2c2-43d8-bf49-2c1f4210dc11/F1f3KUiLh1.json" background="transparent" speed="1" loop autoplay direction="1" mode="normal"></lottie-player>
    </div>
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-12 col-md-auto">
                <h2 class="section-title mb-md-0 color-grey"><?php echo $title;?></h2>
            </div>

            <div class="col-auto">
                <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main"><?php echo $cta['title'];?></a>
            </div>
        </div>

        <div class="row collections-grid justify-content-center">
            <?php
            if (have_rows('collections_repeater')) :
                while (have_rows('collections_repeater')) : the_row();
                    $term       = get_sub_field('collection_tax');
                    $title      = $term->name;
                    $perma      = get_term_link($term, $term->taxonomy);
                    $id_for_acf = $term->taxonomy . "_" . $term->term_id;
                    $thumb      = get_field('archive_thumb_img', $id_for_acf);
                    $thumbnail  = $thumb ? $thumb['sizes']['shop-taxo'] : placeholder_src('shop-taxo')['url'];
                    $alt        = $thumb ? $thumb['alt'] : $title;

                    echo "
                    <div class='col-4 col-md-2 col-xl-2'>
                        <div class='collection'>
                            <a href='{$perma}' class='collection__perma'>
                                <figure class='collection__perma--img'>
                                    <img class='img-fluid' src='{$thumbnail}' alt='{$alt}'>
                                </figure>
                                <h5 class='collection__perma--title'>{$title}</h5>
                            </a>
                        </div>
                    </div>
                    ";
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>

<?php
endif;