<?php
function shady_framework_scripts() {

    $path = get_template_directory_uri();

    // Load site libs js files in footer
    wp_deregister_script('bootstrap'); // to prevent clash with plugins calling bootstrap 3

    // Adding lottie
    wp_enqueue_script('lottie-scripts', '//unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js', '', '', false);

    // Adding scripts file in the footer
    wp_enqueue_script('site-scripts', $path . shady_get_hashed_assets('js/app.js'), '', '', [
        'strategy'      => 'defer',
        'in_footer'     => true
    ]);

    if (is_cart() || is_product()) {
        wp_enqueue_script('shady-woo', $path . shady_get_hashed_assets('js/shadyWoo.js'), ['wc-add-to-cart', 'wc-add-to-cart-variation', 'woocommerce', 'wc-cart'], '', [
            'strategy'      => 'defer',
            'in_footer'     => true
        ]);

        wp_localize_script('shady-woo', 'WPURLS', array(
            'ajaxurl'       => admin_url('admin-ajax.php'),
            'cart_nonce'    => wp_create_nonce('update_cart_nonce'),
        ));
    }

    // the stylesheets
    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    // Register main stylesheet
    wp_enqueue_style('site-css', $path . shady_get_hashed_assets('scss/app.scss'), array(), '', 'all');
}

add_action('wp_enqueue_scripts', 'shady_framework_scripts', 1000);


// admin scrips enqueue
function shady_framework_admin_scripts() {
    $path = get_template_directory_uri();
    wp_enqueue_style('site-admin-css', $path . shady_get_hashed_assets('scss/admin.scss'), array(), '', 'all');
}
// add_action('admin_enqueue_scripts', 'shady_framework_admin_scripts');



/**
 * ref - https://danielshaw.co.nz/wordpress-cache-busting-json-hash-map/
 * Serve theme styles via a hashed filename instead of WordPress' default style.css.
 *
 * Checks for a hashed filename as a value in a JSON object.
 * If it exists: the hashed filename is enqueued in place of style.css.
 * Fallback: the default style.css will be passed through.
 *
 * @param string $css is WordPress’ required, known location for CSS: style.css
 */

function shady_get_hashed_assets($real_file) {
    $map = get_template_directory() . '/dist/parcel-manifest.json';
    static $hash = null;

    if ( null === $hash ) {
        $hash = file_exists( $map ) ? json_decode( file_get_contents( $map ), true ) : [];
    }

    if ( array_key_exists( $real_file, $hash ) ) {
        return '/dist' . $hash[ $real_file ];
    }

    return false;
}

function get_enqueued_scripts () {
    $scripts = wp_scripts();
    echo '<pre>';
    var_dump( array_keys( $scripts->groups ) );
    echo '</pre>';
}

// add_action( 'wp_head', 'get_enqueued_scripts' );