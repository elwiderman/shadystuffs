<?php
/* ========================================================================================================== */
/* METABOXES (meta-box plugin)
/* ========================================================================================================== */
add_filter('rwmb_meta_boxes', 'jeetlab_register_meta_boxes');

function jeetlab_register_meta_boxes($meta_boxes)
{
    $prefix = 'shady_';


    /* ======================================================================================================= */
    /* Slider
    /* ======================================================================================================= */
    $meta_boxes[] = array(
        'id'            => 'sliderCptMb',
        'title'         => __('Additional content for the slide', 'shady'),
        'post_types'    => array('slider'),
        'context'       => 'normal',
        'priority'      => 'high',
        'autosave'      => true,
        'fields'        => array(
            array(
                'name'      => __('Is this slide visible in home page ?', 'shady'),
                'id'        => $prefix . 'slide_is_featured',
                'type'      => 'checkbox',
                'std'       => 1,
            ),
            array('type' => 'divider'),
            array(
                'name'      => __('Alternate background image for mobile', 'shady'),
                'id'        => $prefix . 'slide_mobile_bg',
                'type'      => 'single_image'
            ),
            array(
                'name'      => __('Alternate background image for tablet', 'shady'),
                'id'        => $prefix . 'slide_tablet_bg',
                'type'      => 'single_image'
            ),
            array('type' => 'divider'),
            array(
                'name'      => __('Position of slide content and animation', 'shady'),
                'id'        => 'fakeId',
                'type'      => 'heading',
            ),
            array(
                'name'      => __('Reveal animation Slide Content', 'shady'),
                'id'        => $prefix . 'slide_content_anim',
                'type'      => 'select',
                'options'   => array(
                    'fadeIn'          => __('Fade In', 'shady'),
                    'fadeInLeft'      => __('Fade In Left', 'shady'),
                    'fadeInRight'     => __('Fade In Right', 'shady'),
                    'fadeInDown'      => __('Fade In Down', 'shady'),
                ),
                'placeholder'   => __('Select animation', 'shady'),
            ),
        ),
    );

    /* ======================================================================================================= */
    /* Contact page
    /* ======================================================================================================= */
    $meta_boxes[] = array(
        'id' => 'Contactpage',
        'title' => __('Contact form shortcode goes here', 'shady'),
        'post_types' => array('page'),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'include' => array(
            'template' => array('templates/page-contacts.php'),
        ),
        'fields' => array(
            array(
                'name'  => __('Shortcode', 'shady'),
                'id'    => $prefix . 'contact_shortcode',
                'type'  => 'text',
                'size'  => 100
            ),
        ),
        'validation' => array(
            'rules'  => array(
                $prefix . 'contact_shortcode' => array(
                    'required'  => true,
                ),
            ),
        )
    );

    /* ======================================================================================================= */
    /* Related Posts
    /* ======================================================================================================= */
    $meta_boxes[] = array(
        'id' => 'Related',
        'title' => __('Related posts', 'shady'),
        'post_types' => array('post'),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            // HEADING
            array(
                'type' => 'heading',
                'name' => __('Title of related posts', 'shady'),
                'id' => 'fake_id',
            ),
            // POST
            array(
                'id' => $prefix . 'related',
                'type' => 'post',
                'post_type' => 'post',
                'field_type' => 'select_advanced',
                'clone' => true,
                'max_clone' => 3,
                'sort_clone' => true,
                'query_args' => array(
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                )
            ),
        ),
    );

    return $meta_boxes;
}
