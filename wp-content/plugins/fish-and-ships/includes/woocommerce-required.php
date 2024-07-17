<?php
/**
 * PHP prior to 7, or WooCommerce not found / old release
 *
 * @package Fish and Ships
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;


if ( !function_exists('woocommerce_fish_n_ships_no_wc') ) {
	function woocommerce_fish_n_ships_no_wc() {
		
		echo '<div class="error">';

		if (version_compare( phpversion(), '7.0', '<') ) {
			echo '<p><strong>WC Fish and Ships Plugin</strong>: PHP 7 or newer required. Currently installed: ' . phpversion() . '</p>';
		}

		if (!function_exists('WC')) {
			echo '<p><strong>WC Fish and Ships Plugin</strong>: WooCommerce plugin not detected. It needs WooCommerce 3.0 or newer.</p>';
		} else {
			echo '<p><strong>WC Fish and Ships Plugin</strong>: WooCommerce 3.0 or newer required. Currently installed: ' .  WC()->version . '</p>';
		}
		echo '</div>';
	}
	add_action('admin_notices', 'woocommerce_fish_n_ships_no_wc');
}