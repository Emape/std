<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maestro extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
	$this->load->model('maestro_model'); 
        $this->load->library('session');
    }

    public function index(){       
        $this->load->helper('url');
    }
    
    public function listar_tipo(){       
        $grupo=$this->input->get_post('grupo');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->grupo=$grupo;
                    
        $var   = $this->maestro_model->listarTipo($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
        
    public function listar_empresa(){       
        $filter     = new stdClass();
        $filter_not = new stdClass();
                    
        $var   = $this->maestro_model->listarEmpresa($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
   
    public function listar_dependencia(){       
        $empresa=$this->input->get_post('empresa');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->pkEmpresa=$empresa;
                    
        $var   = $this->maestro_model->listarDependencia($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
    
    public function listar_persona(){       
        $dependencia=$this->input->get_post('dependencia');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->pkDependencia=$dependencia;
                    
        $var   = $this->maestro_model->listarPersona($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
    
    public function registrar_unidad(){
        $detalle_unidad=$this->input->get_post('detalle_unidad');
        $entidad=$this->input->get_post('entidad');
          
        $filter     = new stdClass();
        $filter_not = new stdClass();
            
        $filter->detalle_unidad=$detalle_unidad;
        $filter->entidad=$entidad;
            
        $this->maestro_model->registrarUnidad($filter,$filter_not);
            
        echo "1";
    }
    
    public function registrar_persona(){
        $detalle_paterno=$this->input->get_post('detalle_paterno');
        $detalle_materno=$this->input->get_post('detalle_materno');
        $detalle_nombre=$this->input->get_post('detalle_nombre');
        $unidad=$this->input->get_post('unidad');
        $entidad=$this->input->get_post('entidad');
          
        $filter     = new stdClass();
        $filter_not = new stdClass();
            
        $filter->detalle_paterno=$detalle_paterno;
        $filter->detalle_materno=$detalle_materno;
        $filter->detalle_nombre=$detalle_nombre;
        $filter->unidad=$unidad;
        $filter->entidad=$entidad;   
        
        $this->maestro_model->registrarPersona($filter,$filter_not);
            
        echo "1";
    }
}