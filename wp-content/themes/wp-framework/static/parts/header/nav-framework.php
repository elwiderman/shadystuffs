<header class="<?= (!is_front_page()) ? 'inner' : ''; ?>">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= esc_url(home_url()); ?>">
                <img src="<?= esc_url(get_template_directory_uri()); ?>/assets/images/logo.png"
                alt="<?php bloginfo('name'); ?>" class="logo"/>
                <?php bloginfo('name'); ?>
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
            data-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <?php main_menu(); ?>

                <?php
                // wpml language switcher
                get_template_part('parts/header/icl', 'language');

                // social icons
                get_template_part('parts/header/socials');
                ?>

                <?php if (function_exists('WC') && (!is_cart() && !is_checkout())) : ?>
                <div class="dropdown menu-cart">
                    <button class="btn btn-transparent dropdown-toggle" type="button" id="menuCartBtn" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-basket"></i> <?php _e('Cart', 'jtlb');?>
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
                <?php endif;?>

                <div class="dropdown menu-search">
                    <button class="nav-search-toggle dropdown-toggle" type="button" id="menuSearch"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" arial-labelledby="menuSearch">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
