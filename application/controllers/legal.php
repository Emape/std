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
		
		public function listar_tipo(){
            $grupo=$this->input->get_post('grupo');
           
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->grupo=$grupo;
                    
            $var   = $this->legal_model->listarTipo($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function listar_expediente(){
            $anio=$this->input->get_post('anio');
			$distrito=$this->input->get_post('distrito');
			$organo=$this->input->get_post('organo');
			$especialidad=$this->input->get_post('especialidad');
			$sede=$this->input->get_post('sede');
			$sala=$this->input->get_post('sala');
           
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->anio=$anio;
			$filter->distrito=$distrito;
			$filter->organo=$organo;
			$filter->especialidad=$especialidad;
			$filter->sede=$sede;
			$filter->sala=$sala;
                    
            $var   = $this->legal_model->listarExpediente($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function obtener_expediente(){
            $cod=$this->input->get_post('doc');

            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->cod=$cod;

            $var   = $this->legal_model->listarExpediente($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function listar_actividad(){
            $cod=$this->input->get_post('cod');
			$cod_actividad=$this->input->get_post('cod_actividad');
			
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->cod=$cod;
			$filter->cod_actividad=$cod_actividad;
            $var   = $this->legal_model->listarActividad($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function registrar_expediente(){
			$movimiento=$this->input->get_post('movimiento');
			$cod_mov=$this->input->get_post('cod_mov');
			$doc=$this->input->get_post('doc');
			$distrito=$this->input->get_post('distrito');
			$organo=$this->input->get_post('organo');
			$especialidad=$this->input->get_post('especialidad');
			$sede=$this->input->get_post('sede');
			$sala=$this->input->get_post('sala');
			$expediente=$this->input->get_post('expediente');
			$fecha=$this->input->get_post('fecha');
			$situacion=$this->input->get_post('situacion');
			$involucrado=$this->input->get_post('involucrado');
			$delito=$this->input->get_post('delito');
			$resumen=$this->input->get_post('resumen');
			
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->doc=$doc;
			$filter->cod_mov=$cod_mov;
			$filter->movimiento=$movimiento;
			$filter->distrito=$distrito;
			$filter->organo=$organo;
			$filter->especialidad=$especialidad;
			$filter->sede=$sede;
			$filter->sala=$sala;
			$filter->expediente=$expediente;
			$filter->fecha=$fecha;
			$filter->situacion=$situacion;
			$filter->involucrado=$involucrado;
			$filter->delito=$delito;
			$filter->resumen=$resumen;
			
			if($movimiento=="")
			$this->legal_model->registrarExpediente($filter,$filter_not);	
			else
            $this->legal_model->modificarExpediente($filter,$filter_not);
			
			echo 1;

		}
		
		public function registrar_actividad(){
			$cod_expediente=$this->input->get_post('cod_expediente');
			$cod_actividad=$this->input->get_post('cod_actividad');
			$actividad=$this->input->get_post('actividad');
			$acto=$this->input->get_post('acto');
			$sumilla=$this->input->get_post('sumilla');
			$fecha_inicio=$this->input->get_post('fecha_inicio');
			$fecha_programada=$this->input->get_post('fecha_programada');
			$anexo=$this->input->get_post('anexo');
			$observacion=$this->input->get_post('observacion');

			
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->cod_expediente=$cod_expediente;
			$filter->cod_actividad=$cod_actividad;
			$filter->actividad=$actividad;
			$filter->acto=$acto;
			$filter->sumilla=$sumilla;
			$filter->fecha_inicio=$fecha_inicio;
			$filter->fecha_programada=$fecha_programada;
			$filter->anexo=$anexo;
			$filter->observacion=$observacion;
			
			if($cod_actividad=="")
			$this->legal_model->registrarActividad($filter,$filter_not);	
			else
            $this->legal_model->modificarActividad($filter,$filter_not);
			
			echo 1;

		}
		
		public function anular_actividad(){
			$actividad=$this->input->get_post('actividad');
			
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->actividad=$actividad;
			
            $this->legal_model->anularActividad($filter,$filter_not);
			
			echo 1;

		}
}
