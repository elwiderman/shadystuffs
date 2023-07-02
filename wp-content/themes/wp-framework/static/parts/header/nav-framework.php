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
            <div class="navbar-account">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','shady'); ?>"><i class="fas fa-user"></i></a>
            </div>
            
            <?php if (function_exists('WC') && (!is_cart() && !is_checkout())) : ?>
            <div class="navbar-cart">
                <div class="dropdown menu-cart">
                    <button class="btn btn-transparent dropdown-toggle" type="button" id="menuCartBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i>
                        <?php
                        $count = WC()->cart->get_cart_contents_count();
                        if ($count > 0) {
                            echo ' (<span class="red">'. $count .'</span>)';
                        } else {
                            echo '';
                        }
                        ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuCartBtn">
                        <?php dynamic_sidebar('menu-cart');?>
                    </div>
                </div>
            </div>
            <?php endif;?>

        </div>
    </nav>
</header>