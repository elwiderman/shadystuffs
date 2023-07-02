<?php
// Numeric Page Navi (built into the theme by default)
function pagination($before = '', $after = '') {
    $html = '';
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ($numposts <= $posts_per_page) {
        return;
    }
    if (empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 5;
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if ($start_page <= 0) {
        $start_page = 1;
    }

    $previous = get_previous_posts_link(__('<i class="icon-ita icon-chevron-left"></i>', 'shady'), 0);
    $next = get_next_posts_link(__('<i class="icon-ita icon-chevron-right"></i>', 'shady'), 0);
    if (!is_single() && $paged == 1) {
        $previous = '<a href="#" class="disabled"><i class="icon-ita icon-chevron-left"></i></a>';
    }
    if (!is_single() && $paged == $max_page) {
        $next = '<a href="#" class="disabled"><i class="icon-ita icon-chevron-right"></i></a>';
    }
    $html .= $before . '<nav class="page-navigation">';
    $html .= '<div class="prev">' . $previous . '</div>';
    $html .= '<ul class="pagination">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $paged) {
            $html .= '<li class="current"><a>' . $i . '</a></li>';
        } else {
            $html .= '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
        }
    }
    $html .= '</ul><div class="next">' . $next . '</div></nav>' . $after . "";
    return $html;
} /* End page navi */
