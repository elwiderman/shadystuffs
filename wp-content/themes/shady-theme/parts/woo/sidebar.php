<?php
// the sidebar form goes here
?>

<form id="shadySidebar" class="woo-sidebar-form">
    <div class="accordion" id="filterAccordion">
        <?php
        get_template_part('parts/woo/sidebar/collections');
        get_template_part('parts/woo/sidebar/colors');
        get_template_part('parts/woo/sidebar/sizes');
        get_template_part('parts/woo/sidebar/stock');
        ?>
    </div>

    <?php wp_nonce_field('shady_woo_filter', 'shady_shop_check');?>
    <input type="hidden" name="action" value="shady_woo_filter">
    <input type="hidden" name="per_page" value="<?php echo wc_get_loop_prop('per_page');?>">
    <input type="hidden" name="current_page" value="<?php echo wc_get_loop_prop('current_page');?>">
    <input type="hidden" name="total_pages" value="<?php echo wc_get_loop_prop('total_pages');?>">
    <input type="hidden" name="total" value="<?php echo wc_get_loop_prop('total');?>">
    <input type="hidden" name="paged" value="<?php echo wc_get_loop_prop('paged');?>">

    <input type="submit" value="submit" class="d-none">
</form>