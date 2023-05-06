<?php
namespace MBFS\Bricks;

use MBFS\DashboardRenderer;

class UserDashboard extends \Bricks\Element {
	public $category = 'meta-box';
	public $name     = 'mbfs-user-dashboard';
	public $icon     = 'fa-solid fa-gauge';

	public function get_label() {
		return esc_html__( 'User Dashboard', 'mb-frontend-submission' );
	}

	public function set_controls() {

		$pages = get_pages();
		$args  = [];
		foreach ( $pages as $item ) {
			$args [ $item->ID ] = $item->post_title;
		}

		$this->controls['edit_page'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Edit Page', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => $args,
			'default'     => '1',
			'description' => esc_html__( 'Choose the edit page, where users can edit/submit posts.', 'mb-frontend-submission' ),
		];

		$this->controls['show_welcome_message'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Show welcome message', 'mb-frontend-submission' ),
			'type'        => 'checkbox',
			'default'     => true,
			'description' => esc_html__( 'Show the welcome message true (default) or false.', 'mb-frontend-submission' ),
		];

		$this->controls['columns'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'List columns', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => [
				'title'  => esc_html__( 'Title', 'mb-frontend-submission' ),
				'date'   => esc_html__( 'Date', 'mb-frontend-submission' ),
				'status' => esc_html__( 'Status', 'mb-frontend-submission' ),
			],
			'multiple'    => true,
			'default'     => [
				'title',
				'date',
				'status',
			],
			'description' => esc_html__( 'List of columns to be displayed in the dashboard, separated by comma. Supported values are: title, date, status.', 'mb-frontend-submission' ),
		];

		$this->controls['label_title'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Label Title', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Title',
			'description' => esc_html__( 'The header label for the title column.', 'mb-frontend-submission' ),
		];

		$this->controls['label_date'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Label Date', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Date',
			'description' => esc_html__( 'The header label for the date column.', 'mb-frontend-submission' ),
		];

		$this->controls['label_status'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Label Status', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Status',
			'description' => esc_html__( 'The header label for the status column.', 'mb-frontend-submission' ),
		];

		$this->controls['label_actions'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Label Actions', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Actions',
			'description' => esc_html__( 'The header label for the actions column.', 'mb-frontend-submission' ),
		];

		$this->controls['title_link'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Title Link', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => [
				'view' => esc_html__( 'View', 'mb-frontend-submission' ),
				'edit' => esc_html__( 'Edit', 'mb-frontend-submission' ),
			],
			'default'     => 'view',
			'description' => esc_html__( 'The link action for the post titles. Supported values are: edit or view (default)', 'mb-frontend-submission' ),
		];

		$this->controls['add_new'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Label Add New', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Add New',
			'description' => esc_html__( 'Label for the add new button.', 'mb-frontend-submission' ),
		];
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', '', MBFS_VER );
	}

	public function render() {

		$settings = $this->settings;

		$settings['show_welcome_message'] = empty( $settings['show_welcome_message'] ) ? false : $settings['show_welcome_message'];

		// Render.
		echo "<div {$this->render_attributes( '_root' )}>";

		$dashboard = new DashboardRenderer();
		echo $dashboard->render( $settings );

		echo '</div>';
	}
}
