<script>
    $(document).ready(function(){
        //fecha por defecto
        var f = new Date();
        var dia, mes;
        if(f.getDate()<10) dia="0"+f.getDate(); else dia=f.getDate();
        if(f.getMonth()<10) mes="0"+(f.getMonth()+1); else mes=(f.getMonth()+1);
       
        var fecha_def_ini= "01/"+mes+ "/" + f.getFullYear();
        var fecha_def_fin= dia+"/"+mes+ "/" + f.getFullYear();
        
        $("#fecha_ini").val(fecha_def_ini);
        $("#fecha_fin").val(fecha_def_fin);
        
        //crear calendario
        $('#fecha_ini_icon').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
        $('#fecha_fin_icon').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
        
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        
    });
    
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        });
    });
    
    $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');  
        if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
        }
        $(this).find('.btn').toggleClass('btn-default'); 
    });

</script>
<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Documentos </span>
        <div class="btn-group btn-toggle" data-toggle="buttons">
    <label class="btn btn-primary active">
      <input type="radio" name="options" value="option1"> Internos
    </label>
    <label class="btn btn-default">
      <input type="radio" name="options" value="option2" checked=""> Externos
    </label>
  </div>
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4" align="right">
                <span class="btn btn-primary" title="Agregar"   style="font-size:12px;" data-toggle="modal" data-target="#registrarDocumentoModal">
                    <i  class="fa fa-plus" ></i> 
                </span>
                <span class="btn btn-primary" title="Modificar" style="font-size:12px" data-toggle="modal" data-target="#registrarDocumentoModal">
                    <i  class="fa fa-pencil" ></i> 
                </span>
                <span class="btn btn-primary" title="Anular"    id="anular"  style="font-size:12px" data-toggle="modal" data-target="#eliminarDocumentoModal" >
                    <i  class="fa fa-minus-circle" ></i> 
                </span>
                <a href="./plantilla/plantilla02.xlsx"><span class="btn btn-primary" title="Imprimir"  id="imprimir" style="font-size:12px" >
                    <i class="fa fa-print" ></i> 
                </span></a>
                <a href="./plantilla/pdf.pdf" target="_blank"><span class="btn btn-primary" title="Descargar" id="imprimir" style="font-size:12px" >
                    <i class="fa fa-download" ></i> 
                </span></a>
                <a href="./plantilla/plantilla01.docx"><span class="btn btn-primary" title="Hoja de Tramite" id="hoja" style="font-size:12px" >
                    <i class="fa fa-file-text-o" ></i> 
                </span></a>
                <span class="btn btn-primary" title="Seguimiento"    id="seguimiento"  style="font-size:12px" data-toggle="modal" data-target="#arbolModal" >
                    <i  class="fa fa-sitemap" ></i> 
                </span>
            </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-5">
                            <div class="form-group">
                                <label>Concepto</label>
                                <div class='input-group date'>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-search"></span>
                                </span>
                                <input type='text' name="search" id="search"  class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="dataTables_length">
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Fecha Inicio</label>
                                <div class='input-group date' id="fecha_ini_icon">
                                <input type='text' name="fecha_ini" id="fecha_ini"  class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Fecha Fin</label>
                                <div class='input-group date' id="fecha_fin_icon">
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                           
                            <div class="dataTables_length">
                                 <span class="btn btn-primary" title="Buscar" id="imprimir" style="font-size:12px;margin-top:22px" onclick="imprimir_pdf()">
                    <i class="fa fa-search" ></i> 
                </span>
                            </div>
                        </div>
			
                    </div>	
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:380px" >
                    <table  id="tabla_guia" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th ><b>N. Trámite </b></th>
                            <th ><b>Fecha </b></th>
                            <th ><b>Tipo </b></th>
                            <th ><b>N. Doc. </b></th>
                            <th ><b>Entidad </b></th>
                            <th ><b>Asunto </b></th>
		            <th ><b>Usuario </b></th>
                            <th ><b>Situación </b></th>
                        </tr>
                        </thead>
                        <tbody id="body_guia">
			<tr >
                            <!--<td  colspan="8" align="center">No se encontraron resultados </td>-->
                            
                            <td align="center">2016AF000001</td>
                            <td align="center">01/01/2016 </td>
                            <td >OFICIO</td>
                            <td >1825/2015 E.C. EMAPES.A.</td>
                            <td >IRON MOUNTAIN S.A.</td>
                            <td >NOTIFICACION DE LIMITE DE ESPACIO DE DOCUMENTOS</td>
                            <td align="center">TTUEROS</td>
                            <td align="center">PENDIENTE</td>
                        </tr>	    
                            <td align="center">2016PS000001</td>
                            <td align="center">01/03/2016 </td>
                            <td >MEMORANDUM</td>
                            <td >001-85EC EMAPE S.A.</td>
                            <td >MUNICIPALIDAD DE LIMA</td>
                            <td >REGULARIZACION EN COMITE DE OBRAS</td>
                            <td align="center">COCHOA</td>
                            <td align="center">DECRETADO</td>
                        </tr>	    
                            <td align="center">2016PS000002</td>
                            <td align="center">21/01/2016 </td>
                            <td >INFORME</td>
                            <td >235-5889 E.C. EMAPES.A.</td>
                            <td >GERENCIA DE SISTEMAS DE INFORMACION</td>
                            <td >ACTIVIDADES DEL PERSONAL</td>
                            <td align="center">COCHOA</td>
                            <td align="center">DECRETADO</td>

                        </tr>	
                        </tbody>	
                    </table>
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <section class="content-header">
                        <div class="row">
                            <div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Decretos</span></div>
                                <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4" align="right">
                                    <span class="btn btn-success" title="Agregar"   style="font-size:12px" data-toggle="modal" data-target="#registrarDecretoModal" >
                                    <i  class="fa fa-plus" ></i> 
                                    </span>
                                    <span class="btn btn-success" title="Modificar" style="font-size:12px" data-toggle="modal" data-target="#registrarDecretoModal" >
                                    <i  class="fa fa-pencil" ></i> 
                                    </span>
                                    <span class="btn btn-success" title="Anular"    id="anular"  style="font-size:12px" data-toggle="modal" data-target="#eliminarDecretoModal" >
                                    <i  class="fa fa-minus-circle" ></i> 
                                    </span>
                                    <span class="btn btn-success" title="Descargar"    id="descargar"  style="font-size:12px" >
                                    <i  class="fa fa-download" ></i> 
                                    </span>
                                </div>
                        </div>
                    </section>
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:230px">		
                    <table id="tabla_guia2" class="table table-bordered table-hover dataTable no-footer">
			<thead>
                        <tr class=cabecera>
                            <th><b>Destino</b> </th>
                            <th><b>Gerente</b> </th>
                            <th><b>Fecha</b> </th>
                            <th><b>Vencimiento</b> </th>
                            <th><b>Estado</b> </th>
                        </tr>
                        </thead>
                        <tbody id="body_guia2">
                        <tr>
                            <!--<td colspan=9 align=center>No se encontraron resultados</td>-->
                            <td>GERENCIA DE CONTABILIDAD</td>
                            <td>MIRIAM ECHEGARAY </td>
                            <td align="center">01/02/2016</td>
                            <td align="center">03/02/2016</td>
                            <td align="center">Decretado</td>
                        </tr>
                        <tr>
                            <td>GERENCIA DE SISTEMAS DE INFORMACION</td>
                            <td>RUBEN YEPEZ </td>
                            <td align="center">02/03/2016</td>
                            <td align="center">06/03/2016</td>
                            <td align="center">Decretado</td>
                        </tr>
                        <tr>
                            <td >GERENCIA DE TESORERIA</td>
                            <td >WALTER RIERA</td>
                            <td align="center">05/04/2016</td>
                            <td align="center">12/04/2016</td>
                            <td align="center">Archivado</td>
                        </tr>
                        </tbody>
                    </table>		  
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
    <div class="modal fade" id="eliminarDocumentoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar Guía</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea Eliminar Documento N°  <span id="name_doc"></span> ?</p>
                    <p class="debug-url"></p>
                </div>
                <div class="modal-footer">
                    <button id="cerrar" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-ok">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="registrarDocumentoModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Registrar Documento</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary" style="font-size:12px" onclick="carga_submit()" >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Tipo Documental</label>
                                <select  class="form-control" >
                                    <option>Carta</option>
                                    <option>Informe</option>
                                    <option>Valorizaciones</option>
                                    <option>Otros</option>
                                </select>    
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label># Documento</label>  
                                <input type='text' name="fecha_ini" id="fecha_ini"  class="form-control" />
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Entidad</label>
                                <input type='text' name="search" id="search"  class="form-control" />
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Unidad</label>  
                                <input type='text' name="fecha_ini" id="fecha_ini"  class="form-control" />
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Persona</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                            </div>
                        </div>
                    </div>	
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label class="control-label">Cargar Documento</label>
                            <div class="input-group">    
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                                <input type="file" multiple>
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly> 
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Asunto</label>
                                <textarea name="search" id="search"  class="form-control" style="resize: none;" />
                                
                                </textarea>
                            </div>
                        </div>
                    </div>                  
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Área de Trabajo</label>
                                <textarea name="editor1" id="editor1" rows="20" cols="80" ></textarea>
                                </textarea>
                            </div>
                        </div>
                    </div> 
                </div>   
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="registrarDecretoModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Registrar Decreto</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary" style="font-size:12px" onclick="carga_submit()" >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label># Trámite</label>  
                                <input type='text' name="fecha_ini" id="fecha_ini"  class="form-control" value="2016AF000002" disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4">
                            <div class="form-group">
                                <label>Unidad</label>
                                <select  class="form-control" >
                                    <option>Gerencia Central de Administración y Finanzas</option>
                                    <option>Gerencia Central de Planeamiento y Sistemas</option>
                                    <option>Gerencia Central</option>
                                    <option>Otra</option>
                                </select>    
                            </div>
                        </div>
                        		<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Responsable</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Estado</label>
                                <select  class="form-control" >
                                    <option>Derivado</option>
                                    <option>Archivado</option>
                                    <option>Devuelto</option>
                                    <option>Decretado</option>
                                </select>   
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label># Memo</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                            </div>
                        </div>
                    </div>	
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4" >
                            <div class="form-group">
                                <label>Acciones</label>
                                <select  class="form-control" multiple style="height:90px" >
                                    <option>Evaluar</option>
                                    <option>Aprobar</option>
                                    <option>Urgente</option>
                                    <option>Archivar</option>
                                    
                                </select>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4" >
                            <div class="form-group">
                                <label>Prioridad</label>
                                <select  class="form-control"   >
                                    <option>Alta</option>
                                    <option>Media</option>
                                    <option>Baja</option>
                                </select>   
                            </div>
                            
                            <div class="form-group">
                                <label>Vencimiento</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" value="01/02/2016" />
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-4">
                            <div class="form-group">
                                <label>Decreto</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Ampliación</label>
                                <input type='text' name="fecha_fin" id="fecha_fin"  class="form-control" />
                            </div>
                        </div>
                    </div>	
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label class="control-label">Cargar Documento</label>
                            <div class="input-group">    
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                                <input type="file" multiple>
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly> 
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Asunto</label>
                                <textarea name="search" id="search"  class="form-control" style="resize: none;" />
                                
                                </textarea>
                            </div>
                        </div>
                    </div>                  
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Área de Trabajo</label>
                                <textarea name="editor2" id="editor2" rows="20" cols="80" ></textarea>
                                </textarea>
                            </div>
                        </div>
                    </div> 
                </div>   
            </div>
        </div>
    </div>
    <div class="modal fade" id="arbolModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Seguimiento del Documento</h1>
                <span style="float:right;margin-top:-28px">
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">  
                                <label> # Trámite: 2016AF000001 </label>
                                <div class="tree">
                                <ul>
                                <li>
                                    <a href="#">Inicio</a>
                                    <ul>
                                    <li>
                                    <a href="#">Gerencia de Contabilidad</a>
                                        <ul>
                                        <li>
					<a href="#">Gerencia de Sistemas de Información</a>
					<ul><li>
                                            <a href="#">Gerencia de Tesoreria</a>
                                            <ul><li>
                                                <a href="#">Fin</a>
                                            </li></ul>
					</li></ul>
                                        </li>
                                        </ul>
                                    </li>
                                    </ul>
                                </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
    
</section><!-- /.content -->
