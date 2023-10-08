<?php
/* 
    Template name: Woo Cart Checkout
*/
get_header();
?>

<div class="single-page single-cart-checkout <?php echo is_cart() ? 'cart' : '';?>">
    <?php if (!is_cart()) : ?>
    <section class="section-block section-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="section-title mb-0 color-grey"><?php the_title();?></h1>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="section-block section-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();