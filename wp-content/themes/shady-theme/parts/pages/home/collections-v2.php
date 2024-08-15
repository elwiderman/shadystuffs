<?php
// collections
if (get_field('show_collections_bool')) :
    $title      = get_field('collections_title_text');
    $cta        = get_field('collections_cta_link');
?>

<section class="section-block section-collections">
    <div class="collections-blob">
        <lottie-player src="https://lottie.host/09e6f70e-a2c2-43d8-bf49-2c1f4210dc11/F1f3KUiLh1.json" background="transparent" speed="1" loop autoplay direction="1" mode="normal"></lottie-player>
    </div>
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-12 col-md-auto">
                <h2 class="section-title color-grey" data-text="<?php echo $title;?>"><?php echo $title;?></h2>
            </div>

            <div class="col-auto">
                <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main"><?php echo $cta['title'];?></a>
            </div>
        </div>

        <div class="row collections-grid justify-content-center justify-content-xl-between">
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
                    <div class='col-6 col-md-4 col-xl-auto'>
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