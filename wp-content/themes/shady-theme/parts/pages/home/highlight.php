<?php
// the highlight section
if (get_field('show_highlight_bool')) :
    $title      = get_field('highlight_title_text');
    $desc       = nl2br(get_field('highlight_desc_text'));
    $cta        = get_field('highlight_cta_link');
    $left       = get_field('highlight_left_img');
    $right      = get_field('highlight_right_img');
    ?>

    <section class="section-block section-highlight">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="highlight-left">
                        <figure class="highlight-left__img">
                            <img src="<?php echo $left['url'];?>" alt="<?php echo $left['alt'];?>" class="img-fluid">
                        </figure>
                        <div class="highlight-left__content">
                            <h4 class="highlight-left__content--title"><?php echo $title;?></h4>
                            <p class="highlight-left__content--desc"><?php echo $desc;?></p>
                            <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main mb-4 mb-md-0"><?php echo $cta['title'];?></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="highlight-right">
                        <figure class="highlight-right__img mb-0">
                            <img src="<?php echo $right['url'];?>" alt="<?php echo $right['alt'];?>" class="img-fluid">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
endif;