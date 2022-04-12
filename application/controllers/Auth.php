<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //models
        $this->load->model('M_Auth','auth');
        
        //libs
        //$this->load->library(array('session'));
        $this->load->helper(array('url', 'directory'));
    }


	public function index(){
    
	}
}
