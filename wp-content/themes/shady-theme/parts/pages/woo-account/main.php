<section class="section-block section-main">
    <div class="container">
        <div class="row">
            <?php if (is_user_logged_in()) : ?>
            <div class="col-12">
                <h1 class="page-title"><?php the_title();?></h1>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <div class="account-main"><?php the_content();?></div>
            </div>
        </div>
    </div>
</section>