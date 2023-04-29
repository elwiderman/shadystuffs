<?php
// mailchimp widget
class JeetMailchimpWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'jeet_mailchimp_widget', // base ID of widget
            __('Jeetlab Mailchimp', 'jtlb'), // widget name
            array('description' => __('Displays the Mailchimp form using the shortcode in the widget area.', 'jtlb'))
        );
    }

    // widget frontend
    public function widget($args, $instance) {
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // the output in the website
        if (!empty($instance['shortcode'])) {
            echo '<div class="form-area">';
            echo do_shortcode($instance['shortcode']);
            echo '</div>';
        }

        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {
        if ( isset($instance['title']) ) {
            $title = $instance['title'];
            $shortcode = $instance['shortcode'];
        }
        else {
            $title = __('Subscribe for Newsletter', 'jtlb');
        }

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'jtlb');?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('shortcode'); ?>"><?php _e('Shortcode', 'jtlb'); ?> <span class="requried">*</span>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('shortcode'); ?>" name="<?php echo $this->get_field_name('shortcode'); ?>" type="text" value="<?php echo esc_attr($shortcode); ?>" required/>
        </p>
        <p><small><em><?php _e('Enter the title to display as the title of the widget area. Copy the shortcode from Mailchimp for Wordpress plugin options.', 'jtlb');?></em></small></p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['shortcode'] = ( ! empty( $new_instance['shortcode'] ) ) ? strip_tags( $new_instance['shortcode'] ) : '';
        return $instance;
    }
} // class ends here



// about me widget
class JeetAboutMeWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'jeet_about_me_widget', // base ID of widget
            __('Jeetlab About Me', 'jtlb'), // widget name
            array('description' => __('Displays the excerpt form about me page in the widget area.', 'jtlb'))
        );
    }

    // widget frontend
    public function widget($args, $instance) {
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // the output in the website
        $post_args = array(
            'pagename'       => 'about-me',
            'posts_per_page' => 1
        );
        $about_query = new WP_Query($post_args);
        if ($about_query->have_posts()) :
            while ($about_query->have_posts()) : $about_query->the_post();
                list(
                    $about_txt,
                    $about_img
                ) = array(
                    wpautop(strip_shortcodes(get_the_content('', TRUE))),
                    get_the_post_thumbnail_url(get_the_ID(), 'square') ? get_the_post_thumbnail_url(get_the_ID(), 'square') : placeholder_src('square'),
                );

                echo <<<ABT
                <div class="about-wrap">
                    <div class="about-image">
                        <img class="img-fluid" src="{$about_img}">
                    </div>
                    <div class="about-txt">{$about_txt}</div>
                </div>
ABT;
            endwhile;
        endif;
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {
        if ( isset($instance['title']) ) {
            $title = $instance['title'];
        }
        else {
            $title = __('About me', 'jtlb');
        }

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'jtlb');?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

} // class ends here



// popular posts widget
class JeetPopularPostsWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'jeet_popular_posts_widget', // base ID of widget
            __('Jeetlab Popular Posts', 'jtlb'), // widget name
            array('description' => __('Displays the most post popular posts form about me page in the widget area.', 'jtlb'))
        );
    }

    // widget frontend
    public function widget($args, $instance) {
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // the output in the website
        $post_args = array(
            'post_type'      => 'post',
            'posts_per_page' => $instance['post_per_page'],
            'meta_key'       => 'jeet_post_views_count',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC'
        );
        $popular_query = new WP_Query($post_args);
        if ($popular_query->have_posts()) :
            echo '<ul class="post-lists">';
            while ($popular_query->have_posts()) : $popular_query->the_post();
                list(
                    $post_name,
                    $permalink,
                    $post_date,
                    $post_image
                ) = array(
                    get_the_title(),
                    get_the_permalink(),
                    get_the_date('F j, Y'),
                    get_the_post_thumbnail_url(get_the_ID(), 'small-thumb') ? get_the_post_thumbnail_url(get_the_ID(), 'small-thumb') : placeholder_src('small-thumb'),
                );

                echo <<<LIST
                    <li class="row no-gutters post-wrap">
                        <a class="col-4 post-image" href="{$permalink}">
                            <img class="img-fluid" src="{$post_image}">
                        </a>
                        <div class="col-8 post-content">
                            <h5 class="title"><a href="{$permalink}">{$post_name}</a></h5>
                            <p class="date">{$post_date}</p>
                        </div>
                    </li>
LIST;
            endwhile;
            echo '</ul>';
        endif;
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {

        $title = (isset($instance['title'])) ? $instance['title'] : __('Popular Posts', 'jtlb');
        $post_per_page = (isset($instance['post_per_page'])) ? $instance['post_per_page'] : 5;

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'jtlb');?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_per_page'); ?>"><?php _e('Number of posts to be displayed', 'jtlb');?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('post_per_page'); ?>" name="<?php echo $this->get_field_name('post_per_page'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($post_per_page); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['post_per_page'] = (!empty( $new_instance['post_per_page'])) ? strip_tags($new_instance['post_per_page']) : '';
        return $instance;
    }
}


