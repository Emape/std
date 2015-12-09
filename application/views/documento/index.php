<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Documentos</span></div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4" align="right">
                <span class="btn btn-primary" title="Agregar"   style="font-size:12px" data-toggle="modal" data-target="#guiaiInsertModal" onclick="limpiar()">
                    <i  class="fa fa-plus" ></i> 
                </span>
                <span class="btn btn-primary" title="Modificar" style="font-size:12px" data-toggle="modal" data-target="#guiaiInsertModal" onclick="limpiar()">
                    <i  class="fa fa-pencil" ></i> 
                </span>
                <span class="btn btn-primary" title="Anular"    id="anular"  style="font-size:12px" data-toggle="modal" data-target="#confirm-delete" >
                    <i  class="fa fa-minus-circle" ></i> 
                </span>
                <span class="btn btn-primary" title="Imprimir"  id="imprimir" style="font-size:12px" onclick="imprimir_pdf()">
                    <i class="fa fa-print" ></i> 
                </span>
                <span class="btn btn-primary" title="Descargar" id="imprimir" style="font-size:12px" onclick="imprimir_pdf()">
                    <i class="fa fa-download" ></i> 
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
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                 <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                 <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="dataTables_length">
                                <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                 <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                 <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                 <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="dataTables_length">
                                <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
			<div class="col-xs-2">
                            <div class="dataTables_length">
                                 <input type=text name="search" id="search" aria-controls="tabla_inventario" class="form-control input-sm"> 
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:350px" >
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
                                    <span class="btn btn-success" title="Agregar"   style="font-size:12px" data-toggle="modal" data-target="#guiaiInsertModal" onclick="limpiar()">
                                    <i  class="fa fa-plus" ></i> 
                                    </span>
                                    <span class="btn btn-success" title="Modificar" style="font-size:12px" data-toggle="modal" data-target="#guiaiInsertModal" onclick="limpiar()">
                                    <i  class="fa fa-pencil" ></i> 
                                    </span>
                                    <span class="btn btn-success" title="Anular"    id="anular"  style="font-size:12px" data-toggle="modal" data-target="#confirm-delete" >
                                    <i  class="fa fa-minus-circle" ></i> 
                                    </span>
                                </div>
                        </div>
                    </section>
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:300px">		
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
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar Guía</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea Eliminar la Guía de Ingreso N°  <span id="name_guia"></span> ?</p>
                    <p class="debug-url"></p>
                </div>
                <div class="modal-footer">
                    <button id="cerrar" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-ok">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
<script src="../js/jquery.uitablefilter.js" ></script>