<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/phpmailer/class.phpmailer.php');
require_once(APPPATH.'third_party/phpmailer/class.smtp.php');

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
        $login      = $this->input->post('login');
        $password   = $this->input->post('senha');
        $email      = $this->input->post('email');
        
        if(empty($login) || empty($password) || empty($email)){
            echo "<script>alert('Preencha todos os campos');</script>";
        }

        $params     = array(
            'p_operacao' => 2,
            'p_login'    => $login,
            'p_password' => $password,
            'p_email'    => $email
        );

        $insert_user = $this->auth->sp_auth($params);
        if($insert_user){
          

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host     = 'mail.hugomesquita.com.br';
            $mail->SMTPAuth = true;
            $mail->Username = 'master@hugomesquita.com.br';
            $mail->Password = '%3T5*Z%e~#YW';
            $mail->SMTPSecure = 'ssl'; //tls //ssl
            $mail->Port = 465; //587    //465
            
            $mail->setFrom('master@hugomesquita.com.br', 'Hugo Mesquita');
            $mail->addAddress($email, $login);
            $mail->Subject = 'NOTIFICAÇÃO DE CONFIRMAÇÃO - '.date('d/m/Y H:i:s');
            $mail->Body     = 'Clique no Link Abaixo para Confirmar seu Email';
            $mail->isHTML(true);
            $mail->CharSet = 'utf-8'; 
            if(!$mail->send()) {
              echo 'Email nao pode ser enviado';
              echo 'Erro: ' . $mail->ErrorInfo;
            } else {
                echo "<script>alert('Registro efetuado, abra sua caixa de entrada de email e confirme no link, para efetuar a validação.');</script>"; 
                header('location:'.base_url('login/index'));
            }

            //header('location:'.base_url('login/index'));
            //enviar email para validar
        }


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
