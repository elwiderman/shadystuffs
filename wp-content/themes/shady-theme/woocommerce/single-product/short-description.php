<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

// show the icon list if exists
if (have_rows('icon_list_repeater')) :
	$all_icons	= get_field('prod_iconlist_repeater', 'option');
	// echo '<pre>';
	// var_dump(get_field('icon_list_repeater'));
	// echo '</pre>';
	echo "<ul class='woocommerce-product-details__icon-list'>";
	while (have_rows('icon_list_repeater')) : the_row();
		$index  = get_sub_field('item_select');
		$icon   = $all_icons[$index]['icon_img'];
		$text   = $all_icons[$index]['label_text'];

		echo "<li>
			<figure class='wrap mb-0'>
				<img class='img-fluid' src='{$icon['url']}' alt='{$icon['alt']}'>
				<figcaption class='text-uppercase'>{$text}</figcaption>
			</figure>
		</li>";
	endwhile;
	echo "</ul>";

	$note	= get_field('icon_group_note_text', 'option');
	echo "<h6 class='woocommerce-product-details__icon-list-note'>{$note}</h6>";
endif;

// hiding the short description for now 
/*
<div class="woocommerce-product-details__short-description">
	$short_description; // WPCS: XSS ok.
</div>
*/