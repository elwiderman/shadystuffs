<?php
/* 
    Template name: SHADY DEV
*/
get_header();

$user           = new WP_User(get_current_user_id());
if (is_user_logged_in() && in_array('administrator', $user->roles)) :
    /*  
    // clone the icon list to all prods
    $base_pid       = 1409;
    $base_data      = get_field('icon_list_repeater', $base_pid);  

    // get the products
    $all_products   = wc_get_products([
        'exclude'   => [1409],
        'limit'     => -1,
        'return'    => 'ids'
    ]);

    $i = 0;
    foreach ($all_products as $product) :
        $i++;
        echo '<pre>';
        var_dump($product);
        var_dump($i);
        echo '</pre>';

        foreach($base_data as $row) :
            // Add the row to the destination post
            add_row('icon_list_repeater', $row, $product);
        endforeach;
    endforeach;
    */

else :
    echo '<h1>boom</h1>';
endif;

get_footer();