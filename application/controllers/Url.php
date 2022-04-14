<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //models
        $this->load->model('M_Job','job');
        
        //libs    
        $this->load->library(array('session','job_lib'));
        $this->load->helper(array('url', 'directory'));
    }


	public function index(){
		$idauth = $this->session->userdata('user_auth')['IdAuth'];
	
        $params_list_all_url = array(
            'p_operacao'    => 0,
            'p_opcao'       => 1,
            'p_idauth'      => $idauth,
            'p_idurl'       => null,
            'p_url'         => null,
            'p_statuscode'  => null,
            'p_body'        => null,
            'p_ipterminal'  => null
        );

        $list_url = $this->job->sp_monitoring($params_list_all_url);        
      
		$data = array(
			'titulo' 	=> 'XPTO - Dashboard',
			'list_urls' => $list_url
		);
		
		$this->load->view('dashboard/index',$data);
	}


    public function list(){
        $idauth = $this->session->userdata('user_auth')['IdAuth'];
    
        $params_list_all_url = array(
            'p_operacao'    => 0,
            'p_opcao'       => 1,
            'p_idauth'      => $idauth,
            'p_idurl'       => null,
            'p_url'         => null,
            'p_statuscode'  => null,
            'p_body'        => null,
            'p_ipterminal'  => null
        );

        $list_url = $this->job->sp_monitoring($params_list_all_url);        
      
        $data = array(
            'list_urls' => $list_url
        );
        
        $this->load->view('dashboard/urls',$data);
    } 


    public function insert(){
        $idauth = $this->session->userdata('user_auth')['IdAuth'];
        $url    = $this->input->post('url');

        $params_insert_url = array(
            'p_operacao'    => 3,
            'p_opcao'       => null,
            'p_idauth'      => $idauth,
            'p_idurl'       => null,
            'p_url'         => $url,
            'p_statuscode'  => null,
            'p_body'        => null,
            'p_ipterminal'  => $_SERVER['REMOTE_ADDR']
        );

        $insert_url = $this->job->sp_monitoring($params_insert_url);
        if($insert_url){
            echo "ok";
        }

    }




	public function delete($idurl){
		$idauth = $this->session->userdata('user_auth')['IdAuth'];


        $params_del_url = array(
            'p_operacao'    => 2,
            'p_opcao'       => null,
            'p_idauth'      => $idauth,
            'p_idurl'       => $idurl,
            'p_url'         => null,
            'p_statuscode'  => null,
            'p_body'        => null,
            'p_ipterminal'  => null
        );

        $del_url = $this->job->sp_monitoring($params_del_url);
        if($del_url){
        	echo "ok";
        }

	}
}
