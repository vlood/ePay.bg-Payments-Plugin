=== Plugin Name ===
Tags: payments, payment gateway, shortcode, epay.bg
Requires at least: 4.1
Contributors: vloo
Tested up to: 4.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A shortcode for sending payments for a product or service, using epay.bg service.

== Description ==

The plugin allows you to create a button for making a payment through epay.bg (a Bulgarian service). The button can be added in any page or post, using a shortcode. Parameters that you can define in the shortcode are:

* url of the payment gateway (ePay got a sandbox and a live urls, that can be used);
* merchant secret (you get one when you register at their site);
* mercant key, a.k.a. MIN (also received after registration);
* amount of the payment in BGN currency;
* expiration date for the time till when the system will be expecting a payment from the client;
* description of the payment;
* redirection url for when a payment is successfully completed;
* redirection url for when a payment is cancelled;
* label on the submit button;

The plugin supports localization and has about 4-5 strings, so it will be pretty easy for anyone to localize it with Codestyling Localization plugin or POEdit tool.

= Example =

[epay sum="50" secret="THIS_IS_THE_SECRET" expdate="01.08.2020" submiturl="https://devep2.datamax.bg/ep2/epay2_demo/" min="MERCHANT_ID" descr="YOU PAY ME FOR THIS" failurl="http://yoursite.com/fail" successurl=" http://yoursite.com/success" btnlabel="Proceed to ePay"]

= TODO =
* Rethink the invoice id thingy (currently giving a random 10-digit number);
* Make a flag arg for demo/live payment gateway (currently there is an arguement for the gateway url);
* Validation of the arguements (none currently);
* Set default values (some of the args shouldn't be required);

Any ideas for additional features are welcome!

= GitHub Repo =

Here it is: https://github.com/vlood/ePay.bg-Payments-Plugin

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
1. Search for 'EPay.bg Payments'
1. Activate EPay.bg Payments from your Plugins page.

Now you can add a button in any page, post or other custom post type, that has a content field. Other features will be coming soon (eventually);

= From WordPress.org =

1. Download 'EPay.bg Payments'.
1. Upload the 'epay-payments' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
1. Activate it from your Plugins page.

== Frequently Asked Questions ==

= Does it have a settings page? =

Nope.

== Changelog ==

= 0.1. - 2015.01.30 =

* initial commit, yay!

== Upgrade Notice ==
