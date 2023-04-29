<?php
/*
    Hooks, actions and custom helper functions for cart, checkout, orders
    Author: Ajasra Das
*/


/*
	Ajaxifying mini-cart in main menu
	-------------------------------------
*/
/* Changing the mini-cart buttons */
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

// add_action('woocommerce_widget_shopping_cart_buttons', 'jeet_woo_widget_shopping_cart_button_view_cart', 10);
add_action('woocommerce_widget_shopping_cart_buttons', 'jeet_woo_widget_shopping_cart_proceed_to_checkout', 20);

function jeet_woo_widget_shopping_cart_button_view_cart() {
    echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="btn btn-primary btn-rounded">' . esc_html__('guarda il carrello', 'jtlb') . '</a>';
}

function jeet_woo_widget_shopping_cart_proceed_to_checkout() {
    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-primary btn-rounded">' . esc_html__('Checkout', 'jtlb') . '</a>';
}


/* Show cart contents / total Ajax */
// add_filter('woocommerce_add_to_cart_fragments', 'jeet_woo_header_add_to_cart_fragment');

function jeet_woo_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

    ob_start();
    $count = $woocommerce->cart->cart_contents_count;
	?>

    <button class="btn btn-transparent dropdown-toggle" type="button" id="menuCartBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-shopping-basket"></i> <?php _e('Cart', 'jtlb');?>
        <?php
        if ( $count > 0 ) {
            echo " (<span class='red'>{$count}</span>)";
        } else {
            echo "";
        }
        ?>
    </button>

	<?php
	$fragments['button#menuCartBtn'] = ob_get_clean();
	return $fragments;
}


/* Override add to cart text */
// add_filter('woocommerce_product_add_to_cart_text', 'jeet_woo_custom_product_add_to_cart_text'); // archive
function jeet_woo_custom_product_add_to_cart_text() {
	global $product;

	if ($product->is_type('simple')) {
		return '<i class="fas fa-shopping-basket"></i>' . __('aggiungi', 'jtlb');
	}
	if (($product->is_type('grouped') || $product->is_type('variable')) || ($product->get_stock_quantity() < 1)) {
		return '<i class="fas fa-share"></i>' . __('visualizza', 'jtlb');
	}
}

// add_filter('woocommerce_product_single_add_to_cart_text', 'jeet_woo_custom_product_add_to_cart_text_single'); // single
function jeet_woo_custom_product_add_to_cart_text_single() {
	return '<i class="fas fa-shopping-basket"></i>' . __('aggiungi al carrello', 'jtlb');
}

/* overriding billing form */
function jeet_move_default_address_fields($fields) {
	/* // Move these around as necessary. You'll see we added email first.
	$billing_order = array(
		'billing_first_name',
		'billing_last_name',
		'billing_email',
		'billing_phone',
		'billing_address_1',
		'billing_address_2',
		'billing_state',
		'billing_country',
		'billing_postcode'
	);

	$count = 0;
    $priority = 10;

	// This sets the billing fields in the order above
	foreach($billing_order as $billing_field) {
		$count++;
		$fields['billing'][$billing_field]['priority'] = $count * $priority;
	}

	$fields['billing']['billing_state']['class'] = array('form-row-first');
    $fields['billing']['billing_country']['class'] = array('form-row-last');

	// Move these around as necessary
	$shipping_order = array(
		'shipping_first_name',
		'shipping_last_name',
		'shipping_address_1',
		'shipping_address_2',
		'shipping_city',
		'shipping_state',
		'shipping_country',
		'shipping_postcode'
	);

	$count = 0;
    $priority = 10;

	// This sets the shipping fields in the order above
	foreach($billing_order as $billing_field) {
		$count++;
		$fields['shipping'][$billing_field]['priority'] = $count * $priority;
	}

	$fields['shipping']['shipping_state']['class'] = array('form-row-first');
    $fields['shipping']['shipping_country']['class'] = array('form-row-last');

	return $fields; */

	// echo '<pre>';
	// var_dump($fields);
	// echo '</pre>';

	unset($fields['company']);

	$address_order = array(
		'address_1',
		'address_2',
		'city',
		'state',
		'country',
		'postcode'
	);

	$count = 5;
    $priority = 10;

	foreach($address_order as $order_field) {
		$count++;
		$fields[$order_field]['priority'] = $count * $priority;
	}

	$fields['address_2']['label_class'] = '';
	if (is_edit_account_page()) {
		$fields['email']['priority'] = 30;
		$fields['phone']['priority'] = 40;
	}

	$fields['state']['class'] = array('form-row-first');
    $fields['country']['class'] = array('form-row-last');
    $fields['postcode']['class'] = array('form-row-first');

	return $fields;
}
add_filter('woocommerce_default_address_fields', 'jeet_move_default_address_fields');