// youtube/vimeo recent video widget
class JeetRecentVideoWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'jeet_recent_video_widget', // base ID of widget
            __('Jeetlab Recent Video', 'jtlb'), // widget name
            array('description' => __('Displays a custom video thumbnail in the sidebar widget area which opens in modal on clicking.', 'jtlb'))
        );
    }

    // widget frontend
    public function widget($args, $instance) {
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $video_url = $instance['video_url'];

        $video_btn = '';

        if ($video_url) {
            if (strpos($video_url, 'vimeo') !== false) {
                $video_id = vimeo_id($video_url);
                $video_embed = 'https://player.vimeo.com/video/' . $video_id;
                $video_type = 'vimeo';
            } else {
                $video_id = youtube_id($video_url);
                $video_embed = 'https://www.youtube.com/embed/' . $video_id . '?&rel=0&showinfo=1&iv_load_policy=3&modestbranding=1';
                $video_type = 'youtube';
            }
        }
        $image = (isset($instance['image_id'])) ? wp_get_attachment_image_src($instance['image_id'], 'gallery')[0] : placeholder_src('gallery');
        ?>
        <!-- trigger modal -->
        <a href="#" class="d-block modal-trigger" data-toggle="modal" data-target="#sidebarVideoModal" data-video="<?php echo $video_embed;?>" data-type="<?php echo $video_type;?>">
            <img class="img-fluid" src="<?php echo $image;?>">
            <div class="overlay">
                <i class="far fa-play-circle"></i>
            </div>
        </a>

        <!-- Modal -->
        <div class="modal fade" id="sidebarVideoModal" tabindex="-1" role="dialog" aria-labelledby="sidebarVideoModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="<?php echo $video_embed;?>" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // end widget
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {
        $title = (isset($instance['title'])) ? $instance['title'] : __('Recent Video', 'jtlb');
        $video_url = ($instance['video_url']) ? $instance['video_url'] : '';
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'jtlb');?><span class="requried">*</span> :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('video_url'); ?>"><?php _e('Youtube/Vimeo Url', 'jtlb');?><span class="requried">*</span> :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('video_url'); ?>" name="<?php echo $this->get_field_name('video_url'); ?>" type="url" value="<?php echo esc_attr($video_url); ?>"/>
            <small class="text-muted"><em><?php _e('Insert the URL of the video from youtube or vimeo and paste here.', 'jtlb');?></em></small>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image_id'); ?>">Placeholder Image:</label>
            <?php
                echo '<img class="jeet_widget_media_image" src="' . wp_get_attachment_image_src($instance['image_id'])[0] . '" style="margin:0;padding:0;max-width:150px;display:inline-block" />';
            ?>

            <input type="hidden" class="widefat jeet_widget_media_button_image_id" name="<?php echo $this->get_field_name('image_id'); ?>" id="<?php echo $this->get_field_id('image_id'); ?>" value="<?php echo esc_attr($instance['image_id']); ?>">

            <input type="button" class="button button-primary jeet_widget_media_button" id="jeet_widget_media_button" name="<?php echo $this->get_field_name('image_id'); ?>" value="Upload Image" style="margin-top:5px;" />

            <small class="text-muted" style="float:left;"><em><?php _e('This image acts as the placeholer for triggering the video.', 'jtlb');?></em></small>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['video_url'] = (!empty( $new_instance['video_url'])) ? strip_tags($new_instance['video_url']) : '';
        $instance['image_id'] = (!empty( $new_instance['image_id'])) ? strip_tags($new_instance['image_id']) : '';
        return $instance;
    }
}


/* =========================================================================================================== */
add_action('widgets_init', function () {
    // about me widget
    register_widget('JeetAboutMeWidget');

    // register the mailchimp widget only if mailchimp plugin exsits
    if (function_exists('mc4wp'))
    register_widget('JeetMailchimpWidget');

    // popular posts
    register_widget('JeetPopularPostsWidget');

    // recent video
    register_widget('JeetRecentVideoWidget');
});