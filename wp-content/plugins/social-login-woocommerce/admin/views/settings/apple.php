<?php

$settings = array(


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Enable',
		'id' 			=> 'gl-enable',
		'section_id' 	=> 'gl',
		'default' 		=> 'yes',
	),

	array(
		'callback' 		=> 'textarea',
		'title' 		=> 'Private Key',
		'id' 			=> 'gl-key',
		'section_id' 	=> 'gl',
		'args' 		=> array(
			'rows' 	=> 9
		)
		
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Private Key ID',
		'id' 			=> 'gl-keyid',
		'section_id' 	=> 'gl',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Client ID',
		'id' 			=> 'gl-clientid',
		'section_id' 	=> 'gl',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Team ID',
		'id' 			=> 'gl-teamid',
		'section_id' 	=> 'gl',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Type',
		'id' 			=> 'btn-mode',
		'section_id' 	=> 'btn',
		'args'			=> array(
			'options' => array(
				'center-align' 	=> 'Logo with text',
				'logo-only' 	=> 'Only Logo',
			)
		),
		'default' 		=> 'center-align'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Text',
		'id' 			=> 'btn-text',
		'section_id' 	=> 'btn',
		'args'			=> array(
			'options' => array(
				'sign-in' 	=> 'Sign in with Apple',
				'continue' 	=> 'Continue with Apple',
				'sign-up'	=> 'Sign up with Apple'
			)
		),
		'default' 		=> 'sign-in'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Color',
		'id' 			=> 'btn-color',
		'section_id' 	=> 'btn',
		'args'			=> array(
			'options' => array(
				'black' 	=> 'Black',
				'white' 	=> 'White',
			)
		),
		'default' 		=> 'black'
	),


	

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Language Locale',
		'id' 			=> 'btn-locale',
		'section_id' 	=> 'btn',
		'default' 		=> get_locale(),
		'desc' 			=> "For eg: fr_FR."
	),

);

return apply_filters( 'xoo_sl_admin_settings', $settings, 'apple' );

?>