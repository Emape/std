<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "./library/PHPExcel.php"; 
require_once "./library/PHPWord.php"; 

class Legal extends CI_Controller {
    
        public function __construct(){
        parent::__construct();
        $this->load->model('legal_model'); 
		$this->load->library('session');
		if (!isset($_SESSION['usuario'])) {echo '<script type="text/javascript">window.location="../std";</script>';}
        }

        public function expediente()
	{   
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->view('documento/expediente');
	}
        
        public function listar_categoria(){
            $grupo=$this->input->get_post('grupo');
           
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->grupo=$grupo;
                    
            $var   = $this->legal_model->listarCategoria($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
}
