<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mpesa_lib
{
    protected $ci;

	protected $request_headers;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('api_lib');
		$this->ci->config->load('mpesa');
		
		// Initialize request headers
		$this->request_headers = array(
			'Content-Type:application/json',
			'Authorization:Bearer '.$this->_get_access_token()
		);

	}
	
	#region REST REQUEST HELPERS
	// Initial CURL request setup wrapper
	private function _curl_setup($url,$headers=NULL)
	{
		// Curl
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		$headers = !isset($headers) ? $this->request_headers : $headers;

		// If headers have been provided ~ add them to the request
		if(is_array($headers))
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);	
		}
				
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		return $curl;
	}

	// Make a REST get request
	public function get_request($url,$headers=NULL)
	{		
		$curl = $this->_curl_setup($url,$headers);
		$curl_response = curl_exec($curl);

		return $curl_response;
	}

    // Make REST post request
    public function post_request($url,$data=NULL,$headers=NULL)
    {		
		
		$curl = $this->_curl_setup($url,$headers);

		curl_setopt($curl, CURLOPT_POST, TRUE);

		$data_string = json_encode($data);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		
		$curl_response = curl_exec($curl);

		return $curl_response;
    }
	#endregion REST REQUESTS

	#region MPESA HELPERS
	// Generate a valid mpesa timestamp
	private function _get_timestamp()
	{
		return date('YmdHis');
	}
	
	// Generate access token
	private function _get_access_token()
	{
		$consumer_key = $this->ci->config->item('consumer_key');
		$consumer_secret = $this->ci->config->item('consumer_secret');

		$credentials = base64_encode($consumer_key.':'.$consumer_secret);

		$token_response = $this->get_request($this->ci->config->item('url_generate_token'),array(
			'Authorization: Basic '.$credentials
		));
		
		$token_response = json_decode($token_response);
		return $token_response->access_token;
	}
	#endregion REST REQUESTS

	// Generate lipa na mpesa
	protected function get_lipa_na_mpesa_password($short_code,$pass_key,$timestamp)
	{
		return base64_encode($short_code.$pass_key.$timestamp);
	}

	// Return lipa na mpesa data ~ uses dev data for each param that is not passed
	private function _get_lipa_na_mpesa_data($phone=NULL,$amount=10,$account_reference=NULL,$description=NULL)
	{
		$timestamp = $this->_get_timestamp();
		$password = $this->get_lipa_na_mpesa_password(
			$this->ci->config->item('lipa_na_mpesa_online_shortcode'),
			$this->ci->config->item('lipa_na_mpesa_online_passkey'),
			$timestamp
		);

		// Set defaults ~ use dev version if param is not available
		$phone = empty($phone) ? $this->ci->config->item('test_msisdn') : $phone;
		$amount = empty($amount) ? $this->ci->config->item('min_send_amount') : (float)$amount;
		$description = empty($description) ? $this->ci->config->item('default_lipa_na_mpesa_description') : $description;
		$account_reference = empty($account_reference) ? $this->ci->config->item('default_account_reference') : $account_reference;

		$request_data = array(
			//Fill in the request parameters with valid values
			'BusinessShortCode' => $this->ci->config->item('lipa_na_mpesa_online_shortcode'),
			'Password' => $password,
			'Timestamp' => $timestamp,
			'TransactionType' => 'CustomerPayBillOnline',
			'Amount' => $amount,
			'PartyA' => $phone,
			'PartyB' => $this->ci->config->item('lipa_na_mpesa_online_shortcode'),
			'PhoneNumber' => $phone,
			'CallBackURL' => $this->ci->config->item('url_lipa_na_mpesa_callback'),
			'AccountReference' => $account_reference,
			'TransactionDesc' => $description
		);
		return $request_data;
	}

	protected function get_valid_phone($phone)
	{
		$phone = trim($phone);
		$response_phone = $phone;
		// If the phone number has 10 digits, replace the first one with 254
		if(strlen($response_phone) == 10)
		{
			$response_phone = str_split($phone);
			$response_phone[0] = '254';
			
			$response_phone = join($response_phone,'');
		}
		return $response_phone;
	}

    // Lipa na mpesa stk push
    public function lipa_na_mpesa($phone=NULL,$amount=10,$account_reference='',$description='')
    {
		$phone = $this->get_valid_phone($phone);
		$request_data = $this->_get_lipa_na_mpesa_data($phone,$amount,$account_reference,$description);

		$response = $this->ci->api_lib->post_request(
			$this->ci->config->item('url_lipa_na_mpesa'),
			$request_data,
			$this->request_headers
		);
		
		// Return the response object ~ API handler should handle parsing this back to JSON if ajax
		return json_decode($response);
    }

    // B2B - Business to business
    public function b2b()
    {
        //TODO: Add implementation
    }

    // C2B - Customer to business
    public function c2b()
    {
        //TODO: Add implementation
    }

    // B2C - Business to customer
    public function b2c()
    {
        //TODO: Add implementation
    }

    // Transaction Reversal
    public function reversal()
    {
        //TODO: Add implementation
    }
}


/* End of file Mpesa_lib.php */
