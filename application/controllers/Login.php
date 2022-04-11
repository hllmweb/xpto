<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $data = array(
            'titulo' => 'Login'
        );
        
		$this->load->view('login/index', $data);
	}
}
