<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>



<div class="account-login-wrap">
	<div class="row justify-content-center align-items-center" id="customer_login">
	
		<div class="col-12 col-md-5 col-xl-4">
			<div class="social-login">
				<?php echo do_shortcode('[TheChamp-Login title="Login with your Social Networks" redirect_to="?login=success"]');?>
			</div>
		</div>
	
		<div class="col-12 col-md-1 col-xl-2">
			<div class="social-login-or w-100">
				<h6 class="text-bold text-center mb-0"> - OR - </h6>
			</div>
		</div>
	
		<div class="col-12 col-md-5 col-xl-4">
			<div class="login-registration">
				<ul class="nav nav-tabs" id="shadyLoginRegn" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="shady-login-tab" data-bs-toggle="tab" data-bs-target="#shady-login-tab-pane"
							type="button" role="tab" aria-controls="shady-login-tab-pane" aria-selected="true">Login</button>
					</li>
					<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="shady-regn-tab" data-bs-toggle="tab" data-bs-target="#shady-regn-tab-pane"
							type="button" role="tab" aria-controls="shady-regn-tab-pane" aria-selected="false">Register</button>
					</li>
					<?php endif; ?>
				</ul>
				<div class="tab-content" id="shadyLoginRegnContent">
					<div class="tab-pane fade show active" id="shady-login-tab-pane" role="tabpanel" aria-labelledby="shady-login-tab" tabindex="0">
						<form class="woocommerce-form woocommerce-form-login login" method="post">	
							<?php do_action( 'woocommerce_login_form_start' ); ?>
	
							<div class="form-group">
								<label class="form-label" for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							</div>
							<div class="form-group">
								<label class="form-label" for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
								<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password" autocomplete="current-password" />
							</div>
	
							<?php do_action( 'woocommerce_login_form' ); ?>
	
							<div class="form-row">
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
									<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
								</label>
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<div class="w-100"></div>
								<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
							</div>
							<div class="woocommerce-LostPassword lost_password">
								<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
							</div>
	
							<?php do_action( 'woocommerce_login_form_end' ); ?>
	
						</form>
					</div>
	
					<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
					<div class="tab-pane fade" id="shady-regn-tab-pane" role="tabpanel" aria-labelledby="shady-regn-tab" tabindex="0">
						<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
	
							<?php do_action( 'woocommerce_register_form_start' ); ?>
	
							<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
	
								<div class="form-group">
									<label class="form-label" for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
								</div>
	
							<?php endif; ?>
	
							<div class="form-group">
								<label class="form-label" for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
								<input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							</div>
	
							<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
	
								<div class="form-group">
									<label class="form-label" for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
									<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" autocomplete="new-password" />
								</div>
	
							<?php else : ?>
	
								<p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>
	
							<?php endif; ?>
	
							<?php do_action( 'woocommerce_register_form' ); ?>
	
							<div class="woocommerce-form-row form-row">
								<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
								<button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
							</div>
	
							<?php do_action( 'woocommerce_register_form_end' ); ?>
	
						</form>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
