<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "./library/PHPExcel.php"; 

class Maestro extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
	$this->load->model('maestro_model'); 
        $this->load->library('session');
		if (!isset($_SESSION['usuario'])) {echo '<script type="text/javascript">window.location="../std";</script>';}
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
    
    public function verificar_cierre(){       
        $dependencia=$this->input->get_post('dependencia');
        $mes=$this->input->get_post('mes');
        $anio=$this->input->get_post('anio');
        
        $filter     = new stdClass();
        $filter_not = new stdClass();

        $filter->pkDependencia=$dependencia;
        $filter->mes=$mes;
        $filter->anio=$anio;
                    
        $var   = $this->maestro_model->verificarCierre($filter,$filter_not);
        
        
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
            $filter->central=$_SESSION['central'];
            $filter->dependencia=$_SESSION['pkDependencia'];
            
        $existe_fecha   = $this->maestro_model->existeFecha($fecha,$dependencia);
        
        if($existe_fecha>0){
            $var   = $this->maestro_model->listarAsistencia($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        else{
       
            $var   = $this->maestro_model->listarPersona2($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        
    }
	
	public function listar_locador2(){     
            $var   = $this->maestro_model->listarPersona3();
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
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
        $horaMinuto2=$this->input->get_post('horaMinuto2');
        $observacion=$this->input->get_post('observacion');
        $asistio=$this->input->get_post('asistio');
        $fecha=$this->input->get_post('fecha');
        $dependencia=$this->input->get_post('dependencia');
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->pkPersona=$pkPersona;
        $filter->horaMinuto=$horaMinuto;
        $filter->horaMinuto2=$horaMinuto2;
        $filter->observacion=$observacion;
        $filter->asistio=$asistio;
        $filter->fecha=$fecha;
        $filter->pkDependencia=$dependencia;
        
        $existe=$this->maestro_model->verificarAsistencia($filter,$filter_not);
        $filter->existe=$existe[0]->cantidad;
        $this->maestro_model->registrarAsistencia($filter,$filter_not);
        
        echo "1";
    }
    
    public function registrar_cierre(){

        $mes=$this->input->get_post('mes');
        $anio=$this->input->get_post('anio');
        $dependencia=$this->input->get_post('dependencia');
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->mes=$mes;
        $filter->anio=$anio;
        $filter->pkDependencia=$dependencia;
        
        $this->maestro_model->registrarCierre($filter,$filter_not);
        
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
            $filter->central=$_SESSION['central'];
            $filter->dependencia=$_SESSION['pkDependencia'];
        
        $existe_fecha   = $this->maestro_model->existeFecha($fecha,$dependencia);
        
        if($existe_fecha>0){
            $var   = $this->maestro_model->listarAsistencia($filter,$filter_not);
        }
        else{
       
            $var   = $this->maestro_model->listarPersona2($filter,$filter_not);
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
        $conta=0;
        $total=0;
        foreach($var as $key => $v ){
            if($v->asistio=='1'){ $asistir="Asistió"; $conta++;} else {$asistir="Faltó";}
            
            if($v->apellidoPaterno!="")
            $nombrecompleto=$v->apellidoPaterno.' '.$v->apellidoMaterno.' '.$v->nombre;
            else
            $nombrecompleto=$v->razonSocial;
            
            $obj->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, ($i-6))
                ->setCellValue('B'.$i, $v->ruc)
                ->setCellValue('C'.$i, $nombrecompleto)
                ->setCellValue('D'.$i, $v->gerencia)
                ->setCellValue('E'.$i, $asistir )
                ->setCellValue('F'.$i, $v->tiempo)
                ->setCellValue('G'.$i, $v->tiempo2)
                ->setCellValue('H'.$i, $v->observacion);
            $i=$i+1;
            $total++;
        }
        $obj->setActiveSheetIndex(0)
                ->setCellValue('F3', $total)
                ->setCellValue('H3', $conta)
                ->setCellValue('H4', ($total-$conta));
        
        $obj->getActiveSheet()->getStyle('A7:H'.($i-1))->applyFromArray($style_border);
        //prepare download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="asistencia_diaria.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
        $objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
        exit;
        }
        
        public function exportar_asistencia_detalle(){
        $dependencia=$this->input->get_post('dependencia');
        $fecha=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get_post('fecha'))));
        $estado_locador='1';
        
            $filter     = new stdClass();
            $filter_not = new stdClass();

            $filter->pkDependencia=$dependencia;
            $filter->fecha=$fecha;
            $filter->estado_locador=$estado_locador;
            $filter->central=$_SESSION['central'];
            $filter->dependencia=$_SESSION['pkDependencia'];
        
        $var   = $this->maestro_model->listarAsistenciaMensual($filter,$filter_not);
        
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
        $obj = PHPExcel_IOFactory::load("./plantilla/plantilla04.xlsx");
        $obj->setActiveSheetIndex(0);  //set first sheet as active
        
        $mes=substr($fecha,5,2);
        $anio=substr($fecha,0,4);
        
        if($mes=='01')
            $mesx="Enero";
        else if($mes=='02')
            $mesx="Febrero";
        else if($mes=='03')
            $mesx="Marzo";
        else if($mes=='04')
            $mesx="Abril";
        else if($mes=='05')
            $mesx="Mayo";
        else if($mes=='06')
            $mesx="Junio";
        else if($mes=='07')
            $mesx="Julio";
        else if($mes=='08')
            $mesx="Agosto";
        else if($mes=='09')
            $mesx="Setiembre";
        else if($mes=='10')
            $mesx="Octubre";
        else if($mes=='11')
            $mesx="Noviembre";
        else if($mes=='12')
            $mesx="Diciembre";
        
        $obj->getActiveSheet()->setCellValue('C4', $mesx .' '.$anio);   
        
        $i = 7;
        $j = 7;
        $conta=0;
        $total=0;
        $val_ruc="";
        $vruc="";
        foreach($var as $key => $v ){
            if($val_ruc!=$v->ruc){
            $val_ruc=$v->ruc;
            if($v->asistio=='1'){ $asistir="Asistió"; $conta++;} else {$asistir="Faltó";}
            
            if($v->apellidoPaterno!="")
            $nombrecompleto=$v->apellidoPaterno.' '.$v->apellidoMaterno.' '.$v->nombre;
            else
            $nombrecompleto=$v->razonSocial;
            
            $obj->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, ($i-6))
                ->setCellValue('B'.$i, $v->ruc)
                ->setCellValue('C'.$i, $nombrecompleto)
                ->setCellValue('D'.$i, $v->gerencia);
                /*->setCellValue('E'.$i, $asistir )
                ->setCellValue('F'.$i, $v->tiempo)
                ->setCellValue('G'.$i, $v->tiempo2)
                ->setCellValue('H'.$i, $v->observacion);*/
            $i=$i+1;
            $total++;
            }
        }
        //print_R($var);die;
        $o=6;$d="";
        foreach($var as $k => $w ){
            
        $d=$w->tiempo;
        
        if($vruc==$w->id){
        $vruc=$w->id;
        }
        else{$o++;$vruc=$w->id;}
       
        
        
           if($w->dias=='1'){$dia1=$d;$obj->setActiveSheetIndex(0)->setCellValue('E'.$o, $dia1);}
           else if($w->dias=='2'){$dia2=$d;$obj->setActiveSheetIndex(0)->setCellValue('F'.$o, $dia2);}
           else if($w->dias=='3'){$dia3=$d;$obj->setActiveSheetIndex(0)->setCellValue('G'.$o, $dia3);}
           else if($w->dias=='4'){$dia4=$d;$obj->setActiveSheetIndex(0)->setCellValue('H'.$o, $dia4);}
           else if($w->dias=='5'){$dia5=$d;$obj->setActiveSheetIndex(0)->setCellValue('I'.$o, $dia5);}
           else if($w->dias=='6'){$dia6=$d;$obj->setActiveSheetIndex(0)->setCellValue('J'.$o, $dia6);}
           else if($w->dias=='7'){$dia7=$d;$obj->setActiveSheetIndex(0)->setCellValue('K'.$o, $dia7);}
           else if($w->dias=='8'){$dia8=$d;$obj->setActiveSheetIndex(0)->setCellValue('L'.$o, $dia8);}
           else if($w->dias=='9'){$dia9=$d;$obj->setActiveSheetIndex(0)->setCellValue('M'.$o, $dia9);}
           else if($w->dias=='10'){$dia10=$d;$obj->setActiveSheetIndex(0)->setCellValue('N'.$o, $dia10);}
           else if($w->dias=='11'){$dia11=$d;$obj->setActiveSheetIndex(0)->setCellValue('O'.$o, $dia11);}
           else if($w->dias=='12'){$dia12=$d;$obj->setActiveSheetIndex(0)->setCellValue('P'.$o, $dia12);}
           else if($w->dias=='13'){$dia13=$d;$obj->setActiveSheetIndex(0)->setCellValue('Q'.$o, $dia13);}
           else if($w->dias=='14'){$dia14=$d;$obj->setActiveSheetIndex(0)->setCellValue('R'.$o, $dia14);}
           else if($w->dias=='15'){$dia15=$d;$obj->setActiveSheetIndex(0)->setCellValue('S'.$o, $dia15);}
           else if($w->dias=='16'){$dia16=$d;$obj->setActiveSheetIndex(0)->setCellValue('T'.$o, $dia16);}
           else if($w->dias=='17'){$dia17=$d;$obj->setActiveSheetIndex(0)->setCellValue('U'.$o, $dia17);}
           else if($w->dias=='18'){$dia18=$d;$obj->setActiveSheetIndex(0)->setCellValue('V'.$o, $dia18);}
           else if($w->dias=='19'){$dia19=$d;$obj->setActiveSheetIndex(0)->setCellValue('W'.$o, $dia19);}
           else if($w->dias=='20'){$dia20=$d;$obj->setActiveSheetIndex(0)->setCellValue('X'.$o, $dia20);}
           else if($w->dias=='21'){$dia21=$d;$obj->setActiveSheetIndex(0)->setCellValue('Y'.$o, $dia21);}
           else if($w->dias=='22'){$dia22=$d;$obj->setActiveSheetIndex(0)->setCellValue('Z'.$o, $dia22);}
           else if($w->dias=='23'){$dia23=$d;$obj->setActiveSheetIndex(0)->setCellValue('AA'.$o, $dia23);}
           else if($w->dias=='24'){$dia24=$d;$obj->setActiveSheetIndex(0)->setCellValue('AB'.$o, $dia24);}
           else if($w->dias=='25'){$dia25=$d;$obj->setActiveSheetIndex(0)->setCellValue('AC'.$o, $dia25);}
           else if($w->dias=='26'){$dia26=$d;$obj->setActiveSheetIndex(0)->setCellValue('AD'.$o, $dia26);}
           else if($w->dias=='27'){$dia27=$d;$obj->setActiveSheetIndex(0)->setCellValue('AE'.$o, $dia27);}
           else if($w->dias=='28'){$dia28=$d;$obj->setActiveSheetIndex(0)->setCellValue('AF'.$o, $dia28);}
           else if($w->dias=='29'){$dia29=$d;$obj->setActiveSheetIndex(0)->setCellValue('AG'.$o, $dia29);}
           else if($w->dias=='30'){$dia30=$d;$obj->setActiveSheetIndex(0)->setCellValue('AH'.$o, $dia30);}
           else if($w->dias=='31'){$dia31=$d;$obj->setActiveSheetIndex(0)->setCellValue('NI'.$o, $dia31);}
           
        }
        $obj->setActiveSheetIndex(0)
                ->setCellValue('I4', $total);
        
        $obj->getActiveSheet()->getStyle('A7:AI'.($i-1))->applyFromArray($style_border);
        //prepare download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="asistencia_mensual.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
        $objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
        exit;
        }
    
}