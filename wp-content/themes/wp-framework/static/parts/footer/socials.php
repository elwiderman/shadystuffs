<?php
// the footer socials 
if (have_rows('socials_repeater', 'option')) :
    $social_title   = get_field('social_block_title_text', 'option');

    echo "
    <div class='col-12 col-md-4 col-xl-auto'>
        <div class='footer__top--menu-block'>
            <h6 class='footer__top--menu-title'>{$social_title}</h6>
            <ul class='footer__top--soicals'>
    ";

    while (have_rows('socials_repeater', 'option')) : the_row();
        $icon       = get_sub_field('network_select', 'option');
        $link       = get_sub_field('link', 'option');

        if ($link) :
            echo "
            <li>
                <a itemprop='sameAs' href='{$link['url']}' target='_blank'>
                    <i class='{$icon}'></i>
                </a>
            </li>
            ";
        endif;
    endwhile;
    echo "</ul></div></div>";
endif;