<?php // General breadcrumb using breadcrumb trail plugin ?>
<section class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h1><?=$wp_query->queried_object->name;?></h1>
                <?php
                // breadcrumb (get the yoast breadcrumb else show a custom one)
                if ( function_exists('yoast_breadcrumb') ) :
                    yoast_breadcrumb('<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">','</nav>');
                else:
                    echo shady_custom_breadcrumbs();
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<div class="clearfix"></div>