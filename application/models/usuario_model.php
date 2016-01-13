<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class usuario_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1 = "usuario";
        $this->table_2 = "persona";
        $this->table_3 = "dependencia";
        $this->table_4 = "permiso";
    }
	
    public function obtener_usuario($filter,$filter_not){
        $this->db_1->select('*');
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
}
