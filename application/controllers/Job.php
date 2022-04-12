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
        //$execute = $this->job->exec_job();
        //print_r($execute);


        //atividades
        $job = new Job_lib();
        $job->url = "https://www.globo.com/";
	    echo $job->process_execute();





    }



}

?>