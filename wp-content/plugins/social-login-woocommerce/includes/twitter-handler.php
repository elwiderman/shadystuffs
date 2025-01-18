<?php

require XOO_SL_PATH. '/vendor/autoload.php';

$consumerKey 		= xoo_sl_helper()->get_x_option('gl-ckey');
$consumerSecret 	= xoo_sl_helper()->get_x_option('gl-csecret');

use Abraham\TwitterOAuth\TwitterOAuth;

if( !session_id() ){
	session_start();
}


if( !isset( $_SESSION['access_token'] ) ){
	if( isset( $_GET['oauth_token'] ) && isset( $_SESSION['oauth_token'] ) && $_GET['oauth_token'] === $_SESSION['oauth_token'] ){ // User authorized access

		$connection = new TwitterOAuth( $consumerKey, $consumerSecret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );

		$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_GET['oauth_verifier'] ] );

		$_SESSION['access_token'] = $access_token;

	}
	else{ //generate token and send user to twitter login page

		if( !isset( $_SESSION['oauth_token'] ) ){ //generate token

			// Begins
			$connect = new TwitterOAuth( $consumerKey, $consumerSecret );
			// Get a request token
			$request_token = $connect->oauth(
				'oauth/request_token',
				array( 'oauth_callback' => get_site_url() )
			);

			$_SESSION['oauth_token'] 		= $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		}


		if( isset( $_SESSION['oauth_token'] ) ){ // send to login page

			$connectTwitter2 		= new TwitterOAuth( $consumerKey, $consumerSecret , $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
			$verify_authentication 	= $connectTwitter2->url( 'oauth/authorize', array( 'oauth_token' => $_SESSION['oauth_token']  ) );

			wp_redirect($verify_authentication);
			exit;
		}
	}
}

if( isset( $_SESSION['access_token'] ) ){
	$access_token 	= $_SESSION['access_token'];
	$connection 	= new TwitterOAuth( $consumerKey, $consumerSecret, $access_token['oauth_token'], $access_token['oauth_token_secret'] );
	$user 			= $connection->get('account/verify_credentials', ['include_email' =>'true' ] );
	if( $user && is_object( $user ) ){
		return $user;
	}
	else{
		//user not received, start again
		unset($_SESSION['access_token']);
	}
}
