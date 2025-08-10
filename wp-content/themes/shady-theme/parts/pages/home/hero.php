<?php
// hero section
if (get_field('show_hero_slider_bool')) : ?>
<section class="section-block section-hero">
    <div class="container-full">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="hero-slider swiper" id="homeHeroSlider">
                    <div class="swiper-wrapper">
                    <?php
                    while (have_rows('hero_slider_repeater')) : the_row();
                        $bg     = get_sub_field('bg_img');
                        $main   = get_sub_field('main_img');
                        $link   = get_sub_field('link');
                        
                        echo "
                        <div class='swiper-slide'>
                            <div class='slide'>
                                <a href='{$link['url']}' target='{$link['target']}' class='slide__perma' style='background-image:url({$bg['url']});'>
                                    <figure class='slide__perma--thumb mb-0'>
                                        <img class='img-fluid' src='{$main['url']}' alt='{$main['alt']}'>
                                    </figure>
                                    <h2 class='slide__perma--label'>
                                        <span>{$link['title']}</span>
                                    </h2>
                                </a>
                            </div>
                        </div>
                        ";
                    endwhile;
                    while (have_rows('hero_slider_repeater')) : the_row();
                        $bg     = get_sub_field('bg_img');
                        $main   = get_sub_field('main_img');
                        $link   = get_sub_field('link');
                        
                        echo "
                        <div class='swiper-slide'>
                            <div class='slide'>
                                <a href='{$link['url']}' target='{$link['target']}' class='slide__perma' style='background-image:url({$bg['url']});'>
                                    <figure class='slide__perma--thumb mb-0'>
                                        <img class='img-fluid' src='{$main['url']}' alt='{$main['alt']}'>
                                    </figure>
                                    <h2 class='slide__perma--label'>{$link['title']}</h2>
                                </a>
                            </div>
                        </div>
                        ";
                    endwhile;
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
endif;


// searh section
if (get_field('show_searchbar_bool')) : ?>

<section class="section-block section-search">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-xl-8">
                <div class="prod-search-wrap">
                    <?php echo do_shortcode(get_field('searchbar_shortcode'));?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
endif;