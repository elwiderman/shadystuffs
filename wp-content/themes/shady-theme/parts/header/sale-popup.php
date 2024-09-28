<?php
// site wide sale popup - shows on all pages except prod singe cart and checkout

// echo '<pre>';
// var_dump(get_field('show_sitewide_popup_bool', 'option'));
// echo '</pre>';

if (get_field('show_sitewide_popup_bool', 'option')) :
    if (!is_product() && !is_cart() && !is_checkout()) :
        $popup      = get_field('popup_img', 'option');
        ?>
        <div class="modal fade" id="salePop" tabindex="-1" aria-labelledby="salePopLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="icon-x"></i>
                    </button>
                    <div class="modal-body">
                        <figure class="sale-pop mb-0">
                            <img src="<?php echo $popup['url'];?>" alt="<?php echo $popup['alt'];?>" class="img-fluid">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endif;
endif;