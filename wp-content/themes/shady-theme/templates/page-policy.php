<?php
/*
    Template name: Page Policies
*/
get_header();
?>

<div class="single-page single-policies">
    <section class="section-block section-hero">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1 class="page-title"><?php the_title();?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block section-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-11">
                    <div class="content-wrap"><?php the_content();?></div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();