// move checkout fields
function jeet_move_woocommerce_checkout_fields($fields) {
	// Move these around as necessary. You'll see we added email first.
	$billing_order = array(
		'billing_first_name',
		'billing_last_name',
		'billing_email',
		'billing_postcode',
		'billing_address_1',
		'billing_address_2',
		'billing_city',
		'billing_state',
		'billing_country',
		'billing_phone',
		// 'billing_mobile',
		// 'billing_fiscal_code',
		// 'billing_recipient_code_type',
		// 'billing_recipient_code_type_content',
	);

	$count = 1;
    $priority = 10;

	// This sets the billing fields in the order above
	foreach($billing_order as $billing_field) {
		$count++;
		$fields['billing'][$billing_field]['priority'] = $count * $priority;
	}

    unset($fields['billing']['billing_company']);
    unset($fields['shipping']['shipping_company']);

    $fields['billing']['billing_email']['class'] = array('form-row-wide');
    $fields['billing']['billing_phone']['class'] = array('form-row-first');
    $fields['billing']['billing_postcode']['class'] = array('form-row-wide');

	// echo '<pre>';
	// var_dump($fields['billing']);
	// echo '</pre>';
	return $fields;
}
add_filter('woocommerce_checkout_fields', 'jeet_move_woocommerce_checkout_fields');

/* 
	Add custom checkout fields
*/

// add_action( 'woocommerce_billing_fields', 'jeet_add_custom_woocommerce_billing_fields' );
function jeet_add_custom_woocommerce_billing_fields($fields) {
	$fields['billing_mobile'] = array(
        'label' 		=> __('Cellulare', 'jtlb'), // Add custom field label
        'placeholder' 	=> '',
        'required' 		=> true, // if field is required or not
        'clear' 		=> false, // add clear or not
        'type' 			=> 'tel', // add field type
		'class' 		=> array('form-row', 'form-row-last'),    // add class name
		'validate'		=> array('phone')
	);

	$fields['billing_fiscal_code'] = array(
        'label' 		=> __('Codice Fiscale / Partita Iva', 'jtlb'), // Add custom field label
        'placeholder' 	=> '',
        'required' 		=> true, // if field is required or not
        'clear' 		=> false, // add clear or not
        'type' 			=> 'text', // add field type
		'class' 		=> array('form-row', 'form-row-first'),    // add class name
	);

	$fields['billing_recipient_code_type'] = array(
        'label' 		=> __('Scegli un metodo di identificazione per la fattura elettronica', 'jtlb'), // Add custom field label
        'placeholder' 	=> '',
        'required' 		=> false, // if field is required or not
        'clear' 		=> true, // add clear or not
		'type' 			=> 'radio', // add field type
		'options'		=> array(
			'none'		=> __('Nessun codice identificativo', 'jtlb'),
			'code'		=> __('Codice univoco destinatario (6 o 7 caratteri)', 'jtlb'),
			'mail'		=> __('Indirizzo di Posta Elettronica Certificata (PEC)', 'jtlb')
		),
		'class' 		=> array('form-row-wide', 'identify-method'),    // add class name
	);

	$fields['billing_recipient_code_type_content'] = array(
        'label' 		=> __('Scegli un metodo di identificazione per la fattura elettronica', 'jtlb'), // Add custom field label
        'placeholder' 	=> '',
        'required' 		=> false, // if field is required or not
        'clear' 		=> false, // add clear or not
        'type' 			=> 'hidden', // add field type
		'class' 		=> array('form-row', 'form-row-first', 'hide'),    // add class name
	);
	
	/* $fields['billing_additional_data'] = array(
        'label' 		=> __('Dati supplementari (Indicare codice SDI e/o PEC per fattura elettronica)', 'jtlb'), // Add custom field label
        'placeholder' 	=> '',
        'required' 		=> false, // if field is required or not
        'clear' 		=> false, // add clear or not
        'type' 			=> 'textarea', // add field type
		'class' 		=> array('form-row', 'form-row-first'),    // add class name
    ); */

    return $fields;
}

