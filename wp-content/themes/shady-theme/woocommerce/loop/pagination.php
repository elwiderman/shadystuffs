<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

?>
<nav class="woocommerce-pagination">
	<div class="load-more-wrap w-100 text-center" style="display:none;">
		<form id="loadMoreProducts">
			<?php wp_nonce_field('shady_woo_loadmore', 'shady_woo_loadmore');?>
			<input type="hidden" name="action" value="shady_load_more_products">
			<input type="hidden" name="collections" value="">
			<input type="hidden" name="sizes" value="">
			<input type="hidden" name="colors" value="">
			<input type="hidden" name="stock" value="">
			<input type="hidden" name="current_page" value="<?php echo wc_get_loop_prop('current_page');?>">
			<input type="hidden" name="total_pages" value="<?php echo wc_get_loop_prop('total_pages');?>">
			<input type="hidden" name="per_page" value="<?php echo wc_get_loop_prop('per_page');?>">
			<button type="submit" class="btn-main"><span>Load more</span></button>
		</form>
	</div>
</nav>
