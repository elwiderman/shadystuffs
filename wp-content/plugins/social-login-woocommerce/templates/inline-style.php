<?php
/**
 * Responsible for settings styling
 *
 * This template can be overridden by copying it to yourtheme/templates/social-login-woocommerce/inline-style.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/easy-login-woocommerce/
 * @version 1.1
 */


$xSettings 		= xoo_sl_helper()->get_x_option();
$glSettings 	= xoo_sl_helper()->get_general_option();
$appleSettings 	= xoo_sl_helper()->get_apple_option();

$xbgColor 	= $xSettings['btn-bgcolor'];
$xTxtColor 	= $xSettings['btn-txtcolor'];
$xPadding 	= $xSettings['btn-pd'];

$btnHeight 	= $glSettings['btn-height'];
$btnWidth 	= $glSettings['btn-width'];
$btnRadius  = ((int) $glSettings['btn-radius'])/2;

$iconSize = 38;

switch ($glSettings['gl-iconsize']) {
	case 'small':
		$iconSize = 20;
		break;
	
	case 'medium':
		$iconSize = 30;
		break;

	case 'large':
		$iconSize = 38;
		break;
}

?>

.xoo-sl-btn-x a, .xoo-sl-btn-x a:hover{
	background-color: <?php echo esc_html( $xbgColor ) ?>;
	color: <?php echo esc_html( $xTxtColor ) ?>;
}

.xoo-sl-display-text .xoo-sl-icon svg{
	fill: <?php echo esc_html( $xTxtColor ) ?>;
}

.xoo-sl-display-text .xoo-sl-btn-x a {
	padding: <?php echo esc_html( $xPadding ); ?>
}


.xoo-sl-display-text .xoo-sl-btn-x, .xoo-sl-display-text .xoo-sl-apple-login-btn{
	height: <?php echo (int) $btnHeight ?>px;
	max-width: <?php echo (int) $btnWidth ?>px;
	width: 100%;
}

.xoo-sl-display-text .xoo-sl-btn-x a, .xoo-sl-display-text .xoo-sl-apple-login-btn{
	border-radius: <?php echo (int) $btnRadius ?>px;
}

span.xoo-sl-icon svg, .xoo-sl-display-icon .xoo-sl-apple-login-btn{
    width: <?php echo (int) $iconSize ?>px;
    height: <?php echo (int) $iconSize ?>px;
}