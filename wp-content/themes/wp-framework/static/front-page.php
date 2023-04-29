<?php
get_header();
/*
	Template name: Homepage
*/
?>

<?php
/* TOP LAYOUTS
------------------------------------*/
get_template_part('parts/slider');
get_template_part('parts/home', 'example');
//get_template_part('parts/fixed-image');
//get_template_part('parts/fixed-video');
//get_template_part('parts/top-news');
//get_template_part('parts/claim');

/* POST LAYOUTS
------------------------------------*/
//get_template_part('parts/regular-post');
//get_template_part('parts/slide-post');
//get_template_part('parts/static-post');
//get_template_part('parts/full-rectangle-post');

/* EXTRA LAYOUTS
------------------------------------*/
//get_template_part('parts/newsletter');
//get_template_part('parts/social');
//get_template_part('parts/sponsor');
?>

<?php get_footer(); ?>

<script>
    // home.init();
</script>
