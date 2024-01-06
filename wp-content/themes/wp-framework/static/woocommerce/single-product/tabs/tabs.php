<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="accordion product-accordion" id="productAccordion">
		<?php
		$i = 0;
		foreach ($product_tabs as $key => $product_tab) :
			$i++;
			if ($i == 1) :
				$title_collapsed 	= '';
				$aria_expanded		= 'true';
				$collapse_show		= 'show';
			else :
				$title_collapsed 	= 'collapsed';
				$aria_expanded		= 'false';
				$collapse_show		= '';
			endif;
			?>
			<div class="card">
				<div class="card-header" id="<?php echo esc_attr( $key ); ?>">
					<h4 class="card-header__title <?php echo $title_collapsed;?>" type="button" data-toggle="collapse"
						data-target="#<?php echo esc_attr( $key ); ?>-content" aria-expanded="<?php echo $aria_expanded;?>" aria-controls="<?php echo esc_attr( $key ); ?>-content">
						<span class="card-header__title--label">
							<?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key));?>
						</span>
						<span class="card-header__title--icon">
							<i class="icon-plus"></i>
						</span>
					</h4>
				</div>

				<div id="<?php echo esc_attr( $key ); ?>-content" class="<?php echo esc_attr( $key ); ?>-content collapse <?php echo $collapse_show;?>" aria-labelledby="<?php echo esc_attr( $key ); ?>" data-parent="#productAccordion">
					<div class="card-body">
						<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endforeach;
		?>


	</div>

<?php endif;