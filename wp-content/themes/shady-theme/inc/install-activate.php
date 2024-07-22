<?php
/* 
    run on installation and activation of theme 
*/



/* add seed on theme activation */
add_action('after_switch_theme', 'shady_create_seed_after_theme_switch');

function shady_create_seed_after_theme_switch () {
    $theme_activated = get_option('shady_theme_active');

    // do the stuff if theme is not activated or is activated for the first time
    if (!$theme_activated) :
        /* add images to media library */
        // get images
        $image_dir = get_stylesheet_directory() . '/assets/images/placeholders/';
        $image_files = array_diff(scandir($image_dir), array('.', '..', '.DS_Store'));

        $image_ids = array();
        
        foreach ($image_files as $image) {
            $file = $image_dir . $image;
            
            $image_types = array(
                'image/png',
                'image/jpeg',
                'image/jpeg',
                'image/jpeg',
                'image/gif',
                'image/bmp',
                'image/vnd.microsoft.icon',
                'image/tiff',
                'image/tiff',
                'image/svg+xml',
                'image/svg+xml',
            );

            // check if the file is image
            if (in_array(mime_content_type($file), $image_types)) : 
                $filename = basename($file);
                $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
                if (!$upload_file['error']) {
                    $wp_filetype = wp_check_filetype($filename, null );
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        // 'post_parent' => $parent_post_id,
                        'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
                    if (!is_wp_error($attachment_id)) {
                        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                        wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                    }

                    array_push($image_ids, $attachment_id);
                }
            endif;
        }

        /* create pages */
        // home page
        $home_data = array(
            'ID'            => 1,
            'post_title'    => 'Home',
            'post_content'  => '',
            'post_type'     => 'page',
            'page_template' => 'front-page.php',
            'post_status'   => 'publish'
        );

        $home_page_id = wp_update_post($home_data);

        // 2 slider posts
        $slide_content = array(
            '<h3>We don\'t need no education</h3>',
            '<h3>We don\'t need no thought control</h3>',
            '<h3>Another Brick In The Wall</h3>',
        );
        $slide_anim = array(
            'fadeIn',
            'fadeInLeft',
            'fadeInRight',
            'fadeInDown'
        );

        for ($i = 1; $i < 4; $i++) { 
            $x = $i - 1;
            $slide = array(
                'post_title'    => 'Slide ' . $i,
                'post_type'     => 'slider',
                'post_status'   => 'publish',
                'post_content'  => $slide_content[$x]
            );
            $slide_id = wp_insert_post( $slide );
            // add featured image to post
            if ($slide_id) {
                update_post_meta($slide_id, '_thumbnail_id', $image_ids[$x]);
                update_post_meta($slide_id, 'jee_slide_content_anim', $slide_anim[$x]);
            }
        }

        // add contact page
        $contact_page_id = wp_insert_post(array(
            'post_title'    => 'Contact',
            'post_type'     => 'page',
            'page_template' => 'templates/page-contacts.php',
            'post_status'   => 'publish',
            'post_content'  => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique officia corrupti deserunt! Consequuntur incidunt minus, quis dolorum, aperiam exercitationem ipsum recusandae eos dolore eveniet perferendis enim, nihil laudantium molestias eaque.</p>'
        ));

        // add archive page 
        $archive_page_id = wp_update_post(array(
            'ID'            => 2,
            'post_title'    => 'Archive',
            'post_type'     => 'page',
            'page_template' => 'templates/page-archives.php',
            'post_status'   => 'publish',
        ));

        if ($home_page_id && $archive_page_id && $contact_page_id) {
            // set the options to change
            $option = array(
                // set home page as front page
                'page_on_front'                 => $home_page_id,
                'show_on_front'                 => 'page',
                // change category base
                'category_base'                 => '/cat',
                // change tag base
                'tag_base'                      => '/label',
                // disable comments
                'default_comment_status'        => 'closed',
                // disable trackbacks
                'use_trackback'                 => '',
                // disable pingbacks
                'default_ping_status'           => 'closed',
                // disable pinging
                'default_pingback_flag'         => '',
                // change the permalink structure
                'permalink_structure'           => '/%postname%/',
                // dont use year/month folders for uploads 
                'uploads_use_yearmonth_folders' => 1,
                // don't use those ugly smilies
                'use_smilies'                   => 0
            );
            // change the options!
            foreach ( $option as $key => $value ) {  
                update_option( $key, $value );
            }
            
            // flush rewrite rules because we changed the permalink structure
            global $wp_rewrite;
            $wp_rewrite->flush_rules();

            // Check if the menu exists
            $menu_name = 'Main Menu';
            $menu_exists = wp_get_nav_menu_object( $menu_name );

            // If it doesn't exist, let's create it.
            if( !$menu_exists){
                $menu_id = wp_create_nav_menu($menu_name);

                // Set up default menu items
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => get_the_title($home_page_id),
                    'menu-item-object-id'   => $home_page_id, 
                    'menu-item-object'  => 'page',
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'post_type'
                ));

                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => get_the_title($archive_page_id),
                    'menu-item-object-id'   => $archive_page_id,
                    'menu-item-object'  => 'page',
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'post_type'
                ));

                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => get_the_title($contact_page_id),
                    'menu-item-object-id'   => $contact_page_id,
                    'menu-item-object'  => 'page',
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'post_type'
                ));
            }
            
            $locations = get_theme_mod('nav_menu_locations');
            $locations['main-nav'] = $menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );

            add_option( 'shady_theme_active', true );
        }

    endif;    
}


// on cf7 activate for the first time add the shortcode to the contact page
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
// add shortcode to contact page on cf7 activate
register_activation_hook( 'contact-form-7/wp-contact-form-7.php', 'shady_add_shortcode_to_contact_page_on_activate');

function shady_add_shortcode_to_contact_page_on_activate() {
    $cf_query = new WP_Query(array(
        'post_type'         => 'wpcf7_contact_form',
        'posts_per_page'    => 1
    ));

    $shortcode = '';

    if ($cf_query->have_posts()) {
        while ($cf_query->have_posts()) {
            $cf_query->the_post();

            $shortcode = '[contact-form-7 id="'.get_the_ID().'" title="'.get_the_title().'"]';
        }
        
    }
    wp_reset_postdata();
    // check if contact page exists 
    $contact_page = get_page_by_path( 'contact' , OBJECT );
    if (!isset($contact_page)) {       

        // create contact page
        $contact_data = array(
            'post_title'    => 'Contact',
            'post_type'     => 'page',
            'page_template' => 'templates/page-contacts.php',
            'post_status'   => 'publish',
            'post_content'  => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique officia corrupti deserunt! Consequuntur incidunt minus, quis dolorum, aperiam exercitationem ipsum recusandae eos dolore eveniet perferendis enim, nihil laudantium molestias eaque.</p>'
        );

        $contact_page_id = wp_insert_post($contact_data);

        if (!is_wp_error($contact_page_id)) {
            update_post_meta($contact_page_id, 'shady_contact_shortcode', $shortcode);
        }

    } else {
        update_post_meta($contact_page->ID, 'shady_contact_shortcode', $shortcode);
    }
}