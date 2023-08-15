<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?> - <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo image('theme/favicon.png?v=1'); ?>"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
    <?php //include_once (TEMPLATEPATH . '/parts/header/analytics.php'); ?>
</head>

<body <?php body_class(); ?>>

<div class="no-overflow"></div>

<div class="animationload">
    <div class="spinner"></div>
</div>


<?php
// add required template part
get_template_part('parts/header/nav', 'framework');
?>

<div class="main-content-wrap">
