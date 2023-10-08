<?php
/* 
    Template name: Woo Cart Checkout
*/
get_header();
?>

<div class="single-page single-cart-checkout <?php echo is_cart() ? 'cart' : 'checkout';?>">
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