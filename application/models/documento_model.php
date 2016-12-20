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
        $this->db_1->order_by('d.pkDocumento','desc');
        
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarMovimiento($filter,$filter_not){
        $this->db_1->select('m.*,REPLACE(nroMemo, " ", "") as nroMemo,s.descripcion as tipo, d.descripcion as dependencia, CONCAT(pe.nombre, " ",pe.apellidoPaterno, " ",pe.apellidoMaterno) as gerente');
        $this->db_1->from($this->table_4.' m');
        $this->db_1->join($this->table_5.' d','d.pkDependencia=m.pkDependencia','LEFT');
        $this->db_1->join($this->table_6.' p','p.pkPersona=m.pkPersona','LEFT');
        $this->db_1->join($this->table_3.' s','s.pkTipo=m.situacion','LEFT');
        $this->db_1->join($this->table_6.' pe','pe.pkPersona=d.pkGerente','LEFT');
        
        $this->db_1->where('m.pkDocumento',$filter->cod);
        if(isset($filter->nromov)){$this->db_1->where('m.pkMovimiento',$filter->nromov);}
        //$this->db_1->where('pe.estado','1');
        //$this->db_1->where('pe.cargo','1');
        $this->db_1->where('m.estado','1');
		$this->db_1->where('d.estado','1');
		$this->db_1->order_by('m.fechaCreada','asc');
        //$this->db_1->where('p.estado','1');
        
        $query = $this->db_1->get();
        
        $result = array();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function obtenerNroTipoDoc($filter,$filter_not){
        /*$this->db_1->select("de.siglas , MAX(substring_index(d.nroDocumento,'-',1)*1)+1 as nro");
        $this->db_1->from($this->table_1.' d');
        $this->db_1->join($this->table_5.' de','de.pkDependencia=d.pkDependencia');
        $this->db_1->where('d.fechaDocumento >=',date('Y').'-01-01');
        $this->db_1->where('d.pkTipoDoc','1');
		$this->db_1->where('d.pkTipo',$filter->tipo);
		$this->db_1->where('d.pkDependencia',$filter->unidad);
		$this->db_1->not_like('d.nroDocumento','2015');*/
		
		$query=$this->db_1->query("(SELECT dependencia.siglas,'' AS nro FROM dependencia WHERE pkDependencia = '".$filter->unidad."' ) UNION (SELECT de.siglas, MAX(substring_index(d.nroDocumento, '-', 1)*1)+1 as nro FROM documento d JOIN dependencia de ON de.pkDependencia=d.pkDependencia WHERE d.fechaDocumento >= '".date('Y').'-01-01'."' AND d.pkTipoDoc = '1' AND d.pkTipo = '".$filter->tipo."' AND d.pkDependencia = '".$filter->unidad."' AND d.estado='1' AND d.nroDocumento NOT LIKE '%2015%') UNION (SELECT de.siglas, MAX(substring_index(d.nroMemo, '-', 1)*1)+1 as nro FROM movimiento d JOIN dependencia de ON de.pkDependencia=d.pkDependencia WHERE d.fechaCreada >= '".date('Y').'-01-01'."' AND d.pkTipo = '".$filter->tipo."' AND d.pkDependencia = '".$filter->unidad."' AND d.estado='1' AND d.nroMemo NOT LIKE '%2015%' )");
		
		//print_r("(SELECT de.siglas, MAX(substring_index(d.nroDocumento, '-', 1)*1)+1 as nro FROM documento d JOIN dependencia de ON de.pkDependencia=d.pkDependencia WHERE d.fechaDocumento >= '".date('Y').'-01-01'."' AND d.pkTipoDoc = '1' AND d.pkTipo = '".$filter->tipo."' AND d.pkDependencia = '".$filter->unidad."' AND d.nroDocumento NOT LIKE '%2015%') UNION (SELECT de.siglas, MAX(substring_index(d.nroMemo, '-', 1)*1)+1 as nro FROM movimiento d JOIN dependencia de ON de.pkDependencia=d.pkDependencia WHERE d.fechaCreada >= '".date('Y').'-01-01'."' AND d.pkTipo = '".$filter->tipo."' AND d.pkDependencia = '".$filter->unidad."' AND d.nroMemo NOT LIKE '%2015%' )");die;
        //$query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function verificarNro($filter,$filter_not){
		
		$query=$this->db_1->query("(SELECT de.siglas, substring_index(d.nroDocumento, '-', 1)*1 as nro FROM documento d JOIN dependencia de ON de.pkDependencia=d.pkDependencia WHERE d.fechaDocumento >= '".date('Y').'-01-01'."' AND d.pkTipoDoc = '1' AND d.estado='1' and d.pkTipo = '".$filter->tipo."' AND d.pkDependencia = '".$filter->unidad."' AND d.nroDocumento NOT LIKE '%2015%') UNION (SELECT de.siglas, substring_index(d.nroMemo, '-', 1)*1 as nro FROM movimiento d JOIN dependencia de ON de.pkDependencia=d.pkDependencia WHERE d.fechaCreada >= '".date('Y').'-01-01'."' AND d.estado='1' and d.pkTipo = '".$filter->tipo."' AND d.pkDependencia = '".$filter->unidad."' AND d.nroMemo NOT LIKE '%2015%' )");

        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
    public function listarDocumentoMovimiento($filter,$filter_not){
		/*$cat=array('9496',
'12369',
'12595',
'4460',
'9080',
'12939',
'13071',
'13305',
'20957',
'26317',
'9257',
'10777',
'10939',
'11207',
'11303',
'11500',
'12080',
'12251',
'12718',
'12805',
'13094',
'13180',
'13256',
'13314',
'13627',
'13629',
'20154',
'20376',
'20380',
'20391',
'20426',
'20577',
'9584',
'9122',
'10709');*/
        $this->db_1->select('CONCAT(pe.nombre, " ",pe.apellidoPaterno, " ",pe.apellidoMaterno) as gerente,m.nroMemo,d.*,m.fechaCreada as fechaMovimiento,b.descripcion as estadoMovimiento,"" as nroTramiteMovimiento, a.descripcion as dependenciaMovimiento,m.pkDependencia,m.pkDocumento,e.pkEmpresa,e.ruc,e.razonSocial,e.estado,t.descripcion as tipo, s.descripcion as situacion,de.descripcion as dependencia');
        $this->db_1->from($this->table_1.' d');
        $this->db_1->join($this->table_2.' e','e.pkEmpresa=d.pkEmpresa');
        $this->db_1->join($this->table_3.' t','t.pkTipo=d.pkTipo');
        $this->db_1->join($this->table_3.' s','s.pkTipo=d.situacion');
        $this->db_1->join($this->table_5.' de','de.pkDependencia=d.pkDependencia');
        $this->db_1->join($this->table_4.' m','m.pkDocumento=d.pkDocumento','left');
        $this->db_1->join($this->table_5.' a','a.pkDependencia=m.pkDependencia','left');
        $this->db_1->join($this->table_3.' b','b.pkTipo=m.situacion','left');
		$this->db_1->join($this->table_6.' pe','pe.pkPersona=a.pkGerente','LEFT');
        
        $this->db_1->where('d.fechaDocumento >=',date('Y-m-d', strtotime($filter->fecha_ini)));
        $this->db_1->where('d.fechaDocumento <=',date('Y-m-d', strtotime($filter->fecha_fin)));
        $this->db_1->where('d.pkTipoDoc',$filter->tipo_doc);
		$this->db_1->where('m.pkDependencia<>','0');
		
		
		//$this->db_1->where_in('d.pkDependencia', $cat);
		//CGR  $this->db_1->where('d.pkDependencia','9080');
		//Acceso a la ifnromacion $this->db_1->where('m.pkDependencia','7');
        
        if(isset($filter->nrodoc)){$this->db_1->where('d.pkDocumento',$filter->nrodoc);}
        //if(isset($filter->flaguser)){$this->db_1->where('d.usuarioCreador',$_SESSION['usuario']);}
        
        $this->db_1->where('d.estado','1');
		$this->db_1->where('e.estado','1');
        $this->db_1->where('t.estado','1');
        $this->db_1->where('(m.estado = 1 OR  ISNULL(m.estado))');
		
		$this->db_1->order_by('a.descripcion,fechaMovimiento','asc');
        
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
		
		if($filter->empresa=='1')
		$vdependencia=$filter->unidad;
		else{
		$vdependencia=$_SESSION['pkDependencia'];
		}
				
        $data =   array('estado' => '1',
                        'nroDocumento' => strtoupper($filter->nroDocumento),
                        'pkTipo' => $filter->tipo,
                        'pkTipoDoc' => $filter->tipo_doc,
                        'situacion' => '62',
                        'fechaDocumento' => date('Y-m-d', strtotime($filter->fechaDocumento)),
                        'pkEmpresa' => $filter->empresa,
                        'pkDependencia' => $filter->unidad,
                        'pkPersona' => $filter->persona,
                        'asunto' => strtoupper($filter->asunto),
                        'areaTrabajo' => $filter->areaTrabajo,
                        'dependenciaCreador' => $_SESSION['pkDependencia'],
                        'usuarioCreador' => strtoupper($_SESSION['usuario']),
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
        $this->db_1->insert($this->table_1, $data); 
        $id=$this->db_1->insert_id();
	
		/*----------Obtener Siglas---------*/
		$this->db_1->select('siglas');
        $this->db_1->from($this->table_5.' d');
		$this->db_1->where('d.pkDependencia',$vdependencia);
        $this->db_1->where('d.estado','1');

        $query = $this->db_1->get();
		if($query->row()->siglas == null)
		$siglas='OT';
		else
        $siglas=$query->row()->siglas;
		/*-----------Fin siglas--------*/

				/*----------Obtener Contar---------*/
		if($siglas=="OT"){
			
		$this->db_1->select('(MAX(CONVERT(RIGHT(nroTramite,6),UNSIGNED INTEGER))+1) AS ultimo');
        $this->db_1->from($this->table_1.' d');
        $this->db_1->where('d.fechaDocumento>=',date("Y")."-01-01");
		$this->db_1->where('d.estado','1');
		$this->db_1->where('d.pkTipoDoc',$filter->tipo_doc);	
		$this->db_1->like('d.nroTramite',date("Y").'OT');	
			
		$query = $this->db_1->get();
		if($query->row()->ultimo == null){
		$contar=1;
		}
		else
        $contar=$query->row()->ultimo;	
			
		}

		else{
			
				
        $this->db_1->select('(MAX(CONVERT(RIGHT(nroTramite,6),UNSIGNED INTEGER))+1) AS ultimo');
        $this->db_1->from($this->table_1.' d');
        $this->db_1->where('d.fechaDocumento>=',date("Y")."-01-01");
		$this->db_1->where('d.estado','1');
		$this->db_1->where('d.pkTipoDoc',$filter->tipo_doc);
		
		
		if($_SESSION['pkDependencia']=='23')
		$this->db_1->where('d.dependenciaCreador',$vdependencia);	
		else
        $this->db_1->where('d.pkDependencia',$vdependencia);
		
        		
        $query = $this->db_1->get();
		if($query->row()->ultimo == null)
		$contar=1;
		else
			$contar=$query->row()->ultimo;
		
        }
			/*--------------Fin Contar--------------*/
		
        $datau = array('nroTramite' => date("Y").$siglas.str_pad(($contar), '6', '0', STR_PAD_LEFT));
        $this->db_1->where('pkDocumento', $id);
        $this->db_1->update($this->table_1, $datau);
		
		
		if($filter->tipo_doc=="1"){
		//**// Inicio Registrar Movimiento
				
		$data =   array('estado' => '1',
                        'pkDocumento' => $id,
                        'nroMemo' => $filter->memo0,
                        'fechaVencimiento' => date('Y-m-d', strtotime($filter->fecha_vencimiento0)),
                        'pkEmpresa' => '1',
						'pkDependencia' => $filter->unidad0,
                        'pkPersona' => $filter->responsable00,
						'situacion' => $filter->estado0,
                        'prioridad' => $filter->prioridad0,
                        'acciones' => $filter->accion0,
						'pkTipo' => $filter->tipo0,
                        'usuarioCreador' => strtoupper($_SESSION['usuario']),
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        ); 
        $this->db_1->insert($this->table_4, $data);      
		
		//**// Fin Registrar Movimiento
		}
		
		$this->db_1->select('siglas');
        $this->db_1->from($this->table_5.' d');
		$this->db_1->where('d.pkDependencia',$vdependencia);
        $this->db_1->where('d.estado','1');

        $query = $this->db_1->get();
		if($query->row()->siglas == null)
		$siglas='OT';
		else
        $siglas=$query->row()->siglas;
		
		return date("Y").$siglas.str_pad(($contar), '6', '0', STR_PAD_LEFT);
    }
    
    public function registrarMovimiento($filter,$filter_not){
        $data =   array('estado' => '1',
                        'pkDocumento' => $filter->cod_documento,
                        'decreto' => $filter->decreto,
                        'ampliacion' => $filter->ampliacion,
                        'nroMemo' => strtoupper($filter->nroMemo),
                        'fechaVencimiento' => date('Y-m-d', strtotime($filter->fechaVencimiento)),
                        'pkEmpresa' => '1',
                        'pkDependencia' => $filter->dependencia,
                        'pkPersona' => $filter->persona,
                        'situacion' => $filter->situacion,
                        'prioridad' => $filter->prioridad,
                        'acciones' => $filter->acciones,
                        'asunto' => $filter->asunto,
						'pkTipo' => $filter->tipo2,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioCreador' => strtoupper($_SESSION['usuario']),
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        ); 
        $this->db_1->insert($this->table_4, $data);      
		
		$data =   array('estado' => '1',                    
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaModificada' => date('Y-m-d H:i:s'),
						'situacion' => $filter->situacion,
                        );	
						
        $this->db_1->where('estado', '1');
        $this->db_1->where('pkDocumento', $filter->cod_documento);
        $this->db_1->update($this->table_1, $data);      
		
    }
    
    public function modificarMovimiento($filter,$filter_not){
		
		if(isset($filter->dependencia)){
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
						'pkTipo' => $filter->tipo2,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );
						
		}	
		else{
	        $data =   array('estado' => '1',                    
                        'nroMemo' => $filter->nroMemo,
                        'pkEmpresa' => '1',
                        'pkPersona' => $filter->persona,
                        'situacion' => $filter->situacion,
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaModificada' => date('Y-m-d H:i:s'),
						'pkTipo' => $filter->tipo2,
                        );
		}		
						
        $this->db_1->where('estado', '1');
        $this->db_1->where('pkMovimiento', $filter->cod_movimiento);
        $this->db_1->update($this->table_4, $data);      
		
		$data =   array('estado' => '1',                    
                'usuarioModificador' => strtoupper($_SESSION['usuario']),
                'fechaModificada' => date('Y-m-d H:i:s'),
				'situacion' => $filter->situacion,
                );
	
						
        $this->db_1->where('estado', '1');
        $this->db_1->where('pkDocumento', $filter->cod_documento);
        $this->db_1->update($this->table_1, $data);
    }
    
    public function modificarDocumento($filter,$filter_not){
        $data =   array('nroDocumento' => $filter->nroDocumento,
                        'pkTipo' => $filter->tipo,
                        'fechaDocumento' => date('Y-m-d', strtotime($filter->fechaDocumento)),
                        'pkEmpresa' => $filter->empresa,
                        'pkDependencia' => $filter->unidad,
                        'pkPersona' => $filter->persona,
                        'asunto' => strtoupper($filter->asunto),
                        'areaTrabajo' => $filter->areaTrabajo,
                        'usuarioModificador' => strtoupper($_SESSION['usuario']),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
        $this->db_1->where('estado', '1');
        $this->db_1->where('pkDocumento', $filter->cod_documento);
        $this->db_1->update($this->table_1, $data); 
		
		return  $filter->nroTramite;
    }
    
    public function anularDocumento($filter,$filter_not){
        $data = array('estado' => '0', 'usuarioModificador' => strtoupper($_SESSION['usuario']),'fechaModificada' => date('Y-m-d H:i:s'));
        $this->db_1->where('pkDocumento', $filter->nrodoc);
        $this->db_1->update($this->table_1, $data); 
    }
    
    public function anularMovimiento($filter,$filter_not){
        $data = array('estado' => '0', 'usuarioModificador' => strtoupper($_SESSION['usuario']),'fechaModificada' => date('Y-m-d H:i:s'));
        $this->db_1->where('pkMovimiento', $filter->nromov);
        $this->db_1->update($this->table_4, $data); 
    }
}