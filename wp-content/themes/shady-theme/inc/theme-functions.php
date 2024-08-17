<?php

/* Enqueue Dashicons style for frontend use
------------------------------------*/
add_action('admin_enqueue_scripts', 'shady_enqueue_dashicons');
function shady_enqueue_dashicons() {
    wp_enqueue_style('dashicons');
}


/* ADD CUSTOM STYLE
------------------------------------*/
add_action('admin_head', 'admin_style');

function admin_style() {
    echo <<<STYLE
		<style type="text/css" media="all">
			body.toplevel_page_sections .wrap h1 {
				margin: 20px 0;
				font-weight: bold;
			}
		</style>
STYLE;
}


/* ADD EXCERPT TO PAGES
------------------------------------*/
add_action('init', 'shady_add_excerpts_to_pages');
function shady_add_excerpts_to_pages() {
    add_post_type_support('page', 'excerpt');
}


/* HIDE ADMIN BAR
------------------------------------*/
//show_admin_bar(false);


/* POST THUMBNAIL
------------------------------------*/
add_theme_support('post-thumbnails');


/* POST FORMAT
------------------------------------*/
add_theme_support('post-formats',
    array(
//			'aside',             // title less blurb
//			'gallery',           // gallery of images
        //'link',              // quick link to other site
        //'image',             // an image
//			'quote',             // a quick quote
        //'status',            // a Facebook like status update
//			'video',             // video
        //'audio',             // audio
        //'chat'               // chat transcript
    )
);
add_action('after_setup_theme', 'shady_remove_post_formats', 100);

function shady_remove_post_formats() {
   remove_theme_support('post-formats');
}


/* WPML CLASSES
------------------------------------*/
if (function_exists('icl_object_id')) {
    //override and save space for WPML CSS
    //define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
    //define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);

    //add lang class
    add_filter('body_class', 'append_language_class');
    function append_language_class($classes)
    {
        $classes[] = ICL_LANGUAGE_CODE;  //or however you want to name your class based on the language code
        return $classes;
    }
}
// returns the current language elements
function wpml_current_lang()
{
    $languages = icl_get_languages('skip_missing=0');
    $curr_lang = array();
    if (!empty($languages)) {

        foreach ($languages as $language) {
            if (!empty($language['active'])) {
                $curr_lang = $language; // This will contain current language info.
                break;
            }
        }
    }
    return $curr_lang;
}

/* WOOCOMMERCE INTEGRATION
------------------------------------*/
if (class_exists('WooCommerce')) {

    function shady_woocommerce_support() {
        add_theme_support('woocommerce', array(
            'thumbnail_image_width' => 150,
            'single_image_width'    => 300,
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 4,
                'min_columns'     => 2,
                'max_columns'     => 5,
            ),
        ));

        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
    add_action('after_setup_theme', 'shady_woocommerce_support');
}


/* CUSTOM BACKEND FOOTER
------------------------------------*/
function shady_custom_admin_footer()
{
    _e('<span id="footer-thankyou">Developed by <a href="https://shadystuffs.com/" target="_blank">Shady Stuffs</a></span>', 'shady');
}

add_filter('admin_footer_text', 'shady_custom_admin_footer');


/* MENU LINK ARCHIVI CPT
------------------------------------*/
add_action('admin_head-nav-menus.php', 'wpclean_add_metabox_menu_posttype_archive');

function wpclean_add_metabox_menu_posttype_archive()
{
    add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}

