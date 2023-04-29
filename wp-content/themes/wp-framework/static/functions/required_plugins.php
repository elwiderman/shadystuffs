<?php
/**
* @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
*
* @package    TGM-Plugin-Activation
* @subpackage Example
* @version    2.6.1 for parent theme Jeetlab Framework
* @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
* @copyright  Copyright (c) 2011, Thomas Griffin
* @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
* @link       https://github.com/TGMPA/TGM-Plugin-Activation
*/

/**
* Include the TGM_Plugin_Activation class.
*/
require_once get_template_directory() . '/functions/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'jeetlab_framework_register_required_plugins' );

/**
* Register the required plugins for this theme.
*/
function jeetlab_framework_register_required_plugins() {
    /*
    * Array of plugin arrays. Required keys are name and slug.
    * If the source is NOT from the .org repo, then source is also required.
    */
    $plugins = array(
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => true,
            'force_activation' => true
        ),
        array(
            'name' => 'Regenerate Thumbnails',
            'slug' => 'regenerate-thumbnails',
            'required' => true,
            'force_activation' => true
        ),
        array(
            'name' => 'Query Monitor',
            'slug' => 'query-monitor',
            'required' => true,
            'force_activation' => true
        ),
        array(
            'name' => 'Meta Box',
            'slug' => 'meta-box',
            'required' => true,
            'force_activation' => true
        ),
        array(
            'name' => 'Meta Box AIO',
            'slug' => 'meta-box-aio',
            'source' => get_template_directory() . '/plugins/meta-box-aio.zip',
            'required' => true,
            'force_activation' => true
        ),
        array(
            'name' => 'Category Order and Taxonomy Terms Order',
            'slug' => 'taxonomy-terms-order',
        ),
        array(
            'name' => 'Post Types Order',
            'slug' => 'post-types-order',
        ),
        array(
            'name' => 'Yoast SEO',
            'slug' => 'wordpress-seo',
            'required' => true,
            'force_activation' => true
        ),
        array(
            'name' => 'Wordfence Security – Firewall & Malware Scan',
            'slug' => 'wordfence',
            // 'required' => true,
            // 'force_activation' => true
        ),
    );

    /*
    * Array of configuration settings. Amend each line as needed.
    */
    $config = array(
        'id' => 'jtlb',
        'default_path' => '',
        'menu' => 'framework-install-plugins',
        'parent_slug' => 'themes.php',
        'capability' => 'edit_theme_options',
        'has_notices' => true,
        'dismissable' => false,
        'dismiss_msg' => __('The following plugins are essential for the theme to work as expected.', 'jtlb'),
        'is_automatic' => true,
        'message' => '',
    );

    tgmpa( $plugins, $config );
}
