<?php
/* 
    Template name: Archive Collections
*/
get_header();
$desk_img   = get_field('hero_banner_desk_img');
$mob_img    = get_field('hero_banner_mob_img');
?>

<div class="archive-page archive-collections">
    <section class="section-block section-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure class="hero-banner">
                        <?php
                        if ($desk_img) :
                            $display_class = $mob_img ? 'd-none d-md-block' : '';
                            echo "<img class='img-fluid {$display_class}' src='{$desk_img['url']}' alt='{$desk_img['alt']}' width='{$desk_img['width']}' height='{$desk_img['height']}'>";
                        endif;
                        if ($mob_img) :
                            echo "<img class='img-fluid d-md-none' src='{$mob_img['url']}' alt='{$mob_img['alt']}' width='{$mob_img['width']}' height='{$mob_img['height']}'>";
                        endif;
                        ?>

                        <?php
                        $home_id = get_option('page_on_front');
                        if (get_field('show_discount_badge_bool', $home_id)) :
                            $badge  = get_field('discount_badge_img', $home_id);

                            echo "
                            <figure class='hero-banner__sale-badge mb-0'>
                                <img class='img-fluid' src='{$badge['url']}' alt='{$badge['alt']}'>
                            </figure>
                            ";
                        endif;
                        ?>
                    </figure>
                </div>

                <div class="col-12 d-none">
                    <nav class="woocommerce-breadcrumb">
                        <a href="<?php echo esc_url(home_url());?>"><?php _e('Home', 'shady');?></a>&nbsp;/&nbsp;
                        <a href="<?php echo get_permalink(wc_get_page_id('shop'));?>"><?php _e('Store', 'shady');?></a>&nbsp;/&nbsp;<?php the_title();?>
                    </nav>
                </div>

                <div class="col-12">
                    <h1 class="page-title mb-0 color-grey"><?php the_title();?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block section-collections">
        <div class="collections-blob">
            <lottie-player src="https://lottie.host/09e6f70e-a2c2-43d8-bf49-2c1f4210dc11/F1f3KUiLh1.json" background="transparent" speed="1" loop autoplay direction="1" mode="normal"></lottie-player>
        </div>
        <div class="container">
            <div class="row collections-grid">
                <?php
                $all_terms = get_terms([
                    'taxonomy'      => 'collection',
                    'hide_empty'    => false
                ]);

                if ($all_terms) :
                    foreach ($all_terms as $term) :
                        $title      = $term->name;
                        $perma      = get_term_link($term, $term->taxonomy);
                        $id_for_acf = $term->taxonomy . "_" . $term->term_id;
                        $thumb      = get_field('archive_thumb_img', $id_for_acf);
                        $thumbnail  = $thumb ? $thumb['sizes']['shop-taxo'] : placeholder_src('shop-taxo')['url'];
                        $alt        = $thumb ? $thumb['alt'] : $title;

                        echo "
                        <div class='col-6 col-md-4 col-xl-3'>
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
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();