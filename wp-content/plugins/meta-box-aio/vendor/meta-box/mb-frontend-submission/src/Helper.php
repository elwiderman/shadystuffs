<?php
namespace MBFS;

use WP_Post;

class Helper {
	public static function convert_boolean( $value ): string {
		return is_string( $value ) ? $value : ( $value ? 'true' : 'false' );
	}

	public static function get_post_content( WP_Post $post ): string {
		$content = $post->post_content;

		// Oxygen Builder.
		if ( defined( 'CT_VERSION' ) && ! defined( 'SHOW_CT_BUILDER' ) ) {
			$shortcode = get_post_meta( $post->ID, 'ct_builder_shortcodes', true );
			$content   = $shortcode ? $shortcode : $content;
		}

		$content = apply_filters( 'mbfs_dashboard_edit_page_content', $content );
		$content = apply_filters( 'rwmb_frontend_dashboard_edit_page_content', $content );

		return $content;
	}
}
