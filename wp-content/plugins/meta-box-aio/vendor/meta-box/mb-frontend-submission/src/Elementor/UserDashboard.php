<?php
namespace MBFS\Elementor;

use MBFS\Dashboard;
use Elementor\Controls_Manager;

class UserDashboard extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mbfs_user_dashboard';
	}

	public function get_title() {
		return esc_html__( 'User Dashboard', 'mb-frontend-submission' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'metabox' ];
	}

	public function get_keywords() {
		return [ 'dashboard' ];
	}

	public function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'mb-frontend-submission' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'type'               => Controls_Manager::TEXT,
				'label'              => esc_html__( 'Title', 'mb-frontend-submission' ),
				'placeholder'        => esc_html__( 'Enter the form title', 'mb-frontend-submission' ),
				'frontend_available' => true,
			]
		);

		$pages = get_pages();
		if ( isset( $pages ) ) {
			$args = [];
			foreach ( $pages as $item ) {
				$args [ $item->ID ] = $item->post_title;
			}

			$this->add_control(
				'dashboard_edit_page',
				[
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Edit page', 'mb-frontend-submission' ),
					'multiple'    => true,
					'options'     => $args,
					'description' => esc_html__( 'Choose the edit page, where users can edit/submit posts.', 'mb-frontend-submission' ),
				]
			);
		}

		$this->add_control(
			'columns',
			[
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Columns', 'mb-frontend-submission' ),
				'multiple'    => true,
				'options'     => [
					'title'  => esc_html__( 'Title', 'mb-frontend-submission' ),
					'date'   => esc_html__( 'Date', 'mb-frontend-submission' ),
					'status' => esc_html__( 'Status', 'mb-frontend-submission' ),
				],
				'default'     => [ 'title', 'date', 'status' ],
				'description' => esc_html__( 'List of columns to be displayed in the dashboard, separated by comma.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'show_welcome_message',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show welcome message', 'mb-frontend-submission' ),
				'label_on'     => esc_html__( 'True', 'mb-frontend-submission' ),
				'label_off'    => esc_html__( 'False', 'mb-frontend-submission' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$atts     = [];
		$settings = $this->get_settings_for_display();

		if ( isset( $settings['title'] ) ) {
			echo '<h3>' . esc_html( $settings['title'] ) . '</h3>';
		}

		$atts = [];

		if ( $settings['dashboard_edit_page'] ) {
			$atts['edit_page'] = $settings['dashboard_edit_page'];
		}

		if ( $settings['columns'] ) {
			$atts['columns'] = $settings['columns'];
		}

		if ( $settings['show_welcome_message'] === 'yes' ) {
			$atts['show_welcome_message'] = $settings['show_welcome_message'];
		}

		$dashboard = new Dashboard();
		echo $dashboard->shortcode( $atts );
	}
}
