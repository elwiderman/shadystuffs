<?php
/*
    Template name: Page Sidebar
*/
get_header();
get_template_part('parts/content/utilities/breadcrumb', '01');
?>
<div class="clearfix"></div>

<section class="single-page">
    <div class="container">
        <div class="row">
            <!-- content-section -->
            <div class="col-md-9 the-post">
                <?php
                if (have_posts()):
                    while (have_posts()):the_post(); ?>
                        <div class="row">

                            <?php
                            if (!empty(get_the_post_thumbnail_url($post->ID, 'single-featured'))) {
                                $featured_image = get_the_post_thumbnail_url($post->ID, 'single-featured');
                                echo <<<FEATIMG
                                <div class="col-md-12 featured-image">
                                    <img src="{$featured_image}" class="img-responsive">
                                </div>
FEATIMG;
                            }
                            ?>

                            <div class="col-md-12 content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                endif;
                wp_reset_query();
                ?>
            </div>
            <!-- !.content-section -->

            <!-- sidebar section -->
            <div class="col-md-3 sidebar">
                <?php dynamic_sidebar('page-sidebar'); ?>
            </div>
            <!-- !.sidebar section -->
        </div>
    </div>
</section>

<?php get_footer(); ?>

