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
		// $idauth = 2;
	
  //       $params_list_all_url = array(
  //           'p_operacao'    => 0,
  //           'p_opcao'       => 1,
  //           'p_idauth'      => $idauth,
  //           'p_idurl'       => null,
  //           'p_url'         => null,
  //           'p_statuscode'  => null,
  //           'p_body'        => null,
  //           'p_ipterminal'  => null
  //       );

        //$list_url = $this->job->sp_monitoring($params_list_all_url);        
      
		$data = array(
			'titulo' 	=> 'XPTO - Dashboard',
		//	'list_urls' => $list_url
		);
		
		$this->load->view('dashboard/index',$data);
	}


}
