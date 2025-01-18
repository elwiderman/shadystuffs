<?php

$sections = array(

	/* General TAB Sections */
	array(
		'title' => 'Main',
		'id' 	=> 'gl_main',
		'tab' 	=> 'general',
	),


	array(
		'title' => 'Style',
		'id' 	=> 'sy_main',
		'tab' 	=> 'general',
		'desc' 	=> 'Some styling options are specific to social type.'
	),


	array(
		'title' => 'Texts',
		'id' 	=> 'gl_texts',
		'tab' 	=> 'general',
		'desc' 	=> 'Leave text empty to remove element'
	),


	array(
		'title' => 'General',
		'id' 	=> 'gl',
		'tab' 	=> 'google',
		'desc' 	=> '<a href="https://docs.xootix.com/social-login/google" target="_blank">Documentation</a>'
	),


	array(
		'title' => 'Button',
		'id' 	=> 'btn',
		'tab' 	=> 'google',
		'desc' 	=> '<a href="https://developers.google.com/identity/gsi/web/tools/configurator" target="_blank">Button Generator</a>'
	),


	array(
		'title' => 'General',
		'id' 	=> 'gl',
		'tab' 	=> 'facebook',
		'desc' 	=> '<a href="https://docs.xootix.com/social-login/facebook" target="_blank">Documentation</a><br><i>Button shows up after configuration.</i>'
	),


	array(
		'title' => 'Button',
		'id' 	=> 'btn',
		'tab' 	=> 'facebook',
		'desc' 	=> '<a href="https://developers.facebook.com/docs/facebook-login/web/login-button" target="_blank">Button Generator</a>'
	),

	array(
		'title' => 'General',
		'id' 	=> 'gl',
		'tab' 	=> 'x',
		'desc' 	=> '<a href="https://docs.xootix.com/social-login/x" target="_blank">Documentation</a>'
	),


	array(
		'title' => 'Button',
		'id' 	=> 'btn',
		'tab' 	=> 'x',
	),


	array(
		'title' => 'Apple',
		'id' 	=> 'gl',
		'tab' 	=> 'apple',
		'desc' 	=> '<a href="https://docs.xootix.com/social-login/apple" target="_blank">Documentation</a><br><i>Button shows up after configuration.</i>'
	),


	array(
		'title' => 'Button',
		'id' 	=> 'btn',
		'tab' 	=> 'apple',
	),



);

return apply_filters( 'xoo_sl_admin_settings_sections', $sections );