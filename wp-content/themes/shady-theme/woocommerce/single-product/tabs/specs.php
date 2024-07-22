<?php
// the product specs section
global $product;

$pid = $product->get_id();

if (have_rows('product_spec_repeater', $pid)) :
    echo "<div class='product-spec-wrap'>";
    while (have_rows('product_spec_repeater', $pid)) : the_row();
        $label      = get_sub_field('label_text', $pid);
        $info       = get_sub_field('info_text', $pid);

        if (get_sub_field('is_info_a_link_bool', $pid)) :
            $link   = get_sub_field('info_link', $pid);

            $info   = "<a href='{$link['url']}' class='click-to-toggle'>{$link['title']}</a>";
        endif;

        echo "
        <div class='product-spec-wrap__row'>
            <div class='product-spec-wrap__row--label'>{$label}</div>
            <div class='product-spec-wrap__row--info'>{$info}</div>
        </div>
        ";
    endwhile;
    echo "</div>";
endif;