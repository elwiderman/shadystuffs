<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$order_id       = $order->get_id();
$shipper        = get_field('shipping_partner_text', $order_id);
$awb            = get_field('awb_text', $order_id);
$link           = get_field('shipping_link_text', $order_id);
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>Hi <?php echo $order->get_billing_first_name(); ?>,</p>

<p>We wanted to inform you that your order #<?php echo $order->get_order_number(); ?> has been <strong><?php echo ucfirst($order->get_status()); ?></strong> through <strong><?php echo $shipper;?></strong>.</p>

<?php
if ($link) {
    echo "<p>To track your order <a href='{$link}' target='_blank'>click here</a>.</p>";
}
?>

<p>Please find the order tracking details below -</p>
<p>Courier - <b><?php echo $shipper;?></b></p>
<p>AWB No. - <b><?php echo $awb;?></b></p>

<p>Thank you for shopping with us!</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
