jQuery(document).ready(function($){

	var Facebook = {

		$buttonClicked: '',

		init: function(){

			var tries = 0;

			var runned = setInterval( function(){

				if( window.FB ){
					clearInterval(runned);
					Facebook.run();
				}

				if( tries >= 20 ){
					clearInterval(runned);
				}

				tries++;

			}, 500  );



		},

		run: function(){

			FB.init({
				appId 		: xoo_sl_localize.facebook.app_id,
				cookie 		: true,
				xfbml 		: true,
				status		: true,
				version 	: 'v16.0',
			});
      
			FB.AppEvents.logPageView();
			
			Facebook.configureButton();


		},

		configureButton(){

			$(document.body).on( 'click', '.xoo-sl-btn-facebook', function(e){
				Facebook.processLoginOnClick( $(this) );
			});

		},

		processLoginOnClick($button){

			FB.login(function(response) {

				if (response.status === 'connected') {
					// Logged into your webpage and Facebook.
					Processor.init( response, 'facebook', $button);
				} 

			}, {scope: 'public_profile,email', auth_type: 'rerequest'});
		},


	}

	if( xoo_sl_localize.facebook.enable === "yes" ){
		Facebook.init();
	}

	var Apple = {

		$buttonClicked: '',

		init: function(){

			var tries = 0;

			var runned = setInterval( function(){

				if( window.AppleID ){
					clearInterval(runned);
					Apple.run();
				}

				if( tries >= 20 ){
					clearInterval(runned);
				}

				tries++;

			}, 500  );

		},

		run: function(){

			AppleID.auth.init(xoo_sl_localize.apple.initArgs);

			if( !$('.xoo-sl-apple-login-btn > div').length ) return;

			var originalButtonHTML = $('.xoo-sl-apple-login-btn > div').parent().html();

			$('.xoo-sl-apple-login-btn').each(function(index, el){
				var $el = $(el);
				
				$el.html(originalButtonHTML);
				$el.on('click', function(){
					Apple.$buttonClicked = $el;
					AppleID.auth.signIn();
				})
				
			})
		
			$(document).on('AppleIDSignInOnSuccess', Apple.onLoginSuccess );
			
		},

		onLoginSuccess: function(e){
			console.log(e);
			Processor.init( e.detail, 'apple', Apple.$buttonClicked );
		}

	}

	if( xoo_sl_localize.apple.enable === "yes" ){
		Apple.init();
	}




	var Google = {

		$buttonClicked: '',


		init: function(){

			var tries = 0;

			var runned = setInterval( function(){

				if( window.google ){
					clearInterval(runned);
					Google.run();
				}

				if( tries >= 20 ){
					clearInterval(runned);
				}

				tries++;

			}, 500  );

		},

		run: function(){

			google.accounts.id.initialize({
				client_id: xoo_sl_localize.google.client_id,
				callback: Google.callback
			});

			Google.renderButtons();
		},


		renderButtons: function(){

			var buttonParams = xoo_sl_localize.google.button;

			$('.xoo-sl-goo-btn').each(function( index, el ){

				buttonParams.click_listener = function(){
					Google.$buttonClicked = $(el);
				}

				google.accounts.id.renderButton(
					el,
					xoo_sl_localize.google.button
				);
			})
		},

		callback: function(response){
			Processor.init( response, 'google', Google.$buttonClicked );
		},

		

	}

	if( xoo_sl_localize.google.enable === "yes" ){
		Google.init();
	}

	var Processor = {

		social: '',
		$button: '',
		$buttonContainer: '',
		$easyLoginSection: '',
		$easyLoginContainer: '',
		$loader: '',
		isEasyLogin: '',


		init: function( socialData, socialType, $button ){

			Processor.$button 				= $button;
			Processor.$buttonContainer 		= $button.parents('.xoo-sl-container');
			Processor.$easyLoginSection 	= $button.parents('.xoo-el-section');
			Processor.isEasyLogin 			= Processor.$easyLoginSection.length;
			Processor.$easyLoginContainer 	= Processor.$easyLoginSection.parents('.xoo-el-form-container');
			Processor.$loader 				= Processor.$buttonContainer.find('.xoo-sl-processing');


			Processor.$buttonContainer.find('.xoo-sl-processing').show();

			$.ajax({
		        url: xoo_sl_localize.adminurl,
		        type: 'POST',
		        data: {
		          action: 'xoo_sl_process_social_response',
		          socialData: socialData,
		          socialType: socialType,
		          isEasyLogin: Processor.$easyLoginSection.length ? 'yes' : 'no'
		        },
		        success: function(response){

		        	if( response.success === 'false' && response.message ){
		        		$('.xoo-sl-notice-container').html(response.message);
		        		Processor.loader.hide();
		        	}

		        	if( response.success === "true" ){

		        		Processor.$loader.find('span').text( response.message )

		        		var redirectTo = xoo_sl_localize.redirect_to;		

		        		if( Processor.isEasyLogin && Processor.$easyLoginSection.find('input[name="xoo_el_redirect"]').length ){
		        			redirectTo = Processor.$easyLoginSection.find('input[name="xoo_el_redirect"]').val();
		        		}

		        		window.location = redirectTo;
		        	}

		        	if( response.register && response.register === "yes" ){
		        		Processor.forceRegister( response.userData );
		        	}

		        	$(document).trigger('xoo_sl_processing_userinfo',[response]);
		        }
		    });
		},


		forceRegister: function( userData ){

			Processor.$loader.hide();

    		var $registrationSection = Processor.$easyLoginContainer.find('[data-section="register"]');

    		if( !$registrationSection.length ){
    			$registrationSection = $('.xoo-el-form-popup').find('[data-section="register"]');
    			if( !$registrationSection.length ){
    				alert('no registration form found.');
    				return;
    			}
    			$('.xoo-el-forcereg-tgr').trigger('click'); //open popup
    		}

    		Processor.$easyLoginContainer.find('.xoo-el-forcereg-tgr').trigger('click');

    		var $email 		= $('.xoo-el-form-container input[name="xoo_el_reg_email"]'),
				$firstName 	= $('.xoo-el-form-container input[name="xoo_el_reg_fname"]'),
				$lastName 	= $('.xoo-el-form-container input[name="xoo_el_reg_lname"]');

			if( $email.length ) $email.val(userData.email);

			if( $firstName.length ) $firstName.val(userData.first_name);

			if( $lastName.length ) $lastName.val(userData.last_name);

			$registrationSection.find('.xoo-el-notice').html(xoo_sl_localize.fillFieldsNotice).show();
		}

	}

	$('body').on( 'click', '.xoo-sl-btn-x', function(){

		var redirectTo 		= xoo_sl_localize.redirect_to,
			$easyLoginCont 	= $(this).closest('.xoo-el-form-container');

		if( $easyLoginCont.length && $easyLoginCont.find('input[name="xoo_el_redirect"]').length ){
			redirectTo = $easyLoginCont.find('input[name="xoo_el_redirect"]').val();
		}

		document.cookie = 'xoo_sl_redirect='+redirectTo+'; path=/';
	} );
 	

})
