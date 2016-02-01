<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
	$this->load->model('usuario_model'); 
        $this->load->library('session');
    }

    public function index(){       
        $this->load->helper('url');
        $this->load->view('Acceso/index');
    }
        
    public function obtener_usuario(){       
        $usuario=$this->input->get_post('usuario');
        $contrasena=$this->input->get_post('contrasena');
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
		
	$filter->usuario=$usuario;
        $filter->contrasena=$contrasena;
        
        $acceso   = $this->usuario_model->obtener_usuario($filter,$filter_not);

        if(count((array)$acceso)>0){
        $filter->cod_usuario   = $acceso->pkUsuario;
        $arrMenu  = $this->usuario_model->obtener_permiso($filter,$filter_not);
        
        $array1=array();
        $array2=array();
        $array3=array();
        $array4=array();
        
        foreach($arrMenu as $row){
        $array1[]=$row->pkMenu;
        $array2[]=$row->pkSubmenu;
        $array3[]=$row->pkSeccion;
        $array4[]=$row->pkOperador;
        }

            $cuenta = array(
                   'codigo'             => $acceso->pkUsuario,
                   'usuario'            => $acceso->usuario,
                   'dni'                => $acceso->dni,
                   'nombre'             => $acceso->nombre,
                   'apellidoPaterno'    => $acceso->apellidoPaterno,
                   'apellidoMaterno'    => $acceso->apellidoMaterno,
                   'gerencia'           => $acceso->descripcion,
                   'sigla'              => $acceso->siglas,
                   'pkDependencia'      => $acceso->unidadx,
                   'central'            => $acceso->central,
                   'cMenu'              => $array1,
                   'cSubmenu'           => $array2,
                   'cSeccion'           => $array3,
                   'cOperador'          => $array4,
            );
            $this->session->set_userdata($cuenta);
            echo 1;
        }
        else
            echo 0;
    }
    
    public function cerrar_sesion(){
        $this->session->sess_destroy();
        header("Location:../acceso");
    }
}