<script src="<?php base_url()?>js/jquery.uitablefilter.js"      type="text/javascript"></script>
<script src="<?php base_url()?>library/plugins/select2/select2.full.min.js"></script>

<script>
    $(document).ready(function(){      
        listar_persona();
        
        theTable = $("#tabla_persona");
        $("#search").keyup(function () {
        $.uiTableFilter(theTable, this.value);
        });

		$("#boton_permiso").hide();
		
	});
        /*$("#boton_registrar").click(function(){
            validarCampos();
            if($("#total_error").val()>0){
            $("#texto-yellow").html("La(s) Salida(s) ingresada(s) deben ser mayor a las 12:00 o no tienen el formato correcto (Ejm. 21:15)");
            $("#alert-yellow").slideDown('slow');
            ocultarAlerta();    
            }
            else{
            unidad=<?php echo $_SESSION['pkDependencia']?>;
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_asistencia',
                data : "dependencia="+unidad+"&fecha="+$("#fecha").val()+ "&"+$("#form_persona").serialize(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $("#texto-green").html("Se registró la asistencia correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
                    }
                },
                error : function(request, xhr, status) {                
                $("#texto-red").html("Error : "+status+' '+xhr.responseText+ ' - '+ request);
                $("#alert-red").slideDown('slow');
                }
                });
            }       
        });
        
        $(".btn-proceder").click(function(){
                unidad=<?php echo $_SESSION['pkDependencia']?>;
                mes=$("#fecha").val().substr(3,2);
                anio=$("#fecha").val().substr(6,4);
                
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_cierre',
                data : "dependencia="+unidad+"&mes="+mes+ "&anio="+anio,
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".close").click();
                    verificar_cierre();
                    $("#texto-green").html("Se realizó el cierre correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
                    
                    }
                },
                error : function(request, xhr, status) {                
                $("#texto-red").html("Error : "+status+' '+xhr.responseText+ ' - '+ request);
                $("#alert-red").slideDown('slow');
                }
                });
                

        });


        
    });
*/
    
    function ocultarAlerta(){
        window.setTimeout(function(){
        $("#alert-green").slideUp('slow');
        $("#alert-red").slideUp('slow');
        $("#alert-blue").slideUp('slow');
        $("#alert-yellow").slideUp('slow');
        }, 8000);  
    }
  
    function listar_persona(){
        $("#cuerpoPersona").fadeIn(1000).html("<tr><td colspan='6' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
       
        $.ajax({
		url : '<?php base_url()?>Maestro/listar_locador2',
		type : 'POST',
		success : function(result) {
		var documento = eval(result);      
            var html = "";
            v=1;
            $.each(documento, function () {
				
			if(this.apellidoPaterno==null || this.apellidoPaterno==""){	nombres =  this.razonSocial;}
			else {nombres=  this.apellidoPaterno + ' ' + this.apellidoMaterno + ' ' + this.nombre;}	
			if(this.nivel==null){nivel="";} else {if(this.nivel=='1') nivel="ADMINISTRADOR";else if(this.nivel=='3') nivel="USUARIO"; else nivel="";} 
			if(this.cargo=='1'){cargo="Gerente / Jefe";} else {cargo="Empleado"} 			
            html += "<tr id='fila" + this.pkPersona + "' onclick=detalle("+this.pkPersona+") >";
            html += "<td style='text-align:center'><input id='pkPersona"+v+"' name='pkPersona[]' type='hidden'  value='" + this.pkPersona + "' />"+v+"</td>";
            html += "<td style='text-align:center'>" + this.ruc + "</td>";
			html += "<td><input type=hidden id=campo" + this.pkPersona + " value='" + nombres + "'  >" + nombres + "</td>";
            html += "<td>" + this.gerencia + "</td>";
            html += "<td style='text-align:center'>"+cargo+"</td>";
            html += "<td style='text-align:center'>"+nivel+"</td>";
            html += "</tr>";
            v++;
            });
            $("#cuerpoPersona").html(html === "" ? " <tr><td colspan='6' align=center>No se encontraron resultados</td></tr>" : html);
	
		},
		error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
		},
        });
	}
	
	function detalle(cod,nom){
        $('#tabla_persona tr').removeClass('highlighted');
        $("#fila" + cod).addClass('highlighted');
        $("#cod_persona").val(cod);
		$("#boton_permiso").show();
		$("#nombrecompleto").html($("#campo"+cod).val());
	}
</script>

<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Usuarios </span>
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4 bloqueExterno" align="right">
                <?php if(in_array('39',$_SESSION['cOperador'])){?>  
                <span id="boton_agregar" class="btn btn-primary" title="Nuevo"   style="font-size:12px;">
                    <i  class="fa fa-plus" ></i> 
                </span>
                <?php } if(in_array('40',$_SESSION['cOperador'])){?>  
                <span id="boton_editar" class="btn btn-primary" title="Modificar"  style="font-size:12px" >
                    <i class="fa fa-pencil" ></i> 
                </span>
                <?php } if(in_array('41',$_SESSION['cOperador'])){?>  
                <span id="boton_permiso" class="btn btn-primary" title="Permisos"  style="font-size:12px" data-toggle="modal" data-target="#permisoModal" >
                    <i class="fa fa-key" ></i> 
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
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-5">
                            <div class="form-group">
                                <label>Descripción </label>
                                <div class='input-group date'>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-search"></span>
                                </span>
                                <input type='text' name="search" id="search"  class="form-control" />
								<input type="hidden" name="cod_persona" id="cod_persona">
								<input type="hidden" name="nombre" id="nombre">
								
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-5">
                            <div class="dataTables_length">
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">

                            </div>
                        </div>
                    </div>	
                </div>
                <form id="form_persona" method="post">
                <div class="box-body pad table-responsive" style="overflow:scroll;height:700px" >
                    <table  id="tabla_persona" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th style='width:20px;text-align:center'><b> N. </b></th>
                            <th style='width:90px;;text-align:center'><b> RUC </b></th>
                            <th ><b> Personal </b></th>
                            <th ><b> Gerencia </b></th>
							<th style='width:90px;;text-align:center' ><b> Cargo </b></th>
							<th style='width:60px;;text-align:center'><b> Nivel </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoPersona">
						<tr>
                            <td  colspan="9" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
                </form>
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
    
    <div class="modal fade" id="permisoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Asignar Permisos a <span id="nombrecompleto"></span></h4>
                </div>
                <div class="modal-body">
                    <p>Desea realizar el cierre de  <span id="mesanio"></span></p>
                    <p class="debug-url"></p>
                </div>
                <div class="modal-footer">
                    <button id="cerrar" type="button" class="btn btn-default btn-default-cerrar" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-proceder">Proceder</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->