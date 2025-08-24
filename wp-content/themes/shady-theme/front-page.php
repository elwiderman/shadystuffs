<?php
/*
    Template name: Homepage
*/
get_header();
?>

<div class="single-page single-home woocommerce">
    <?php
    get_template_part('parts/pages/home/hero');
    get_template_part('parts/pages/home/collections');
    get_template_part('parts/pages/home/bestsellers');
    get_template_part('parts/pages/home/b2bcustom');
    // get_template_part('parts/pages/home/highlight');
    // get_template_part('parts/pages/home/arrivals');
    ?>
</div>

<?php
get_footer();