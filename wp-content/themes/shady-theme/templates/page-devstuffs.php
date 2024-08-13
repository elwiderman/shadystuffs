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

    /*
    $product    = wc_get_product(1409);    
    if ($product->is_type('variable')) :
        $variations = $product->get_children();

        // echo '<pre>';
        // var_dump($product->get_attributes());
        // var_dump($product->get_available_variations());
        // echo '</pre>';

        // get the fabric attributes
        $fabrics = get_terms([
            'taxonomy'      => 'pa_fabric',
            'hide_empty'    => false
        ]);
        $pa_fabric  = [];
        foreach ($fabrics as $item) {
            array_push($pa_fabric, $item->slug);
        }

        // get the color attributes
        $colors = get_terms([
            'taxonomy'      => 'pa_color',
            'hide_empty'    => false
        ]);
        $pa_color   = [];
        $prod_colors = get_the_terms(1409, 'color');
        foreach ($prod_colors as $color) {
            foreach ($colors as $item) {
                if ($color->slug === $item->slug) {
                    array_push($pa_color, $item->slug);
                }
            }
        }

        // get the size attributes
        $sizes = get_terms([
            'taxonomy'      => 'pa_size',
            'hide_empty'    => false
        ]);
        $pa_size    = [];
        foreach ($sizes as $item) {
            array_push($pa_size, $item->slug);
        }
        
        // Define the attributes for the product
        $attributes = [
            'pa_fabric'         => [
                'name'          => 'Fabric',
                'value'         => implode('|', $pa_fabric),
                'is_visible'    => 1,
                'is_variation'  => 1,
                'is_taxonomy'   => 1,
            ],
            'pa_color'          => [
                'name'          => 'Color',
                'value'         => implode('|', $pa_color),
                'is_visible'    => 1,
                'is_variation'  => 1,
                'is_taxonomy'   => 1,
            ],
            'pa_size'           => [
                'name'          => 'Size',
                'value'         => implode('|', $pa_size),
                'is_visible'    => 1,
                'is_variation'  => 1,
                'is_taxonomy'   => 1,
            ]
        ];

        $fabric_id  = wc_attribute_taxonomy_id_by_name('pa_fabric');
        $color_id   = wc_attribute_taxonomy_id_by_name('pa_color');
        $size_id    = wc_attribute_taxonomy_id_by_name('pa_size');

        // Prepare the attributes to be saved
        $product_attributes = array();
        foreach ($attributes as $key => $data) {
            $product_attributes[$key] = new WC_Product_Attribute();
            switch ($key) {
                case 'pa_fabric':
                    $id = $fabric_id;
                    break;
                case 'pa_color':
                    $id = $color_id;
                    break;
                case 'pa_size':
                    $id = $size_id;
                    break;
            }

            $product_attributes[$key]->set_id($id); // 0 for custom attributes, or attribute ID for global attributes
            $product_attributes[$key]->set_name($key);
            $product_attributes[$key]->set_options(explode('|', $data['value']));
            $product_attributes[$key]->set_visible($data['is_visible']);
            $product_attributes[$key]->set_variation($data['is_variation']);
        }

        // Set the attributes for the product
        $product->set_attributes($product_attributes);

        // delete all variations
        if (sizeof($variations) > 0) {
            foreach ($variations as $pid) {
                wp_delete_post($pid, true);
            }
        }

        
        // set the defautl attributes for the product
        $default_attributes = array(
            'pa_fabric' => 'standard',
            'pa_color'  => $pa_color[0], // using the first color in the list
            'pa_size'   => 'medium',
        );

        $product->set_default_attributes($default_attributes);

        $product->save();

        // creating the variation
        foreach ($pa_fabric as $fabric) {
            foreach ($pa_size as $size) {
                foreach ($pa_color as $color) {
                    $attribute = [
                        'pa_fabric' => $fabric,
                        'pa_color'  => $color,
                        'pa_size'   => $size
                    ];

                    $variation = new WC_Product_Variation();
                    $variation->set_parent_id(1409);
                    $variation->set_attributes($attribute);
                    $desc    = '';
                    switch ($fabric) {
                        case 'premium':
                            $variation->set_regular_price(1099);
                            $desc .= 'Fabric: 180 GSM Premium - Long fibre cotton, silky smooth, bio-washed, pre-shrunk<br>';
                            break;

                        case 'standard':
                            $variation->set_regular_price(899);
                            $desc .= 'Fabric: 180 GSM Standard - Best in class cotton, bio-washed, pre-shrunk<br>';
                            break;
                    }

                    switch ($size) {
                        case 'small':
                            $desc .= 'Chest: 38 inches | Body Length: 26 inches<br>';
                            break;
                        case 'medium':
                            $desc .= 'Chest: 40 inches | Body Length: 27 inches<br>';
                            break;
                        case 'large':
                            $desc .= 'Chest: 42 inches | Body Length: 28 inches<br>';
                            break;
                        case 'extra-large':
                            $desc .= 'Chest: 44 inches | Body Length: 29 inches<br>';
                            break;
                        case 'double-extra-large':
                            $desc .= 'Chest: 46 inches | Body Length: 30 inches<br>';
                            break;
                    }
                    $desc   .= '<b>Please confirm your size from the <a href="#" class="trigger-sizechart" data-bs-toggle="modal" data-bs-target="#sizeChartPop">size chart</a> before ordering.</b>';

                    $variation->set_description($desc);

                    $variation->save();

                    echo "Variation created - " . $variation->get_id() . "<br>";
                }
            }
        }

    endif;
*/

    /*

    $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
    $args = [
        'post_type'         => 'product',
        'post_status'       => 'publish',
        'posts_per_page'    => 5,
        'paged'             => $paged,
        'fields'            => 'ids',
        // 'no_found_rows'     => true,
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) :
        foreach ($query->posts as $product_id) :
            // Example: Get product object
            $product = wc_get_product($product_id);

            // Check if the product exists and is a variable product

            if ($product && $product->is_type('variable')) :
                $variations = $product->get_children();

                // get the fabric attributes
                $fabrics = get_terms([
                    'taxonomy'      => 'pa_fabric',
                    'hide_empty'    => false
                ]);
                $pa_fabric  = [];
                foreach ($fabrics as $item) :
                    array_push($pa_fabric, $item->slug);
                endforeach;

                // get the color attributes
                $colors = get_terms([
                    'taxonomy'      => 'pa_color',
                    'hide_empty'    => false
                ]);
                $pa_color   = [];
                $prod_colors = get_the_terms($product_id, 'color');
                foreach ($prod_colors as $color) :
                    foreach ($colors as $item) :
                        if ($color->slug === $item->slug) :
                            array_push($pa_color, $item->slug);
                        endif;
                    endforeach;
                endforeach;

                // get the size attributes
                $sizes = get_terms([
                    'taxonomy'      => 'pa_size',
                    'hide_empty'    => false
                ]);
                $pa_size    = [];
                foreach ($sizes as $item) :
                    array_push($pa_size, $item->slug);
                endforeach;
                
                // Define the attributes for the product
                $attributes = [
                    'pa_fabric'         => [
                        'name'          => 'Fabric',
                        'value'         => implode('|', $pa_fabric),
                        'is_visible'    => 1,
                        'is_variation'  => 1,
                        'is_taxonomy'   => 1,
                    ],
                    'pa_color'          => [
                        'name'          => 'Color',
                        'value'         => implode('|', $pa_color),
                        'is_visible'    => 1,
                        'is_variation'  => 1,
                        'is_taxonomy'   => 1,
                    ],
                    'pa_size'           => [
                        'name'          => 'Size',
                        'value'         => implode('|', $pa_size),
                        'is_visible'    => 1,
                        'is_variation'  => 1,
                        'is_taxonomy'   => 1,
                    ]
                ];

                $fabric_id  = wc_attribute_taxonomy_id_by_name('pa_fabric');
                $color_id   = wc_attribute_taxonomy_id_by_name('pa_color');
                $size_id    = wc_attribute_taxonomy_id_by_name('pa_size');

                // Prepare the attributes to be saved
                $product_attributes = array();
                foreach ($attributes as $key => $data) :
                    $product_attributes[$key] = new WC_Product_Attribute();
                    switch ($key) {
                        case 'pa_fabric':
                            $id = $fabric_id;
                            $position = 0;
                            break;
                        case 'pa_color':
                            $id = $color_id;
                            $position = 1;
                            break;
                        case 'pa_size':
                            $id = $size_id;
                            $position = 2;
                            break;
                    }

                    $product_attributes[$key]->set_id($id); // 0 for custom attributes, or attribute ID for global attributes
                    $product_attributes[$key]->set_name($key);
                    $product_attributes[$key]->set_options(explode('|', $data['value']));
                    $product_attributes[$key]->set_position($position);
                    $product_attributes[$key]->set_visible($data['is_visible']);
                    $product_attributes[$key]->set_variation($data['is_variation']);
                endforeach;

                // Set the attributes for the product
                $product->set_attributes($product_attributes);

                // delete all variations
                if (sizeof($variations) > 0) :
                    foreach ($variations as $pid) :
                        wp_delete_post($pid, true);
                    endforeach;
                endif;

                
                // set the defautl attributes for the product
                $default_attributes = array(
                    'pa_fabric' => 'standard',
                    'pa_color'  => $pa_color[0], // using the first color in the list
                    'pa_size'   => 'm',
                );

                $product->set_default_attributes($default_attributes);

                $product->save();

                // creating the variation
                foreach ($pa_fabric as $fabric) :
                    foreach ($pa_size as $size) :
                        foreach ($pa_color as $color) :
                            $attribute = [
                                'pa_fabric' => $fabric,
                                'pa_color'  => $color,
                                'pa_size'   => $size
                            ];

                            $variation = new WC_Product_Variation();
                            $variation->set_parent_id($product_id);
                            $variation->set_attributes($attribute);
                            $desc    = '';
                            switch ($fabric) {
                                case 'premium':
                                    $variation->set_regular_price(1099);
                                    $desc .= 'Fabric: 180 GSM Premium - Long fibre cotton, silky smooth, bio-washed, pre-shrunk<br>';
                                    break;

                                case 'standard':
                                    $variation->set_regular_price(899);
                                    $desc .= 'Fabric: 180 GSM Standard - Best in class cotton, bio-washed, pre-shrunk<br>';
                                    break;
                            }

                            switch ($size) {
                                case 's':
                                    $desc .= 'Chest: 38 inches | Body Length: 26 inches<br>';
                                    break;
                                case 'm':
                                    $desc .= 'Chest: 40 inches | Body Length: 27 inches<br>';
                                    break;
                                case 'l':
                                    $desc .= 'Chest: 42 inches | Body Length: 28 inches<br>';
                                    break;
                                case 'xl':
                                    $desc .= 'Chest: 44 inches | Body Length: 29 inches<br>';
                                    break;
                                case 'xxl':
                                    $desc .= 'Chest: 46 inches | Body Length: 30 inches<br>';
                                    break;
                            }
                            $desc   .= '<b>Please confirm your size from the <a href="#" class="trigger-sizechart" data-bs-toggle="modal" data-bs-target="#sizeChartPop">size chart</a> before ordering.</b>';

                            $variation->set_description($desc);

                            $variation->save();

                            echo "Variation created - " . $variation->get_id() . "<br>";
                        endforeach;
                    endforeach;
                endforeach;

            endif;
            echo "Processed product ID " . $product_id . "<br>";
        endforeach;

        echo "<hr>";
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
            'prev_text' => __('&laquo; Previous'),
            'next_text' => __('Next &raquo;'),
        ));
    endif;
    wp_reset_postdata();

    */


    /*

    // Define the batch size (number of products to process in one batch)
    $batch_size = 1;

    // Get the product IDs (you can adjust this to your specific needs)
    $args = array(
        'limit' => -1, // Get all products (adjust based on your needs)
        'return' => 'ids', // Return only product IDs
        'status' => 'publish'
    );
    $product_ids = wc_get_products($args);

    // Determine the number of batches
    $total_products = count($product_ids);
    $total_batches = ceil($total_products / $batch_size);

    $i = 0;
    for ($batch = 0; $batch < $total_batches; $batch++) :
        // Get the current batch of product IDs
        $current_batch_ids = array_slice($product_ids, $batch * $batch_size, $batch_size);


        foreach ($current_batch_ids as $product_id) :
            $i++;
            // Your processing logic here (e.g., deleting and creating variations, adding attributes, etc.)

            // Example: Get product object
            $product = wc_get_product($product_id);

            // Check if the product exists and is a variable product

            if ($product && $product->is_type('variable')) :
                $variations = $product->get_children();

                // get the fabric attributes
                $fabrics = get_terms([
                    'taxonomy'      => 'pa_fabric',
                    'hide_empty'    => false
                ]);
                $pa_fabric  = [];
                foreach ($fabrics as $item) :
                    array_push($pa_fabric, $item->slug);
                endforeach;

                // get the color attributes
                $colors = get_terms([
                    'taxonomy'      => 'pa_color',
                    'hide_empty'    => false
                ]);
                $pa_color   = [];
                $prod_colors = get_the_terms($product_id, 'color');
                foreach ($prod_colors as $color) :
                    foreach ($colors as $item) :
                        if ($color->slug === $item->slug) :
                            array_push($pa_color, $item->slug);
                        endif;
                    endforeach;
                endforeach;

                // get the size attributes
                $sizes = get_terms([
                    'taxonomy'      => 'pa_size',
                    'hide_empty'    => false
                ]);
                $pa_size    = [];
                foreach ($sizes as $item) :
                    array_push($pa_size, $item->slug);
                endforeach;
                
                // Define the attributes for the product
                $attributes = [
                    'pa_fabric'         => [
                        'name'          => 'Fabric',
                        'value'         => implode('|', $pa_fabric),
                        'is_visible'    => 1,
                        'is_variation'  => 1,
                        'is_taxonomy'   => 1,
                    ],
                    'pa_color'          => [
                        'name'          => 'Color',
                        'value'         => implode('|', $pa_color),
                        'is_visible'    => 1,
                        'is_variation'  => 1,
                        'is_taxonomy'   => 1,
                    ],
                    'pa_size'           => [
                        'name'          => 'Size',
                        'value'         => implode('|', $pa_size),
                        'is_visible'    => 1,
                        'is_variation'  => 1,
                        'is_taxonomy'   => 1,
                    ]
                ];

                $fabric_id  = wc_attribute_taxonomy_id_by_name('pa_fabric');
                $color_id   = wc_attribute_taxonomy_id_by_name('pa_color');
                $size_id    = wc_attribute_taxonomy_id_by_name('pa_size');

                // Prepare the attributes to be saved
                $product_attributes = array();
                foreach ($attributes as $key => $data) :
                    $product_attributes[$key] = new WC_Product_Attribute();
                    switch ($key) {
                        case 'pa_fabric':
                            $id = $fabric_id;
                            $position = 0;
                            break;
                        case 'pa_color':
                            $id = $color_id;
                            $position = 1;
                            break;
                        case 'pa_size':
                            $id = $size_id;
                            $position = 2;
                            break;
                    }

                    $product_attributes[$key]->set_id($id); // 0 for custom attributes, or attribute ID for global attributes
                    $product_attributes[$key]->set_name($key);
                    $product_attributes[$key]->set_options(explode('|', $data['value']));
                    $product_attributes[$key]->set_position($position);
                    $product_attributes[$key]->set_visible($data['is_visible']);
                    $product_attributes[$key]->set_variation($data['is_variation']);
                endforeach;

                // Set the attributes for the product
                $product->set_attributes($product_attributes);

                // delete all variations
                if (sizeof($variations) > 0) :
                    foreach ($variations as $pid) :
                        wp_delete_post($pid, true);
                    endforeach;
                endif;

                
                // set the defautl attributes for the product
                $default_attributes = array(
                    'pa_fabric' => 'standard',
                    'pa_color'  => $pa_color[0], // using the first color in the list
                    'pa_size'   => 'm',
                );

                $product->set_default_attributes($default_attributes);

                $product->save();

                // creating the variation
                foreach ($pa_fabric as $fabric) :
                    foreach ($pa_size as $size) :
                        foreach ($pa_color as $color) :
                            $attribute = [
                                'pa_fabric' => $fabric,
                                'pa_color'  => $color,
                                'pa_size'   => $size
                            ];

                            $variation = new WC_Product_Variation();
                            $variation->set_parent_id($product_id);
                            $variation->set_attributes($attribute);
                            $desc    = '';
                            switch ($fabric) {
                                case 'premium':
                                    $variation->set_regular_price(1099);
                                    $desc .= 'Fabric: 180 GSM Premium - Long fibre cotton, silky smooth, bio-washed, pre-shrunk<br>';
                                    break;

                                case 'standard':
                                    $variation->set_regular_price(899);
                                    $desc .= 'Fabric: 180 GSM Standard - Best in class cotton, bio-washed, pre-shrunk<br>';
                                    break;
                            }

                            switch ($size) {
                                case 's':
                                    $desc .= 'Chest: 38 inches | Body Length: 26 inches<br>';
                                    break;
                                case 'm':
                                    $desc .= 'Chest: 40 inches | Body Length: 27 inches<br>';
                                    break;
                                case 'l':
                                    $desc .= 'Chest: 42 inches | Body Length: 28 inches<br>';
                                    break;
                                case 'xl':
                                    $desc .= 'Chest: 44 inches | Body Length: 29 inches<br>';
                                    break;
                                case 'xxl':
                                    $desc .= 'Chest: 46 inches | Body Length: 30 inches<br>';
                                    break;
                            }
                            $desc   .= '<b>Please confirm your size from the <a href="#" class="trigger-sizechart" data-bs-toggle="modal" data-bs-target="#sizeChartPop">size chart</a> before ordering.</b>';

                            $variation->set_description($desc);

                            $variation->save();

                            echo "Variation created - " . $variation->get_id() . "<br>";
                        endforeach;
                    endforeach;
                endforeach;

            endif;
            echo "{$i} - Processed product ID " . $product_id . "<br>";
        endforeach;

        // Optional: Add a delay between batches to prevent server overload
        sleep(1); // Delay in seconds

        // Optional: Flush output to monitor progress in real-time
        if (ob_get_level()) :
            ob_flush();
            flush();
        endif;
    endfor;

    echo "All batches have been processed.";


    */

else :
    echo '<h1>boom</h1>';
endif;

get_footer();