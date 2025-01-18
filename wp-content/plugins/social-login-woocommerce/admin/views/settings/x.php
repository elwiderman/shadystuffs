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
		'callback' 		=> 'text',
		'title' 		=> 'Consumer Key',
		'id' 			=> 'gl-ckey',
		'section_id' 	=> 'gl',
		'default' 		=> '',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Consumer Secret',
		'id' 			=> 'gl-csecret',
		'section_id' 	=> 'gl',
		'default' 		=> '',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Icon',
		'id' 			=> 'btn-icon',
		'section_id' 	=> 'btn',
		'args'			=> array(
			'options' => array(
				'x1' 		=> 'With Border',
				'x2' 		=> 'Without Border',
			)
		),
		'default' 		=> 'x2'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Button Text',
		'id' 			=> 'btn-text',
		'section_id' 	=> 'btn',
		'default' 		=> 'Sign in with [icon]',
		'desc' 			=> '[icon] is placeholder for icon'
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Button Background Color',
		'id' 			=> 'btn-bgcolor',
		'section_id' 	=> 'btn',
		'default' 		=> '#000000',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Button Color',
		'id' 			=> 'btn-txtcolor',
		'section_id' 	=> 'btn',
		'default' 		=> '#fff',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Padding',
		'id' 			=> 'btn-pd',
		'section_id' 	=> 'btn',
		'default' 		=> '3px 20px',
		'desc' 			=> 'Default: 3px 20px'
	),

);

return apply_filters( 'xoo_sl_admin_settings', $settings, 'twitter' );