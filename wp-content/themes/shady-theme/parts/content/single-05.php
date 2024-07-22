<?php
get_header();
get_template_part('parts/content/utilities/breadcrumb', '02');
?>

<section class="single-page post-single">
    <div class="container">
        <div class="row">
            <!-- content-section -->
            <div class="col-md-9 the-post">
                <?php
                if (have_posts()):
                    while (have_posts()):the_post(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="title">
                                    <?php the_title(); ?>
                                </h1>
                                <div class="pre-title">
                                    <span class="date"><i class="far fa-calendar-alt"></i> <?= get_the_date(); ?></span>
                                    <span class="categories">
                                        <i class="fas fa-tags"></i>
                                        <?= list_categories('category', true); ?>
                                    </span>
                                </div>
                            </div>

                            <?php
                            if (!empty(get_the_post_thumbnail_url($post->ID, 'single-featured'))) {
                                $featured_image = get_the_post_thumbnail_url($post->ID, 'single-featured');
                                echo <<<FEATIMG
                                <div class="col-md-12 featured-image">
                                    <img src="{$featured_image}" class="img-fluid">
                                </div>
FEATIMG;
                            }
                            ?>

                            <div class="col-md-12 content">
                                <?php
                                if (rwmb_meta('jeetlab_page_subtitle')) {
                                    echo '<div class="lead blue">' . rwmb_meta('jeetlab_page_subtitle') . '</div>';
                                }
                                echo get_the_content_with_formatting();
                                ?>

                            </div>
                        </div>
                        <?php
                        $related = rwmb_meta('jeetlab_related');
                    endwhile;
                endif;
                wp_reset_query();
                ?>


                <!-- related -->
                <?php
                if (!empty($related)) { ?>
                    <div class="row related-items">
                        <div class="title-area col-md-12">
                            <h1><?php _e('Related posts', 'shady'); ?></h1>
                        </div>
                        <div class="col-md-12">
                            <div class="related-list owl-carousel owl-theme">
                                <?php
                                foreach ($related as $news) {
                                    $title = get_the_title($news);
                                    $url = get_the_permalink($news);
                                    $cate = list_categories('category');
                                    if (empty(get_the_post_thumbnail_url($news, 'smiles-thumb'))) {
                                        $feat_image = wp_get_attachment_image_src(8, 'smiles-thumb')[0]; //define default image
                                    } else {
                                        $feat_image = get_the_post_thumbnail_url($news, 'smiles-thumb');
                                    }
                                    echo <<<ITEMS
                                    <div class="">
                                        <div class="image">
                                            <a href="{$url}">
                                                <img src="{$feat_image}" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <div class="pre-title">
                                                <span class="categories">{$cate}</span>
                                            </div>
                                            <div class="title">
                                                <a href="{$url}">{$title}</a>
                                            </div>
                                        </div>
                                    </div>
ITEMS;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!-- !.related -->
                <div class="clearfix"></div>
            </div>
            <!-- !.content-section -->

            <!-- sidebar section -->
            <div class="col-md-3 sidebar">
                <?php dynamic_sidebar('generic-sidebar'); ?>
            </div>
            <!-- !.sidebar section -->
        </div>
    </div>
</section>

<?php get_footer(); ?>

