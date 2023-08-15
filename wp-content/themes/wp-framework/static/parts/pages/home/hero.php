<?php
// hero section
$hero_slider    = get_field('hero_slider_gallery');
if (have_rows('hero_slider_repeater')) : ?>
<section class="section-block section-hero">
    <div class="container-full">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="hero-slider home-hero">
                <?php
                while (have_rows('hero_slider_repeater')) : the_row();
                    if (get_sub_field('is_active_bool')) :
                        $link       = get_sub_field('slide_link');
                        $link_class = $link ? '' : 'no-link';
                        $img        = get_sub_field('slide_img');
                        

                        $link_class = $link ? 'slide__perma' : 'slide__perma no-link';
                        $link_href  = $link ? $link['url'] : '#';
                        $link_target= $link ? $link['target'] : '';
                        
                        echo "
                        <div>
                            <div class='slide'>
                                <a href='{$link_href}' class='{$link_class}' target='{$link_target}'>
                                    <figure class='slider__img mb-0'>
                                        <img class='img-fluid' src='{$img['url']}' alt='{$img['alt']}'>
                                    </figure>
                                </a>
                            </div>
                        </div>
                        ";
                    endif;
                endwhile;
                ?>
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