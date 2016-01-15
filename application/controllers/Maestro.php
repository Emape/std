<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "./library/PHPExcel.php"; 

class Maestro extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
	$this->load->model('maestro_model'); 
        $this->load->library('session');
    }

    public function index(){       
        $this->load->helper('url');
    }
    
    public function listar_tipo(){       
        $grupo=$this->input->get_post('grupo');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->grupo=$grupo;
                    
        $var   = $this->maestro_model->listarTipo($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
        
    public function listar_empresa(){       
        $filter     = new stdClass();
        $filter_not = new stdClass();
                    
        $var   = $this->maestro_model->listarEmpresa($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
   
    public function listar_dependencia(){       
        $empresa=$this->input->get_post('empresa');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->pkEmpresa=$empresa;
                    
        $var   = $this->maestro_model->listarDependencia($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
    
    public function listar_persona(){       
        $dependencia=$this->input->get_post('dependencia');
            
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->pkDependencia=$dependencia;
                    
        $var   = $this->maestro_model->listarPersona($filter,$filter_not);
        if(count((array)$var)>0) echo json_encode($var); else echo 0;
    }
    
    public function listar_locador(){     
        
        $dependencia=$this->input->get_post('dependencia');
        $fecha=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get_post('fecha'))));
        $estado_locador='1';
        
            $filter     = new stdClass();
            $filter_not = new stdClass();

            $filter->pkDependencia=$dependencia;
            $filter->fecha=$fecha;
            $filter->estado_locador=$estado_locador;
        
        $existe_fecha   = $this->maestro_model->existeFecha($fecha);
        
        if($existe_fecha>0){
            $var   = $this->maestro_model->listarAsistencia($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        else{
       
            $var   = $this->maestro_model->listarPersona($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        
    }
    
    public function registrar_unidad(){
        $detalle_unidad=$this->input->get_post('detalle_unidad');
        $entidad=$this->input->get_post('entidad');
          
        $filter     = new stdClass();
        $filter_not = new stdClass();
            
        $filter->detalle_unidad=$detalle_unidad;
        $filter->entidad=$entidad;
            
        $this->maestro_model->registrarUnidad($filter,$filter_not);
            
        echo "1";
    }
    
    public function registrar_persona(){
        $detalle_paterno=$this->input->get_post('detalle_paterno');
        $detalle_materno=$this->input->get_post('detalle_materno');
        $detalle_nombre=$this->input->get_post('detalle_nombre');
        $unidad=$this->input->get_post('unidad');
        $entidad=$this->input->get_post('entidad');
          
        $filter     = new stdClass();
        $filter_not = new stdClass();
            
        $filter->detalle_paterno=$detalle_paterno;
        $filter->detalle_materno=$detalle_materno;
        $filter->detalle_nombre=$detalle_nombre;
        $filter->unidad=$unidad;
        $filter->entidad=$entidad;   
        
        $this->maestro_model->registrarPersona($filter,$filter_not);
            
        echo "1";
    }
    
    public function registrar_asistencia(){
        $pkPersona=$this->input->get_post('pkPersona');
        $horaMinuto=$this->input->get_post('horaMinuto');
        $asistio=$this->input->get_post('asistio');
        $fecha=$this->input->get_post('fecha');
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->pkPersona=$pkPersona;
        $filter->horaMinuto=$horaMinuto;
        $filter->asistio=$asistio;
        $filter->fecha=$fecha;
        
        $this->maestro_model->registrarAsistencia($filter,$filter_not);
        
        echo "1";
    }
    
    public function exportar_asistencia(){
        $dependencia=$this->input->get_post('dependencia');
        $fecha=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get_post('fecha'))));
        $estado_locador='1';
        
            $filter     = new stdClass();
            $filter_not = new stdClass();

            $filter->pkDependencia=$dependencia;
            $filter->fecha=$fecha;
            $filter->estado_locador=$estado_locador;
        
        $existe_fecha   = $this->maestro_model->existeFecha($fecha);
        
        if($existe_fecha>0){
            $var   = $this->maestro_model->listarAsistencia($filter,$filter_not);
        }
        else{
       
            $var   = $this->maestro_model->listarPersona($filter,$filter_not);
        }
        
        $this->load->library('session');
        
        //style 
        
        $style_border = array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
        );
        
        //load Excel template file
        $obj = PHPExcel_IOFactory::load("./plantilla/plantilla03.xlsx");
        $obj->setActiveSheetIndex(0);  //set first sheet as active

        $obj->getActiveSheet()->setCellValue('B4', (is_null($fecha) ? "":date('d/m/Y',strtotime($fecha))));   
        $obj->getActiveSheet()->setCellValue('D4', $_SESSION['nombre']." ".$_SESSION['apellidoPaterno']." ".$_SESSION['apellidoMaterno']); 
        
        $i = 7;
        
        foreach($var as $key => $v ){
            if($v->asistio=='1'){ $asistir="Asistió";} else {$asistir="Faltó";}
            
            $obj->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, ($i-6))
                ->setCellValue('B'.$i, $v->ruc)
                ->setCellValue('C'.$i, $v->apellidoPaterno.' '.$v->apellidoMaterno.' '.$v->nombre)
                ->setCellValue('D'.$i, $v->gerencia)
                ->setCellValue('E'.$i, $asistir )
                ->setCellValue('F'.$i, $v->tiempo);
            $i=$i+1;
        }
        $obj->getActiveSheet()->getStyle('A7:F'.($i-1))->applyFromArray($style_border);
        //prepare download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="asistencia_diaria.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
        $objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
        exit;
        }
    
}