<?php
/* ========================================================================================================== */
/* METABOXES (meta-box plugin)
/* ========================================================================================================== */
add_filter('rwmb_meta_boxes', 'jeetlab_register_meta_boxes');

function jeetlab_register_meta_boxes($meta_boxes)
{
    $prefix = 'jeet_';


    /* ======================================================================================================= */
    /* Slider
    /* ======================================================================================================= */
    $meta_boxes[] = array(
        'id'            => 'sliderCptMb',
        'title'         => __('Additional content for the slide', 'jtlb'),
        'post_types'    => array('slider'),
        'context'       => 'normal',
        'priority'      => 'high',
        'autosave'      => true,
        'fields'        => array(
            array(
                'name'      => __('Is this slide visible in home page ?', 'jtlb'),
                'id'        => $prefix . 'slide_is_featured',
                'type'      => 'checkbox',
                'std'       => 1,
            ),
            array('type' => 'divider'),
            array(
                'name'      => __('Alternate background image for mobile', 'jtlb'),
                'id'        => $prefix . 'slide_mobile_bg',
                'type'      => 'single_image'
            ),
            array(
                'name'      => __('Alternate background image for tablet', 'jtlb'),
                'id'        => $prefix . 'slide_tablet_bg',
                'type'      => 'single_image'
            ),
            array('type' => 'divider'),
            array(
                'name'      => __('Position of slide content and animation', 'jtlb'),
                'id'        => 'fakeId',
                'type'      => 'heading',
            ),
            array(
                'name'      => __('Reveal animation Slide Content', 'jtlb'),
                'id'        => $prefix . 'slide_content_anim',
                'type'      => 'select',
                'options'   => array(
                    'fadeIn'          => __('Fade In', 'jtlb'),
                    'fadeInLeft'      => __('Fade In Left', 'jtlb'),
                    'fadeInRight'     => __('Fade In Right', 'jtlb'),
                    'fadeInDown'      => __('Fade In Down', 'jtlb'),
                ),
                'placeholder'   => __('Select animation', 'jtlb'),
            ),
        ),
    );

    /* ======================================================================================================= */
    /* Contact page
    /* ======================================================================================================= */
    $meta_boxes[] = array(
        'id' => 'Contactpage',
        'title' => __('Contact form shortcode goes here', 'jtlb'),
        'post_types' => array('page'),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'include' => array(
            'template' => array('templates/page-contacts.php'),
        ),
        'fields' => array(
            array(
                'name'  => __('Shortcode', 'jtlb'),
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
        'title' => __('Related posts', 'jtlb'),
        'post_types' => array('post'),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            // HEADING
            array(
                'type' => 'heading',
                'name' => __('Title of related posts', 'jtlb'),
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
