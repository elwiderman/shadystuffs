<?php
if (get_field('show_new_arrivals_bool')) :
    $section_title  = get_field('arrivals_title_text');
    $cta            = get_field('arrivals_cta_link');
    ?>

    <section class="section-block section-arrivals">
        <div class="arrivals-blob">
            <lottie-player src="https://lottie.host/d0a99084-05ba-403d-8b38-9fd9de12ecde/0Rfy7lu9yT.json" background="transparent" speed="1" direction="1" playMode="normal" loop autoplay></lottie-player>
        </div>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h2 class="section-title mb-md-0 color-grey text-lowercase"><?php echo $section_title;?></h2>
                </div>

                <?php if ($cta) : ?>
                <div class="col-auto">
                    <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main"><?php echo $cta['title'];?></a>
                </div>
                <?php endif;?>
            </div>
        </div>

        <?php
        // for new arrivals
        if (sizeof(get_field('new_arrivals_relations')) > 0) :
            echo "<div class='products-carousel'>";
            foreach (get_field('new_arrivals_relations') as $post_id) :
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