<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //models
        $this->load->model('M_Job','job');
        
        //libs    
        $this->load->library(array('session','job_lib'));
        $this->load->helper(array('url', 'directory'));
    }

	public function index(){  
        $params_list_all_url = array(
            'p_operacao'    => 0,
            'p_opcao'       => 0,
            'p_idauth'      => null,
            'p_idurl'       => null,
            'p_statuscode'  => null,
            'p_body'        => null,
            'p_ipterminal'  => null
        );

        $list_url = $this->job->sp_monitoring($params_list_all_url);
    
        //atividades
        $job = new Job_lib();
      
        foreach($list_url as $row){
            $job->url = $row['Url'];
            $json_job = $job->process_execute();
            $json_job_objeto = json_decode($json_job);
            //echo $json_job_objeto->statuscode;
            //echo $json_job_objeto->header;

            $params_insert_all_url = array(
                'p_operacao'    => 1,
                'p_opcao'       => null,
                'p_idauth'      => intval($row['IdAuth']),
                'p_idurl'       => intval($row['IdUrl']),
                'p_statuscode'  => $json_job_objeto->statuscode,
                'p_body'        => $json_job_objeto->header,
                'p_ipterminal'  => $_SERVER['REMOTE_ADDR']
            );
            
            $insert_url = $this->job->sp_monitoring($params_insert_all_url);
        
        }


        if($insert_url){
            echo "ok";
        }
        /*$job->url = "https://www.globo.com";
        $json_job = $job->process_execute();
        $json_job_objeto = json_decode($json_job);
        echo $json_job_objeto->statuscode;
        echo $json_job_objeto->header;
        echo $json_job_objeto->body;*/
    }

}

?>