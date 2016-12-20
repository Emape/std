<script src="<?php base_url()?>js/jquery.uitablefilter.js"      type="text/javascript"></script>
<script src="<?php base_url()?>library/plugins/select2/select2.full.min.js"></script>

<script>
    $(document).ready(function(){
		listar_expediente();
        listar_categoria(1);
        listar_categoria(2);
        listar_categoria(3);
        listar_categoria(4);
        listar_categoria(5);
		listar_tipo(6);
        
		theTable = $("#tabla_documento");
        $("#ssearch").keyup(function () {
        $.uiTableFilter(theTable, this.value);
        });
		
		$('#fecha').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
		
		$('#fecha_inicio').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
		
		$('#fecha_programada').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
        
        $("#form_documento #guardar").click(function(){
			$("#boton_editar").hide();
            if($("#form_documento #distrito").val()=="0"){
                $("#texto-yellow").html("Seleccione el distrito judicial");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_documento #especialidad").val()=="0"){
                $("#texto-yellow").html("Seleccione la Expecialidad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #expediente").val()==""){
                $("#texto-yellow").html("Ingrese Nro. Expediente");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #fecha").val()==""){
                $("#texto-yellow").html("Seleccione la Fecha");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }

            else if($("#form_documento #situacion").val()=="0"){
                $("#texto-yellow").html("Seleccione la Situación");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Legal/registrar_expediente',
                data : $('#form_documento').serialize(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar").click();
                    $("#texto-green").html("Se registró el expediente correctamente");
                    $("#alert-green").slideDown('slow');
                    listar_expediente();
                    ocultarAlerta();
                    limpiar_expediente();
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
		
        $("#form_movimiento #guardar").click(function(){
            if($("#form_movimiento #actividad").val()=="0"){
                $("#texto-yellow").html("Seleccione la actividad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #fecha_inicio").val()==""){
                $("#texto-yellow").html("Seleccione la Fecha de Inicio");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #fecha_programada").val()==""){
                $("#texto-yellow").html("Seleccione la Fecha Programada");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Legal/registrar_actividad',
                data : $('#form_movimiento').serialize(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar").click();
                    $("#texto-green").html("Se registró la actividad correctamente");
                    $("#alert-green").slideDown('slow');
                    listar_actividad($("#cod_expediente").val());
                    ocultarAlerta();
                    limpiar_actividad();
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
       
        $(".btn-registrar-organo").click(function(){
            if($("#detalle_organo").val()==""){
                $("#texto-yellow").html("Ingrese Organo Juris.");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_organo',
                data : "detalle_organo="+$('#detalle_organo').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-organo").click();
                    $("#texto-green").html("Se registró el organo juris. correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
					$('#sorgano').empty();
					$('#organo').empty();
                    listar_categoria(2);
                    $("#detalle_organo").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
		
		$(".btn-registrar-especialidad").click(function(){
            if($("#detalle_especialidad").val()==""){
                $("#texto-yellow").html("Ingrese Especialidad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_especialidad',
                data : "detalle_especialidad="+$('#detalle_especialidad').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-especialidad").click();
                    $("#texto-green").html("Se registró la especialidad correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
					$('#sespecialidad').empty();
					$('#especialidad').empty();
                    listar_categoria(3);
                    $("#detalle_especialidad").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
		
		$(".btn-registrar-sede").click(function(){
            if($("#detalle_sede").val()==""){
                $("#texto-yellow").html("Ingrese Sede");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_sede',
                data : "detalle_sede="+$('#detalle_sede').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-sede").click();
                    $("#texto-green").html("Se registró la Sede correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
					$('#ssede').empty();
					$('#sede').empty();
                    listar_categoria(4);
                    $("#detalle_sede").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
		
		$(".btn-registrar-sala").click(function(){
            if($("#detalle_sala").val()==""){
                $("#texto-yellow").html("Ingrese Sala");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_sala',
                data : "detalle_sala="+$('#detalle_sala').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-sala").click();
                    $("#texto-green").html("Se registró la Sala correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
					$('#ssala').empty();
					$('#sala').empty();
                    listar_categoria(5);
                    $("#detalle_sala").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
      
        $(".btn-eliminar2").click(function(){
            actividad=$('#cod_actividad').val();

            $.ajax({
            url : '<?php base_url()?>Legal/anular_actividad',
            data :'actividad='+actividad,
            type : 'POST',
            success : function(result) {
                if(result=='1'){
                $(".btn-default-cerrar").click();
                $("#texto-green").html("Se eliminó la actividad correctamente");
                $("#alert-green").slideDown('slow');
                listar_actividad($("#cod_expediente").val());
                ocultarAlerta();
                }
            },
            error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
            }
            });	
        });
        
    });
    
 	function obtener_expediente(doc){
    limpiar_expediente();
    $.ajax({
	url : '<?php base_url()?>Legal/obtener_expediente',
	data :'doc='+doc,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            $.each(documento, function () {
			
			$("#form_documento #distrito").select2("val", this.pkDistrito);
			$("#form_documento #organo").select2("val", this.pkOrgano);
			$("#form_documento #especialidad").select2("val", this.pkEspecialidad);
			$("#form_documento #sede").select2("val", this.pkSede);
			$("#form_documento #sala").select2("val", this.pkSala);
			$("#situacion").val(this.situacion);
            $("#form_documento #expediente").val(this.nroExpediente);
			
            $("#form_documento #fecha").val(this.fecha.substring(8,10)+'/'+this.fecha.substring(5,7)+'/'+this.fecha.substring(0,4));
			$("#form_documento #involucrado").val(this.involucrados);
			$("#form_documento #delito").val(this.delito);
			$("#form_documento #resumen").val(this.resumen);
                        
            });       
        },
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
	
    function listar_expediente(){
		$("#boton_editar").hide();
		
		$("#boton_agregar0").hide();
		$("#boton_editar0").hide();
		$("#boton_anular0").hide();
		
		
		$("#cuerpoMovimiento").html("<tr><td colspan='7' align=center>No se encontraron resultados</td></tr>");
		var contador=1;
        $("#cuerpoExpediente").html("<tr><td colspan='7' align=center>No se encontraron resultados</td></tr>");
		
        $("#cuerpoDocumento").fadeIn(1000).html("<tr><td colspan='8' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
        $.ajax({
	url : '<?php base_url()?>Legal/listar_expediente',
	data :'anio='+$("#sanio").val()+'&distrito='+$("#sdistrito").val()+'&organo='+$("#sorgano").val()+'&especialidad='+$("#sespecialidad").val()+'&sede='+$("#ssede").val()+'&sala='+$("#ssala").val(),
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            var html = "";

            $.each(documento, function () {	
			smov=(this.pkMovimiento == null ? "" : this.pkMovimiento);
            html += "<tr id='fila" + contador + "' onclick=detalle_documento('" + this.pkExpediente +"','" + smov +"','" + this.cod_mov +"','" + contador + "') >";
            html += "<td>" + contador + "</td>";
            html += "<td>" + (this.nroTramite == null ? "" : this.nroTramite) + "</td>";
            html += "<td>" + (this.nroExpediente == null ? "" : this.nroExpediente) + "</td>";
            html += "<td>" + (this.involucrados == null ? "" : this.involucrados) + "</td>";
            html += "<td>" + (this.fecha == null ? "" : this.fecha.substr(8,2)+"/"+this.fecha.substr(5,2)+"/"+this.fecha.substr(0,4)) + "</td>";
            html += "<td>" + (this.resumen == null ? "" :this.resumen) + "</td>";
            //html += "<td>" + (this.usuarioCreador == null ? "" :this.usuarioCreador) + "</td>";
            html += "<td>" + (this.situacion == null ? "" :this.tipoDetalle) + "</td>";
            html += "</tr>";
			contador++;
            });
			
			
			
            $("#cuerpoDocumento").html(html === "" ? " <tr><td colspan='7' align=center>No se encontraron resultados</td></tr>" : html);
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });

    }
   
    function ocultarAlerta(){
        window.setTimeout(function(){
        $("#alert-green").slideUp('slow');
        $("#alert-red").slideUp('slow');
        $("#alert-blue").slideUp('slow');
        $("#alert-yellow").slideUp('slow');
        }, 8000);  
    }     

    function detalle_documento(cod,mov,cod_mov,i){
		obtener_expediente(cod);
        $('#tabla_documento tr').removeClass('highlighted');
        $("#fila" + i).addClass('highlighted');
        $("#cod_documento").val(cod);
		$("#cod_expediente").val(cod);
		$("#doc").val(cod);
		$("#movimiento").val(mov);
		$("#cod_mov").val((cod_mov == null ? "" : cod_mov));
		$("#boton_editar").show();
		if(cod == 'null')
		$("#boton_agregar0").hide();
		else
		$("#boton_agregar0").show();

		listar_actividad(cod);

    }
	
	function listar_actividad(cod){
		    $("#cuerpoMovimiento").fadeIn(1000).html("<tr><td colspan='7' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
        $.ajax({
	url : '<?php base_url()?>Legal/listar_actividad',
	data :'cod='+cod,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            var html = "";
            var i=1;
            $.each(documento, function () {
            html += "<tr id='filad" + this.pkActividad + "' onclick=detalle_movimiento('" + this.pkActividad +"','"+i+"') >";
            html += "<td>" + i + "</td>";
            html += "<td>" + this.actividadDetalle + "</td>";
            html += "<td>" + this.actoDetalle + "</td>";
            html += "<td>" + this.sumilla + "</td>";
            html += "<td>" + this.fechaInicio.substr(8,2)+"/"+this.fechaInicio.substr(5,2)+"/"+this.fechaInicio.substr(0,4) + "</td>";
            html += "<td>" + this.fechaProgramada.substr(8,2)+"/"+this.fechaProgramada.substr(5,2)+"/"+this.fechaProgramada.substr(0,4) + "</td>";
			html += "<td>" + this.anexo + "</td>";
            html += "</tr>";
            i++;
            });
            $("#cuerpoMovimiento").html(html === "" ? " <tr><td colspan='7' align=center>No se encontraron resultados</td></tr>" : html);
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
	}

	function limpiar_expediente(){
		$("#form_documento #distrito").select2("val", "0");
		$("#form_documento #organo").select2("val", "0");
		$("#form_documento #especialidad").select2("val", "0");
		$("#form_documento #sede").select2("val", "0");
		$("#form_documento #sala").select2("val", "0");
		$('#form_documento #situacion').val("0");
		$("#form_documento #expediente").val("");	
		$("#form_documento #fecha").val("");
		$("#form_documento #involucrado").val("");
		$("#form_documento #delito").val("");
		$("#form_documento #resumen").val("");
	}

	function limpiar_actividad(){
		$("#cod_actividad").val("");
		$('#tabla_movimiento tr').removeClass('highlighted');
		$("#form_movimiento #actividad").select2("val", "0");
	    //$('#form_documento #acto').val("0");
		$("#form_movimiento #sumilla").val("");	
		$("#form_movimiento #fecha_inicio").val("");
		$("#form_movimiento #fecha_programada").val("");
		$("#form_movimiento #anexo").val("");
		$("#form_movimiento #observacion").val("");
		
		$("#boton_editar0").hide();
		$("#boton_anular0").hide();
	}

    function obtener_actividad(actividad){
        $("#cod_expediente").val($("#doc").val());
		$("#cod_actividad").val(actividad);
        $.ajax({
	url : '<?php base_url()?>Legal/listar_actividad',
	data :'cod_actividad='+actividad,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            $.each(documento, function () {
            $("#form_movimiento #actividad").select2("val", this.actividad ); 
			$("#acto").val(this.acto);
			$("#acto").val(this.acto);
			$("#sumilla").val(this.sumilla);
			$("#fecha_inicio").val(this.fechaInicio.substring(8,10)+'/'+this.fechaInicio.substring(5,7)+'/'+this.fechaInicio.substring(0,4));
			$("#fecha_programada").val(this.fechaProgramada.substring(8,10)+'/'+this.fechaProgramada.substring(5,7)+'/'+this.fechaProgramada.substring(0,4));
			$("#anexo").val(this.anexo);
			$("#observacion").val(this.observacion);
            
            });   
        },
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }

    function detalle_movimiento(pkActividad,i){
		$("#label_tramite_d").html(i);
		obtener_actividad(pkActividad);
        $("#boton_editar0").show();
		$("#boton_anular0").show();
        $('#tabla_movimiento tr').removeClass('highlighted');
        $("#filad" + pkActividad).addClass('highlighted');
    }
   
    function listar_categoria(grupo){
		if(grupo=='1'){
               $('#distrito').append($('<option>', { value: 0,text : "Seleccionar" })); 
				}
                else if(grupo=='2'){
				$('#organo').append($('<option>', { value: 0,text : "Seleccionar" })); 
				}
                else if(grupo=='3'){
				$('#especialidad').append($('<option>', { value: 0,text : "Seleccionar" })); 
				}				
                else if(grupo=='4'){
				$('#sede').append($('<option>', { value: 0,text : "Seleccionar" }));  
				}
                else if(grupo=='5'){
				$('#sala').append($('<option>', { value: 0,text : "Seleccionar" })); 
				}
		
		
		



		
        $.ajax({
	url : '<?php base_url()?>Legal/listar_categoria',
	data :'grupo='+grupo,
	type : 'POST',
	success : function(result) {

	var documento = eval(result); 
            $.each(documento, function () {
                if(grupo=='1'){
                $('#sdistrito').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				$('#distrito').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				}
                else if(grupo=='2'){
                $('#sorgano').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				$('#organo').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				}
                else if(grupo=='3'){
                $('#sespecialidad').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				$('#especialidad').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				}				
                else if(grupo=='4'){
                $('#ssede').append($('<option>', { value: this.pkCategoria,text : this.descripcion }));  
				$('#sede').append($('<option>', { value: this.pkCategoria,text : this.descripcion }));  
				}
                else if(grupo=='5'){
                $('#ssala').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				$('#sala').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				}
				else if(grupo=='6'){
				$('#actividad').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
				}
	});
        },
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
	
	function listar_tipo(grupo){
    $.ajax({
	url : '<?php base_url()?>Legal/listar_tipo',
	data :'grupo='+grupo,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
				if(grupo=='6'){
				$('#actividad').append($('<option>', { value: 0,text : "Seleccionar" })); 
				}
            $.each(documento, function () {
				if(grupo=='6'){
				$('#actividad').append($('<option>', { value: this.pkTipo,text : this.descripcion })); 
				}
	});
        },
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
</script>
<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Expedientes Legales
        </span>      
            <div class="btn-group">
                <select name="sanio" id="sanio"  class="form-control" onchange="listar_expediente()">
                    <option <?php if(date('Y')=='2015')echo "selected"; ?> value="2015"> 2015 </option>
                    <option <?php if(date('Y')=='2016')echo "selected"; ?> value="2016"> 2016 </option>
                    <option <?php if(date('Y')=='2017')echo "selected"; ?> value="2017"> 2017 </option>
                    <option <?php if(date('Y')=='2018')echo "selected"; ?> value="2017"> 2018 </option>
                    <option <?php if(date('Y')=='2019')echo "selected"; ?> value="2017"> 2019 </option>
                    <option <?php if(date('Y')=='2020')echo "selected"; ?> value="2017"> 2020 </option>
                </select>
            </div>
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4 bloqueExterno" align="right">
                <?php if(in_array('29',$_SESSION['cOperador'])){?>  
                <span id="boton_editar" class="btn btn-primary" title="Modificar" style="font-size:12px;display:none" data-toggle="modal" data-target="#registrarDocumentoModal"><!--onclick="obtener_documento();" -->
                    <i  class="fa fa-pencil" ></i> 
                </span>
                <?php } ?>  

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
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Distrito Judicial</label>
                                <div class='form-group'>
                                <select name="sdistrito" id="sdistrito"  class="form-control" onchange="listar_expediente()">
                                <option value=""> Todas </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Organo Juris.</label>
                                <div class='form-group'>
                                <select name="sorgano" id="sorgano"  class="form-control" onchange="listar_expediente()" >
                                <option value=""> Todas </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Especialidad</label>
                                <div class='form-group'>
                                <select name="sespecialidad" id="sespecialidad"  class="form-control" onchange="listar_expediente()" >
                                <option value=""> Todas </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Sede</label>
                                <div class='form-group'>
                                <select name="ssede" id="ssede"  class="form-control" onchange="listar_expediente()" >
                                <option value=""> Todas </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Sala/Juzgado</label>
                                <div class='form-group'>
                                <select name="ssala" id="ssala"  class="form-control" onchange="listar_expediente()" >
                                <option value=""> Todas </option>
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>N° Expediente</label>
                                <div class='form-group'>
                                <input type='text' name="ssearch" id="ssearch"  class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:380px" >
				<input type="hidden" name="cod_documento" id="cod_documento">
				<input type="hidden" name="cod_movimiento" id="cod_movimiento">
                    <table  id="tabla_documento" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th ><b>N. </b></th>
                            <th ><b>N. Trámite </b></th>
                            <th ><b>Expediente </b></th>
                            <th ><b>Involucrados </b></th>
                            <th ><b>Fecha </b></th>
                            <th ><b>Resumen </b></th>
							<!--<th ><b>Usuario </b></th>-->
                            <th ><b>Situación </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoDocumento">
						<tr >
                            <td  colspan="8" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
	
<section class="content-header" style="margin-bottom:10px;margin-top:-20px">
	<div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Seguimiento del Expediente
        </span>      
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4" align="right">
                <span id="boton_agregar0" class="btn btn-primary" title="Agregar"   style="font-size:12px;display:none" data-toggle="modal" data-target="#registrarMovimientoModal" onclick="limpiar_actividad()">
                    <i  class="fa fa-plus" ></i> 
                </span>
                <span id="boton_editar0" class="btn btn-primary" title="Modificar" style="font-size:12px;display:none" data-toggle="modal" data-target="#registrarMovimientoModal" >
                    <i  class="fa fa-pencil" ></i> 
                </span>
                <span id="boton_anular0" class="btn btn-primary" title="Anular" id="anular" style="font-size:12px;display:none" data-toggle="modal" data-target="#eliminarMovimientoModal" >
                    <i  class="fa fa-minus-circle" ></i> 
                </span>
            </div>
    </div>
</section>

	<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body pad table-responsive" style="overflow:scroll;height:230px" >
                    <table  id="tabla_movimiento" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th ><b>N. </b></th>
                            <th ><b>Actividad </b></th>
                            <th ><b>Acto </b></th>
                            <th ><b>Sumilla </b></th>
                            <th ><b>Fecha Inicio </b></th>
                            <th ><b>Fecha Programada </b></th>
							<th ><b>Anexo </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoMovimiento">
			<tr >
                            <td  colspan="8" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
	<div class="modal fade" id="eliminarMovimientoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar Movimiento</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea Eliminar el Movimiento N°  <span id="label_tramite_d"></span> ?</p>
                    <p class="debug-url"></p>
                </div>
                <div class="modal-footer">
                    <button id="cerrar" type="button" class="btn btn-default btn-default-cerrar" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-eliminar2">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    <form id="form_documento">
	<input type="hidden" name="movimiento" id="movimiento">
	<input type="hidden" name="cod_mov" id="cod_mov">
	<input type="hidden" name="doc" id="doc">	

    <div class="modal fade" id="registrarDocumentoModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Registro del Expediente </h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" title="Guardar" class="btn btn-primary" style="font-size:12px" >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" title="Cerrar" aria-label="Close" class="btn btn-default btn-default-cerrar" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Distrito Judicial</label>                             
                                <select class="form-control select2" style="width: 100%;" name="distrito" id="distrito">
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
                            <div class="form-group">
                                <label>Organo Juris.</label>  
								<span data-toggle="modal" data-target="#registrarOrganoModal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;" id="agregar_organo" title="Agregar Organo" class="btn btn-danger btn-insertar-organo" style="font-size:12px"><i class="fa fa-plus"></i></span>
														
                                 <select  class="form-control select2" style="width: 100%;" name="organo" id="organo">
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Especialidad</label>
								
								<span data-toggle="modal" data-target="#registrarEspecialidadModal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;" id="agregar_especialidad" title="Agregar Especialidad" class="btn btn-danger btn-insertar-especialidad" style="font-size:12px"><i class="fa fa-plus"></i></span>
								
                                <select  class="form-control select2" style="width: 100%;" name="especialidad" id="especialidad">
                                </select>
                            </div>
                        </div>
						</div>
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Sede</label>
								<span data-toggle="modal" data-target="#registrarSedeModal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;" id="agregar_sede" title="Agregar Sede" class="btn btn-danger btn-insertar-sede" style="font-size:12px"><i class="fa fa-plus"></i></span>
                                <select  class="form-control select2" style="width: 100%;" name="sede" id="sede">
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="groupUnidad"  >
                            <div class="form-group">
                                <label>Sala/Juzgado</label>
								<span data-toggle="modal" data-target="#registrarSalaModal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;" id="agregar_sala" title="Agregar sala" class="btn btn-danger btn-insertar-sala" style="font-size:12px"><i class="fa fa-plus"></i></span>
                                <select  class="form-control select2" style="width: 100%;" name="sala" id="sala">
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="groupPersona" >
                            <div class="form-group">
                                <label># Expediente</label>  
                                <input type="text" class="form-control" style="width: 100%;" name="expediente" id="expediente">
                            </div>
                        </div>
                    </div>	
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="text" class="form-control" style="width: 100%;" name="fecha" id="fecha">
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="groupUnidad"  >
                            <div class="form-group">
                                <label>Situación</label> 
                                <select class="form-control" style="width: 100%;" name="situacion" id="situacion">
								<option value="0">Seleccionar</option>
								<option value="68">En Trámite</option>
								<option value="69">Finalizado</option>
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="groupPersona" >
                            <div class="form-group">
                                <label>Involucrados</label>  
                                <input type="text" class="form-control" style="width: 100%;" name="involucrado" id="involucrado">
                              
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Delito</label>
								<input type="text" class="form-control" style="width: 100%;" name="delito" id="delito">
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Resumen</label>
                                <textarea name="resumen" id="resumen"  class="form-control" style="resize: none;height:100px" />
                                
                                </textarea>
                            </div>
                        </div>
                    </div>                  
                   
                </div>   
            </div>
        </div>
    </div>
    </form>
    <form id="form_movimiento">
    <div class="modal fade" id="registrarMovimientoModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Registro de la Actividad <input type="hidden" name="cod_actividad" id="cod_actividad"><input type="hidden" name="cod_expediente" id="cod_expediente"></h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" title="Guardar" class="btn btn-primary" style="font-size:12px" >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" title="Cerrar" aria-label="Close" class="btn btn-default btn-default-cerrar" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Actividad</label>                             
                                <select class="form-control select2" style="width: 100%;" name="actividad" id="actividad">
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
                            <div class="form-group">
                                <label>Acto</label>  
                                 <select  class="form-control" style="width: 100%;" name="acto" id="acto">
								 <option value="78">Escrito</option>
								 <option value="79">Auto Admisorio</option>
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Sumilla</label>
                                <input  class="form-control" style="width: 100%;" name="sumilla" id="sumilla">
                          
                            </div>
                        </div>
					</div>

					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Fecha Inicio</label>
                                <input type="text" class="form-control" style="width: 100%;" name="fecha_inicio" id="fecha_inicio">
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="groupUnidad"  >
                            <div class="form-group">
                                <label>Fecha Programada</label> 
                                <input type="text" class="form-control" style="width: 100%;" name="fecha_programada" id="fecha_programada">
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="groupPersona" >
                            <div class="form-group">
                                <label>Anexo</label>  
                                <input type="text" class="form-control" style="width: 100%;" name="anexo" id="anexo">
                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea name="observacion" id="observacion"  class="form-control" style="resize: none;height:100px" />
                                </textarea>
                            </div>
                        </div>
                    </div>                  
                   
                </div>   
            </div>
        </div>
    </div>
    </form>
    
    <div class="modal fade" id="registrarOrganoModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Registrar Organo</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-organo" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-organo" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Entidad</label>  
                                <input type='text' name="cod_entidad" id="cod_entidad"  class="form-control"  disabled />
                            </div>
                        </div>-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Organo Juris.</label><br>
                                <input type="text" name="detalle_organo" id="detalle_organo" class="form-control">  
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
    
	    <div class="modal fade" id="registrarEspecialidadModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Registrar Especialidad</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-especialidad" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-especialidad" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Especialidad</label><br>
                                <input type="text" name="detalle_especialidad" id="detalle_especialidad" class="form-control">  
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
	
        <div class="modal fade" id="registrarSedeModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Registrar Sede</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-sede" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-sede" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Sala/Juzgado</label>  
                                <input type='text' name="cod_entidad" id="cod_unidad"  class="form-control"  disabled />
                            </div>
                        </div>-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Sede</label><br>
                                <input type="text" name="detalle_sede" id="detalle_sede" class="form-control">  
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="registrarSalaModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Sala/Juzgado</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-sala" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-sala" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Unidad</label>  
                                <input type='text' name="cod_entidad2" id="cod_unidad2"  class="form-control"  disabled />
                            </div>
                        </div>-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Sala</label><br>
                                <input type="text" name="detalle_sala" id="detalle_sala" class="form-control">  
                            </div>
                        </div>
                       
                    </div>	
                </div>   
            </div>
        </div>
    </div>   
    
</section><!-- /.content -->
<script>  $(function () {$(".select2").select2({
    placeholder:"Seleccionar"
});}); </script>