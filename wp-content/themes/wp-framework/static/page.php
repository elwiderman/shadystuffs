<?php
get_header();

get_template_part('parts/content/utilities/breadcrumb', '01');

if (have_posts()) :
    while (have_posts()) : the_post();
        $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'slider-home-large'));
        ?>
        <section class="single-page">
            <div class="container">
                <div class="the-post clearfix">
                    <div class="row">
                        <?php
                        if (!empty($feat_image)) {
                            echo <<<IMG
                            <div class="col-md-12 featured-image">
                                <img src="{$feat_image}" class="img-responsive">
                            </div>
IMG;
                        }
                        ?>
                        <div class="col-lg-12">
                            <div id="the-content">
                                <?php
                                
                                the_content();
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    endwhile;
endif;
wp_reset_query(); // resetting query for main query
?>

<?php get_footer(); ?>

