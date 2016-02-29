<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class usuario_model extends CI_Model{
    public function __construct(){
        parent::__construct();
		 $this->load->library('session');
        date_default_timezone_set('America/Lima');
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1 = "usuario";
        $this->table_2 = "persona";
        $this->table_3 = "dependencia";
        $this->table_4 = "permiso";
    }
	
    public function obtener_usuario($filter,$filter_not){
        $this->db_1->select('*, p.pkDependencia as unidadx,u.pkDependencia as unidadu, d.dependencia as central');
        $this->db_1->from($this->table_1.' u');
        $this->db_1->join($this->table_2.' p','p.pkPersona=u.pkPersona');
        $this->db_1->join($this->table_3.' d','d.pkDependencia=u.pkDependencia');
        
        $this->db_1->where('u.usuario',trim($filter->usuario));
        $this->db_1->where('u.contrasena',trim(md5($filter->contrasena)));
        $this->db_1->where('u.estado','1');
        $this->db_1->where('p.estado','1');
        $this->db_1->where('d.estado','1');
		
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->row();
        }
        return $result;
    } 
	
	public function obtenerPermiso($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_4.' p');
		$this->db_1->where('p.pkUsuario',$filter->codigo);
		
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function obtener_permiso($filter,$filter_not){
        $this->db_1->select('pkPermiso,pkMenu,pkSubmenu,pkSeccion,pkOperador');
        $this->db_1->from($this->table_4.' p');
        
        $this->db_1->where('p.pkUsuario',trim($filter->cod_usuario));
        $this->db_1->where('p.estado','1');
		
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    } 
	
	public function cambiarContrasena($filter,$filter_not){
		$data =   array('contrasena' => md5($filter->pass),
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );					
        $this->db_1->where('estado', '1');
		$this->db_1->where('usuario', $_SESSION['usuario']);
        $this->db_1->update($this->table_1, $data);   
	}
	
	public function registrarPermiso($filter,$filter_not){

		$this->db_1->select('count(*) as contador');
        $this->db_1->from($this->table_4.' p');
        $this->db_1->where('p.pkUsuario',$filter->codigo);
		$this->db_1->where('p.pkMenu',$filter->p1);
		$this->db_1->where('p.pkSubmenu',$filter->p2);
		$this->db_1->where('p.pkSeccion',$filter->p3);
		$this->db_1->where('p.pkOperador',$filter->p4);

        $query = $this->db_1->get();
        $contador=$query->row()->contador;

		if($contador=='0'){
			$data =   array('estado' => '1',
                        'pkUsuario' => $filter->codigo,
                        'pkMenu' => $filter->p1,
                        'pkSubmenu' => $filter->p2,
						'pkSeccion' => $filter->p3,
                        'pkOperador' => $filter->p4,
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
			$this->db_1->insert($this->table_4, $data); 
		}
		else{
			$data =   array('estado' => $filter->estado,
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
						);    
		$this->db_1->where('pkUsuario',$filter->codigo);
		$this->db_1->where('pkMenu',$filter->p1);
		$this->db_1->where('pkSubmenu',$filter->p2);
		$this->db_1->where('pkSeccion',$filter->p3);
		$this->db_1->where('pkOperador',$filter->p4);
		
		$this->db_1->update($this->table_4, $data);
		}
	}
}
