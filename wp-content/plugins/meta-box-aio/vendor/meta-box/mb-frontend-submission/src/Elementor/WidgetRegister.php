<?php
namespace MBFS\Elementor;

class WidgetRegister {

	public function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_metabox_category' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register' ] );
	}

	public function add_metabox_category() {
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'metabox',
			[
				'title' => esc_html__( 'Meta Box', 'mb-frontend-submission' ),
				'icon'  => 'fa fa-m',
			]
		);
	}

	public function register( $widgets_manager ) {
		$widgets_manager->register( new SubmissionForm );
		$widgets_manager->register( new UserDashboard );
	}
}
