<?php
namespace MBFS\Bricks;

class BricksMeta {
	public function get_attributes( int $post_id ): array {
		$data     = get_post_meta( $post_id, '_bricks_page_content_2', true ) ?: [];
		$data     = $data ?: [];
		$settings = $this->get_submit_form_settings( $data );

		return $settings ? $this->format( $settings, $post_id ) : [];
	}

	private function get_submit_form_settings( array $data ): array {
		foreach ( $data as $widget ) {
			$type = $widget['name'] ?? '';
			if ( $type === 'mbfs-form-submission' ) {
				return $widget['settings'];
			}
		}

		return [];
	}

	private function format( array $settings, int $post_id ): array {
		$attributes              = [
			'url' => get_permalink( $post_id ),
		];
		$attributes['id']        = $settings['meta_box_id'] ?? '';
		$attributes['post_type'] = $settings['post_type'] ?? 'post';

		return $attributes;
	}
}