// display the custom added fields in the woo orders admin
// add_action('woocommerce_admin_billing_fields', 'jeet_custom_woocommerce_admin_billing_fields'); 
function jeet_custom_woocommerce_admin_billing_fields($fields) {
	$fields['mobile'] = array(
		'label' => __('Mobile', 'woocommerce'),
	);
	$fields['additional_data'] = array(
		'label' => __('Additional Data', 'woocommerce'),
	);
	$fields['fiscal_code'] = array(
		'label' => __('Codice Fiscale / Partita Iva', 'woocommerce'),
		'css'	=> array('form-field-wide')
	);
	
	return $fields;
}


// add custom fields to woocommerce admin order detail page
// add_action( 'woocommerce_admin_order_data_after_order_details', 'jeet_editable_order_meta_general' );
function jeet_editable_order_meta_general( $order ){  ?>
 
		<br class="clear" /><br>
		<hr>
		<h4>Fattura elettronica <a href="#" class="edit_address">Edit</a></h4>
		<?php 
			/*
			 * get all the meta data values we need
			 */ 
			$code_type = get_post_meta( $order->id, '_billing_recipient_code_type', true );
			$method = get_post_meta( $order->id, '_billing_recipient_code_type_content', true );
		?>
		<div class="address">
			<p>
				<strong><?php _e('Metodo di identificazione per la fattura elettronica', 'jtlb');?>: </strong>
				<?php
				switch ($code_type) {
					case 'code':
						_e('Codice univoco destinatario', 'jtlb');
						echo ' - <b>' . $method . '</b>';
						break;
					case 'mail':
						_e('Indirizzo di Posta Elettronica Certificata', 'jtlb');
						echo ' - <b>' . $method . '</b>';
						break;
					
					case 'none':
						echo '-';
						break;
				}
				?>
			</p>
		</div>
		<div class="edit_address">
		<?php
 
			woocommerce_wp_radio( array(
				'id'			=> 'billing_recipient_code_type',
				'label' 		=> __('Scegli un metodo di identificazione per la fattura elettronica', 'jtlb'),
				'value' 		=> $code_type,
				'options' 		=> array(
					'none'		=> __('Nessun codice identificativo', 'jtlb'),
					'code'		=> __('Codice univoco destinatario', 'jtlb'),
					'mail'		=> __('Indirizzo di Posta Elettronica Certificata', 'jtlb')
				),
				'style' => 'width:16px', // required for checkboxes and radio buttons
				'wrapper_class' => 'form-field-wide' // always add this class
			) );
 
			woocommerce_wp_text_input( array(
				'id' 		=> 'billing_recipient_code_type_content',
				'label' 	=> __('Metodo', 'jtlb') . ':',
				'value' 	=> $method,
				'wrapper_class' => 'form-field-wide'
			) );
		?>
		</div>
 
 
<?php }
 
//  save the metafields on edit from woo admin orders
// add_action( 'woocommerce_process_shop_order_meta', 'jeet_save_general_details' );
function jeet_save_general_details( $ord_id ){
	update_post_meta( $ord_id, '_billing_recipient_code_type', wc_clean( $_POST[ 'billing_recipient_code_type' ] ) );
	if (wc_clean( $_POST[ 'billing_recipient_code_type' ] ) == 'none') {
		$method = '';
	} else {
		$method = wc_clean( $_POST[ 'billing_recipient_code_type_content' ] );
	}
	update_post_meta( $ord_id, '_billing_recipient_code_type_content',  $method);
	// wc_clean() and wc_sanitize_textarea() are WooCommerce sanitization functions
}





/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
add_filter( 'woocommerce_package_rates', 'jeet_hide_shipping_when_free_is_available', 100 );
function jeet_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}


// add fields
/* add_action( 'woocommerce_before_checkout_billing_form', 'misha_select_field' );
 
// save fields to order meta
add_action( 'woocommerce_checkout_update_order_meta', 'misha_save_what_we_added' );
 
// select
function misha_select_field( $checkout ){
 
	// you can also add some custom HTML here
 
	woocommerce_form_field( 'contactmethod', array(
		'type'          => 'select', // text, textarea, select, radio, checkbox, password, about custom validation a little later
		'required'	=> true, // actually this parameter just adds "*" to the field
		'class'         => array('misha-field', 'form-row-wide'), // array only, read more about classes and styling in the previous step
		'label'         => 'Preferred contact method',
		'label_class'   => 'misha-label', // sometimes you need to customize labels, both string and arrays are supported
		'options'	=> array( // options for <select> or <input type="radio" />
			''		=> 'Please select', // empty values means that field is not selected
			'By phone'	=> 'By phone', // 'value'=>'Name'
			'By email'	=> 'By email'
			)
		), $checkout->get_value( 'contactmethod' ) );
 
	// you can also add some custom HTML here
 
}


// save field values
function misha_save_what_we_added( $order_id ){
 
	if( !empty( $_POST['contactmethod'] ) )
		update_post_meta( $order_id, 'contactmethod', sanitize_text_field( $_POST['contactmethod'] ) );
 

 
} */


