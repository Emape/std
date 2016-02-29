<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
		$this->load->model('usuario_model'); 
		$this->load->model('maestro_model'); 
        $this->load->library('session');

    }

    public function index(){       
        $this->load->helper('url');
        $this->load->view('Acceso/index');
    }
	
	public function password(){       
        $this->load->helper('url');
        $this->load->view('Acceso/password');
    }
	
	public function cambiar_contrasena(){
		$pass=$this->input->get_post('pass');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();
                     
        $filter->pass=$pass;
                    
        $var   = $this->usuario_model->cambiarContrasena($filter,$filter_not);
		
		echo "1";
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
                   'pkDependencia'      => $acceso->unidadu,
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
	
	public function plantilla_permiso(){
        $var   = $this->maestro_model->plantillaPermiso();
        $cadena="<ul>";
		$var1="";$var2="";$var3="";$var4="";
        $i=0;
        foreach($var as $key => $v ){
			if($v->des3!=$var3 and $var3!=""){$cadena.="</ul>";
				if($v->des2!=$var2){$cadena.="</li></ul>";
					if($v->des1!=$var1){$cadena.="</li></ul>";
				}}}
							
            if($v->des1!=$var1){$cadena.="<li><a href='#'>".$v->des1."</a><ul>";}
			if($v->des2!=$var2){$cadena.="<li><a href='#'>".$v->des2."</a><ul>";}
			if($v->des3!=$var3){$cadena.="<li><a href='#'>".$v->des3."</a>";$cadena.="<ul>";}
			$cadena.="<li><a href='#'><label><input type='checkbox' name=check class=check id=checks".$v->id4." onclick='activar(".$v->id1.",".$v->id2.",".$v->id3.",".$v->id4.")' > ".$v->des4."</label></a></li>";

			$var1=$v->des1;$var2=$v->des2;$var3=$v->des3;$var4=$v->des4;
            $i++;
        }
        $cadena.="</ul>";
        echo $cadena;
	}
    
	public function obtener_permiso(){
		$codigo=$this->input->get_post('codigo');
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
		
		$filter->codigo=$codigo;
        $var   = $this->usuario_model->obtenerPermiso($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }    
	
    public function cerrar_sesion(){
        $this->session->sess_destroy();
        header("Location:../acceso");
    }
	
	public function registrar_permiso(){
		$codigo=$this->input->get_post('codigo');
		$estado=$this->input->get_post('estado');
		$p1=$this->input->get_post('p1');
		$p2=$this->input->get_post('p2');
		$p3=$this->input->get_post('p3');
		$p4=$this->input->get_post('p4');
		
		$filter     = new stdClass();
        $filter_not = new stdClass();
		
		$filter->codigo=$codigo;
		$filter->estado=$estado;
		$filter->p1=$p1;
		$filter->p2=$p2;
		$filter->p3=$p3;
		$filter->p4=$p4;
		
        $var   = $this->usuario_model->registrarPermiso($filter,$filter_not);
		echo '1';

	}
}