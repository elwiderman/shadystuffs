<?php
namespace MBFS\Block;

use MBFS\Helper;

class Attributes {
	public function get_attributes( int $edit_page_id ): array {
		if ( ! has_block( 'meta-box/submission-form', $edit_page_id ) ) {
			return [];
		}

		$edit_page = get_post( $edit_page_id );
		$content   = Helper::get_post_content( $edit_page );
		$blocks    = parse_blocks( $content );

		// Get only 'id' and 'post_type' attributes.
		$attributes = [
			'id'        => '',
			'post_type' => 'post',
			'url'       => get_permalink( $edit_page ),
		];
		foreach ( $blocks as $block ) {
			if ( $block['blockName'] !== 'meta-box/submission-form' ) {
				continue;
			}

			$block_atts = $block['attrs'];
			if ( isset( $block_atts['meta_box_id'] ) ) {
				$attributes['id'] = $block_atts['meta_box_id'];
			}
			if ( isset( $block_atts['post_type'] ) ) {
				$attributes['post_type'] = $block_atts['post_type'];
			}
		}

		return $attributes;
	}
}
