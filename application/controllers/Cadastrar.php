<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastrar extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //models
        $this->load->model('M_Auth','auth');
        
        //libs
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'form','directory'));
    }

	public function index(){   
        $data = array(
            'titulo' => 'XPTO - Cadastrar Usuário'
        );
        
        
		$this->load->view('cadastrar/index', $data);
	}

    #cadastrando no banco
    public function insert(){
        /*$login      = $this->input->post('login');
        $password   = $this->input->post('password');
        $email      = $this->input->post('email');
        print_r($this->isEmail("hugomesquitaweb@gmail.com"));*/

    }

    #verificando se existe email cadastrado
    public function isEmail(){
        $email = $this->input->post('email');
         
        $params = array(
            'p_operacao' => 0,
            'p_login'    => null,
            'p_senha'    => null,
            'p_email'    => $email
        );

        $checkEmail = $this->auth->isEmail($params);
        echo json_encode($checkEmail);
        
    }
}
