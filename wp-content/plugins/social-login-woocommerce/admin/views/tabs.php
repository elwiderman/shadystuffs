<?php

$tabs = array(
	'general' => array(
		'title'			=> 'Settings',
		'id' 			=> 'general',
		'option_key' 	=> 'xoo-sl-gl-options'
	),

	'google' => array(
		'title'			=> 'Google',
		'id' 			=> 'google',
		'option_key' 	=> 'xoo-sl-goo-options'
	),

	'facebook' => array(
		'title'			=> 'Facebook',
		'id' 			=> 'facebook',
		'option_key' 	=> 'xoo-sl-fb-options'
	),

	'apple' => array(
		'title'			=> 'Apple',
		'id' 			=> 'apple',
		'option_key' 	=> 'xoo-sl-apl-options',
		'desc' 			=> 'Requires apple developer account'
	),

	'x' => array(
		'title'			=> 'Twitter(X)',
		'id' 			=> 'x',
		'option_key' 	=> 'xoo-sl-x-options'
	),
);

return apply_filters( 'xoo_sl_admin_settings_tabs', $tabs );