// modify html of radio field type
// add_filter( 'woocommerce_form_field_radio', 'jeet_custom_checkout_radio_field', 10, 4 );
function jeet_custom_checkout_radio_field( $no_parameter, $key, $args, $value ) {

	if ( $args['required'] ) {
		$args['class'][] = 'validate-required';
		$required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
	} else {
		$required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
	}

	if ( is_string( $args['label_class'] ) ) {
		$args['label_class'] = array( $args['label_class'] );
	}

	if ( is_null( $value ) ) {
		$value = $args['default'];
	}

	// Custom attribute handling.
	$custom_attributes         = array();
	$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

	if ( true === $args['autofocus'] ) {
		$args['custom_attributes']['autofocus'] = 'autofocus';
	}

	if ( $args['description'] ) {
		$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
	}

	if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
		foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
			$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
		}
	}

    $field           = '';
	$label_id        = $args['id'];
	$sort            = $args['priority'] ? $args['priority'] : '';
	$field_container = '<p class="form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p>';

	
	if ( ! empty( $args['options'] ) ) {
		foreach ( $args['options'] as $option_key => $option_text ) {
			$field .= '<span class="form-check-outer">';
			$field .= '<span class="form-check">';
			$field .= '<label for="' . esc_attr( $label_id ) . '_' . esc_attr( $option_key ) . '">';
			$field .= '<input type="radio" class="form-check-input" 
						value="'. esc_attr($option_key) .'" 
						name="'. esc_attr($key) .'" '. implode(' ', $custom_attributes) .' 
						id="'. esc_attr($label_id) .'_'. esc_attr($option_key) .'"'. checked( $value, $option_key, false ) .' />';
			$field .= '<span class="form-check-label">' . $option_text . '</span></label>';
			$field .= '</span>';

			if ($option_key == 'code') {
				$placeholder = __('Codice univoco destinatario *', 'jtlb');
				$content_attr = 'minlength="6" maxlength="7"';
			} elseif ($option_key == 'mail') {
				$placeholder = __('Indirizzo di posta elettronica certificata *', 'jtlb');
			}

			$field .= ($option_key !== 'none') ? '<span class="form-check-inputfield"><input type="text" name="'. esc_attr($label_id) .'_'. esc_attr($option_key) .'_input" class="input-text" placeholder="'.$placeholder.'" '.$content_attr.' autocomplete="off" required></span>' : '';
			$field .= '</span>';
		}
	}
	
		
	if ( ! empty( $field ) ) {
		$field_html = '';

		if ( $args['label'] && 'checkbox' !== $args['type'] ) {
			$field_html .= '<label for="' . esc_attr($label_id) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
		}

		$field_html .= '<span class="woocommerce-input-wrapper">' . $field . '</span>';

		$container_class = esc_attr( implode( ' ', $args['class'] ) );
		$container_id    = esc_attr( $label_id ) . '_field';
		$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
	}
	
    echo $field;
}

// modify html of hidden text type
// add_filter('woocommerce_form_field_hidden', 'jeet_custom_checkout_hidden_field', 999, 4);
function jeet_custom_checkout_hidden_field($no_parameter, $key, $args, $value) {

    $field = '<p class="form-row ' . implode( ' ', $args['class'] ) .'" id="' . $key . '_field">
        <input type="hidden" class="input-hidden" name="' . $key . '" id="' . $key . '" placeholder="' . $args['placeholder'] . '" value="'. $value.'" />
        </p>';

    return $field;
}


// add custom validation to check if the method is filled 
// add_action('woocommerce_checkout_process', 'jeet_custom_woo_checkout_process_error');
function jeet_custom_woo_checkout_process_error() {	
	// check if identification method is checked 
	if (isset($_POST['billing_recipient_code_type']) && $_POST['billing_recipient_code_type'] !== 'none') {
		// check its not none
		$msg = '';
		if (empty($_POST['billing_recipient_code_type_content'])) {
			$msg .= '<strong>' . __('Metodo di identificazione per la fattura elettronica', 'jtlb') . ' </strong>' . __('is a required field.', 'woocommerce');

			wc_add_notice( $msg, 'error' );
		}		
	}
}