function wpclean_metabox_menu_posttype_archive()
{
    $post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

    if ($post_types) :
        $items = array();
        $loop_index = 999999;

        foreach ($post_types as $post_type) {
            $item = new stdClass();
            $loop_index++;

            $item->object_id = $loop_index;
            $item->db_id = 0;
            $item->object = 'post_type_' . $post_type->query_var;
            $item->menu_item_parent = 0;
            $item->type = 'custom';
            $item->title = $post_type->labels->name;
            $item->url = get_post_type_archive_link($post_type->query_var);
            $item->target = '';
            $item->attr_title = '';
            $item->classes = array();
            $item->xfn = '';

            $items[] = $item;
        }

        $walker = new Walker_Nav_Menu_Checklist(array());

        echo '<div id="posttype-archive" class="posttypediv">';
        echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
        echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
        echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object)array('walker' => $walker));
        echo '</ul>';
        echo '</div>';
        echo '</div>';

        echo '<p class="button-controls">';
        echo '<span class="add-to-menu">';
        echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'shady') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
        echo '<span class="spinner"></span>';
        echo '</span>';
        echo '</p>';

    endif;
}


/* SWITCH IMAGE DEPENDING BY ITS EXISTENCE
-----------------------------------------*/
function switch_post_thumbnail($post_id, $size)
{
    $thumb = get_the_post_thumbnail($post_id, $size);
    if ($thumb == ''):
        global $framework_options;
        $framework_options = get_option('framework_options', $framework_options);
        $src = wp_get_attachment_image_src($framework_options['placeholder_id'], $size);
    else:
        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    endif;
    return "<img width='" . $src[1] . "' height='" . $src[2] . "' src='" . $src[0] . "' class='attachment wp-post-image' alt=''>";
}

/* LIST CATEGORIES BY TAXONOMY
-----------------------------------------*/
function list_categories($taxonomy, $link)
{

    global $post;

    $categories = wp_get_post_terms($post->ID, $taxonomy);
    $numItems = count($categories);
    $i = 0;
    $cat = '';
    // $perma = (get_category_link($category->term_id)) ? get_category_link($category->term_id) : '#';
    foreach ($categories as $category):
        $perma = get_term_link($category->name, $taxonomy);
        $cat .= '<a href="' . $perma . '" class="category">' . $category->name . '</a>';
        $cat .= (++$i === $numItems) ? '' : ' ';
    endforeach;
    return $cat;

}

/* FAST TRANSLATED DATE
------------------------------------*/

function get_smart_time($post_id, $language) {

    global $post;

    switch (get_the_time('m', $post->ID)) {
        case 1:
            $month = ($language == 'it') ? 'Gennaio' : 'January';
            break;
        case 2:
            $month = ($language == 'it') ? 'Febbraio' : 'February';
            break;
        case 3:
            $month = ($language == 'it') ? 'Marzo' : 'March';
            break;
        case 4:
            $month = ($language == 'it') ? 'Aprile' : 'April';
            break;
        case 5:
            $month = ($language == 'it') ? 'Maggio' : 'May';
            break;
        case 6:
            $month = ($language == 'it') ? 'Giugno' : 'June';
            break;
        case 7:
            $month = ($language == 'it') ? 'Luglio' : 'July';
            break;
        case 8:
            $month = ($language == 'it') ? 'Agosto' : 'August';
            break;
        case 9:
            $month = ($language == 'it') ? 'Settembre' : 'September';
            break;
        case 10:
            $month = ($language == 'it') ? 'Ottobre' : 'October';
            break;
        case 11:
            $month = ($language == 'it') ? 'Novembre' : 'November';
            break;
        case 12:
            $month = ($language == 'it') ? 'Dicembre' : 'December';
            break;
    }

    return get_the_time('d ', $post->ID) . $month . get_the_time(' Y', $post->ID);
}

/* QUICK IMAGE PATH
------------------------------------*/
function image($name)
{
    $path = get_bloginfo('template_directory') . '/assets/images/' . $name;
    return $path;
}

/* TO RETRIEVE SOCIAL MENU LINKS FROM THEME OPTIONS */

