<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (is_singular('product')) {
	$wrap_before	= "<div class='container'><div class='row'><div class='col-12'><nav class='woocommerce-breadcrumb'>";
	$wrap_after		= "</nav></div></div></div>";

	global $product;
	// get the collections if exsits
	$producd_id			= $product->get_id();
	$all_collections 	= get_the_terms($product->get_id(), 'collection');
	// insert collections to breadcrumb if it exists
	if ($all_collections && sizeof($all_collections) > 0) {
		$collection		= $all_collections[0]; // considering only the first one
		$collection_data = [$collection->name, get_term_link($collection, $collection->taxonomy)];
		
		// to insert the collection at before the last elem need to splice the array and get the index of the last elem
		$last_index		= count($breadcrumb) - 1;
		array_splice($breadcrumb, $last_index, 0, [$collection_data]);
	}
}


if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}