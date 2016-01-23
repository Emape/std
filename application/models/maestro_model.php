<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class maestro_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1 = "tipo";
        $this->table_2 = "empresa";
        $this->table_3 = "dependencia";
        $this->table_4 = "persona";
        $this->table_5 = "asistencia_locador";
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
        $this->db_1->select('p.*,de.descripcion as gerencia,"" as asistio, "" as tiempo ');
        $this->db_1->from($this->table_4.' p');
        $this->db_1->join($this->table_3.' de','de.pkDependencia=p.pkDependencia');
        $this->db_1->where('p.pkDependencia',$filter->pkDependencia);
        $this->db_1->where('p.estado','1');
        if(isset($filter->estado_locador)){$this->db_1->where('p.locador',$filter->estado_locador);}
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
    
    public function registrarAsistencia($filter,$filter_not){    

        foreach ($filter->pkPersona as $key=>$val)
   	{   
            
            if($filter->horaMinuto[$key]==""){$asistio='0';}else $asistio='1';

            $fecha=   date('Y-m-d', strtotime(str_replace('/', '-', $filter->fecha)));
            
            $data =   array('asistio' => $asistio,
                        'horaMinuto' => $filter->horaMinuto[$key],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        ); 
            $this->db_1->where('pkPersona',$val);
            $this->db_1->where('fecha',$fecha);
            $this->db_1->where('estado','1');
            $this->db_1->update($this->table_5, $data);
            $existe = $this->db_1->affected_rows();
            
            if($existe!='1'){
            $data =   array('estado' => '1',
                        'pkPersona' => $val,
                        'asistio' => $asistio,
                        'fecha' => $fecha,
                        'pkDependencia' => $filter->pkDependencia,
                        'horaMinuto' => $filter->horaMinuto[$key],
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );     
            $this->db_1->insert($this->table_5, $data);
            }
        }
    }
    
    public function existeFecha($fecha,$dependencia){
        $this->db_1->select('*');
        $this->db_1->from($this->table_5.' al');
        $this->db_1->where('al.estado','1');
        $this->db_1->where('al.fecha',$fecha);
        $this->db_1->where('al.pkDependencia',$dependencia);
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        else{
        $result='0';
        }
        return $result;
    }
    
    public function listarAsistencia($filter,$filter_not){
        $this->db_1->select('p.*,de.descripcion as gerencia,al.asistio as asistio, al.horaMinuto as tiempo');
        $this->db_1->from($this->table_5.' al');
        $this->db_1->join($this->table_4.' p','p.pkPersona=al.pkPersona');
        $this->db_1->join($this->table_3.' de','de.pkDependencia=p.pkDependencia');
        $this->db_1->where('p.estado','1');
        $this->db_1->where('al.estado','1');
        $this->db_1->where('p.locador','1');
        $this->db_1->where('al.fecha',$filter->fecha);
        $this->db_1->where('al.pkDependencia',$filter->pkDependencia);
        $this->db_1->order_by("p.apellidoPaterno", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    
}
