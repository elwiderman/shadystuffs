<?php
// the popular searches

if (is_page() || is_singular(['post', 'product'])) :
    $acf_id     = get_the_ID();
elseif (is_tax()) :
    $obj        = get_queried_object();
    $acf_id     = "{$obj->taxonomy}_{$obj->term_id}";
endif;
?>

<div class="footer__middle">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                if (get_field('use_local_popular_search_bool', $acf_id) && !is_shop()) :
                    if (have_rows('popular_search_repeater', $acf_id)) :
                        echo "<h6 class='footer__middle--block-title'>Popular Searches</h6>";
                        echo "<ul class='footer__middle--search-links'>";
                        while (have_rows('popular_search_repeater', $acf_id)) : the_row();
                            $link   = get_sub_field('link');
                            if ($link) :
                                echo "<li><a href='{$link['url']}' target='{$link['target']}'>{$link['title']}</a></li>";
                            endif;
                        endwhile;
                        echo "</ul>";
                    endif;
                else :
                    if (have_rows('global_popular_searches', 'option')) :
                        echo "<h6 class='footer__middle--block-title'>Popular Searches</h6>";
                        echo "<ul class='footer__middle--search-links'>";
                        while (have_rows('global_popular_searches', 'option')) : the_row();
                            $link   = get_sub_field('link');
                            if ($link) :
                                echo "<li><a href='{$link['url']}' target='{$link['target']}'>{$link['title']}</a></li>";
                            endif;
                        endwhile;
                        echo "</ul>";
                    endif;
                endif;
                ?>
            </div>


            <div class="col-12">
                <?php
                if (get_field('use_local_footer_meta_text_bool', $acf_id)) :
                    $meta   = get_field('footer_meta_text', $acf_id);
                    echo "<div class='footer__middle--meta'>{$meta}</div>";
                else :
                    $meta   = get_field('global_footer_meta_text', 'option');
                    echo "<div class='footer__middle--meta'>{$meta}</div>";
                endif;
                ?>
            </div>
        </div>
    </div>
</div>