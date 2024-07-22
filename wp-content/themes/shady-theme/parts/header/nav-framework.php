<?php
// main menu partial
$logo       = get_field('logo_img', 'option');
?>
<header class="header">
    <nav class="header__nav">
        <div class="header__nav--left">
            <button class="navbar-toggler" type="button">
                <div class="navbar-toggler__btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="navbar-toggler__label">
                    <div class="navbar-toggler__label--open"><?php _e('menu', 'shady');?></div>
                    <div class="navbar-toggler__label--close"><?php _e('close', 'shady');?></div>
                </div>
            </button>
        </div>
        <div class="header__nav--brand">
            <a class="navbar-brand" href="<?php echo esc_url(home_url());?>" title="<?php bloginfo('name'); ?>" target="_self">
                <img class="img-fluid" src="<?php echo $logo['url'];?>" alt="<?php echo $logo['alt'];?>" width="<?php echo $logo['width'];?>" height="<?php echo $logo['height'];?>">
            </a>
        </div>
        <div class="header__nav--right">
            <div class="navbar-wishlist">
                <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>wishlist/" title="<?php _e('My Wishlist','shady'); ?>">
                    <i class="icon-heart"></i>
                    <span><?php _e('Wishlist','shady'); ?></span>
                </a>
            </div>
            <div class="navbar-account">
                <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('My Account','shady'); ?>">
                    <i class="icon-user"></i>
                    <span><?php _e('My Account','shady'); ?></span>
                </a>
            </div>
            
            <?php if (function_exists('WC') && (!is_cart() && !is_checkout())) : ?>
            <!-- <div class="navbar-cart">
                <?php //dynamic_sidebar('menu-cart');?>
            </div> -->
            <?php nav_cart();?>
            <?php endif;?>

        </div>
    </nav>

    <nav class="header__main-menu">
        <div class="header__main-menu--wrap">
            <?php main_menu();?>
            <div class="menu-bottom">
                <?php second_menu();?>
                <?php get_template_part('parts/header/socials');?>
            </div>
        </div>
    </nav>
</header>