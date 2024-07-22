<?php

if (get_field('show_bestsellers_bool')) :
    $section_title  = get_field('bestsellers_title_text');
    $cta            = get_field('bestsellers_cta_link');
    ?>

    <section class="section-block section-bestsellers">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h2 class="section-title mb-md-0 color-grey text-lowercase"><?php echo $section_title;?></h2>
                </div>

                <?php if ($cta) : ?>
                <div class="col-auto">
                    <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main mb-4 mb-md-0"><?php echo $cta['title'];?></a>
                </div>
                <?php endif;?>
            </div>
        </div>

        <?php
        // for best sellers
        if (sizeof(get_field('bestsellers_relations')) > 0) :
            echo "<div class='products-carousel'>";
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
    </section>


    <?php
endif;