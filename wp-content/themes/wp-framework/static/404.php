<?php
get_header();
get_template_part('parts/content/utilities/breadcrumb', '02');
?>

    <section class="single-page">
        <div class="container">
            <div class="row the-post">
                <div class="col-md-12 text-center">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/404.svg" alt="Not Found!"
                         width="300" height="300"/><br/>
                    <h1 class="upp inline-block padding-20 size-30"> <?php _e('Page not found!', 'jtlb'); ?> </h1>
                    <br/>
                    <a href="javascript:history.go(-1)" class="button margin-top-10">
                        <?php _e('Go Back', 'jtlb'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>