<?php get_header(); ?>

<?php
$allsearch = new WP_Query("s=$s");
$count = $allsearch->post_count;
$search = get_search_query();
?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <h1><?php _e('Search Results', 'shady');?></h1>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>

    <section class="content-block search-results-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area">
                        <div class="lead">
                            <?php _e('We have found ', 'shady');
                            echo $count; ?>
                            <?php _e('results containing: ', 'shady');
                            echo '"' . $search . '"'; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <?php
                $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
                $args = array(
                    's' => $s,
                    'paged' => $paged
                );
                query_posts($args);
                if (have_posts()):
                    echo '<ul class="archive-items">';
                    while (have_posts()):the_post();

                        list (
                            $title,
                            $excerpt,
                            $permalink,
                            $thumbnail,
                            $time,
                            // $categories
                            ) = array(
                            get_the_title($post->ID),
                            wp_trim_words(get_the_excerpt(), 20),
                            get_permalink($post->ID),
                            get_the_post_thumbnail_url($post->ID, 'generic-thumb'),
                            get_the_time('d F Y', $post->ID),
                            // list_categories('category')
                        );
                        if (empty(get_the_post_thumbnail_url($post->ID, 'generic-thumb'))) {
                            $thumbnail = wp_get_attachment_image_src(8, 'generic-thumb')[0]; //define default image
                        }

                        echo <<<POST
                        <li class="col-md-4 col-sm-6 col-xs-12">
                            <div class="archive-item">
                                <a href="{$permalink}" class="image">
                                    <img src="{$thumbnail}" class="img-responsive">
                                </a>
                                <div class="content">
                                    <div class="content-header">
                                        <div class="date"><i class="far fa-calendar-alt"></i> {$time}</div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="{$permalink}" class="summary">
                                        <h4>{$title}</h4>
                                        <p class="text-muted excerpt">{$excerpt}</p>
                                    </a>
                                </div>
                            </div>
                        </li>
                        
POST;
                    endwhile;

                    /* CLOSE ul AND START PAGINATION */
                    $pagination = pagination();
                    echo <<<PAGINATION
                    </ul>
                    <div class="row">
                        <div class="col-md-12 pull-left">
                            {$pagination}
                        </div>
                    </div>
PAGINATION;

                else:

                    /* NO POSTS HAS BEEN FOUND IN THE DB */
                    $string = __('There are currently no posts to show', 'shady');
                    echo <<<NOPOST
                    <div class="row">
                        <div class="small-12 medium-12 large-12 columns">
                            <h2 class="size-18"><i class="fa fa-warning"></i> <i>{$string}</i></h2>	
                        </div>
                    </div>
NOPOST;
                endif;
                ?>
            </div>
    </section>


<?php get_footer(); ?>