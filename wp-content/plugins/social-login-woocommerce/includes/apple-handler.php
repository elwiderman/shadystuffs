<?php

require XOO_SL_PATH.'/vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

if( !isset( $_POST['socialData'], $_POST['socialData']['authorization'] ) ) return;

$data           = $_POST['socialData'];
$authorization  = $_POST['socialData']['authorization'];

$key 		= xoo_sl_helper()->get_apple_option('gl-key'); // Load your private key
$keyId 		= xoo_sl_helper()->get_apple_option('gl-keyid');
$teamId 	= xoo_sl_helper()->get_apple_option('gl-teamid');
$clientId 	= xoo_sl_helper()->get_apple_option('gl-clientid');

$header = array(
    'alg' => 'ES256',
    'kid' => $keyId
);

$claims = array(
    'iss' => $teamId,
    'iat' => time(),
    'exp' => time() + 3600,
    'aud' => 'https://appleid.apple.com',
    'sub' => $clientId,
);

$clientSecret = JWT::encode($claims, $key, 'ES256', $keyId);


if ( isset( $authorization['code'] ) ) {

    $code = $authorization['code'];

    // Exchange authorization code for tokens
    $tokenUrl = "https://appleid.apple.com/auth/token";

    $tokenData = array(
        'client_id'         => $clientId,
        'client_secret'     => $clientSecret,
        'code'              => $code,
        'grant_type'        => 'authorization_code',
        'redirect_uri'      => get_site_url(),
    );

    $result = wp_remote_post( $tokenUrl, array(
        'body' => $tokenData
    ) );


    $response = json_decode( wp_remote_retrieve_body( $result ), true );

    if ( isset( $response['access_token'] ) ) {

        $email = $fname = $lname = '';
    
        if( isset( $data['user'] ) ){

            $email  = isset( $data['user']['email'] ) ? sanitize_email( $data['user']['email'] ) : '';

            if( isset( $data['user']['name'] ) ){
                $fname  = isset( $data['user']['name']['firstName'] ) ? sanitize_text_field( $data['user']['name']['firstName'] ) : '';
                $lname  = isset( $data['user']['name']['lastName'] ) ? sanitize_text_field( $data['user']['name']['lastName'] ) : '';
            }
            
        }
        else{
            if( isset( $authorization['id_token'] ) ){

                $decoded = explode( '.', $authorization['id_token'] )[1];

                $decoded = json_decode( base64_decode( $decoded ) );

                if( isset( $decoded->email ) ){
                    $email = $decoded->email;
                }

            }
            
        }

        if( $email ){
            return array(
                'email'         => $email,
                'first_name'    => $fname,
                'last_name'     => $lname
            );
            exit;
        }        
        

    }
}

return new WP_Error( 'went-wrong', 'Something went wrong. Please try again' );