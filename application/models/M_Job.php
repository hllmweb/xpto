<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Job extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function exec_job(){
        $query = $this->db->query("select u.Url, m.StatusCode, max(m.DtHrMonitoring) as DtHrMonitoring  from tb_Auth a 
        join tb_Url u on u.IdAuth = a.IdAuth 
        join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
        where a.Login = 'hllm' group by u.Url, m.StatusCode");

        return $query->result_array();
    }





    public function check_acesso($p){
        $params = array(
            array('value' => $p['p_cpf']),
            array('value' => $p['p_email']),
            array('value' => $p['p_senha'])
        );

        $query = $this->db->query("call sp_acesso(?,?,?)",$params);
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