<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class documento_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->library('session');
        date_default_timezone_set('America/Lima');
        
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1 = "documento";
        $this->table_2 = "empresa";
        $this->table_3 = "tipo";
        $this->table_4 = "movimiento";
        $this->table_5 = "dependencia";
        $this->table_6 = "persona";
    }
	
    public function listarDocumento($filter,$filter_not){
        $this->db_1->select('d.*,e.pkEmpresa,e.ruc,e.razonSocial,e.estado,t.descripcion as tipo, s.descripcion as situacion,de.descripcion as dependencia');
        $this->db_1->from($this->table_1.' d');
        $this->db_1->join($this->table_2.' e','e.pkEmpresa=d.pkEmpresa');
        $this->db_1->join($this->table_3.' t','t.pkTipo=d.pkTipo');
        $this->db_1->join($this->table_3.' s','s.pkTipo=d.situacion');
        $this->db_1->join($this->table_5.' de','de.pkDependencia=d.pkDependencia');
        
        $this->db_1->where('d.fechaDocumento >=',date('Y-m-d', strtotime($filter->fecha_ini)));
        $this->db_1->where('d.fechaDocumento <=',date('Y-m-d', strtotime($filter->fecha_fin)));
        $this->db_1->where('d.pkTipoDoc',$filter->tipo_doc);
        if(isset($filter->nrodoc)){$this->db_1->where('d.pkDocumento',$filter->nrodoc);}
        
        $this->db_1->where('d.estado','1');
	$this->db_1->where('e.estado','1');
        $this->db_1->where('t.estado','1');
        $this->db_1->order_by('d.nroTramite','desc');
        
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarMovimiento($filter,$filter_not){
        $this->db_1->select('m.*,s.descripcion as tipo, d.descripcion as dependencia, CONCAT(pe.nombre, " ",pe.apellidoPaterno, " ",pe.apellidoMaterno) as gerente');
        $this->db_1->from($this->table_4.' m');
        $this->db_1->join($this->table_5.' d','d.pkDependencia=m.pkDependencia');
        $this->db_1->join($this->table_6.' p','p.pkPersona=m.pkPersona');
        $this->db_1->join($this->table_3.' s','s.pkTipo=m.situacion');
        $this->db_1->join($this->table_6.' pe','pe.pkPersona=d.pkGerente');
        
        $this->db_1->where('m.pkDocumento',$filter->cod);
        if(isset($filter->nromov)){$this->db_1->where('m.pkMovimiento',$filter->nromov);}
        $this->db_1->where('pe.estado','1');
        $this->db_1->where('pe.cargo','1');
        $this->db_1->where('m.estado','1');
	$this->db_1->where('d.estado','1');
        $this->db_1->where('p.estado','1');
        
        $query = $this->db_1->get();
        
        $result = array();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarDocumentoMovimiento($filter,$filter_not){
        $this->db_1->select('d.*,m.fechaCreada as fechaMovimiento,b.descripcion as estadoMovimiento,"" as nroTramiteMovimiento, a.descripcion as dependenciaMovimiento,m.pkDependencia,m.pkDocumento,e.pkEmpresa,e.ruc,e.razonSocial,e.estado,t.descripcion as tipo, s.descripcion as situacion,de.descripcion as dependencia');
        $this->db_1->from($this->table_1.' d');
        $this->db_1->join($this->table_2.' e','e.pkEmpresa=d.pkEmpresa');
        $this->db_1->join($this->table_3.' t','t.pkTipo=d.pkTipo');
        $this->db_1->join($this->table_3.' s','s.pkTipo=d.situacion');
        $this->db_1->join($this->table_5.' de','de.pkDependencia=d.pkDependencia');
        $this->db_1->join($this->table_4.' m','m.pkDocumento=d.pkDocumento','left');
        $this->db_1->join($this->table_5.' a','a.pkDependencia=m.pkDependencia','left');
        $this->db_1->join($this->table_3.' b','b.pkTipo=m.situacion','left');
        
        $this->db_1->where('d.fechaDocumento >=',date('Y-m-d', strtotime($filter->fecha_ini)));
        $this->db_1->where('d.fechaDocumento <=',date('Y-m-d', strtotime($filter->fecha_fin)));
        $this->db_1->where('d.pkTipoDoc',$filter->tipo_doc);
        
        if(isset($filter->nrodoc)){$this->db_1->where('d.pkDocumento',$filter->nrodoc);}
        if(isset($filter->flaguser)){$this->db_1->where('d.usuarioCreador',$_SESSION['usuario']);}
        
        $this->db_1->where('d.estado','1');
	$this->db_1->where('e.estado','1');
        $this->db_1->where('t.estado','1');
        $this->db_1->where('(m.estado = 1 OR  ISNULL(m.estado))');
        
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        else{ $result="0";}
        return $result;
    }
    
    public function registrarDocumento($filter,$filter_not){
        $contar=0;
        $data =   array('estado' => '1',
                        'nroDocumento' => $filter->nroDocumento,
                        'pkTipo' => $filter->tipo,
                        'pkTipoDoc' => $filter->tipo_doc,
                        'situacion' => '62',
                        'fechaDocumento' => date('Y-m-d', strtotime($filter->fechaDocumento)),
                        'pkEmpresa' => $filter->empresa,
                        'pkDependencia' => $filter->unidad,
                        'pkPersona' => $filter->persona,
                        'asunto' => $filter->asunto,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'dependenciaCreador' => $_SESSION['pkDependencia'],
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
        $this->db_1->insert($this->table_1, $data); 
        $id=$this->db_1->insert_id();
        
        $this->db_1->select('*');
        $this->db_1->from($this->table_1.' d');
        $this->db_1->where('d.fechaDocumento>=',date("Y")."-01-01");
        $this->db_1->where('d.dependenciaCreador',$_SESSION['pkDependencia']);
        $this->db_1->where('d.estado','1');

        $query = $this->db_1->get();
        $contar=$query->num_rows();
        //echo $contar;die;
        $datau = array('nroTramite' => date("Y").$_SESSION['sigla'].str_pad(($contar), '6', '0', STR_PAD_LEFT));
        $this->db_1->where('pkDocumento', $id);
        $this->db_1->update($this->table_1, $datau);
    }
    
    public function registrarMovimiento($filter,$filter_not){
        $data =   array('estado' => '1',
                        'pkDocumento' => $filter->cod_documento,
                        'decreto' => $filter->decreto,
                        'ampliacion' => $filter->ampliacion,
                        'nroMemo' => $filter->nroMemo,
                        'fechaVencimiento' => date('Y-m-d', strtotime($filter->fechaVencimiento)),
                        'pkEmpresa' => '1',
                        'pkDependencia' => $filter->dependencia,
                        'pkPersona' => $filter->persona,
                        'situacion' => $filter->situacion,
                        'prioridad' => $filter->prioridad,
                        'acciones' => $filter->acciones,
                        'asunto' => $filter->asunto,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
        $this->db_1->insert($this->table_4, $data);      
    }
    
    public function modificarMovimiento($filter,$filter_not){
        $data =   array('estado' => '1',
                        'decreto' => $filter->decreto,
                        'ampliacion' => $filter->ampliacion,
                        'nroMemo' => $filter->nroMemo,
                        'fechaVencimiento' => date('Y-m-d', strtotime($filter->fechaVencimiento)),
                        'pkEmpresa' => '1',
                        'pkDependencia' => $filter->dependencia,
                        'pkPersona' => $filter->persona,
                        'situacion' => $filter->situacion,
                        'prioridad' => $filter->prioridad,
                        'acciones' => $filter->acciones,
                        'asunto' => $filter->asunto,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );
        $this->db_1->where('estado', '1');
        $this->db_1->where('pkMovimiento', $filter->cod_movimiento);
        $this->db_1->update($this->table_4, $data);      
    }
    
    public function modificarDocumento($filter,$filter_not){
        $data =   array('nroDocumento' => $filter->nroDocumento,
                        'pkTipo' => $filter->tipo,
                        'fechaDocumento' => date('Y-m-d', strtotime($filter->fechaDocumento)),
                        'pkEmpresa' => $filter->empresa,
                        'pkDependencia' => $filter->unidad,
                        'pkPersona' => $filter->persona,
                        'asunto' => $filter->asunto,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
        $this->db_1->where('estado', '1');
        $this->db_1->where('pkDocumento', $filter->cod_documento);
        $this->db_1->update($this->table_1, $data); 
    }
    
    public function anularDocumento($filter,$filter_not){
        $data = array('estado' => '0', 'usuarioModificador' => $_SESSION['usuario'],'fechaModificada' => date('Y-m-d H:i:s'));
        $this->db_1->where('pkDocumento', $filter->nrodoc);
        $this->db_1->update($this->table_1, $data); 
    }
    
    public function anularMovimiento($filter,$filter_not){
        $data = array('estado' => '0', 'usuarioModificador' => $_SESSION['usuario'],'fechaModificada' => date('Y-m-d H:i:s'));
        $this->db_1->where('pkMovimiento', $filter->nromov);
        $this->db_1->update($this->table_4, $data); 
    }
}