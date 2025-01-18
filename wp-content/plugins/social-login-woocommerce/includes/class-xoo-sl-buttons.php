<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_Sl_Buttons{

	protected static $_instance = null;

	public 	$settings 		= array(),
			$fbSettings 	= array(),
			$gooSettings 	= array();

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){

		$this->settings  		= xoo_sl_helper()->get_general_option();
		$this->fbSettings 		= xoo_sl_helper()->get_fb_option();
		$this->gooSettings 		= xoo_sl_helper()->get_google_option();
		$this->xSettings 		= xoo_sl_helper()->get_x_option();
		$this->appleSettings 	= xoo_sl_helper()->get_apple_option();
		$this->btnWithText 		= $this->settings['gl-btn-type'] === 'text';

		$this->hooks();
	}


	public function hooks(){
		add_shortcode( 'xoo_sl_button', array( $this, 'buttons_shortcode' ) );
	}


	public function get_facebook_html(){

		$settings = $this->fbSettings;

		if( $this->btnWithText ){

			$atts = array(
				'class' 				=> 'fb-login-button',
				'data-width' 			=> esc_attr( $settings['btn-width'] ),
				'data-size' 			=> esc_attr( $settings['btn-size'] ),
				'data-button-type' 		=> esc_attr( $settings['btn-text'] ),
				'data-layout' 			=> esc_attr( $settings['btn-layout'] ),
				'data-use-continue-as' 	=> esc_attr( $settings['btn-name'] ),
			);

			$atts = apply_filters( 'xoo_sl_button_facebook_atts', $atts );

			$atts_text = '';

			foreach ( $atts as $key => $value ) {
				$atts_text .= $key .'="'.$value.'" ';
			}

			$html = '<div '.$atts_text.'></div><span class="xoo-fl-prevent-clicker"></span>';
		}
		else{
			$html = $this->get_icon( $settings['icon-type'] );
		}


		return apply_filters( 'xoo_sl_button_facebook_html', $html );
	}

	public function get_icon( $type ){
		ob_start();
		include XOO_SL_PATH.'/assets/icons/'.$type.'.svg';
		$icon = ob_get_clean();
		return '<span class="xoo-sl-icon">'.$icon.'</span>'
		;
	}

	public function get_google_html(){


		$html = '<div class="xoo-sl-goo-btn"></div>';

		return apply_filters( 'xoo_sl_google_button_html', $html );
	}

	public function get_x_html(){

		$icon = $this->get_icon( $this->xSettings['btn-icon'] );

		if( $this->btnWithText ){
			$text = $this->xSettings['btn-text'];
			$text = str_replace('[icon]', $icon, $text );
		}
		else{
			$text = $icon;
		}

		$html = '<a href="'.add_query_arg( 'logintwitter', 'yes', get_site_url() ).'">'.$text.'</a>';
				
		return apply_filters( 'xoo_sl_x_button_html', $html );
	}


	public function get_apple_html(){

		$settings = $this->appleSettings;

		$icon = $this->get_icon( 'apple' );

		if( $this->btnWithText ){
			$html = '<div id="appleid-signin" data-color="black" data-border="true" data-type="sign in"></div>';
		}
		else{
			$html = $this->get_icon('apple');
		}


		$atts = array(
			'id' 					=> 'appleid-signin',
			'class' 				=> 'xoo-sl-apple-login-btn',
			'data-color' 			=> esc_attr( $settings['btn-color'] ),
			'data-mode' 			=> esc_attr( $settings['btn-mode'] ),
			'data-border-radius' 	=> esc_attr( $this->settings['btn-radius'] ),
			'data-type' 			=> esc_attr( $settings['btn-text'] ),
		);

		$atts = apply_filters( 'xoo_sl_button_apple_atts', $atts );

		$atts_text = '';

		foreach ( $atts as $key => $value ) {
			$atts_text .= $key .'="'.$value.'" ';
		}

		$html = '<div '.$atts_text.'></div>';
		
		return apply_filters( 'xoo_sl_apple_button_html', $html );
	}


	public function get_html(){

		$settings = xoo_sl_helper()->get_general_option();

		$buttons = array();

		if( $this->gooSettings['gl-enable'] === "yes" ){
			$buttons['google'] = $this->get_google_html();
		}

		if( $this->xSettings['gl-enable'] === "yes" ){
			$buttons['x'] = $this->get_x_html();
		}

		if( $this->appleSettings['gl-enable'] === "yes" ){
			$buttons['apple'] = $this->get_apple_html();
		}

		if( $this->fbSettings['gl-enable'] === "yes" ){
			$buttons['facebook'] = $this->get_facebook_html();
		}

		$order 			= $settings['gl-btn-pos'];
		$buttonsSorted 	= array();

		foreach ( $order as $btnKey ) {
			if( !isset( $buttons[ $btnKey ] ) ) continue;
			$buttonsSorted[ $btnKey ] = $buttons[ $btnKey ];
		}
	
		$args = array(
			'buttons' 	=> $buttonsSorted,
			'heading' 	=> $this->settings['gl-txt-heading'],
			'notice' 	=> $this->settings['gl-txt-wait']
		);


		$args = apply_filters( 'xoo_sl_buttons_args', $args );

		if( empty( $buttons ) ) return;

		xoo_sl_helper()->get_template( 'xoo-sl-buttons.php', $args );
	}

	public function buttons_shortcode( $user_atts ){

		$atts = shortcode_atts( array(
			'change_to' 	=> 'logout'
		), $user_atts, 'xoo_sl_button');

		if( is_user_logged_in() ){

			if( $atts[ 'change_to' ] === 'myaccount' ) {
				$change_to_link = wc_get_page_permalink( 'myaccount' );
				$change_to_text =  __( 'My account', 'social-login-woocommerce' );
			}
			else{
				$settings  	= xoo_sl_helper()->get_general_option();
				$logout_link 	= !empty( $settings[ 'm-logout-url' ] ) ? $settings[ 'm-logout-url' ] : $_SERVER[ 'REQUEST_URI' ];
				$change_to_link = wp_logout_url( $logout_link );
				$change_to_text =  __( 'Logout' ,'social-login-woocommerce' );
			}

			echo '<a href="'.$change_to_link.'" class="xoo-sl-changeto">'.$change_to_text.'</a>';
		}
		else{
			echo $this->get_html();
		}
	}

}


function xoo_sl_buttons(){
    return Xoo_Sl_Buttons::get_instance();
}
xoo_sl_buttons();
