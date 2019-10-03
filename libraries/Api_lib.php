<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_lib
{
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	// Check if a request is a valid api request
	public function is_valid_request($api_key='',$access_level=1) 
	{ # TODO: Use the params once we implement API keys

		//TODO: Implement this
		return TRUE;
	}

	// Generate a json response
    public function get_response($is_ok,$message='',$data=NULL)
    {
        $access_url = base_url();
        $substr_len = (strlen($access_url)) - 1;#Length of the substring
        $access_url = substr($access_url,0,$substr_len);#Removing the / after the base url
		
		// Set default message
		if(empty($message))
		{
			$message = $is_ok ? 'Successfully completed operation': 'Failed to complete operation';
		}
		
		//Set access allowed origin
        $this->ci->output->set_header('Access-Control-Allow-Origin: '.$access_url);

        // Set the application type to JSON
        $this->ci->output->set_content_type('application/json','UTF-8');

        $response = array(
            'ok' => (bool)$is_ok,
            'message' => (string)$message,
        );

        if(isset($data))
        {
            $response['data'] = (array)$data;
        }

        return json_encode($response);
    }

	public function print_response($is_ok,$message='',$data=NULL)
	{
		return $this->ci->output->set_output(
			$this->get_response($is_ok,$message,$data)
		);
    }
    
    // Make REST post request
    public function post_request($url,$data=NULL,$headers=NULL)
    {		
		// Curl
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		
		// If headers have been provided ~ add them to the request
		if(!empty($headers) && is_array($headers))
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);	
		}
				
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POST, TRUE);

		$data_string = json_encode($data);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		
		$curl_response = curl_exec($curl);

		return $curl_response;
	}

	// Access restricted error
	public function access_restricted_error()
	{
		$message = 'Access restricted, you are not allowed to view this content';
		
		// Set access code
		$this->ci->output->set_status_header(403,$message);
		return $this->print_response(FALSE,$message);
	}
}

/* End of file Api.php */
