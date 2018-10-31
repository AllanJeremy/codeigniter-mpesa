<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
	API AUTHENTICATION
*/
$config['consumer_key'] = 'YOUR_CONSUMER_KEY';
$config['consumer_secret'] = 'YOUR_CONSUMER_SECRET';

/* 
	TEST CREDENTIALS
*/
$config['shortcode_1'] = '600864';

$config['initiator_name_1'] = 'apitest362';

$config['security_credential_1'] = '362reset';

$config['shortcode_2'] = '600000';

$config['test_msisdn'] = '254708374149';

$config['expiry_date'] = '2018-11-03T21:46:34+03:00';

$config['lipa_na_mpesa_online_shortcode'] = '174379';

$config['lipa_na_mpesa_online_passkey'] = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

/* 
	DEFAULTS
*/
$config['default_lipa_na_mpesa_description'] = 'Mpesa transaction';

$config['default_account_reference'] = 'Customer';

/* 
	LIMITS
*/
$config['min_send_amount'] = 10.0;


// CALLBACK URLS
$config['url_lipa_na_mpesa_callback'] = 'http://www.example.com/';

/* 
	RESPONSE CODES
*/
$config['result_code']['success'] = '0';
$config['result_code']['insufficient_funds'] = '1';
$config['result_code']['less_than_min_transaction_value'] = '2';
$config['result_code']['exceeds_max_transaction_value'] = '3';
$config['result_code']['exceeds_daily_transfer_limit'] = '4';
$config['result_code']['exceeds_min_balance'] = '5';
$config['result_code']['exceeds_max_balance'] = '8';

/* 
	API URLS
*/
$config['url_generate_token'] = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$config['url_lipa_na_mpesa'] = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$config['url_b2c'] = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

$config['url_b2b'] = 'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';

$config['url_c2b_register_url'] = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
$config['url_c2b_simulate_transaction'] = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

$config['url_account_balance'] = 'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query';

$config['url_transaction_status'] = 'https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query';

$config['url_reversal'] = 'https://sandbox.safaricom.co.ke/mpesa/reversal/v1/request';

