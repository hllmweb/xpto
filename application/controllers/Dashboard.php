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
			'titulo' 	=> 'XPTO - Dashboard'
		);
		
		$this->load->view('dashboard/index',$data);
	}


}
