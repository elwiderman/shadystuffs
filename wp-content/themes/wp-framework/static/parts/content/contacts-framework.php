<section class="single-page single-contact">
    <div class="container">
        <!-- content-section -->
        <div class="the-post">
            <div class="content">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="title-area text-center">
                            <h1><?php _e('Want to know more?', 'shady'); ?></h1>
                            <p class="lead"><?php _e('Fill the form below, we will contact you as soon as possible

', 'shady'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">

                        <div class="form-area contact-form">
                            <?= do_shortcode('[contact-form-7 id="23" title="Contact form"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- !.content-section -->
    </div>
</section>

<div class="clearfix"></div>

<?php
/* PASTE IN CONTACT PLUGIN
<div class="row">
	<div class="small-12 medium-6 columns">
		[text* name placeholder "Il tuo nome"]
	</div>
	<div class="small-12 medium-6 columns">
		[email* email placeholder "La tua email"]	
	</div>
	<div class="small-12 medium-12 columns">
		[textarea message  placeholder "Il tuo messaggio"]
	</div>
	<div class="small-12 medium-12 columns">
		[submit class:button "Invia Messaggio"]
	</div>
</div>*/
?>