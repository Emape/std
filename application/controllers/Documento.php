<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "./library/PHPExcel.php"; 
require_once "./library/PHPWord.php"; 

class Documento extends CI_Controller {
    
        public function __construct(){
        parent::__construct();
        $this->load->model('documento_model'); 
		$this->load->library('session');
        }

	public function index()
	{   
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->view('documento/index');
	}
        
	public function expediente()
	{   
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->view('documento/expediente');
	}
	
	public function recepcion()
	{   
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->view('documento/recepcion');
	}
        
        public function listar_documento(){
            $fecha_ini=$this->input->get_post('fecha_ini');
            $fecha_fin=$this->input->get_post('fecha_fin');
            $tipo_doc=$this->input->get_post('tipo_doc');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->fecha_ini=str_replace('/', '-', $fecha_ini);
            $filter->fecha_fin=str_replace('/', '-', $fecha_fin);
            $filter->tipo_doc=$tipo_doc;
                    
            $var   = $this->documento_model->listarDocumento($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        
        public function obtener_documento(){
            $fecha_ini=$this->input->get_post('fecha_ini');
            $fecha_fin=$this->input->get_post('fecha_fin');
            $tipo_doc=$this->input->get_post('tipo_doc');
            $nrodoc=$this->input->get_post('nrodoc');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->fecha_ini=str_replace('/', '-', $fecha_ini);
            $filter->fecha_fin=str_replace('/', '-', $fecha_fin);
            $filter->tipo_doc=$tipo_doc;
            $filter->nrodoc=$nrodoc;
            
            $var   = $this->documento_model->listarDocumento($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        
        public function obtener_movimiento(){

            $nromov=$this->input->get_post('cod_movimiento');
            $nrodoc=$this->input->get_post('cod_documento');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->nromov=$nromov;
            $filter->cod=$nrodoc;
            
            $var   = $this->documento_model->listarMovimiento($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function obtener_nro_tipodoc(){

            $tipo=$this->input->get_post('tipo');
            $unidad=$this->input->get_post('unidad');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->unidad=$unidad;
            $filter->tipo=$tipo;
            
            $var   = $this->documento_model->obtenerNroTipoDoc($filter,$filter_not);
            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
        
        public function registrar_documento(){
			$var=0;
            $cod_documento=$this->input->get_post('cod_documento');
            $tipo_doc=$this->input->get_post('tipo_doc');
            $tipo=$this->input->get_post('tipo');
            $nroDocumento=$this->input->get_post('nroDocumento');
            $fechaDocumento=$this->input->get_post('fecha');
            $empresa=$this->input->get_post('entidad');
            $unidad=$this->input->get_post('unidad');
            $persona=$this->input->get_post('persona');
            $asunto=$this->input->get_post('asunto');
            $areaTrabajo=$this->input->get_post('areaTrabajo');
			$nro_tramite=$this->input->get_post('nro_tramite');
			
			//**//
			$unidad0=$this->input->get_post('unidad0');
            $fecha_vencimiento0=$this->input->get_post('fecha_vencimiento0');
            $responsable00=$this->input->get_post('responsable00');
            $estado0=$this->input->get_post('estado0');
            $tipo0=$this->input->get_post('tipo0');
            $memo0=$this->input->get_post('memo0');
            $acciones0=$this->input->get_post('acciones0');
			$prioridad0=$this->input->get_post('prioridad0');

            $filter     = new stdClass();
            $filter_not = new stdClass();
            
            $filter->cod_documento=$cod_documento;
            $filter->tipo_doc=$tipo_doc;
            $filter->tipo=$tipo;
            $filter->nroDocumento=$nroDocumento;
            $filter->fechaDocumento=str_replace('/', '-', $fechaDocumento);
            $filter->empresa=$empresa;
            $filter->unidad=$unidad;
            $filter->persona=$persona;
            $filter->asunto=$asunto;
            $filter->areaTrabajo=$areaTrabajo;
			$filter->nroTramite=$nro_tramite;
            
            if($cod_documento==""){
			$filter->unidad0=$unidad0;
            $filter->fecha_vencimiento0=str_replace('/', '-', $fecha_vencimiento0);
            $filter->responsable00=$responsable00;
            $filter->estado0=$estado0;
            $filter->tipo0=$tipo0;
            $filter->memo0=$memo0;
            $filter->accion0=$acciones0;
			$filter->prioridad0=$prioridad0;
			
			if($tipo_doc=="1"){
			$verify=$this->documento_model->verificarNro($filter,$filter_not);
			
			$oNroDocumento=explode('-', $nroDocumento);
			foreach ($verify as $row)
			{
			if($row->nro==$oNroDocumento[0])
			$var=2;
			}
			
			}
			
			if($var!=2)	
            $var=$this->documento_model->registrarDocumento($filter,$filter_not);
            }
            else{
			if($var!=2)	
            $var=$this->documento_model->modificarDocumento($filter,$filter_not);    
            }
            
            echo $var;
        }
        
        public function registrar_movimiento(){
            $cod_movimiento=$this->input->get_post('cod_movimiento');
            $cod_documento=$this->input->get_post('cod_documento');
            $decreto=$this->input->get_post('decreto');
            $ampliacion=$this->input->get_post('ampliacion');
            $fechaVencimiento=$this->input->get_post('fecha_vencimiento');
            $nroMemo=$this->input->get_post('memo');
            $dependencia=$this->input->get_post('unidad');
            $persona=$this->input->get_post('responsable');
            $situacion=$this->input->get_post('estado');
            $prioridad=$this->input->get_post('prioridad');
            $acciones=$this->input->get_post('acciones');
            $asunto=$this->input->get_post('asunto');
			$tipo2=$this->input->get_post('tipo2');
            $areaTrabajo=$this->input->get_post('areaTrabajo');

            $filter     = new stdClass();
            $filter_not = new stdClass();
            
            $filter->cod_movimiento=$cod_movimiento;
            $filter->cod_documento=$cod_documento;
            $filter->decreto=$decreto;
            $filter->ampliacion=$ampliacion;
            $filter->nroMemo=$nroMemo;
            $filter->fechaVencimiento=str_replace('/', '-', $fechaVencimiento);
            $filter->dependencia=$dependencia;
            $filter->persona=$persona;
            $filter->situacion=$situacion;
            $filter->prioridad=$prioridad;
            $filter->acciones=$acciones;
            $filter->asunto=$asunto;
			$filter->tipo2=$tipo2;
            $filter->areaTrabajo=$areaTrabajo;
                      
            if($cod_movimiento==""){
            $this->documento_model->registrarMovimiento($filter,$filter_not);
            }
            else{
            $this->documento_model->modificarMovimiento($filter,$filter_not);    
            }
            
            echo "1";
        }
        
        public function anular_documento(){

            $nrodoc=$this->input->get_post('nrodoc');

            $filter     = new stdClass();
            $filter_not = new stdClass();
        
            $filter->nrodoc=$nrodoc;
        
            $this->documento_model->anularDocumento($filter,$filter_not);
            
            echo "1";
        }
        
        public function anular_movimiento(){

            $nromov=$this->input->get_post('nromov');

            $filter     = new stdClass();
            $filter_not = new stdClass();
        
            $filter->nromov=$nromov;
        
            $this->documento_model->anularMovimiento($filter,$filter_not);
            
            echo "1";
        }
        
        public function listar_movimiento(){
            $cod=$this->input->get_post('cod');
            
            $filter     = new stdClass();
            $filter_not = new stdClass();
                     
            $filter->cod=$cod;
                    
            $var   = $this->documento_model->listarMovimiento($filter,$filter_not);

            if(count((array)$var)>0) echo json_encode($var); else echo 0;
        }
		
		public function listar_documento_movimiento(){
        $doc=$this->input->get_post('tipo_doc');
        $ini=$this->input->get_post('fecha_ini');
        $fin=$this->input->get_post('fecha_fin');
               
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->tipo_doc=$doc;
        $filter->fecha_ini=str_replace('/', '-', $ini);
        $filter->fecha_fin=str_replace('/', '-', $fin);
        $filter->flaguser="1";

        $var   = $this->documento_model->listarDocumentoMovimiento($filter,$filter_not);
		
		if(count((array)$var)>0) echo json_encode($var); else echo 0;

        }
        
        public function exportar_documento_movimiento(){
        $doc=$this->input->get_post('doc');
        $ini=$this->input->get_post('ini');
        $fin=$this->input->get_post('fin');
        
        $this->load->library('session');
        
        if($doc==1) {$tipo_doc="DOCUMENTOS INTERNOS";}
        else        {$tipo_doc="DOCUMENTOS EXTERNOS";}
        
        //style 
        
        $style_border = array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
        );
		
		$style_cabecera = array(
		'font' => array(
			'bold' => true,
			'size' => 12,
		),
		'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		),
		'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
		),
		);
		
		$style_blanco =     array(
        'font' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFFFF')
        ),
		'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '3a2a47'
            )
        )
    ),
		);
        
        //load Excel template file
        $obj = PHPExcel_IOFactory::load("./plantilla/plantilla02.xlsx");
        $obj->setActiveSheetIndex(0);  //set first sheet as active

        $obj->getActiveSheet()->setCellValue('C4', $ini." al ".$fin);  
        $obj->getActiveSheet()->setCellValue('C5', $tipo_doc);  
        $obj->getActiveSheet()->setCellValue('J5', strtoupper($_SESSION['gerencia']));  
        $obj->getActiveSheet()->setCellValue('J4', $_SESSION['nombre']." ".$_SESSION['apellidoPaterno']." ".$_SESSION['apellidoMaterno']); 
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->tipo_doc=$doc;
        $filter->fecha_ini=str_replace('/', '-', $ini);
        $filter->fecha_fin=str_replace('/', '-', $fin);
        $filter->flaguser="1";
        
        $var   = $this->documento_model->listarDocumentoMovimiento($filter,$filter_not);
        $i     = 8;
		$ii     = 8;
        $detalle_dependencia="";
        foreach($var as $key => $v ){
			$dias	= (strtotime(date("Y-m-d"))-strtotime($v->fechaMovimiento))/86400;
			$dias 	= abs($dias); $dias = floor($dias);	
		
		if($v->dependenciaMovimiento!=$detalle_dependencia){
			
			$obj->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
			$obj->getActiveSheet()->getStyle('A'.$i.':L'.$i)->applyFromArray($style_cabecera);
			$obj->getActiveSheet()->mergeCells('H'.$i.':L'.$i);
			$obj->getActiveSheet()->getStyle('H'.$i.':H'.$i)->applyFromArray($style_blanco);
			$obj->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $v->dependenciaMovimiento)->setCellValue('H'.$i, $v->dependenciaMovimiento);
			$i=$i+1;
		}	
		
            $obj->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, ($ii-7))
                ->setCellValue('B'.$i, $v->nroTramite)
                ->setCellValue('C'.$i, date('d/m/Y',  strtotime($v->fechaCreada)))    
                ->setCellValue('D'.$i, $v->tipo)
                ->setCellValue('E'.$i, trim($v->nroDocumento))
                ->setCellValue('F'.$i, $v->dependencia)
                ->setCellValue('G'.$i, strtoupper($v->asunto))
                ->setCellValue('H'.$i, $v->dependenciaMovimiento)
                ->setCellValue('I'.$i, $v->nroMemo)
                ->setCellValue('J'.$i, (is_null($v->fechaMovimiento) ? "":date('d/m/Y',strtotime($v->fechaMovimiento))))
				->setCellValue('K'.$i, $v->estadoMovimiento)
				->setCellValue('L'.$i, (is_null($v->fechaMovimiento) ? "":$dias." días"));
						
		$i=$i+1;
		$ii=$ii+1;
		$detalle_dependencia=$v->dependenciaMovimiento;
		
        }
        $obj->getActiveSheet()->getStyle('A8:L'.($i-1))->applyFromArray($style_border);
        //prepare download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="tramite_documentario.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
        $objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
        exit;
        }
        
        public function hoja_tramite(){ 

        $doc=$this->input->get_post('doc');
        $nrodoc=$this->input->get_post('nrodoc');
        $ini=$this->input->get_post('ini');
        $fin=$this->input->get_post('fin');
        $estado="Dar Tramite";
        $estado1="Dar Tramite";
        $origen="Tramite Documentario";
        $origen1="Tramite Documentario";
        
        if($nrodoc%2==0){
            $doc1=$nrodoc-1;
            $doc2=$nrodoc;
        }
        else{
            $doc1=$nrodoc;
            $doc2=$nrodoc+1;
        }
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->tipo_doc=$doc;
        $filter->nrodoc=$doc1;
        $filter->fecha_ini=str_replace('/', '-', $ini);
        $filter->fecha_fin=str_replace('/', '-', $fin);
        
        $var   = $this->documento_model->listarDocumentoMovimiento($filter,$filter_not);

        $filter->tipo_doc=$doc;
        $filter->nrodoc=$doc2;
        $filter->fecha_ini=str_replace('/', '-', $ini);
        $filter->fecha_fin=str_replace('/', '-', $fin);
        
        $var1   = $this->documento_model->listarDocumentoMovimiento($filter,$filter_not);
        if($var=="0"){
        $var='[{"nroTramite":"","dependenciaMovimiento":"","tipo":"","fechaCreada":""}]';
        $var=json_decode($var);
        $estado="";
        $origen="";
        }
        if($var1=="0"){
        $var1='[{"nroTramite":"","dependenciaMovimiento":"","tipo":"","fechaCreada":""}]';
        $var1=json_decode($var1);
        $estado1="";
        $origen1="";
        }

        $PHPWord = new PHPWord();
        //Searching for values to replace
        $document = $PHPWord->loadTemplate('./plantilla/plantilla01.docx');

        $document->setValue('Tramite', $var[0]->nroTramite);
        $document->setValue('Tramite2',$var1[0]->nroTramite);

        $document->setValue('Gerencia', $origen);
        $document->setValue('Gerencia2', $origen1);
        
        $document->setValue('Dependencia', $var[0]->dependenciaMovimiento);
        $document->setValue('Dependencia2',$var1[0]->dependenciaMovimiento);
        
        $document->setValue('Tipo', $var[0]->tipo);
        $document->setValue('Tipo2', $var1[0]->tipo);
        
        $document->setValue('Fecha', ($var[0]->fechaCreada=="" ? "":date('d/m/Y',strtotime($var[0]->fechaCreada))));
        $document->setValue('Fecha2', ($var1[0]->fechaCreada=="" ? "":date('d/m/Y',strtotime($var1[0]->fechaCreada))));
       
        $document->setValue('Estado', $estado);
        $document->setValue('Estado2', $estado1);      
         
        // save as a random file in temp file
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        $document->save($temp_file);

        header("Content-Disposition: attachment; filename='hoja_tramite.doc'");
        header("Content-Type: application/vnd.ms-word; charset=utf-8");
        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);  // remove temp file
 
        }
        
        public function arbol(){
        $doc=$this->input->get_post('doc');
        $nrodoc=$this->input->get_post('nrodoc');
        $ini=$this->input->get_post('ini');
        $fin=$this->input->get_post('fin');
        $cadena="";
        
        $filter     = new stdClass();
        $filter_not = new stdClass();
        
        $filter->tipo_doc=$doc;
        $filter->nrodoc=$nrodoc;
        $filter->fecha_ini=str_replace('/', '-', $ini);
        $filter->fecha_fin=str_replace('/', '-', $fin);
        
        $var   = $this->documento_model->listarDocumentoMovimiento($filter,$filter_not);
        
        $i=0;
        foreach($var as $key => $v ){
            if($v->dependenciaMovimiento!="")  $cadena.="<ul><li><a href='#'>".$v->dependenciaMovimiento."</a>";
            else  $cadena.="<ul><li><a href='#'>No hay resultados</a>";    
            $i++;
        }
        
        $cadena.="<ul><li><a href='#'>Fin</a></li></ul>";
        for($m=1;$m<=$i;$m++){$cadena.="</li></ul>";}
        
        echo $cadena;
        }
}
