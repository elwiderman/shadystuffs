<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

echo "<div class=''>";
?>

<div class="archive-page archive-shadystore">
	<div class="container">
		<div class="row main-wrapper">
			<?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			*/
			do_action( 'woocommerce_sidebar' );
			?>


			<div class="col-12 col-md-9">
				<?php
				/**
				 * Hook: woocommerce_before_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 * @hooked WC_Structured_Data::generate_website_data() - 30
				 */
				do_action( 'woocommerce_before_main_content' );

				?>
				<section class="section-block woocommerce-products-header">
					<?php
					if ( apply_filters( 'woocommerce_show_page_title', true ) ) : 
						$query_obj = get_queried_object();

						if (isset($query_obj->term_id)) :
							$thumb_id = get_term_meta($query_obj->term_id, 'thumbnail_id', true);

							$thumb = ($thumb_id) ? wp_get_attachment_image_src($thumb_id, 'shop-banner')[0] : placeholder_src('shop-banner')['url'];
						else :
							$thumb = (has_post_thumbnail(get_the_ID())) ? get_the_post_thumbnail_url(get_the_ID(), 'shop-banner') : placeholder_src('shop-banner')['url'];
						endif;


						if (!is_shop()) : ?>
						<div class="shop-banner">
							<div class="overlay"></div>
							<figure class="shop-banner__img mb-0">
								<img class="img-fluid" src="<?=$thumb;?>">
							</figure>
							<h1 class="woocommerce-products-header__title shop-banner__title">
								<?php woocommerce_page_title(); ?>
							</h1>
						</div>
						<?php
						endif;
					endif; ?>

					<?php
					/**
					 * Hook: woocommerce_archive_description.
					 *
					 * @hooked woocommerce_taxonomy_archive_description - 10
					 * @hooked woocommerce_product_archive_description - 10
					 */
					do_action( 'woocommerce_archive_description' );
					?>
				</section>
				<?php
				if ( woocommerce_product_loop() ) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );

					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				}

				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
				?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer( 'shop' );
