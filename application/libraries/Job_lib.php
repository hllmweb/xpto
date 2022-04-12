<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Job_lib{

	public $url;

	public function process_execute(){

		$params = array(
			'url' => $this->url
		);

		return json_encode($params);
		// $ch = curl_init("https://www.globo.com/hsduahdusahduahsudhausdhaushdas/");

	}
}

?>