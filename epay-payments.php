<?php
/**
 * Plugin Name: EPay.bg Payments
 * Description: A shortcode for sending payments for a product or service, using epay.bg service.
 * Author: vloo
 * Author URI: https://github.com/vlood
 * Version: 0.1
 * Plugin URI: https://github.com/vlood/epay-payments
 * Text Domain: epaybg-payments
 * License: GPL2
 */
 
/*  Copyright 2015  Vladimir Vassilev  (email : vlood.vassilev@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'WPINC' ) ) {
        die;
}

add_action('plugins_loaded', 'epay_payments_init');
function epay_payments_init() {
	load_plugin_textdomain('epaybg-payments', false, basename( dirname( __FILE__ ) ) . '/languages');
}

function epay_hmac($algo,$data,$passwd){
	/* md5 and sha1 only */
	$algo=strtolower($algo);
	$p=array('md5'=>'H32','sha1'=>'H40');
	if(strlen($passwd)>64) $passwd=pack($p[$algo],$algo($passwd));
	if(strlen($passwd)<64) $passwd=str_pad($passwd,64,chr(0));

	$ipad=substr($passwd,0,64) ^ str_repeat(chr(0x36),64);
	$opad=substr($passwd,0,64) ^ str_repeat(chr(0x5C),64);

	return($algo($opad.pack($p[$algo],$algo($ipad.$data))));
}

add_shortcode('epay', 'epay_shortcode');
function epay_shortcode($args){

	# XXX ePay.bg URL (https://devep2.datamax.bg/ep2/epay2_demo/ if POST to DEMO system)
	$submit_url = $args['submiturl'];
	# XXX Secret word with which merchant make CHECKSUM on the ENCODED packet
	$secret     = $args['secret'];

	$min        = $args['min'];
	$invoice    = sprintf("%.0f", rand(10, 1) * 100000); # Random 10 digit number for an invoice ID. This should be thought over
	$sum        = $args['sum'];
	$exp_date   = $args['expdate']; // # XXX Expiration date
	$descr      = $args['descr'];
	$success_url = $args['successurl'];
	$fail_url = $args['failurl'];
	$button_label = $args['btnlabel'];

$data = <<<DATA
	MIN={$min}
	INVOICE={$invoice}
	AMOUNT={$sum}
	EXP_TIME={$exp_date}
	DESCR={$descr}
DATA;

	# XXX Packet:
	#     (MIN or EMAIL)=     REQUIRED
	#     INVOICE=            REQUIRED
	#     AMOUNT=             REQUIRED
	#     EXP_TIME=           REQUIRED
	#     DESCR=              OPTIONAL

	$ENCODED  = base64_encode($data);
	$CHECKSUM = epay_hmac('sha1', $ENCODED, $secret); # XXX SHA-1 algorithm REQUIRED
	
	//localizable strings
	$min_label = __('MIN', 'epaybg-payments');
	$invoice_label = __('Invoice id', 'epaybg-payments');
	$descr_label = __('Description', 'epaybg-payments');
	$sum_label = __('Total', 'epaybg-payments');
	
return <<<HTML
	<TABLE border=1>

	<form action="{$submit_url}" method=POST>
	<input type=hidden name=PAGE value="paylogin">
	<input type=hidden name=ENCODED value="{$ENCODED}">
	<input type=hidden name=CHECKSUM value="{$CHECKSUM}">
	<input type=hidden name=URL_OK value="{$success_url}">
	<input type=hidden name=URL_CANCEL value="{$fail_url}">

	<TR>
	<TD>{$invoice_label}: {$invoice}</TD>
	</TR>

	<TR>
	<TD>{$descr_label}: {$descr}</TD>
	</TR>

	<TR>
	<TD>{$sum_label}: {$sum}</TD>
	</TR>


	</table>

	<table width=100%>
	<TR align=center>
	<TD><INPUT type=submit value="{$button_label}"></TD>
	</TR>


	</TABLE>

	</form>
HTML;
	
}
