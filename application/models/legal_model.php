<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class legal_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->library('session');
        date_default_timezone_set('America/Lima');
        
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1= "expediente";
        $this->table_2= "categoria_juridica";
		$this->table_3= "documento";
		$this->table_4= "movimiento";
		$this->table_5= "tipo";
		$this->table_6= "actividad";
    }
	
    public function listarCategoria($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_2.' c');
        $this->db_1->where('c.grupo',$filter->grupo);
        $this->db_1->where('c.estado','1');
        $this->db_1->order_by('c.descripcion','asc');
        
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function listarTipo($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_5.' t');
        $this->db_1->where('t.grupo',$filter->grupo);
        $this->db_1->where('t.estado','1');
        $this->db_1->order_by('t.descripcion','asc');
        
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function listarExpediente($filter,$filter_not){
        $this->db_1->select('t.descripcion as tipoDetalle,d.nroTramite,m.pkMovimiento as cod_mov,e.*');
		$this->db_1->from($this->table_3.' d');
		$this->db_1->join($this->table_4.' m', 'm.pkDocumento=d.pkDocumento');
		$this->db_1->join($this->table_1.' e', 'e.pkMovimiento=m.pkMovimiento','left');
		$this->db_1->join($this->table_5.' t', 't.pkTipo=e.situacion','left');		
		
        if(isset($filter->cod) and $filter->cod!="")$this->db_1->where('e.pkExpediente',$filter->cod);
		
		
		if(isset($filter->distrito) and $filter->distrito!="")$this->db_1->where('e.pkDistrito',$filter->distrito);
		if(isset($filter->organo) and $filter->organo!="")$this->db_1->where('e.pkOrgano',$filter->organo);
		if(isset($filter->especialidad) and $filter->especialidad!="")$this->db_1->where('e.pkEspecialidad',$filter->especialidad);
		if(isset($filter->sede) and $filter->sede!="")$this->db_1->where('e.pkSede',$filter->sede);
		if(isset($filter->sala) and $filter->sala!="")$this->db_1->where('e.pkSala',$filter->sala);
		
		if(isset($filter->anio) and $filter->anio!="")$this->db_1->where('(e.anio='.$filter->anio.' or e.anio IS NULL)');

		//$this->db_1->where('d.pkTipoDoc','2');
		$this->db_1->where('d.estado','1');
		$this->db_1->where('m.estado','1');
		//$this->db_1->where('m.pkDependencia','3');
		$this->db_1->where('m.pkPersona',$_SESSION['codigo_persona']);
		
		$this->db_1->order_by('d.fechaDocumento','asc');
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function listarActividad($filter,$filter_not){
        $this->db_1->select('t.descripcion as actividadDetalle, t1.descripcion as actoDetalle,a.*');
		$this->db_1->from($this->table_6.' a');
		$this->db_1->join($this->table_5.' t', 't.pkTipo=a.actividad','left');
		$this->db_1->join($this->table_5.' t1', 't1.pkTipo=a.acto','left');
        if(isset($filter->cod_actividad) and $filter->cod_actividad!="")$this->db_1->where('a.pkActividad',$filter->cod_actividad);
		else $this->db_1->where('a.pkExpediente',$filter->cod);
		
		//$this->db_1->where('t.pkTipo','6');
		//$this->db_1->where('t1.pkTipo','7');
		$this->db_1->where('a.estado','1');
		
		
		$this->db_1->order_by('a.fechaInicio','asc');
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function registrarExpediente($filter,$filter_not){
		$data =   array('pkMovimiento' => $filter->cod_mov,
						'nroExpediente' => strtoupper($filter->expediente),
						'anio' => substr($filter->fecha,6,4),
						'delito' => strtoupper($filter->delito),
						'pkDistrito' => $filter->distrito,
						'pkOrgano' => $filter->organo,
						'pkEspecialidad' => $filter->especialidad,
						'pkSede' => $filter->sede,
						'pkSala' => $filter->sala,
						'fecha' => substr($filter->fecha,6,4).'-'.substr($filter->fecha,3,2).'-'.substr($filter->fecha,0,2),
						'resumen' => strtoupper($filter->resumen),
						'situacion' => $filter->situacion,
						'involucrados' => strtoupper($filter->involucrado),
						'usuarioCreador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
						'estado' => '1',
                        );					
        $this->db_1->insert($this->table_1, $data);  
	}
	
	public function modificarExpediente($filter,$filter_not){
		$data =   array('nroExpediente' => strtoupper($filter->expediente),
						'anio' => substr($filter->fecha,6,4),
						'delito' => strtoupper($filter->delito),
						'pkDistrito' => $filter->distrito,
						'pkOrgano' => $filter->organo,
						'pkEspecialidad' => $filter->especialidad,
						'pkSede' => $filter->sede,
						'pkSala' => $filter->sala,
						'fecha' => substr($filter->fecha,6,4).'-'.substr($filter->fecha,3,2).'-'.substr($filter->fecha,0,2),
						'resumen' => strtoupper($filter->resumen),
						'situacion' => $filter->situacion,
						'involucrados' => strtoupper($filter->involucrado),
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );									
        $this->db_1->where('estado', '1');
		$this->db_1->where('pkExpediente', $filter->doc);
        $this->db_1->update($this->table_1, $data);  
	}
	
		public function registrarActividad($filter,$filter_not){
		$data =   array('pkExpediente' => $filter->cod_expediente,
						'actividad' => $filter->actividad,
						'acto' => $filter->acto,
						'sumilla' => strtoupper($filter->sumilla),
						'fechaInicio' => substr($filter->fecha_inicio,6,4).'-'.substr($filter->fecha_inicio,3,2).'-'.substr($filter->fecha_inicio,0,2),
						'fechaProgramada' => substr($filter->fecha_programada,6,4).'-'.substr($filter->fecha_programada,3,2).'-'.substr($filter->fecha_programada,0,2),
						'anexo' => strtoupper($filter->anexo),
						'observacion' => strtoupper($filter->observacion),
						'usuarioCreador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
						'estado' => '1',
                        );					
        $this->db_1->insert($this->table_6, $data);  
	}
	
	public function modificarActividad($filter,$filter_not){
		$data =   array('actividad' => $filter->actividad,
						'acto' => $filter->acto,
						'sumilla' => strtoupper($filter->sumilla),
						'fechaInicio' => substr($filter->fecha_inicio,6,4).'-'.substr($filter->fecha_inicio,3,2).'-'.substr($filter->fecha_inicio,0,2),
						'fechaProgramada' => substr($filter->fecha_programada,6,4).'-'.substr($filter->fecha_programada,3,2).'-'.substr($filter->fecha_programada,0,2),
						'anexo' => strtoupper($filter->anexo),
						'observacion' => strtoupper($filter->observacion),
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );									
        $this->db_1->where('estado', '1');
		$this->db_1->where('pkActividad', $filter->cod_actividad);
        $this->db_1->update($this->table_6, $data);  
	}
	
	public function anularActividad($filter,$filter_not){
		$data =   array('estado' =>'0',
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );									
		$this->db_1->where('pkActividad', $filter->actividad);
        $this->db_1->update($this->table_6, $data);  
	}
}