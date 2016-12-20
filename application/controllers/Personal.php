<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "./library/PHPExcel.php"; 
require_once "./library/PHPWord.php"; 

class Personal extends CI_Controller {
    
        public function __construct(){
        parent::__construct();
        $this->load->model('documento_model'); 
		$this->load->model('usuario_model'); 
		$this->load->library('session');
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
        
        public function obtener_persona(){
            $cod=$this->input->get_post('cod');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();

            $filter->cod=$cod;
                    
            $var   = $this->usuario_model->listarPersona($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function registrar_persona(){
			
			$verify=0;
			$verify0=0;
			$pkUsuario=$this->input->get_post('pkUsuario');
			$usuario=$this->input->get_post('usuario');
			if($pkUsuario==""){
			$verify   = $this->usuario_model->validarUsuario($usuario);
			$verify0=$verify[0]->contador;
			}
			//print_r($usuario);die; 
			if($verify0==0){			
            $pkPersona=$this->input->get_post('pkPersona');
            
			$dni=$this->input->get_post('dni');
			$ruc=$this->input->get_post('ruc');
			$dependencia=$this->input->get_post('dependencia');
			$apellido_paterno=$this->input->get_post('apellido_paterno');
			$apellido_materno=$this->input->get_post('apellido_materno');
			$nombre=$this->input->get_post('nombre');
			$razon_social=$this->input->get_post('razon_social');
			$cargo=$this->input->get_post('cargo');
			$locador=$this->input->get_post('locador');
			$usuario=$this->input->get_post('usuario');
			$contrasena=$this->input->get_post('contrasena');
			$password=$this->input->get_post('password');
			$nivel=$this->input->get_post('nivel');		
			$email=$this->input->get_post('email');
			
            $filter     = new stdClass();
            $filter_not = new stdClass();

			$filter->pkPersona=$pkPersona;
            $filter->pkUsuario=$pkUsuario;
			$filter->dni=$dni;
			$filter->ruc=$ruc;
			$filter->dependencia=$dependencia;
			$filter->apellido_paterno=$apellido_paterno;
			$filter->apellido_materno=$apellido_materno;
			$filter->nombre=$nombre;
			$filter->razon_social=$razon_social;
			$filter->cargo=$cargo;
			$filter->locador=$locador;
			$filter->usuario=$usuario;
			$filter->contrasena=$contrasena;
			$filter->password=$password;
			$filter->nivel=$nivel;	
			$filter->email=$email;	

            $var   = $this->usuario_model->registrarPersona($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		else{
			echo 2;
		}
		}
}
