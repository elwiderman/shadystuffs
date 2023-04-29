<?php
/*
    Template name: Page Generic Archive
*/
get_header();
get_template_part('parts/content/utilities/breadcrumb', '01');
?>

<section class="content-block archive-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="title-area">
                    <div class="lead">
                        <?php
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile; //resetting the page loop
                        wp_reset_query(); //resetting the page query
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="container">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'paged' => $paged
        );

        $the_posts = new WP_Query($args);

        $temp_query = $wp_query;
        $wp_query = NULL;
        $wp_query = $the_posts;

        if ($the_posts->have_posts()):
            echo '<ul class="archive-items row justify-content-start">';
            while ($the_posts->have_posts()) : $the_posts->the_post();

                list (
                    $title,
                    $excerpt,
                    $permalink,
                    $thumbnail,
                    $time,
                    $categories
                    ) = array(
                    get_the_title($post->ID),
                    wp_trim_words(get_the_excerpt(), 20),
                    get_permalink($post->ID),
                    get_the_post_thumbnail_url($post->ID, 'generic-thumb'),
                    get_the_time('d F Y', $post->ID),
                    list_categories('category', '')
                );
                if (empty(get_the_post_thumbnail_url($post->ID, 'generic-thumb'))) {
                    $thumbnail = placeholder_src('generic-thumb');
                }

                echo <<<POST
                    <li class="col-12 col-md-4">
                        <div class="archive-item">
                            <a href="{$permalink}" class="image">
                                <img src="{$thumbnail}" class="img-responsive">
                            </a>
                            <div class="content">
                                <div class="content-header">
                                    <div class="date"><i class="far fa-calendar-alt"></i> {$time}</div>
                                    <div class="categories">{$categories}</div>
                                </div>
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
                <div class="row justify-content-center">
                    <div class="col-12">
                        {$pagination}
                    </div>
                </div>
PAGINATION;

        else:

            /* NO POSTS HAS BEEN FOUND IN THE DB */
            $string = __('There are currently no posts to show', 'jtlb');
            echo <<<NOPOST
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="size-18"><i class="fa fa-warning"></i> <i>{$string}</i></h2>
                    </div>
                </div>
NOPOST;
        endif;
        wp_reset_postdata();
        $wp_query = NULL;
        $wp_query = $temp_query;
        ?>
    </div>
</section>

<div class="clearfix"></div>

<?php get_footer(); ?>
