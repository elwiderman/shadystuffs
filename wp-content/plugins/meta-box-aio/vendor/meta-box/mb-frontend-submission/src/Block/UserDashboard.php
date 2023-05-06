<?php
namespace MBFS\Block;

use MBFS\DashboardRenderer;

class UserDashboard {
	public function __construct() {
		add_action( 'init', [ $this, 'register_block' ], 99 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue' ], 99 );
	}

	public function register_block() {
		register_block_type( MBFS_DIR . '/block/user-dashboard/build', [
			'render_callback' => [ $this, 'render_block' ],
		] );
	}

	public function render_block( $attributes ): string {
		$dashboard = new DashboardRenderer();
		return $dashboard->render( $attributes );
	}

	public function enqueue() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', '', MBFS_VER );

		$pages = get_pages();
		if ( isset( $pages ) ) {
			$args = [];
			foreach ( $pages as $item ) {
				$args [ $item->ID ] = $item->post_title;
			}
		}

		wp_localize_script( 'meta-box-user-dashboard-editor-script', 'mbudData', $args );
	}
}
