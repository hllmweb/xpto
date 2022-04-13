<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Job extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function sp_monitoring($p){
        $params = array(
            array('value' => $p['p_operacao']),
            array('value' => $p['p_opcao']),
            array('value' => $p['p_idauth']),
            array('value' => $p['p_idurl']),
            array('value' => $p['p_statuscode']),
            array('value' => $p['p_body']),
            array('value' => $p['p_ipterminal'])
        );
        
        //$this->db->trans_start();

        if($p['p_operacao'] == 0){
            $query  = $this->db->query("call sp_monitoring(?,?,?,?,?,?,?)",$params);
            return $query->result_array();
        }

        if($p['p_operacao'] == 1){
            $query  = $this->db->query("call sp_monitoring(?,?,?,?,?,?,?)",$params)->result_array();
            //$query->next_result();
            //$query->free_result();
            return $query;
        }
        //$res    = $query->result_array();

        //$query->next_result(); // Dump the extra resultset.
        //$query->free_result(); // Does what it says.
     
        //return $res;
        //mysqli_next_result( $this->db->conn_id);
        //$query->free_result(); 
        //$this->db->trans_complete();
        // if($query->result()){
        //   echo "ok";
        // }

        //mysqli_next_result($this->db->conn_id);
        
        //$query->next_result();
        // $query->free_result();
        // return $query->result_array();
        //return $query->next_result();
       
        //echo $this->db->conn_id;
        //mysqli_next_result($this->db->conn_id);
        
        //return $query->next_result();
        //  $query->next_result();
       // 
        //return $query->result_array();
    }

    public function sp_up($p){
        mysqli_next_result($this->db->conn_id);
        
        $params = array(
            array('value' => $p['p_operacao']),
            array('value' => $p['p_opcao']),
            array('value' => $p['p_idauth']),
            array('value' => $p['p_idurl']),
            array('value' => $p['p_statuscode']),
            array('value' => $p['p_body']),
            array('value' => $p['p_ipterminal'])
        );

        $query  = $this->db->query("call sp_monitoring(?,?,?,?,?,?,?)",$params);
    
        $data = $query->result_array();
        $query->free_result();
        return $data; 
        //return $query->result();
        /*$query->next_result();
        $query->free_result();
        return $query->result_array();*/
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