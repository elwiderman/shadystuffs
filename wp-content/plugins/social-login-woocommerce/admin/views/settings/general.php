<?php

if ( ! function_exists( 'get_editable_roles' ) ) {
	require_once ABSPATH . 'wp-admin/includes/user.php';
}

$editable_roles = array_reverse( get_editable_roles() );

foreach ( $editable_roles as $role_id => $role_data) {
	$user_roles[$role_id] = translate_user_role( $role_data['name'] );
}

$user_roles = apply_filters( 'xoo_sl_admin_user_roles', $user_roles );

$settings = array(

	/* Main Style */
	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show Buttons on page',
		'id' 			=> 'gl-m-show',
		'section_id' 	=> 'gl_main',
		'args'			=> array(
			'options' => array(
				'popup' 		=> 'Popup',
				'myaccount' 	=> 'WC MyAccount',
				'checkout' 		=> 'WC Checkout',
				'wplogin' 		=> 'WP Login'
			)
		),
		'default' 		=> array( 'popup' ,'myaccount', 'checkout', 'wplogin')
	),


	/* Main Style */
	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show Buttons on form',
		'id' 			=> 'gl-m-show-form',
		'section_id' 	=> 'gl_main',
		'args'			=> array(
			'options' => array(
				'register' 		=> 'Register',
				'login' 		=> 'Login',
				'single' 		=> 'Single Field Form'
			)
		),
		'default' 		=> array( 'register' ,'login', 'single' )
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'User Role',
		'id' 			=> 'gl-userrole',
		'section_id' 	=> 'gl_main',
		'args'			=> array(
			'options' => $user_roles
		),
		'default' 		=> class_exists( 'woocommerce' ) ? 'customer' : 'subscriber'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Redirect URL',
		'id' 			=> 'gl-red-url',
		'section_id' 	=> 'gl_main',
		'default' 		=> '',
		'desc' 			=> 'Leave empty to redirect on the same page'
	),

	
	/** Style **/

	array(
		'callback' 		=> 'sortable',
		'title' 		=> 'Button Order',
		'id' 			=> 'gl-btn-pos',
		'section_id' 	=> 'sy_main',
		'args' 			=> array(
			'options' 		=> array(
				'google' 	=> 'Google',
				'apple' 	=> 'Apple',
				'x'			=> 'X (Twitter)',
				'facebook'	=> 'Facebook'
			),
			'display' 	=> 'vertical'
		),
		'default' => array( 'google', 'apple', 'x', 'facebook' ),
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Buttons Layout',
		'id' 			=> 'gl-btn-layout',
		'section_id' 	=> 'sy_main',
		'args'			=> array(
			'options' => array(
				'one_line' 		=> 'Show buttons in one line',
				'new_line' 		=> 'Show buttons in Separate lines',
			)
		),
		'default' 		=> 'one_line'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Display button as',
		'id' 			=> 'gl-btn-type',
		'section_id' 	=> 'sy_main',
		'args'			=> array(
			'options' => array(
				'icon' 		=> 'Only Icon',
				'text' 		=> 'Icon with Text',
			)
		),
		'default' 		=> 'text'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Only Icon Size',
		'id' 			=> 'gl-iconsize',
		'section_id' 	=> 'sy_main',
		'args'			=> array(
			'options' => array(
				'small' 	=> 'Small',
				'medium' 	=> 'Medium',
				'large' 	=> 'Large'
			)
		),
		'default' 		=> 'medium',
		'desc' 			=> 'When "display button" is set to "Icon" above'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Text Button Width',
		'id' 			=> 'btn-width',
		'section_id' 	=> 'sy_main',
		'default' 		=> 200,
		'desc' 			=> 'Works for Apple & X'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Text Button Height',
		'id' 			=> 'btn-height',
		'section_id' 	=> 'sy_main',
		'default' 		=> 31,
		'desc' 			=> 'Works for Apple & X'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Text Button Border Radius',
		'id' 			=> 'btn-radius',
		'section_id' 	=> 'sy_main',
		'default' 		=> 8,
		'desc' 			=> 'Works for Apple & X'
	),
	


	/** Texts **/
	array(
		'callback' 		=> 'text',
		'title' 		=> 'Heading',
		'id' 			=> 'gl-txt-heading',
		'section_id' 	=> 'gl_texts',
		'default' 		=> 'Or Login Using',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Success Notice',
		'id' 			=> 'gl-txt-sucess',
		'section_id' 	=> 'gl_texts',
		'default' 		=> 'Login Successful',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Waiting',
		'id' 			=> 'gl-txt-wait',
		'section_id' 	=> 'gl_texts',
		'default' 		=> 'Please wait. Signing you in...',
	),

);

if( defined( 'XOO_EL' ) ){
	$settings[] = array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Force Register',
		'id' 			=> 'gl-force-reg',
		'section_id' 	=> 'gl_main',
		'default' 		=> 'no',
		'desc' 			=> 'If enabled, user will be forced to fill form fields'
	);
}

return apply_filters( 'xoo_sl_admin_settings', $settings, 'general' );