<?php
/* THEME OPTIONS
------------------------------------*/
if (is_admin()) : // Load only if we are viewing an admin page

    // Default options values
    $framework_options = array(
        'yoast_keyword_active' => '',
        'placeholder_id' => '',
        'social_urls' => array(
            'fa-facebook' => '',
            'fa-twitter' => '',
            'fa-google' => '',
            'fa-instagram' => '',
            'fa-linkedin' => '',
        ),
        'intro_text' => '',
        'featured_cat' => '',
        'contact_info' => array(
            'fa-address' => '',
            'fa-email' => '',
            'fa-telephone' => '',
            'fa-mobile' => '',
            'fa-fax' => '',
            'fa-timings' => '',
        ),
        'extra_config' => array(
            'blog_post_per_page' => '',
            'map_api' => '',
            'map_latitude' => '',
            'map_longitude' => '',
            'map_infowindow' => ''
        ),
    );

    // Add theme options page to the addmin menu
    function framework_theme_options()
    {
        add_theme_page('Theme options', 'Theme options', 'edit_theme_options', 'theme_options', 'framework_theme_options_page');
    }

    add_action('admin_menu', 'framework_theme_options');


    // Loading bootstrap in the options page
    function bootstrap_load($hook)
    {
        if ('appearance_page_theme_options' != $hook) {
            return;
        }

        wp_enqueue_media();

        wp_enqueue_script('admin-scripts', get_template_directory_uri() . '/assets/scripts/admin.min.js', '', '', false);
        wp_enqueue_style('admin-css', get_template_directory_uri() . '/assets/css/admin.min.css', array(), '', 'all');
    }

    add_action('admin_enqueue_scripts', 'bootstrap_load');


// Register settings and call sanitation functions
    function framework_register_settings()
    {
        register_setting('framework_theme_options', 'framework_options', 'framework_validate_options');
    }

    add_action('admin_init', 'framework_register_settings');


