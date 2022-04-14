<?php

if (!defined('BASEPATH'))
    exit('Não é possível acessar a página!');

class Phpmail
{
    protected $CI;

    public function __construct()
    {
        // log_message('Debug', 'PHPMailer class is loaded.');
        $this->CI = &get_instance();
    }

    public function load()
    {
        require_once(APPPATH.'third_party/phpmailer/class.phpmailer.php');
        require_once(APPPATH.'third_party/phpmailer/class.smtp.php');

        // $objMail = new PHPMailer\PHPMailer\PHPMailer();
        // return $objMail;

        $mail = new PHPMailer();
        return $mail;
    }
}
?>