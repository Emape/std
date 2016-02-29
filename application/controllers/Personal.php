<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "./library/PHPExcel.php"; 
require_once "./library/PHPWord.php"; 

class Personal extends CI_Controller {
    
        public function __construct(){
        parent::__construct();
        $this->load->model('documento_model'); 
		$this->load->library('session');
		if (!isset($_SESSION['usuario'])) {echo '<script type="text/javascript">window.location="../std";</script>';}
        }

	public function index()
	{   
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->view('personal/index');
	}
        
        public function control()
	{   
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->view('personal/control');
	}
        
        public function listar_personal(){
            /*$fecha_ini=$this->input->get_post('fecha_ini');
            $fecha_fin=$this->input->get_post('fecha_fin');
            $tipo_doc=$this->input->get_post('tipo_doc');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->fecha_ini=str_replace('/', '-', $fecha_ini);
            $filter->fecha_fin=str_replace('/', '-', $fecha_fin);
            $filter->tipo_doc=$tipo_doc;
                    
            $var   = $this->documento_model->listarDocumento($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;*/
        }
}
