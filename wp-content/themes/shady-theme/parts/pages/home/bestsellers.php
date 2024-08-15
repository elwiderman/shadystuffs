<?php

if (get_field('show_bestsellers_bool')) :
    $title          = get_field('bestsellers_title_text');
    $desc           = nl2br(get_field('bestsellers_content_text'));
    $bg             = get_field('bestsellers_bg_img');
    $cta            = get_field('bestsellers_cta_link');
    ?>

    <section class="section-block section-bestsellers">
        <div class="section-bg" style="background-image:url(<?php echo $bg['url'];?>)"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-6">
                    <div class="title-wrap">
                        <h4 class="title-wrap__title color-white"><?php echo $title;?></h4>
                        <p class="title-wrap__desc color-white"><?php echo $desc;?></p>
                        <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main mb-4 mb-md-0"><?php echo $cta['title'];?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    // for best sellers
                    if (sizeof(get_field('bestsellers_relations')) > 0) :
                        echo "<div class='bestsellers-carousel'>";
                        foreach (get_field('bestsellers_relations') as $post_id) :
                            $post_object = get_post($post_id);

                            setup_postdata($GLOBALS['post'] =& $post_object);

                            echo "<div>";
                            wc_get_template_part('content', 'product-carousel');
                            echo "</div>";

                            wp_reset_postdata();
                        endforeach;
                        echo "</div>";
                    endif;
                    ?>
                </div>
            </div>
        </div>

    </section>


    <?php
endif;