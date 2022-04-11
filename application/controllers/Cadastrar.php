<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastrar extends CI_Controller {

	public function index()
	{   

        $data = array(
            'titulo' => 'Cadastrar Usuário'
        );
        
		$this->load->view('cadastrar/index', $data);
	}
}
