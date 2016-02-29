<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class maestro_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        date_default_timezone_set('America/Lima');
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1 = "tipo";
        $this->table_2 = "empresa";
        $this->table_3 = "dependencia";
        $this->table_4 = "persona";
        $this->table_5 = "asistencia_locador";
        $this->table_6 = "cierre_asistencia";
		$this->table_7 = "usuario";
		$this->table_8 = "menu";
    }
    
    public function listarTipo($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_1.' t');
        
		if($filter->grupo=='2')
        $this->db_1->where('t.grupo=1 OR t.grupo=2');
		else
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
    
    public function verificarCierre($filter,$filter_not){
        $this->db_1->select(' count(*) as verify');
        $this->db_1->from($this->table_6.' c');
        $this->db_1->where('c.dependencia',$filter->pkDependencia);
        $this->db_1->where('c.mes',$filter->mes);
        $this->db_1->where('c.anio',$filter->anio);
        $this->db_1->where('c.estado','1');
        
        $query = $this->db_1->get();
        $result = $query->result();

        return $result;
    }
    
    public function verificarAsistencia($filter,$filter_not){
        $fecha=   date('Y-m-d', strtotime(str_replace('/', '-', $filter->fecha)));
        $this->db_1->select(' count(*) as cantidad');
        $this->db_1->from($this->table_5.' al');
        $this->db_1->where('al.pkDependencia',$filter->pkDependencia);
        $this->db_1->where('al.fecha',$fecha);
        $this->db_1->where('al.estado','1');
        
        $query = $this->db_1->get();
        $result = $query->result();

        return $result;
    }
    
    public function listarPersona2($filter,$filter_not){
        $this->db_1->select('p.*,de.descripcion as gerencia,"" as asistio, "" as tiempo, "" as tiempo2, "" as observacion ');
        $this->db_1->from($this->table_4.' p');
        $this->db_1->join($this->table_3.' de','de.pkDependencia=p.pkDependencia');
        
        if($filter->central=="1"){
            if($filter->dependencia=='2')
                $arrcc = array('9','10',$filter->pkDependencia);   
            else if($filter->dependencia=='3')
                 $arrcc = array('12',$filter->pkDependencia);
            else if($filter->dependencia=='4')
                $arrcc = array('11','13','14',$filter->pkDependencia); 
            else if($filter->dependencia=='5')
                $arrcc = array('15','16','17','18',$filter->pkDependencia); 
            else if($filter->dependencia=='6')
                $arrcc = array('19','20','21','22',$filter->pkDependencia); 
            
            $this->db_1->where_in('p.pkDependencia',$arrcc); 
        }
        else{
        $this->db_1->where('p.pkDependencia',$filter->pkDependencia);     
        }
        $this->db_1->where('p.estado','1');
        if(isset($filter->estado_locador)){$this->db_1->where('p.locador',$filter->estado_locador);}
        $this->db_1->order_by("de.descripcion,p.razonSocial", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
    
	public function listarPersona3(){
        $this->db_1->select('p.*,de.descripcion as gerencia,pe.nivel,pe.pkUsuario ');
        $this->db_1->from($this->table_4.' p');
        $this->db_1->join($this->table_3.' de','de.pkDependencia=p.pkDependencia');
		$this->db_1->join($this->table_7.' pe','pe.pkPersona=p.pkPersona','left');
        $this->db_1->where('p.estado','1');
        //$this->db_1->where('p.locador','1');
		$this->db_1->where('p.pkEmpresa','1');
        $this->db_1->order_by("de.descripcion,p.razonSocial", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
	
	public function plantillaPermiso(){
        $this->db_1->select('m1.pkMenu as id1, m1.descripcion des1,m2.pkMenu as id2, m2.descripcion des2,m3.pkMenu as id3, m3.descripcion des3,m4.pkMenu as id4, m4.descripcion des4');
        $this->db_1->from($this->table_8.' m1');
        $this->db_1->join($this->table_8.' m2','m2.dependencia=m1.pkMenu');
		$this->db_1->join($this->table_8.' m3','m3.dependencia=m2.pkMenu');
		$this->db_1->join($this->table_8.' m4','m4.dependencia=m3.pkMenu');
        $this->db_1->where('m1.nivel','1');
		$this->db_1->where('m2.nivel','2');
		$this->db_1->where('m3.nivel','3');
		$this->db_1->where('m4.nivel','4');
        $this->db_1->order_by("m1.descripcion", "asc");
        $this->db_1->order_by("m2.descripcion", "asc");
		$this->db_1->order_by("m3.descripcion", "asc");
		$this->db_1->order_by("m4.descripcion", "asc");
		
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
        $existe=$filter->existe;
        foreach ($filter->pkPersona as $key=>$val)
   	{   
            $fecha=   date('Y-m-d', strtotime(str_replace('/', '-', $filter->fecha)));
            if($filter->horaMinuto[$key]==""){$asistio='0';}else $asistio='1';
            
            if($existe>0){
            $data =   array('asistio' => $asistio,
                        'horaMinuto' => $filter->horaMinuto[$key],
                        'horaMinuto2' => $filter->horaMinuto2[$key],
                        'observacion' => $filter->observacion[$key],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        ); 
            $this->db_1->where('pkPersona',$val);
            $this->db_1->where('fecha',$fecha);
            $this->db_1->where('estado','1');
            $this->db_1->update($this->table_5, $data);
            //$existe = $this->db_1->affected_rows();    
            }else{
            $data =   array('estado' => '1',
                        'pkPersona' => $val,
                        'asistio' => $asistio,
                        'fecha' => $fecha,
                        'pkDependencia' => $filter->pkDependencia,
                        'horaMinuto' => $filter->horaMinuto[$key],
                        'horaMinuto2' => $filter->horaMinuto2[$key],
                        'observacion' => $filter->observacion[$key],
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );     
            $this->db_1->insert($this->table_5, $data);
            }
        }
    }
    
        public function registrarCierre($filter,$filter_not){    

            $data =   array('estado' => '1',
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaModificada' => date('Y-m-d H:i:s'),
                      ); 
            $this->db_1->where('mes',$filter->mes);
            $this->db_1->where('anio',$filter->anio);
            $this->db_1->where('dependencia',$filter->pkDependencia);
            $this->db_1->where('estado','0');
            
            $this->db_1->update($this->table_6, $data);
            $existe = $this->db_1->affected_rows();
            
            if($existe!='1'){
            $data =   array('estado' => '1',
                        'mes'=>$filter->mes,
                        'anio'=>$filter->anio,
                        'dependencia'=>$filter->pkDependencia,
                        'usuarioCreador' => $_SESSION['usuario'],
                        'usuarioModificador' => $_SESSION['usuario'],
                        'fechaCreada' => date('Y-m-d H:i:s'),
                        'fechaModificada' => date('Y-m-d H:i:s'),
                        );     
            $this->db_1->insert($this->table_6, $data);
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
        $this->db_1->select('p.*,de.descripcion as gerencia,al.asistio as asistio, al.horaMinuto as tiempo, al.horaMinuto2 as tiempo2,al.observacion');
        $this->db_1->from($this->table_5.' al');
        $this->db_1->join($this->table_4.' p','p.pkPersona=al.pkPersona');
        $this->db_1->join($this->table_3.' de','de.pkDependencia=p.pkDependencia');
        //$this->db_1->where('p.estado','1');
        $this->db_1->where('al.estado','1');
        $this->db_1->where('p.locador','1');
        $this->db_1->where('al.fecha',$filter->fecha);
        $this->db_1->where('al.pkDependencia',$filter->pkDependencia);
        $this->db_1->order_by("de.descripcion,p.razonSocial", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
 
    public function listarAsistenciaMensual($filter,$filter_not){
        $this->db_1->select('p.pkPersona as id,day(al.fecha) as dias,p.*,de.descripcion as gerencia,al.asistio as asistio, al.horaMinuto as tiempo, al.horaMinuto2 as tiempo2,al.observacion');
        $this->db_1->from($this->table_5.' al');
        $this->db_1->join($this->table_4.' p','p.pkPersona=al.pkPersona');
        $this->db_1->join($this->table_3.' de','de.pkDependencia=p.pkDependencia');
        //$this->db_1->where('p.estado','1');
        $this->db_1->where('al.estado','1');
        $this->db_1->where('p.locador','1');
        $this->db_1->where('month(al.fecha)',substr($filter->fecha,5,2));
        $this->db_1->where('al.pkDependencia',$filter->pkDependencia);
        $this->db_1->order_by("de.descripcion,p.razonSocial", "asc");
        
        $query = $this->db_1->get();
        
        $result = new stdclass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
}
