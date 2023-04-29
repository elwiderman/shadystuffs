<?php
/*
    Template name: Privacy Policy
*/
get_header();
get_template_part('parts/content/utilities/breadcrumb', '01');
?>

<section class="single-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (have_posts()):
                    while (have_posts()):the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

