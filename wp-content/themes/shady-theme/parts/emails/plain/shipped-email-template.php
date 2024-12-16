<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$order_id       = $order->get_id();
$shipper        = get_field('shipping_partner_text', $order_id);
$awb            = get_field('awb_text', $order_id);
$link           = get_field('shipping_link_text', $order_id);
?>

Hi <?php echo $order->get_billing_first_name(); ?>,

We wanted to inform you that your order #<?php echo $order->get_order_number(); ?> has been <?php echo ucfirst($order->get_status()); ?> through <?php echo $shipper;?>.

<?php
if ($link) {
    echo "To track your order <a href='{$link}' target='_blank'>click here</a>.";
}
?>

Please find the order tracking details below -
Courier - <?php echo $shipper;?>
AWB No. - <?php echo $awb;?>

Thank you for shopping with us!