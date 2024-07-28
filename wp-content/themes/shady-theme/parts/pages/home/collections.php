<?php
// collections
if (get_field('show_collections_bool')) :
    $title      = get_field('collections_title_text');
    $cta        = get_field('collections_cta_link');
?>

<section class="section-block section-collections">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h2 class="section-title mb-0 color-grey"><?php echo $title;?></h2>
            </div>

            <div class="col-auto">
                <a href="<?php echo $cta['url'];?>" target='<?php echo $cta['target'];?>' class="btn-main"><?php echo $cta['title'];?></a>
            </div>

            <div class="col-12">
                <?php
                if (have_rows('collections_repeater')) :
                    echo "<div class='collections-grid' id='collectionsGrid'>";
                    $i = 0;
                    while (have_rows('collections_repeater')) : the_row();
                        $title  = get_sub_field('title');
                        $img    = get_sub_field('image');
                        $link   = get_sub_field('link');
                        $bg     = "";

                        if (get_sub_field('title_bg_color')) {
                            $color  = get_sub_field('title_bg_color');
                            $bg     = "style='background:{$color};'";
                        }

                        // group items by 3 at once
                        echo ($i % 3 == 0) ? "<div class='grid-row'>" : "";

                        echo "
                        <div class='grid'>
                            <a href='{$link['url']}' target='{$link['target']}' class='grid__perma'>
                                <figure class='grid__thumb mb-0'>
                                    <img class='img-fluid' src='{$img['url']}' alt='{$img['alt']}'>
                                    <figcaption class='grid__thumb--caption' {$bg}>{$title}</figcaption>
                                </figure>
                            </a>
                        </div>
                        
                        ";

                        // close grid-row after 3 elems
                        echo ($i % 3 == 2) ? "</div>" : "";

                        $i++;
                    endwhile;
                    echo "</div>";
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<?php
endif;