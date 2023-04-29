<?php // Breadcrumb for single pages ?>
<section class="page-header single">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <?php
                // breadcrumb (get the yoast breadcrumb else show a custom one)
                if ( function_exists('yoast_breadcrumb') ) :
                    yoast_breadcrumb('<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">','</nav>');
                else:
                    echo jeet_custom_breadcrumbs();
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<div class="clearfix"></div>