function social_menu($menu_class, $position)
{
    $social_list = '<ul class="' . $menu_class . '">';
    $settings = get_option('framework_options');
    foreach ($settings['social_urls'] as $key => $value) {
        switch ($key) {
            case 'fa-facebook':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Facebook';
                break;
            case 'fa-google':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Google +';
                break;
            case 'fa-youtube':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Youtube';
                break;
            case 'fa-twitter':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Twitter';
                break;
            case 'fa-linkedin':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Linkedin';
                break;
            case 'fa-instagram':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Instagram';
                break;
            case 'fa-pinterest':
                $lnk = ($position == 'header') ? '<i class="fa ' . $key . '"></i>' : 'Pinterest';
                break;
        }
        if (!empty($value)) {
            $social_list .= '<li><a href="' . $value . '" target="_blank">' . $lnk . '</a></li>';
        }
    }
    $social_list .= '</ul>';
    return $social_list;
}


/* Removing using of .bmp files */
function shady_mime_types_setting($mime_types)
{
    unset($mime_types['bmp']); //Removing the bmp extension
    unset($mime_types['tif|tiff']); //Removing the tiff extension
    /*$mime_types['avi'] = 'video/avi'; //Adding avi extension*/ /*todo: this how we add new mime types*/
    $mime_types['ogv'] = 'video/ogg';
    $mime_types['webm'] = 'video/webm';
    return $mime_types;
}

add_filter('upload_mimes', 'shady_mime_types_setting', 1, 1);


/* Gets the content with formatting */
function get_the_content_with_formatting()
{
    ob_start();
    the_content();
    $the_content = ob_get_contents();
    ob_end_clean();
    return $the_content;
}

/* Remove gallery from content */
function strip_shortcode_gallery($content)
{
    preg_match_all('/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER);

    if (!empty($matches)) {
        foreach ($matches as $shortcode) {
            if ('gallery' === $shortcode[2]) {
                $pos = strpos($content, $shortcode[0]);
                if (false !== $pos) {
                    return substr_replace($content, '', $pos, strlen($shortcode[0]));
                }
            }
        }
    }

    return $content;
}

/* Removal of certain posts and pages from wordpress search. eg.contact page, banner,etc */
function shady_remove_from_search_filter($query)
{
    if (!$query->is_admin && $query->is_search && $query->is_main_query()) {
//    $query->set( 'post__not_in', array( 66 ) ); //add post ids to the array
    }
}

add_action('pre_get_posts', 'shady_remove_from_search_filter');


/* Get Vimeo video Id */
function vimeo_id($video)
{
    $regs = array();
    $video_id = '';
    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $video, $regs)) {
        $video_id = $regs[3];
    }
    return $video_id;
}

/* Get Youtube video Id */
function youtube_id($video)
{
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video, $matches);
    $video_id = $matches[1];
    return $video_id;
}


/* Adding favicon to admin pages */
function shady_add_favicon() {
    $favicon_url = image('theme/admin-favicon.png');
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon_url . '" />';
}
/* Adding custom logo to wp login page */
function shady_login_logo() {
    // get logo from theme settings
    $logo       = get_field('logo_img', 'option');
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $logo['url'];?>);
            height: 57px;
            min-width: 220px;
            width: 100%;
            background-size: contain;
            background-repeat: no-repeat;
            margin-bottom: 0px;
            pointer-events: none;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'shady_login_logo' );

// need to make sure that function runs when you're on the login page and admin pages
add_action('login_head', 'shady_add_favicon');
add_action('admin_head', 'shady_add_favicon');


