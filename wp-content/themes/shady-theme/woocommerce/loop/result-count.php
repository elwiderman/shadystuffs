<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<p class="woocommerce-result-count" id="resultCount">
	<span class="zero"><?php _e( 'No results found!', 'shady' );?></span>
	<span class="single"><?php _e( 'Showing the single result', 'woocommerce' );?></span>
	<span class="result">
		<?php _e('Showing 1 -', 'shady');?>
		<span class="result__current">0</span>
		<?php _e(' of ', 'shady');?>
		<span class="result__total">0</span>
	</span>
</p>
