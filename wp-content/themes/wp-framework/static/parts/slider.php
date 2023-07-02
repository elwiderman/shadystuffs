<?php
// get the slider data
$args = array(
    'post_type'         => 'slider',
    // 'meta_query'    => array(
    //     array(
    //         'key'   => 'shady_slide_is_featured',
    //         'value' => 1,
    //         'compare' => '='
    //         )
    // ),
    'posts_per_page'    => -1,
);

$slider_query = new WP_Query($args);

if ($slider_query->have_posts()) : ?>

    <section class="section-block section-slider">
        <div class="container-full">
            <div class="home-slider">
                <?php while ($slider_query->have_posts()) : $slider_query->the_post();
                    list(
                        $slide_image,
                        $slide_content,
                        $slide_alignment,
                        $slide_anim
                    ) = array(
                        get_the_post_thumbnail_url(get_the_ID(), 'slider-home'),
                        get_the_content(),
                        rwmb_meta('shady_slide_content_position'),
                        rwmb_meta('shady_slide_content_anim'),
                    );
                    $justify = ($slide_alignment == 'left') ? 'justify-content-start' : 'justify-content-end';

                    // if (is_mobile()) {
                    //     if (rwmb_meta('shady_slide_mobile_bg')) {
                    //         $slide_image = rwmb_meta('shady_slide_mobile_bg', array('size' => 'full'))['url'];
                    //     }
                    // }
                    // if (is_tablet()) {
                    //     if (rwmb_meta('shady_slide_tablet_bg')) {
                    //         $slide_image = rwmb_meta('shady_slide_tablet_bg', array('size' => 'full'))['url'];
                    //     }
                    // }
                    ?>

                    <div>
                        <div class="slide-bg" style="background-image: url('<?php echo $slide_image;?>');">
                            <div class="container">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-xl-6">
                                        <div class="slide-content">
                                            <span class="animation-wrap" data-animation="<?php echo $slide_anim;?>" data-delay="1.3s">
                                                <?php echo $slide_content;?>
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
            
        </div>
    </section>


    <?php
endif;
wp_reset_postdata();