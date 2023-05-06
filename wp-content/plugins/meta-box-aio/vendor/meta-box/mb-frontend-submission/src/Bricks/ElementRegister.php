<?php
namespace MBFS\Bricks;

class ElementRegister {
	public function __construct() {
		add_action( 'init', [ $this, 'register' ], 99 );
	}

	public function register() {
		if ( ! defined( 'BRICKS_VERSION' ) ) {
			return;
		}

		add_filter( 'bricks/builder/i18n', [ $this, 'i18n' ] );

		$elements = [
			__DIR__ . '/SubmissionForm.php',
			__DIR__ . '/UserDashboard.php',
		];

		foreach ( $elements as $element ) {
			\Bricks\Elements::register_element( $element );
		}
	}

	public function i18n( array $i18n ): array {
		$i18n['meta-box'] = esc_html__( 'Meta Box', 'mb-frontend-submission' );
		return $i18n;
	}
}
