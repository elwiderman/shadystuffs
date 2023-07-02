<?php
/*
	Template name: Page Contacts
*/
get_header();

get_template_part('parts/content/utilities/breadcrumb', '01');

if (have_posts()):
    while (have_posts()) : the_post();
    list(
        $page_title,
        $feat_image,
        $content,
        $shortcode,
    ) = array(
        get_the_title(),
        get_the_post_thumbnail_url($post->ID, 'page-header'),
        get_the_content(),
        rwmb_meta('shady_contact_shortcode'),
    );
    ?>
        <section class="single-page single-contact">
            <div class="container-wrap-lg">
                <!-- featured image -->
                <div class="featured-header">
                    <img src="<?= $feat_image; ?>" class="img-fluid header-bg">
                </div>
                <!-- featured image -->
            </div>
            <div class="container">
                <!-- content-section -->
                <div class="the-post pb-4">
                    <div class="row justify-content-center mb-5">
                        <div class="col-12 col-sm-7">
                            <div class="page-title text-center">
                                <h2><?= $page_title; ?></h2>
                            </div>
                            <div class="description text-center">
                                <?= $content; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-7 form-area contact-form">
                            <?= do_shortcode($shortcode); ?>
                        </div>
                    </div>
                </div>
                <!-- !.content-section -->
            </div>
        </section>

        <div class="clearfix"></div>

        <?php
    endwhile;
endif;
wp_reset_query();

get_footer();