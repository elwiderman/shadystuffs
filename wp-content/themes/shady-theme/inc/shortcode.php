<?php 
	
/* SHOIPPING CART CANVAS
------------------------------------*/
/*
	add_shortcode ( 'shopping-cart-canvas', 'shopping_cart_canvas_callback' );
	
	function shopping_cart_canvas_callback () {
		$html = '';
		$html .= '<div class="row collapse">';
		
		// PAGINAZIONE
		//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$args = array(
		'post_type' => 'products',
		
		// PAGINAZIONE
		//'paged' => $paged,
		
		'order' => 'DESC',
		'orderby' => 'id',
		'post_not_in' => $post->ID,
		'posts_per_page' => 4
		);
		query_posts($args);
		
		if(have_posts()):
		//$pagination .= pagination();
		
		while (have_posts()): the_post();
		$cats=wp_get_post_terms(get_the_ID(), 'categoria-portfolio');
		$cat=$cats[0];
		list (
			$permalink,
			$titolo,
			$thumbnail,
			$term,
			$date
		) = array (
			get_permalink($post->ID),
			get_the_title (),
			lf_post_thumbnail($post->ID, 'related-post'),
			$cat->name,
			lf_time()
		);	
		$html .= <<<eof
		<div class="small-12 medium-3 large-3 columns">
			<figure>
				<a href="{$permalink}">
					{$thumbnail}
				</a>
			</figure>
		</div>
		<div class="small-12 medium-9 large-9 columns">
			<div class="padding-left-10">
				<h5 class="no-margin">
					<a class="mine" href="{$permalink}">
						{$titolo}
					</a>
				</h5>
				<span class="label white">
					{$term}
				</span>
				<span class="label transparent scorpion">
					{$date}
				</span>
			</div>
		</div>
		<div class="clearfix margin-bottom-20"></div>
eof;
		endwhile; wp_reset_query();
		//$html .= $pagination;
		endif;
		$html .= '</div>';
		
		return $html;
	}
	*/



/*  NEWSLETTER LOGO
------------------------------------*/

	add_shortcode ( 'newsletters_logo', 'newsletters_logo_callback' );
	
	function newsletters_logo_callback () {
				
		$png = get_bloginfo('template_url').'assets/images/logo.png';
		$jpg = get_bloginfo('template_url').'assets/images/logo.jpg';
		
		$html = '<img src="" />';
		
		//return $html;
	}


	
?>