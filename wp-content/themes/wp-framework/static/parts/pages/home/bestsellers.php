<?php

if (get_field('show_bestsellers_bool')) :
    $section_title  = get_field('bestsellers_title_text');
    $cta            = get_field('bestsellers_cta_link');
    ?>

    <section class="section-block section-bestsellers">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h2 class="section-title mb-0 color-grey text-lowercase"><?php echo $section_title;?></h2>
                </div>

                <?php if ($cta) : ?>
                <div class="col-auto">
                    <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main"><?php echo $cta['title'];?></a>
                </div>
                <?php endif;?>
            </div>
        </div>

        <?php
        if (have_rows('bestsellers_repeater')) :
            echo "<div class='products-carousel'>";
            while (have_rows('bestsellers_repeater')) : the_row();
                $post_object = get_post(get_sub_field('product'));

                setup_postdata($GLOBALS['post'] =& $post_object);

                echo "<div>";
                wc_get_template_part('content', 'product-carousel');
                echo "</div>";

                wp_reset_postdata();
            endwhile;
            echo "</div>";
        endif;
        ?>
    </section>


    <?php
endif;