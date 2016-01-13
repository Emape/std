<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class maestro_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1 = "tipo";
        $this->table_2 = "empresa";
        $this->table_3 = "dependencia";
        $this->table_4 = "persona";
    }
    
    public function listarTipo($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_1.' t');
        
        $this->db_1->where('t.grupo',$filter->grupo);
        $this->db_1->where('t.estado','1');
        $this->db_1->order_by("t.descripcion", "asc"); 
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarEmpresa($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_2.' e');
        
        $this->db_1->where('e.estado','1');
        $this->db_1->order_by("e.razonSocial", "asc");
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarDependencia($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_3.' d');
        $this->db_1->where('d.pkEmpresa',$filter->pkEmpresa);
        $this->db_1->where('d.estado','1');
        $this->db_1->order_by("d.descripcion", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarPersona($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_4.' p');
        $this->db_1->where('p.pkDependencia',$filter->pkDependencia);
        $this->db_1->where('p.estado','1');
        $this->db_1->order_by("p.apellidoPaterno", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function registrarUnidad($filter,$filter_not){
        $data =   array('estado' => '1',
                        'descripcion' => strtoupper($filter->detalle_unidad),
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        'pkEmpresa' => $filter->entidad,
                        );    
        $this->db_1->insert($this->table_3, $data);      
    }
    
    public function registrarPersona($filter,$filter_not){
        $data =   array('estado' => '1',
                        'apellidoPaterno' => strtoupper($filter->detalle_paterno),
                        'apellidoMaterno' => strtoupper($filter->detalle_materno),
                        'nombre' => strtoupper($filter->detalle_nombre),
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        'pkdependencia' => $filter->unidad,
                        'pkEmpresa' => $filter->entidad,
                        );     
        $this->db_1->insert($this->table_4, $data);      
    }
}
