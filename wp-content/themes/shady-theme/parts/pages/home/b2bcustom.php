<?php
// the b2b custom blocks
if (have_rows('b2b_custom_repeater')) :
    echo "<div class='b2bcustom-content-wrap'>";
    $i = 0;
    while (have_rows('b2b_custom_repeater')) : the_row();
        $i++;
        $feat_img   = get_sub_field('feat_img');
        $title      = get_sub_field('title_text');
        $subtitle   = get_sub_field('subtitle_text');
        $thumb_img  = get_sub_field('content_bg_img');
        $cta        = get_sub_field('cta_link');
        ?>
        <section class="section-block section-b2bcustom">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <figure class="block-feat mb-0">
                            <img src="<?php echo $feat_img['url'];?>" alt="<?php echo $feat_img['alt'];?>" class="img-fluid">
                        </figure>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="block-meta" style="background-image:url(<?php echo $thumb_img['url'];?>);">
                            <div class="block-meta__content">
                                <h3 class="block-meta__content--title"><?php echo $title;?></h3>
                                <p class="block-meta__content--desc lead"><?php echo $subtitle;?></p>
                                <a href="<?php echo $cta['url'];?>" target="<?php echo $cta['target'];?>" class="block-meta__content--cta btn-main"><?php echo $cta['title'];?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endwhile;
    echo "</div>";
endif;