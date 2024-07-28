<?php get_header(); ?>

<?php
switch (get_post_format()) {
    case 'aside':
        get_template_part('parts/content/single', '01');
        break;

    case 'gallery':
        get_template_part('parts/content/single', '02');
        break;

    case 'quote':
        get_template_part('parts/content/single', '03');
        break;

    case 'video':
        get_template_part('parts/content/single', '04');
        break;

    default:
        get_template_part('parts/content/single', '05');
        break;
}
?>

<?php get_footer(); ?>