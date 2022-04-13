<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//lib responsável por retornar o status, header e body da url
class Job_lib{

	public $url;

	public function process_execute(){
		$ch = curl_init($this->url);


		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => true,
			CURLINFO_HEADER_OUT => true,
			CURLOPT_HTTPHEADER => [
				"$this->url",
				"User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36"
			],
			CURLOPT_ENCODING => '',
			CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS]); 
		
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$request  = curl_getinfo($ch, CURLINFO_HEADER_OUT);
		curl_close($ch);			
		

		$result = array(
			'statuscode' => $httpcode,
			'header'	 => $request,
			'body'		 => $data
		);
		return json_encode($result);
		
	}
}

?>