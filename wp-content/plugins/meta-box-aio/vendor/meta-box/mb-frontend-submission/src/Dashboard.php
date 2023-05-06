<?php
namespace MBFS;

use MBFS\DashboardRenderer;

class Dashboard {
	public function __construct() {
		add_shortcode( 'mb_frontend_dashboard', [ $this, 'shortcode' ] );
	}

	public function shortcode( $atts ) {
		/*
		 * Do not render the shortcode in the admin.
		 * Prevent errors with enqueue assets in Gutenberg where requests are made via REST to preload the post content.
		 */
		if ( is_admin() ) {
			return '';
		}

		$dashboard = new DashboardRenderer();
		return $dashboard->render( $atts );
	}

}
