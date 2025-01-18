<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class Xoo_Sl_Handler{

    protected static $_instance = null;

    public $settings;

    public static function get_instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function __construct(){
        $this->settings = xoo_sl_helper()->get_general_option();
        $this->hooks();
    }

    public function hooks(){
        add_action( 'wp_ajax_xoo_sl_process_social_response', array( $this, 'process_social_response' ) );
        add_action( 'wp_ajax_nopriv_xoo_sl_process_social_response', array( $this, 'process_social_response' ) );
        add_action( 'init', array( $this, 'process_x_response' ) );
    }

    public function process_x_response(){

        if( !isset( $_GET['logintwitter'] ) && !isset( $_GET['oauth_token'] ) ) return;

        $response = require_once XOO_SL_PATH.'/includes/twitter-handler.php';

        $user_data = array(
            'social_type' => 'x'
        );

        if( isset( $response->email ) ){
            $user_data['email'] = sanitize_email( $response->email );
        }

        if( isset( $response->name ) ){
            $name = explode(' ', $response->name );
            $user_data['first_name'] = isset( $name[0] ) ? sanitize_text_field( $name[0] ) : '';
            $user_data['last_name']  = isset( $name[1] ) ? sanitize_text_field( $name[1] ) : '';
        }

        if( isset( $response->profile_image_url_https ) ){
            $user_data['picture'] = sanitize_url( $response->profile_image_url_https );
        }

        $this->handle_response_data( $user_data, false );

    }


    public static function update_user_social_login_status( $user_id, $social_type ){
        update_user_meta( $user_id, '_xoo-sl-social-login', sanitize_text_field( $social_type ) );
    }

    public function handle_response_data( $user_data, $ajax = true ){

        try {

            $user_data   = apply_filters( 'xoo_sl_social_login_user_data', $user_data );

            if( is_wp_error( $user_data ) ){
                throw new Xoo_Exception( $user_data );
                
            }         

            if( !$user_data['email'] ){
                throw new Xoo_Exception( __( 'Could not access email. Please check the permission settings and make sure email access is provided.' ,'social-login-woocommerce' ) );
            }


            do_action( 'xoo_sl_before_processing_userdata', $user_data );

            //Login user
            if( email_exists( $user_data['email'] ) ){
                $action = $this->login( $user_data['email'] );
            }
            else{
                $action = $this->register( $user_data );
            }

            if( is_wp_error( $action ) ){
                throw new Xoo_Exception( $action );
            }

            if( $ajax ){

                $args = array(
                    'success' => 'true',
                    'message' => $this->settings['gl-txt-sucess']
                );

                wp_send_json( $args );
            }
            else{
                $redirectURL = isset( $_COOKIE['xoo_sl_redirect'] ) ? sanitize_url( $_COOKIE['xoo_sl_redirect'] ) : get_site_url();
                wp_safe_redirect( add_query_arg( 'login', 'success', $redirectURL ) );
                exit;
            }

            

            
        } catch (Xoo_Exception $e) {

            $message = xoo_sl_add_notice( $e->getMessage(), 'error');

            if( $ajax ){
                 $args = array(
                    'success' => 'false',
                    'message' => xoo_sl_add_notice( $message, 'error')
                );

                wp_send_json( $args );
            }
            else{
                wp_die( $message );
            }
        }

         
    }


    //Social login handler
    public function process_social_response(){

        $social_data = apply_filters( 'xoo_sl_social_login_user_data', $_POST['socialData'], $_POST['socialType'] );

        $user_data  = array(
            'email'         => '',
            'first_name'    => '',
            'last_name'     => '',
            'picture'       => '',
            'social_type'   => sanitize_text_field( $_POST['socialType'] )
        );

        if( $_POST['socialType'] === 'google' ){

            $token = $social_data['credential'];

            $info = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));

            $user_data['email']         = sanitize_email( isset( $info->email ) ? $info->email : '' );
            $user_data['first_name']    = sanitize_text_field( isset( $info->given_name ) ? $info->given_name : '' );
            $user_data['last_name']     = sanitize_text_field( isset( $info->family_name ) ? $info->family_name : '' );
            $user_data['picture']       = sanitize_text_field( isset( $info->picture ) ? $info->picture : '' );

        }

        if( $_POST['socialType'] === 'facebook' ){

            $info = include XOO_SL_PATH.'/includes/facebook-handler.php';

            if( is_wp_error( $info ) ){
                $user_data = $info;
            }
            else{
                $user_data['email']         = sanitize_email( $info->getField('email') );
                $user_data['first_name']    = sanitize_text_field( $info->getField('first_name') );
                $user_data['last_name']     = sanitize_text_field( $info->getField('last_name') ); 
            }

        }

        if( $_POST['socialType'] === 'apple' ){

            $info = include XOO_SL_PATH.'/includes/apple-handler.php';

            if( is_wp_error( $info ) ){
                $user_data = $info;
            }
            else{
                $user_data['email']         = sanitize_email( $info['email'] );
                $user_data['first_name']    = sanitize_text_field( $info['first_name'] );
                $user_data['last_name']     = sanitize_text_field( $info['last_name'] ); 
            }

        }

        $this->handle_response_data( $user_data );
            
    }


    public function login( $email ){

        $email = sanitize_email( $email );
        $user  = get_user_by( 'email', $email );

        if( !is_wp_error( $user ) ){

            wp_clear_auth_cookie();
            wp_set_current_user ( $user->ID  );
            wp_set_auth_cookie  ( $user->ID  );

            do_action( 'wp_login', $user->user_login, $user );

        }
        
        return $user; //returns wp_error if login unsucesful.

    }


    public function register( $user_data ){

        $email = sanitize_email( $user_data[ 'email' ] );

         // Check the email address.
        if ( empty( $email ) || ! is_email( $email ) ) {
            return new WP_Error( 'registration-error-invalid-email', __( 'Please provide a valid email address.', 'social-login-woocommerce' ) );
        }

        if ( email_exists( $email ) ) {
            return new WP_Error( 'registration-error-email-exists',  __( 'An account is already registered with your email address. Please log in.', 'social-login-woocommerce' ) );
        }

        // Handle username creation.
        if ( isset( $user_data['username'] ) && !empty( $user_data['username'] ) ) {
            $username = sanitize_user( $username );

            if ( empty( $username ) || ! validate_username( $username ) ) {
                return new WP_Error( 'registration-error-invalid-username', __( 'Please enter a valid account username.', 'social-login-woocommerce' ) );
            }

            if ( username_exists( $username ) ) {
                return new WP_Error( 'registration-error-username-exists', __( 'An account is already registered with that username. Please choose another.', 'social-login-woocommerce' ) );
            }
        } else {
            $username = sanitize_user( current( explode( '@', $email ) ), true );

            // Ensure username is unique.
            $append     = 1;
            $o_username = $username;

            while ( username_exists( $username ) ) {
                $username = $o_username . $append;
                $append++;
            }
        }

        // Handle password creation.
        $password = $password_generated = false;
        if ( isset( $user_data['password'] ) && !empty( $user_data['password'] ) ) {
            $password           = wp_generate_password();
            $password_generated = true;
        }

        // Use WP_Error to handle registration errors.
        $errors = new WP_Error();

        $errors = apply_filters( 'xoo_sl_registration_errors', $errors, $username, $email );

        if ( $errors->get_error_code() ) {
            return $errors;
        }

        $new_customer_data = apply_filters( 'xoo_sl_new_customer_data', array(
            'user_login' => $username,
            'user_pass'  => $password,
            'user_email' => $email,
            'role'       => $this->settings['gl-userrole'],
            'first_name' => isset( $user_data['first_name'] ) ? sanitize_text_field( $user_data['first_name'] ) : '',
            'last_name'  => isset( $user_data['last_name'] ) ? sanitize_text_field( $user_data['last_name'] ) : '',
        ) );

        $customer_id = wp_insert_user( $new_customer_data );

        if ( is_wp_error( $customer_id ) ) {
            wp_send_json(
                array(
                    'success' => 'false',
                    'message' => xoo_sl_add_notice( $action->get_error_message(), 'error')
                )
            );
        }

        self::update_user_social_login_status( $customer_id, $user_data['social_type'] );

        do_action( 'xoo_sl_created_customer', $customer_id, $new_customer_data, $password_generated );

        $this->login( $email ); //Everything is good , login user.

    }
}

function xoo_sl_handler(){
    return Xoo_Sl_Handler::get_instance();
}
xoo_sl_handler();

?>