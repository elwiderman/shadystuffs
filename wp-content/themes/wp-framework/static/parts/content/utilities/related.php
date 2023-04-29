<?php
$related = rwmb_meta('lf_related', $post->ID);
if (!empty($related[0])):
    ?>
    <section class="padding-bottom-40">
        <div class="row">
            <div class="small-12 columns">
                <h3>
                    <?php _e('Related', 'jtlb'); ?>
                </h3>
                <hr/>
            </div>
        </div>

        <div class="row small-up-1 medium-up-3 large-up-3">
            <?php
            foreach ($related as $news):

                if (empty($news))
                    continue;

                list (
                    $title,
                    $excerpt,
                    $permalink,
                    $thumbnail,
                    $time,
                    $categories
                    ) = array(
                    get_the_title($news),
                    get_the_excerpt(),
                    get_permalink($news),
                    switch_post_thumbnail($news, '370x270'),
                    get_the_time('d F Y', $news),
                    get_the_category($news)
                );

                if (strlen($excerpt) > 100)
                    $excerpt = preg_replace('/\s+?(\S+)?$/', '', substr($excerpt, 0, '100')) . '..';

                $items = count($categories);
                $i = 0;
                $cat = '';
                foreach ($categories as $category):
                    $cat .= '<a class="bold" href="' . get_category_link($category->term_id) . '"><i class="fa fa-pencil"></i> &nbsp;' . $category->name . '</a> ';
                    $cat .= (++$i === $items) ? '' : ' / ';
                endforeach;

                echo <<<POST
                <div class="column">
                    <article class="category">
                        <figure class="zoom-img">
                            <a href="{$permalink}">
                                {$thumbnail}
                            </a>
                        </figure>
                        
                        <div class="entry">
                            <span class="time"><i class="fa fa-calendar"></i> &nbsp; {$time} &nbsp; <span class="float-right">{$cat}</span></span>
                            <h3>
                                <a href="{$permalink}">
                                    {$title}
                                </a>
                            </h3>
                            <p class="no-margin medium-gray">
                                {$excerpt}
                            </p>
                        </div>
                    </article>
                </div>
POST;

            endforeach;
            ?>
        </div>
    </section>
<?php endif; ?>
