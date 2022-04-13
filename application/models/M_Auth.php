<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Auth extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function sp_auth($p){
        mysqli_next_result($this->db->conn_id);
        $params = array(
            array('value' => $p['p_operacao']),
            array('value' => $p['p_login']),
            array('value' => $p['p_password']),
            array('value' => $p['p_email'])
        );

        $query = $this->db->query("call sp_auth(?,?,?,?)",$params);
        $data = $query->result_array();
        $query->free_result();
        return $data;
    }



    public function isEmail($p){
        $params = array(
            array('value' => $p['p_operacao']),
            array('value' => $p['p_login']),
            array('value' => $p['p_senha']),
            array('value' => $p['p_email'])
        );

        $query = $this->db->query("call sp_auth(?,?,?,?)",$params);
        return $query->result_array();
    }

    

    public function check_permissao($p){
        $params = array(
            array('value' => $p['p_hash_acesso']),
            array('value' => $p['p_controller'])
        );

        $query = $this->db->query("call sp_permissao(?,?)",$params);
        return $query->result_array();
    }

}

?>