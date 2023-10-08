<?php
// the socials

if (have_rows('socials_repeater', 'option')) :
    $social_title   = get_field('social_block_title_text', 'option');

    echo "
    <div class='social-wrap'>
        <h5 class='social-wrap__title'>{$social_title}</h5>
        <ul class='social-wrap__icons'>
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
    echo "</ul></div>";
endif;


