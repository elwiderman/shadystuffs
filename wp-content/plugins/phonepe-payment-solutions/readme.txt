=== PhonePe Payment Solutions === 
Contributors: PhonePe Team
Tags: PhonePe, PhonePe Payments, PayWithPhonePe, PhonePe WooCommerce, PhonePe Plugin, PhonePe Payment Gateway
Requires PHP: 8.2 or later
Plugin Name: PhonePe Payment Solutions
Authors: PhonePe
Tested up to: 6.7
Stable tag: 3.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Using this plugin you can accept payments through PhonePe. After activating this plugin, you can see the PhonePe option linked to the checkout page of woocommerce site. On configuring with the provided Merchant credentials, you can enable this plugin in Preprod/Production environment.

== Compatibilities and Dependencies ==
- WordPress v5.4.1 or higher
- WooCommerce v4.14 or higher
- PHP v8.2 or higher (For lower PHP versions, please download plugin version v2.0.11 from the [Advanced View](https://wordpress.org/plugins/phonepe-payment-solutions/advanced/) section.)

== Getting Started == 

New to PhonePe Payment Gateway? Follow the below steps to access PhonePe Merchant Dashboard.

== Registration and Login ==
- Check your registered email ID for an email from no-reply@phonepe.com with the subject line: "PhonePe dashboard access - ". This email contains a link to the login page.
- Click the link and enter your registered Email ID or phone number.
- You can log in using either the OTP option or by setting up a password via the Forgot Password option.

Note: PhonePe will provide Merchant ID, Client ID, and Client Secret for both test and live modes. No money is deducted from your account in test mode.
If you haven’t registered yet, you can [sign up](https://business.phonepe.com/register?utm_source=plugin_website_woocommerce) here.

== Plugin Installation == 

There are 2 ways of installing the PhonePe payment gateway plugin:-
i)  Download the plugin repository from https://wordpress.org/plugins/phonepe-payment-solutions/
            OR
ii) Install the plugin directly from the Wordpress dashboard

Note: In case you have installed the plugin directly from the wordpress dashboard, skip to Configuration. In case you have downloaded the repository from here, follow the steps below to complete the installation.

== Steps after downloading the plugin ==

* Unzip and open the downloaded folder.
* Upload all plugin files in "wp-content/plugins/" directory
* Install and activate the plugin from Wordpress admin panel
* Visit the WooCommerce > Settings page to configure PhonePe Payment Solutions
* Your PhonePe Payment Gateway plugin is now setup. You can now accept payments through PhonePe.

== Configuration ==

1. Activate the Plugin
    - Log into your WordPress admin and activate the PhonePe Payment Solutions plugin in the WordPress Plugin Manager.

2. Configure WooCommerce Settings
    - Log into your WooCommerce Webstore account.
    - Navigate to Settings → Checkout/Payment Gateways tab.
    - Scroll down to the Checkout page and go to the PhonePe Payment Solutions settings under Gateway Display.
    - Click on PhonePe Payment Solutions to edit the settings.
    - If PhonePe is not listed, ensure the plugin is activated in the WordPress Plugin Manager.

3. Enter Credentials Based on Plugin Version

4. For Plugin Version 3.0.1 and Later:

    Fill in the following credentials.

    - Enable - Check the box to enable PhonePe payments.
    - Client Id – Staging/Production Client ID provided by PhonePe.
    - API Key – Staging/Production Client Secret provided by PhonePe.
    - Client Version – Staging/Production client version provided by PhonePe
    - Environment – Select the environment type (Staging/Production).

5. For Plugin Version 2.0.11 and Earlier:

    Fill in the following credentials.

    - Enable - Enable check box
    - Merchant ID - Staging/Production MID provided by PhonePe
    - Salt Key - Staging/Production Key provided by PhonePe
    - Salt Key Index - Staging/Production provided by PhonePe
    - Environment - Select environment type

Your PhonePe payment gateway is now enabled, and you can start accepting payments through PhonePe.
Need Help?
If you encounter any integration issues, please create a support ticket from your [PhonePe Merchant Dashboard](https://business.phonepe.com/dashboard) for assistance.

== Changelog ==

= Version 3.0.4 =
* Added enhanced status check polling to resolve instagram browser issue.

= Version 3.0.3 =
* Minor bug fixes

= Version 3.0.2 =
* Updated readme with latest integration instructions.

= Version 3.0.1 =
* Added support for V2 of the Payment Gateway APIs from PhonePe, introducing multiple new features such as payment retries and token-based security.

= Version 2.0.11 =
* Ensured seamless rendering of PhonePe Payment Solutions within WooCommerce's new wc block-based checkout, resolving issues that rendering PhonePe PG in payment options. Enhance your customers' checkout experience with this compatibility update.

= Version 2.0.10 =
* Added FRA (Fraud Risk Assessment) granular error messages to order notes for WooCommerce merchants, enhancing transparency and facilitating smoother transaction management.

= Version 2.0.9 =
* Merchants can customize Payment page open mode either Open on top of the current page or Redirect to a full-length payment page
* BugFix: Check status button 

= Version 2.0.8 =
* BugFix: IFrame on WooCommerce Checkout was aligned to bottom left
* Order notes by the payment gateway are prefixed with PhonePe Payment solution

= Version 2.0.7 =
* Previous versions added in plugin

= Version 2.0.6 =
* Added CTA links to phonepe business dashboard 
* Hosted all image assets to phonepe CDN reducing filesize of plugin 
* Added step 4 in Refund education

= Version 2.0.5 = 
* Merchant support email id updated
* UAT environment support added

= Version 2.0.4 = 
* Refund education prompt added
* Improvisation in redirection after payment

= Version 2.0.3 =
* Merchant troubleshooting journey features added 
* Added transaction id in order notes
* BugFix: handling for error codes fixed
* Order once marked completed will not be modified by plugin in any case

= Version 2.0.2 =
* BugFix: Guzzle Https library calls migrated to Wordpress native wp_remote network calls
* Moved PhonePe PG Settings to the sidebar
* New logo
* BugFix: replaced deprecated Wordpress function for getting redirect URL with its alternative.

= Version 2.0.1 =
* New Logo and description 
* Settings link on installed plugins for easy navigation 
* merchant transaction id removed from order notes
