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
		$this->table_5 = "chat";
    }
	
    public function obtener_usuario($filter,$filter_not){
        $this->db_1->select('*, p.pkPersona, p.pkDependencia as unidadx,u.pkDependencia as unidadu, d.dependencia as central');
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
	
	public function listarUsuarioChat(){
        $this->db_1->select('u.pkUsuario,u.usuario,pe.razonSocial');
        $this->db_1->from($this->table_4.' p');
        $this->db_1->join($this->table_1.' u','u.pkUsuario=p.pkUsuario');
        $this->db_1->join($this->table_2.' pe','pe.pkPersona=u.pkPersona');
		
        $this->db_1->where('u.estado','1');
        $this->db_1->where('p.estado','1');
        $this->db_1->where('pe.estado','1');
		$this->db_1->where('p.pkOperador','45');
		
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function listarChat($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_5.' c');
        $this->db_1->where("(DATE_FORMAT(fechaCreada,'%Y-%m-%d')='".date('Y-m-d')."' or DATE_FORMAT(fechaCreada,'%Y-%m-%d')='".date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ( date('Y-m-d') ) ))."') and ((pkUsuario='".$_SESSION['codigo']."' and pkUsuarioDestino='".$filter->destino."') or (pkUsuario='".$filter->destino."' and pkUsuarioDestino='".$_SESSION['codigo']."'))");
        $this->db_1->where('c.estado','1');

        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function listarVerMsj(){
        $this->db_1->select('*');
        $this->db_1->from($this->table_5.' c');
        $this->db_1->where("(DATE_FORMAT(fechaCreada,'%Y-%m-%d')='".date('Y-m-d')."' or DATE_FORMAT(fechaCreada,'%Y-%m-%d')='".date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ( date('Y-m-d') ) ))."')  and visto=0");
		$this->db_1->where('pkUsuarioDestino', $_SESSION['codigo']);
        $this->db_1->where('c.estado','1');

        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
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
	
	public function modificarVisto($filter,$filter_not){
		$data =   array('visto' => '1',
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );					
        $this->db_1->where('estado', '1');
		$this->db_1->where('pkUsuarioDestino', $_SESSION['codigo']);
        $this->db_1->update($this->table_5, $data);   
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
	
	public function registrarChat($filter,$filter_not){

			$data =   array('pkUsuario' => $_SESSION['codigo'],
						'pkUsuarioDestino' => $filter->destino,
						'detalle' => $filter->detalle,
						'visto' => '0',
						'estado' => '1',
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );    
			$this->db_1->insert($this->table_5, $data); 
	}
	
	public function anularUsuario($filter,$filter_not){
		$data =   array('estado' => '0',
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );					
    
		$this->db_1->where('pkPersona', $filter->usuario);
        $this->db_1->update($this->table_2, $data);  	

		$datau =   array('estado' => '0',
						'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );					
    
		$this->db_1->where('pkPersona', $filter->usuario);
        $this->db_1->update($this->table_1, $datau);  
	}
	
	public function listarPersona($filter,$filter_not){
        $this->db_1->select('p.pkPersona,p.dni,p.apellidoPaterno,p.apellidoMaterno,p.nombre,p.ruc,p.razonSocial,p.email,p.cargo,p.locador,p.pkDependencia,u.pkUsuario,u.usuario,u.contrasena,u.nivel');
        $this->db_1->from($this->table_2.' p');
        $this->db_1->join($this->table_1.' u','u.pkPersona=p.pkPersona','left');
		
        $this->db_1->where('p.pkPersona',trim($filter->cod));
        $this->db_1->where('p.estado','1');
		
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    } 
	
	public function registrarPersona($filter,$filter_not){
		if($filter->contrasena=="") $pwd=$filter->password;
		else $pwd=md5($filter->contrasena);
		
		if(isset($filter->locador)) $locador='1';else $locador='0';
		
		// validar si existe el usuario
		$this->db_1->select('count(*) as contador');
        $this->db_1->from($this->table_1.' u');
        $this->db_1->where('u.usuario',trim($filter->usuario));
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
		
		
        if($result[0]->contador==0 or $filter->pkUsuario!="" or $filter->pkUsuario==""){
			if($filter->pkPersona==""){
				$data =   array('dni' => $filter->dni,
						'ruc' => $filter->ruc,
						'pkDependencia' => $filter->dependencia,
						'apellidoPaterno' => strtoupper($filter->apellido_paterno),
						'apellidoMaterno' => strtoupper($filter->apellido_materno),
						'nombre' => strtoupper($filter->nombre),
						'razonSocial' => strtoupper($filter->razon_social),
						'cargo' => $filter->cargo,
						'email' => $filter->email,
						'locador' => $locador,
						'estado' => '1',
						'pkEmpresa' => '1',
                        'usuarioCreador' => strtolower($_SESSION['usuario']),
                        'usuarioModificador' => strtolower($_SESSION['usuario']),
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );  
				$this->db_1->insert($this->table_2, $data);
				$id_persona=$this->db_1->insert_id();
			}else{
				$data =  array('dni' => $filter->dni,
						'ruc' => $filter->ruc,
						'pkDependencia' => $filter->dependencia,
						'apellidoPaterno' => strtoupper($filter->apellido_paterno),
						'apellidoMaterno' => strtoupper($filter->apellido_materno),
						'nombre' => strtoupper($filter->nombre),
						'razonSocial' => strtoupper($filter->razon_social),
						'cargo' => $filter->cargo,
						'email' => $filter->email,
						'locador' => $locador,
						'estado' => '1',
						'pkEmpresa' => '1',
                        'usuarioModificador' => strtolower($_SESSION['usuario']),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        ); 
				$this->db_1->where('pkPersona',$filter->pkPersona);
				$this->db_1->update($this->table_2, $data);
				$id_persona=$filter->pkPersona;
			} 	

			if($filter->pkUsuario==""){
				$data =   array('usuario' => strtolower($filter->usuario),
						'contrasena' => strtolower($pwd),
						'estado' => '1',
						'pkPersona' => $id_persona,
						'pkEmpresa' => '1',
						'pkDependencia' => $filter->dependencia,
						'nivel' => $filter->nivel,
                        'usuarioCreador' => strtolower($_SESSION['usuario']),
                        'usuarioModificador' => strtolower($_SESSION['usuario']),
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );  
				$this->db_1->insert($this->table_1, $data);
			}else{
				$data =   array('usuario' => strtolower($filter->usuario),
						'contrasena' => strtolower($pwd),
						'estado' => '1',
						'pkPersona' => $id_persona,
						'pkEmpresa' => '1',
						'pkDependencia' => $filter->dependencia,
						'nivel' => $filter->nivel,
                        'usuarioModificador' => strtolower($_SESSION['usuario']),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );   
				$this->db_1->where('pkUsuario',$filter->pkUsuario);
				$this->db_1->update($this->table_1, $data);
			} 
			$msj=1;//registrado usuario	
		}
		else{
			$msj=2;//existe usuario
		}			
			return $msj;
	}
	
	public function validarUsuario($usuario){
		// validar si existe el usuario
		$this->db_1->select('count(*) as contador');
        $this->db_1->from($this->table_1.' u');
        $this->db_1->where('u.usuario',trim($usuario));
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
		return $result;
	}
}
