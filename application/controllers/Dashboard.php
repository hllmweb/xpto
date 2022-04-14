<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //models
        $this->load->model('M_Job','job');
        
        //libs    
        $this->load->library(array('session','job_lib'));
        $this->load->helper(array('url', 'directory'));
    }


	public function index(){    
        
		$data = array(
			'titulo' 	    => 'XPTO - Dashboard',
            'login_name'    => $this->session->userdata('user_auth')['Login']
		);
        

        if($this->session->userdata('user_auth')){
            $this->load->view('dashboard/index', $data);
        }else{
            redirect('/login');
        }
  

    
	}

    public function logout(){
		$this->session->unset_userdata('user_auth');
		redirect('/login');
    }


}
