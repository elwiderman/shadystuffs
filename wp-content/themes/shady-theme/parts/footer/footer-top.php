<div class="footer__top">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-auto">
                <div class="row">
                    <?php
                    if (have_rows('footer_menus_repeater', 'option')) :
                        while (have_rows('footer_menus_repeater', 'option')) : the_row();
                            $menu_title         = get_sub_field('menu_title_text');
                            ?>
                            <div class="col-12 col-md-4 col-xl-auto">
                                <div class="footer__top--menu-block">
                                    <h6 class="footer__top--menu-title"><?php echo $menu_title;?></h6>
                                    <?php
                                    if (have_rows('menu_items_repeater', 'option')) :
                                        echo "<ul class='footer__top--menu'>";
                                        while (have_rows('menu_items_repeater', 'option')) : the_row();
                                            $link       = get_sub_field('menu_item_link');
                                            if ($link) :
                                                echo "
                                                <li>
                                                    <a href='{$link['url']}' target='{$link['target']}'>{$link['title']}</a>
                                                </li>";
                                            endif;
                                        endwhile;
                                        echo "</ul>";
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    endif;
                    ?>
        
                    <?php get_template_part('parts/footer/socials');?>
                </div>
            </div>

            <?php
            if (have_rows('footer_promo_stuffs_repeater', 'option')) :
                echo "<div class='col-12 col-md-auto'>";
                while (have_rows('footer_promo_stuffs_repeater', 'option')) : the_row();
                    $icon       = get_sub_field('icon_image');
                    $text       = nl2br(get_sub_field('content_text'));
                    ?>
                    <div class="footer__top--promo">
                        <figure class="mb-0">
                            <?php
                            if ($icon) :
                                echo "<img class='img-fluid' src='{$icon['url']}' alt='{$icon['alt']}'>";
                            endif;
                            ?>
                        </figure>
                        <p class="text mb-0"><?php echo $text;?></p>
                    </div>
                    <?php
                endwhile;
                echo "</div>";
            endif;
            ?>
        </div>
    </div>
</div>