<?php
// hero section
if (have_rows('home_hero_repeater')) : ?>
<section class="section-block section-hero">
    <div class="home-hero-slider">
        <?php
        while (have_rows('home_hero_repeater')) : the_row();
            if (get_sub_field('show_slide_bool')) :
                $thumb      = get_sub_field('slide_img');
                $bg         = get_sub_field('slide_bg_img');
                $text       = nl2br(get_sub_field('slide_content_text'));
                $cta        = get_sub_field('slide_cta_link');
                $cta_color  = get_sub_field('slide_cta_style_select');

                echo "
                <div>
                    <div class='slide'>
                        <a href='{$cta['url']}' class='slide__perma'>
                            <div class='slide__bg' style='background-image:url({$bg['url']})'></div>
                            <figure class='slide__thumb mb-0'>
                                <img class='img-fluid' src='{$thumb['url']}' alt='{$thumb['alt']}'>
                            </figure>
                            <div class='slide__content'>
                                <div class='slide__content--text to-stagger'>{$text}</div>
                                <div class='slide__content--btn to-stagger'>
                                    <div class='{$cta_color}'>shop now!</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                ";
            endif;
        endwhile;
        ?>
    </div>
    <?php
    if (get_field('show_discount_badge_bool')) :
        $badge  = get_field('discount_badge_img');
        $logo   = get_field('logo_img');

        echo "
        <figure class='sale-badge mb-0'>
            <img class='img-fluid' src='{$badge['url']}' alt='{$badge['alt']}'>
        </figure>
        <figure class='logo mb-0'>
            <img class='img-fluid' src='{$logo['url']}' alt='{$logo['alt']}'>
        </figure>
        ";
    endif;
    ?>
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