// Function to generate options page
    function framework_theme_options_page()
    {
        global $framework_options;
        if (!isset($_REQUEST['updated'])) {
            $_REQUEST['updated'] = false; // This checks whether the form has just been submitted.
        } ?>
        <div class="wrap theme-options-page" xmlns="http://www.w3.org/1999/html">

            <h2 class="page-title"><?php echo __('Theme Options', 'jtlb'); ?></h2>

            <div class="options-tabs">

                <form method="post" action="options.php">

                    <?php
                    $settings = get_option('framework_options', $framework_options);
                    settings_fields('framework_theme_options');
                    ?>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active nav-item">
                            <a href="#general" aria-controls="general" role="tab" data-toggle="tab"
                               class="nav-link show active">
                                <?php echo __('General Configuration', 'jtlb'); ?>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#social" aria-controls="social" role="tab" data-toggle="tab" class="nav-link">
                                <?php echo __('Social', 'jtlb'); ?>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" class="nav-link">
                                <?php echo __('Contact Information', 'jtlb'); ?>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#extra" aria-controls="extra" role="tab" data-toggle="tab" class="nav-link">
                                <?php echo __('Extra Configuration', 'jtlb'); ?>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in show active" id="general">
                            <!-- general config -->
                            <div class="">
                                <div class="form-group row">
                                    <label class="col-md-2">Placeholder Image</label>
                                    <div class="col-md-2">
                                        <img class="placeholder text-left img-fluid"
                                             src="<?php $src = wp_get_attachment_image_src($settings['placeholder_id']);
                                             echo $src[0]; ?>"/>

                                    </div>
                                    <div class="col-md-2">
                                        <input class="placeholder_id" type="hidden"
                                               name="framework_options[placeholder_id]"
                                               value="<?php echo $settings['placeholder_id']; ?>">
                                        <a href="#" class="btn btn-primary placeholder_upload">Upload</a>
                                    </div>
                                </div>
                            </div>
                            <!-- !.general config -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="social">
                            <!-- social urls -->
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($framework_options['social_urls'] as $key => $value): ?>
                                        <div class="form-group row">
                                            <label
                                                class="col-md-2"><?php echo strtoupper(str_replace('fa-', '', $key)); ?></label>

                                            <div class="col-md-4">
                                                <?php
                                                if (!isset($settings['social_urls'][$key])) {
                                                    $settings['social_urls'][$key] = '';
                                                }
                                                ?>
                                                <textarea name="framework_options[social_urls][<?php echo $key; ?>]"
                                                          class="form-control"><?php echo stripslashes($settings['social_urls'][$key]); ?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- !.social urls -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="contact">
                            <!-- contact info -->
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($framework_options['contact_info'] as $key => $value):
                                        ?>
                                        <div class="form-group row">
                                            <label class="col-md-2">
                                                <?php echo strtoupper(str_replace('fa-', '', $key));
                                                ?>
                                            </label>
                                            <div class="col-md-4">
                                                <?php
                                                if (!isset($settings['contact_info'][$key])) {
                                                    $settings['contact_info'][$key] = '';
                                                }
                                                ?>
                                                <textarea name="framework_options[contact_info][<?php echo $key; ?>]"
                                                          class="form-control"><?php echo stripslashes($settings['contact_info'][$key]); ?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    ?>
                                </div>
                            </div>
                            <!-- !.contact info -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="extra">
                            <!-- extra config -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- <div class="form-group row">
                                        <label class="col-md-2">Events archive Image</label>
                                        <div class="col-md-2">
                                            <img class="events_header_image text-left img-fluid"
                                                 src="<?php //$src = wp_get_attachment_image_src($settings['extra_config']['events_header_image']);
                                                 //echo $src[0]; ?>"/>

                                        </div>
                                        <div class="col-md-2">
                                            <input class="events_header_image_id" type="hidden"
                                                   name="framework_options[extra_config][events_header_image]"
                                                   value="<?php //echo $settings['extra_config']['events_header_image']; ?>">
                                            <a href="#" class="btn btn-primary btn-sm events_header_image_upload">Upload</a>
                                        </div>
                                    </div> -->

                                    <div class="form-group row">
                                        <label class="col-md-2">
                                            <?php echo __('Posts Per Page Override', 'jtlb'); ?>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="number" min="1" class="form-control"
                                                   name="framework_options[extra_config][blog_post_per_page]"
                                                   value="<?php echo stripslashes($settings['extra_config']['blog_post_per_page']); ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-2">
                                            <?php echo __('Google map API key', 'jtlb'); ?>
                                        </label>
                                        <div class="col-md-4">
                                            <textarea name="framework_options[extra_config][map_api]"
                                                      class="form-control"><?php echo stripslashes($settings['extra_config']['map_api']); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2">
                                            <?php echo __('Latitude', 'jtlb'); ?>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                   name="framework_options[extra_config][map_latitude]"
                                                   value="<?php echo stripslashes($settings['extra_config']['map_latitude']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2">
                                            <?php echo __('Longitude', 'jtlb'); ?>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                   name="framework_options[extra_config][map_longitude]"
                                                   value="<?php echo stripslashes($settings['extra_config']['map_longitude']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2">
                                            <?php echo __('Map Infowindow', 'jtlb'); ?>
                                        </label>
                                        <div class="col-md-4">
                                            <textarea name="framework_options[extra_config][map_infowindow]"
                                                      class="form-control"><?php echo stripslashes($settings['extra_config']['map_infowindow']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- !.extra config -->
                        </div>
                    </div>


                    <div class="submit">
                        <input type="submit" class="btn btn-primary" value="Save Options"/>
                    </div>
                </form>
            </div>


            <?php if (false !== $_REQUEST['updated']) : ?>
                <div class="updated fade">
                    <p>
                        <strong><?php _e('Options saved', 'jtlb'); ?></strong>
                    </p>
                </div>
            <?php endif; // If the form has just been submitted, this shows the notification
            ?>

        </div>
        <script>
            jQuery(document).ready(function ($) {
                $('.placeholder_upload').click(function (e) {
                    e.preventDefault();
                    var custom_uploader = wp.media({
                        title: 'Custom Image',
                        button: {
                            text: 'Upload Image'
                        },
                        multiple: false  // Set this to true to allow multiple files to be selected
                    })
                        .on('select', function () {
                            var attachment = custom_uploader.state().get('selection').first().toJSON();
                            console.log(attachment);
                            $('.placeholder').attr('src', attachment.url);
                            $('.placeholder_id').val(attachment.id);
                        })
                        .open();
                });
                $('.events_header_image_upload').click(function (e) {
                    e.preventDefault();
                    var custom_uploader = wp.media({
                        title: 'Custom Image',
                        button: {
                        text: 'Upload Image'
                        },
                        multiple: false  // Set this to true to allow multiple files to be selected
                    })
                    .on('select', function () {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        console.log(attachment);
                        $('.events_header_image').attr('src', attachment.url);
                        $('.events_header_image_id').val(attachment.id);
                    })
                    .open();
                 });
            });
        </script>
        <?php
    }


//Prima di salvare controllo valori passati....
    function framework_validate_options($input)
    {
        global $framework_options, $liquid_categories;

        //$settings = get_option( 'framework_options', $framework_options );
        $input['analytics'] = wp_filter_post_kses($input['analytics']);
        $input['placeholder_id'] = wp_filter_post_kses($input['placeholder_id']);
        foreach ($framework_options['social_urls'] as $key => $value):
            $input['social_urls'][$key] = wp_filter_post_kses($input['social_urls'][$key]);
        endforeach;

        return $input;
    }


endif;  // EndIf is_admin()

?>