// custom breadcrumbs
function get_custom_breadcrumbs()
{
    // Set variables for later use
    $here_text = __('You are currently here!');
    $home_link = home_url('/');
    $home_text = __('Home');
    $link_before = '<span typeof="v:Breadcrumb">';
    $link_after = '</span>';
    $link_attr = ' rel="v:url" property="v:title"';
    $link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter = ' &raquo; ';              // Delimiter between crumbs
    $before = '<span class="current">'; // Tag before the current crumb
    $after = '</span>';                // Tag after the current crumb
    $page_addon = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links = '';

    /**
     * Set our own $wp_the_query variable. Do not use the global variable version due to
     * reliability
     */
    $wp_the_query = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    // Handle single post requests which includes single pages, posts and attatchments
    if (is_singular()) {
        /**
         * Set our own $post variable. Do not use the global variable version due to
         * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
         */
        $post_object = sanitize_post($queried_object);

        // Set variables
        $title = apply_filters('the_title', $post_object->post_title);
        $parent = $post_object->post_parent;
        $post_type = $post_object->post_type;
        $post_id = $post_object->ID;
        $post_link = $before . $title . $after;
        $parent_string = '';
        $post_type_link = '';

        if ('post' === $post_type) {
            // Get the post categories
            $categories = get_the_category($post_id);
            if ($categories) {
                // Lets grab the first category
                $category = $categories[0];

                $category_links = get_category_parents($category, true, $delimiter);
                $category_links = str_replace('<a', $link_before . '<a' . $link_attr, $category_links);
                $category_links = str_replace('</a>', '</a>' . $link_after, $category_links);
            }
        }

        if (!in_array($post_type, ['post', 'page', 'attachment'])) {
            $post_type_object = get_post_type_object($post_type);
            $archive_link = esc_url(get_post_type_archive_link($post_type));

            $post_type_link = sprintf($link, $archive_link, $post_type_object->labels->singular_name);
        }

        // Get post parents if $parent !== 0
        if (0 !== $parent) {
            $parent_links = [];
            while ($parent) {
                $post_parent = get_post($parent);

                $parent_links[] = sprintf($link, esc_url(get_permalink($post_parent->ID)), get_the_title($post_parent->ID));

                $parent = $post_parent->post_parent;
            }

            $parent_links = array_reverse($parent_links);

            $parent_string = implode($delimiter, $parent_links);
        }

        // Lets build the breadcrumb trail
        if ($parent_string) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ($post_type_link)
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ($category_links)
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }

    // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
    if (is_archive()) {
        if (is_category()
            || is_tag()
            || is_tax()
        ) {
            // Set the variables for this section
            $term_object = get_term($queried_object);
            $taxonomy = $term_object->taxonomy;
            $term_id = $term_object->term_id;
            $term_name = $term_object->name;
            $term_parent = $term_object->parent;
            $taxonomy_object = get_taxonomy($taxonomy);
            $current_term_link = $before . $taxonomy_object->labels->singular_name . ': ' . $term_name . $after;
            $parent_term_string = '';

            if (0 !== $term_parent) {
                // Get all the current term ancestors
                $parent_term_links = [];
                while ($term_parent) {
                    $term = get_term($term_parent, $taxonomy);

                    $parent_term_links[] = sprintf($link, esc_url(get_term_link($term)), $term->name);

                    $term_parent = $term->parent;
                }

                $parent_term_links = array_reverse($parent_term_links);
                $parent_term_string = implode($delimiter, $parent_term_links);
            }

            if ($parent_term_string) {
                $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }

        } elseif (is_author()) {

            $breadcrumb_trail = __('Author archive for ') . $before . $queried_object->data->display_name . $after;

        } elseif (is_date()) {
            // Set default variables
            $year = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day = $wp_the_query->query_vars['day'];

            // Get the month name if $monthnum has a value
            if ($monthnum) {
                $date_time = DateTime::createFromFormat('!m', $monthnum);
                $month_name = $date_time->format('F');
            }

            if (is_year()) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif (is_month()) {

                $year_link = sprintf($link, esc_url(get_year_link($year)), $year);

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif (is_day()) {

                $year_link = sprintf($link, esc_url(get_year_link($year)), $year);
                $month_link = sprintf($link, esc_url(get_month_link($year, $monthnum)), $month_name);

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }

        } elseif (is_post_type_archive()) {

            $post_type = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object($post_type);

            $breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;

        }
    }

    // Handle the search page
    if (is_search()) {
        $breadcrumb_trail = __('Search query for: ') . $before . get_search_query() . $after;
    }

    // Handle 404's
    if (is_404()) {
        $breadcrumb_trail = $before . __('Error 404') . $after;
    }

    // Handle paged pages
    if (is_paged()) {
        $current_page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
        $page_addon = $before . sprintf(__(' ( Page %s )'), number_format_i18n($current_page)) . $after;
    }

    $breadcrumb_output_link = '';
    $breadcrumb_output_link .= '<div class="breadcrumb">';
    if (is_home()
        || is_front_page()
    ) {
        // Do not show breadcrumbs on page one of home and frontpage
        if (is_paged()) {
            $breadcrumb_output_link .= $here_text . $delimiter;
            $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
            $breadcrumb_output_link .= $page_addon;
        }
    } else {
        $breadcrumb_output_link .= $here_text . $delimiter;
        $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

    return $breadcrumb_output_link;
}

/* Remove wp editor in certain pages */
function shady_hide_editor() {
    if (is_admin()) {
        // check if post/page
        $screen = get_current_screen();
        /* if homepage editor removal is not required then add $screen->parent_base == 'edit' to the below if clause */
        if ($screen->base == 'post' && isset($_GET['post'])) {
            // Get the Post ID.
            $post_id = $_GET['post'];

            // Get the Post ID.
            // $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
            // if (!isset($post_id)) return;

            // Hide the editor on the page titled 'Home'
            /* $homepgname = get_the_title($post_id);
            if ($homepgname == 'Home'){
                remove_post_type_support('page', 'editor');
            } */

            // Hide the editor on a page with a specific page template
            // Get the name of the Page Template file.
            $template_file = get_post_meta($post_id, '_wp_page_template', true);

            // if ($template_file == 'templates/page-agency.php') { // the filename of the page template
            //     remove_post_type_support('page', 'editor');
            // }
        }
    }
}
add_action('current_screen', 'shady_hide_editor');


/*
** Adding bootstrap responsive oembed wrapper to videos added through the wp-editor
*/
function shady_embed_oembed_html( $cache, $url, $attr, $post_ID ) {
    $classes = array();
    // Add these classes to all embeds.
    $classes_all = array(
        'embed-responsive',
        'embed-responsive-16by9'
    );
    // Check for different providers and add appropriate classes.
    if (false !== strpos($url,'vimeo.com')) {
        $classes[] = 'vimeo';
    }

    if (false !== strpos($url, 'youtube.com')) {
        $classes[] = 'youtube';
    }

    $classes = array_merge( $classes, $classes_all );

    return '<div class="' . esc_attr( implode( $classes, ' ' ) ) . '">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'shady_embed_oembed_html', 99, 4);


/*
** Get placeholder image
*/
function placeholder_src($size) {
    $thumb      = get_field('placeholder_gen_img', 'option');
    $thumb_size = ($size) ? $size : 'thumbnail';

    return [
        'url'   => $thumb['sizes'][$size],
        'alt'   => $thumb['alt']
    ];
}
function product_placeholder($size) {
    $thumb      = get_field('placeholder_prod_img', 'option');
    $thumb_size = ($size) ? $size : 'thumbnail';

    return [
        'url'   => $thumb['sizes'][$size],
        'alt'   => $thumb['alt']
    ];
}


/*
** Limit classificazione taxonomy selection to one, by converting it to radio button instead of the usual checkboxes
*/
function shady_taxo_checktoradio(){
    echo '<script type="text/javascript">jQuery("#classificazione-pop input, #classificazionechecklist input, .cat-checklist.classificazione-checklist input").each(function(){this.type="radio"});</script>';
}

// add_action('admin_footer', 'shady_taxo_checktoradio');


/* Add css to iframe loaded page in visual composer */
// add_action( 'admin_enqueue_scripts', 'shady_visual_composer_override' );

function shady_visual_composer_override() {
    wp_enqueue_script('jeet-vc-override', get_template_directory_uri() . '/assets/js/jt_admin.js', array('jquery'), '1.0.0', true);
}


/* Modify asset names on wp upload */
/* function shady_modify_uploaded_file_names($file) {
    $info = pathinfo($file['name']);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($file['name'], $ext);

    $file['name'] = $name . '_adsolut_web_agency_napoli' . $ext; // uniqid method
    // $file['name'] = md5($name) . $ext; // md5 method
    // $file['name'] = base64_encode($name) . $ext; // base64 method
    return $file;
} */
// add_filter('wp_handle_upload_prefilter', 'shady_modify_uploaded_file_names', 1, 1);



/* To fix pagination and permalink structure of portfolio posts */
/* to fix portfolio archive page pagination, TODO: replace portfolio with required post type */
function no_canonical($url) {
    return false;
}

function adjust_show_request($request) {
    if ($request->query_vars['post_type'] === 'portfolio' && $request->is_singular === true && $request->current_post == -1 && $request->is_paged === true) {
        add_filter('redirect_canonical', 'no_canonical');
    }
    return $request;
}
// add_action('parse_query', 'adjust_show_request');

// to have archive page same permalink as that of the cpt archvie.
// add_rewrite_rule('^portfolio/page/([0-9]+)','index.php?pagename=portfolio&paged=$matches[1]', 'top');


/* To add custom taxonomy in the url of CPT */
// here the taxonmy is called servizi - change accordingly
function shady_custom_portfolio_post_link( $post_link, $id = 0 ) {
    $post = get_post($id);
    if ( is_object( $post ) ){
        $terms = wp_get_object_terms( $post->ID, 'servizi' );
        if( $terms ){
            return str_replace( '%servizi%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}
// add_filter('post_type_link', 'shady_custom_portfolio_post_link', 1, 3);


/* Limit post revisions */
add_filter('wp_revisions_to_keep', 'shady_wp_revisions_to_keep', 10, 2 );

function shady_wp_revisions_to_keep( $num, $post ) {
    // can be set for certain post types
    // if( 'custom_post_type' == $post->post_type ) {
	//     $num = 5;
    // }
    $num = 1;
    return $num;
}


// prevent pages from being displayed in the search results
function shady_exclude_posts_from_search( $query ) {
    if ( $query->is_search && $query->is_main_query() ) {
        $query->set( 'post__not_in', array( 79 ) );
    }
}

add_action( 'pre_get_posts', 'shady_exclude_posts_from_search' );



/* 
** Fix missing serialized theme options or any other data after migration 
*1: first target the entry eg, 'framework_options' is in wp_option table 
*2: do the preg replace for the entry
*3: save it back after unserializing so that wp fixes the serilization issue
*/
// add_action('init', 'shady_fix_serizliztion_issues');

function shady_fix_serizliztion_issues() {
    $query = "SELECT * FROM wp_options WHERE option_name = 'framework_options'";
    $result = $wpdb->get_results($query);

    // either this 
    $options = get_option( 'framework_options' );
    // or this 
    $data = $result[0]->option_value;
    /* for php5 based systems */
    // $data = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $data);

    /* for php7 based systems */
    $data = preg_replace_callback(
    '!(?<=^|;)s:(\d+)(?=:"(.*?)";(?:}|a:|s:|b:|i:|o:|N;))!s',
    function ($match) { return 's:' . strlen($match[2]); },
    $data );

    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';

    // echo '<pre>';
    // var_dump($result[0]->option_value);
    // echo '</pre>';

    update_option( 'accesspress_parallax_pro', maybe_unserialize($data) );

    // now everything should work peacefully
}

/* move metaboxes to bottom */
add_filter( 'wpseo_metabox_prio', function() {
    return 'low';
}, 10 );

// remove the unwanted html from cf7 
add_filter('wpcf7_autop_or_not', '__return_false');