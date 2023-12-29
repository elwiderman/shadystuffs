<?php
/*
	Template name: Page Contact Us
*/
get_header();

$phone          = get_field('phone');
$whatsapp       = get_field('whatsapp');
$email          = get_field('email');
$form           = get_field('form_shortcode');
?>
<div class="single-page single-contact">
    <section class="section-block section-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title"><?php the_title();?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block section-contact">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="content-wrap">
                        <address><?php the_content();?></address>
                        <?php
                        if ($phone) :
                            $no_space_phone = str_replace(' ', '', $phone);
                            echo "
                            <div class='content-wrap__links'>
                                <i class='icon-phone-call'></i>
                                <a href='tel:{$no_space_phone}' target='_blank'>{$phone}</a>
                            </div>
                            ";
                        endif;
                        if ($whatsapp) :
                            echo "
                            <div class='content-wrap__links'>
                                <i class='icon-whatsapp'></i>
                                <a href='{$whatsapp}' target='_blank'>{$phone}</a>
                            </div>
                            ";
                        endif;
                        if ($email) :
                            echo "
                            <div class='content-wrap__links'>
                                <i class='icon-mail'></i>
                                <a href='mailto:{$email}' target='_blank'>{$email}</a>
                            </div>
                            ";
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="form-area form-contact">
                        <?php echo do_shortcode($form);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
/*
<div class="form-group">
    [text* fullname class:form-control id:fullname placeholder "Name *"]
</div>
<div class="form-group">
    [email* uemail class:form-control id:uemail placeholder "Email *"]
</div>
<div class="form-group form-radio">
    <label for="shadySubject" class="form-label">Subject *</label>
    [radio subject id:shadySubject class:form-radio-elem use_label_element "Bulk / Corporate orders" "Grievances" "Everything else..."]
</div>
<div class="form-group">
    [textarea* message class:form-control id:message placeholder "Message *"]
</div>
<div class="form-submit d-flex justify-content-center justify-content-lg-end align-items-center">
    <div class="wpcf7-spinner"></div><button class="btn-main wpcf7-submit d-inline-flex" type="submit">Send</button>
</div>
*/