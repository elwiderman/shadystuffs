<?php
// collections
if (get_field('show_collections_bool')) :
    $title      = get_field('collections_title_text');
    $cta        = get_field('collections_cta_link');
?>

<section class="section-block section-collections">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title"><?php echo $title;?></h1>
            </div>

            <div class="col-12 col-lg-7">
                <?php
                // the feat blocks 
                if (have_rows('featured_collections_repeater')) :
                    echo "<div class='collection-wrap'>";
                    while (have_rows('featured_collections_repeater')) : the_row();
                        $img    = get_sub_field('thumb_img');
                        $link   = get_sub_field('link');

                        echo "
                        <div class='collection'>
                            <a href='{$link['url']}' target='{$link['target']}' class='collection__perma'>
                                <figure class='collection__perma--thumb mb-0'>
                                    <img class='img-fluid' src='{$img['url']}' alt='{$img['alt']}'>
                                </figure>
                                <h5 class='collection__perma--label mb-0'>{$link['title']}</h5>
                            </a>
                        </div>
                        ";
                    endwhile;
                    echo "</div>";
                endif;
                ?>
            </div>
            <div class="col-12 col-lg-5">
                <?php
                // the gallery
                if (sizeof(get_field('collections_slider_gallery')) > 0) :
                    echo "
                    <div class='collections-slider-wrap'>
                        <div class='collections-slider' id='homeCollectionsSlider'>
                            <div class='swiper-wrapper'>";
                    foreach (get_field('collections_slider_gallery') as $thumb) :
                        echo "
                        <div class='swiper-slide'>
                            <div class='slide'>
                                <figure class='slide__thumb mb-0'>
                                    <img class='img-fluid' src='{$thumb['url']}' alt='{$thumb['alt']}'>
                                </figure>
                            </div>
                        </div>
                        ";
                    endforeach;
                    echo "
                            </div>
                            <button class='slide-navs left-arrow'>
                                <span></span>
                            </button>
                            <button class='slide-navs right-arrow'>
                                <span></span>
                            </button>
                        </div>";

                    if ($cta['url']) :
                        echo "<a href='{$cta['url']}' target='{$cta['target']}' class='btn-white'>{$cta['title']}</a>";
                    endif;
                    
                    echo "</div>";
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<?php
endif;