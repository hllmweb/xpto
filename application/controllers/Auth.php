<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //models
        $this->load->model('M_Auth','auth');
        
        //libs
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'directory'));
    }


	public function isLogin(){
        $login      = $this->input->post('login');
        $password   = $this->input->post('senha');

        $params = array(
            'p_operacao'    => 1,
            'p_login'       => $login,
            'p_password'    => $password,
            'p_email'       => null
        );

        $islogin = $this->auth->sp_auth($params);

        print_r($islogin);
        
        

	}
}
