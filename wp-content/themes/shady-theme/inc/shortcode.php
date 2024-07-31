<?php 
/* 
	custom shortcodes for the theme
*/
add_shortcode('shady_latest_products', 'shady_latest_products_shortcode');
function shady_latest_products_shortcode() {
	if (!is_admin()) :
		$query = new WC_Product_Query([
			'limit' 	=> 4,
			'orderby' 	=> 'date',
			'order' 	=> 'DESC',
			'return' 	=> 'ids'
		]);
		$products = $query->get_products();
		
		$html	= "";

		if ($products) :
			$html	.= "
			<div class='woocommerce products-wrap'>
			<h4 class='products-wrap__title'>New in Store</h4>
			<div class='products row product-grid'>";
			foreach ( $products as $product ) :
				$post_object = get_post($product);
				setup_postdata($GLOBALS['post'] =& $post_object);
				
				ob_start();
				wc_get_template_part('content', 'product');
				$html	.= ob_get_contents();
				ob_end_clean();

			endforeach;
			$html	.= "</div></div>";
		endif;
		
		wp_reset_query();
		return $html;
	endif;

	return false;
}