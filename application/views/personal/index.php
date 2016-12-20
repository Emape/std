<script src="<?php base_url()?>js/jquery.uitablefilter.js"      type="text/javascript"></script>
<script src="<?php base_url()?>library/plugins/select2/select2.full.min.js"></script>

<script>
    $(document).ready(function(){      
        listar_persona();
        listar_dependencia();
        theTable = $("#tabla_persona");
        $("#search").keyup(function () {
        $.uiTableFilter(theTable, this.value);
        });

		$("#boton_permiso").hide();
		$("#boton_anular").hide();
		
		$.ajax({
        url : '<?php base_url()?>acceso/plantilla_permiso',
        type : 'POST',
        success : function(result) {
            $("#arbol").html(result);
        },
        error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
        }
        });	
		
		$("#form_usuario #apellido_paterno, #form_usuario #apellido_materno, #form_usuario #nombre").keyup(function() {
		$("#form_usuario #razon_social").val($("#form_usuario #apellido_paterno").val()+" "+ $("#form_usuario #apellido_materno").val()+" "+$("#form_usuario #nombre").val());
		$("#form_usuario #usuario").val($("#form_usuario #nombre").val().substr(0,1)+$("#form_usuario #apellido_paterno").val());
		});
		
		$("#show_hide_password").click(function(){
			var current = $(this).attr('action');
			if(current=='hide'){
				$("#contrasena").attr('type','text');
				$(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
			}
			if(current=='show'){
				$("#contrasena").attr('type','password');
				$("#contrasena").val("");
				$(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
			}
		});
	});
    
	function listar_dependencia(){
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_dependencia',
	data :'empresa=1',
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            $.each(documento, function () {
            $('#dependencia').append($('<option>', { value: this.pkDependencia,text : this.descripcion }));		
            });                
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
	      
    $(".btn-eliminar").click(function(){
            usuario=$('#cod_persona').val();
            $.ajax({
            url : '<?php base_url()?>Acceso/anular_usuario',
            data :'usuario='+usuario,
            type : 'POST',
            success : function(result) {
                if(result=='1'){
                $(".btn-default-cerrar").click();
                $("#texto-green").html("Se eliminó el usuario correctamente");
                $("#alert-green").slideDown('slow');
                listar_persona();
                ocultarAlerta();
                }
            },
            error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
            }
            });	
    });
	
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
			if(this.cargo=='1'){cargo="Gerente / Jefe";} else {cargo="Colaborador"} 			
            html += "<tr id='fila" + this.pkPersona + "' onclick=detalle("+this.pkPersona+","+this.pkUsuario+",'"+this.pkPersona+"') >";
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
	
	function detalle(cod,cod_user,nom){
		$(".check").each(function(){$(this).prop('checked',false);});
        $('#tabla_persona tr').removeClass('highlighted');
        $("#fila" + cod).addClass('highlighted');
        $("#cod_persona").val(cod);
		$("#cod_usuario").val(cod_user);
		
		if(cod_user==null)
		$("#boton_permiso").hide();
		else
		$("#boton_permiso").show();
	
		$("#boton_anular").show();	
		
		$("#nombrecompleto").html($("#campo"+cod).val());
		$("#label_usuario").html($("#campo"+nom).val());
		
		$("#pkPersona").val(cod);
		$("#pkUsuario").val(cod_user);
		
		obtener_persona(cod);
		
		$.ajax({
        url : '<?php base_url()?>acceso/obtener_permiso',
        type : 'POST',
		data : "codigo="+$("#cod_usuario").val(),
        success : function(result) {
			var documento = eval(result);      
            $.each(documento, function () {

				if(this.estado=='1')
				$("#checks"+this.pkOperador).prop('checked',true);
				else if(this.estado='0')
				$("#checks"+this.pkOperador).prop('checked',false);	
				else
				window.location = "http://" + location.host+"/std";
					
            });
        },
        error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
        }
        });	
	}
	
	function activar(p1,p2,p3,p4){
		
		if($('#checks'+p4).is(':checked')) estado="1";
        else estado="0";
		
		$.ajax({
        url : '<?php base_url()?>acceso/registrar_permiso',
        type : 'POST',
		data : "codigo="+$("#cod_usuario").val()+"&p1="+p1+"&p2="+p2+"&p3="+p3+"&p4="+p4+"&estado="+estado,
        success : function(result) {
			if(result='1')
			console.log(result);	
			else
			window.location = "http://" + location.host+"/std";
        },
        error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
        }
        });	
	}
	
	function limpiar_usuario(){
				$("#boton_permiso").hide();
				$("#boton_anular").hide();
				$("#pkPersona").val("");
				$("#pkUsuario").val("");
				$("#dni").val("");
				$("#ruc").val("");
				$("#dependencia").select2("val","0");
				$("#apellido_paterno").val("");
				$("#apellido_materno").val("");
				$("#form_usuario #nombre").val("");
				$("#razon_social").val("");
				$("#email").val("");
				$("#cargo").val("0");
				$("#password").val("");
				$("#locador").prop("checked",false);	
				$("#usuario").val("");
				$("#contrasena").val("");
				$("#nivel").val("0");
				$('#tabla_persona tr').removeClass('highlighted');
				$("#usuario").attr('readonly', false);
	}
	
	function obtener_persona(cod){
		$.ajax({
        url : '<?php base_url()?>Personal/obtener_persona',
        type : 'POST',
		data : "cod="+cod,
        success : function(result) {
			var documento = eval(result);      
            $.each(documento, function () {
				$("#pkPersona").val(this.pkPersona);
				$("#pkUsuario").val(this.pkUsuario);
				
				$("#dni").val(this.dni);
				$("#ruc").val(this.ruc);
				$("#dependencia").select2("val",this.pkDependencia);
				$("#apellido_paterno").val(this.apellidoPaterno);
				$("#apellido_materno").val(this.apellidoMaterno);
				$("#form_usuario #nombre").val(this.nombre);
				$("#razon_social").val(this.razonSocial);
				$("#email").val(this.email);
				$("#cargo").val(this.cargo);
				$("#password").val(this.contrasena);
				if(this.locador=="1")
				$("#locador").prop("checked",true);
				else
				$("#locador").prop("checked",false);	
				$("#usuario").val(this.usuario);

				if(this.pkUsuario=="" || this.pkUsuario==null)
					$("#usuario").attr('readonly', false);
				else
					$("#usuario").attr('readonly', true);
				
				$("#contrasena").val("");
				
				if(this.nivel==null)
					$("#nivel").val(0);
				else
					$("#nivel").val(this.nivel);
				
				/*if(this.estado=='1')
				$("#checks"+this.pkOperador).prop('checked',true);
				else if(this.estado='0')
				$("#checks"+this.pkOperador).prop('checked',false);	
				else
				window.location = "http://" + location.host+"/std";*/
					
            });
        },
        error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
        }
        });	
	}
	
	    $("#form_usuario #guardar").click(function(){
			//$("#boton_editar").hide();
			if($("#form_usuario #dni").val()==""){
                $("#texto-yellow").html("Ingrese Nro. Documento");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_usuario #dependencia").val()=="0"){
                $("#texto-yellow").html("Seleccione la Dependencia");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #apellido_paterno").val()==""){
                $("#texto-yellow").html("Ingrese Apellido Paterno");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #apellido_materno").val()==""){
                $("#texto-yellow").html("Ingrese Apellido Materno");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #nombre").val()==""){
                $("#texto-yellow").html("Ingrese Nombre");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #cargo").val()=="0"){
                $("#texto-yellow").html("Seleccione el Cargo");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #usuario").val()==""){
                $("#texto-yellow").html("Ingrese Usuario");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #contrasena").val()=="" && $("#form_usuario #password").val()==""){
                $("#texto-yellow").html("Ingrese Contraseña");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
			else if($("#form_usuario #nivel").val()=="0"){
                $("#texto-yellow").html("Seleccione el nivel");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Personal/registrar_persona',
                data : $('#form_usuario').serialize(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar").click();
                    $("#texto-green").html("Se registró el usuario correctamente");
                    $("#alert-green").slideDown('slow');
                    listar_persona();
                    ocultarAlerta();
					limpiar_usuario()
                    }
					else if(result=='2'){
                    $("#texto-red").html("El usuario ya se encuentra registrado, intente con otro.");
                    $("#alert-red").slideDown('slow');
                    ocultarAlerta();
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
</script>

<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Usuarios </span>
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4 bloqueExterno" align="right">
                <?php if(in_array('39',$_SESSION['cOperador'])){?>  
                <span id="boton_usuario" class="btn btn-primary" title="Usuario"   style="font-size:12px;" data-toggle="modal" data-target="#usuarioModal" >
                    <i  class="fa fa-user" ></i> 
                </span>
                <?php } if(in_array('41',$_SESSION['cOperador'])){?>  
                <span id="boton_permiso" class="btn btn-primary" title="Permisos"  style="font-size:12px" data-toggle="modal" data-target="#permisoModal" >
                    <i class="fa fa-key" ></i> 
                </span>
				<?php } if(in_array('40',$_SESSION['cOperador'])){?>  
                <span id="boton_anular" class="btn btn-danger" title="Anular"  style="font-size:12px" data-toggle="modal" data-target="#eliminarModal" >
                    <i class="fa fa-minus-circle" ></i> 
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
								<input type="hidden" name="cod_usuario" id="cod_usuario">
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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Persona: <span id="nombrecompleto"></span></h4>
                </div>
				<div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">  
                                <div class="tree">
                                    <ul>
                                    <li>
                                    <a href="#"><b>Permiso de Usuario</b></a>
                                    
                                    <span id="arbol"></span>
                                    
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
	
	<form id="form_usuario">
    <div class="modal fade" id="usuarioModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Registro del Usuario <input type="hidden" name="pkPersona" id="pkPersona"> <input type="hidden" name="pkUsuario" id="pkUsuario"></h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" title="Guardar" class="btn btn-primary" style="font-size:12px" >
                   <i class="fa fa-save"></i>
                </span>
				<span id="limpiar" title="Limpiar" class="btn btn-success" style="font-size:12px" onclick="limpiar_usuario()" >
                   <i class="fa fa-paint-brush"></i>
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
                                <label>DNI</label>                             
                                <input type="text" class="form-control" style="width: 100%;" name="dni" id="dni">
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
                            <div class="form-group">
                                <label>RUC</label> 
								<input type="text" class="form-control" style="width: 100%;" name="ruc" id="ruc">
                                <!---->
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Dependencia</label>
                                <select  class="form-control select2" style="width: 100%;" name="dependencia" id="dependencia">
								 <option value="0">Seleccione</option>								 
                                </select>
                            </div>
                        </div>
					</div>

					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>A. Paterno</label>
                                <input type="text" class="form-control" style="width: 100%;" name="apellido_paterno" id="apellido_paterno">
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>A. Materno</label> 
                                <input type="text" class="form-control" style="width: 100%;" name="apellido_materno" id="apellido_materno">
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Nombres</label>  
                                <input type="text" class="form-control" style="width: 100%;" name="nombre" id="nombre">
                              
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Razón Social</label>
                                <input type="text" class="form-control" style="width: 100%;" name="razon_social" id="razon_social">
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Cargo</label> 
                                <select  class="form-control" style="width: 100%;" name="cargo" id="cargo">
									<option value="0"> Seleccione </option>
									<option value="1"> Gerente/Jefe </option>
									<option value="2"> Colaborador </option>
                                </select>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Locador</label> <br> 
                                <input type="checkbox" name="locador" id="locador">
                              
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" style="width: 100%;" name="email" id="email" placeholder="usuario@emape.gob.pe">
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">

                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                
                              
                            </div>
                        </div>
                    </div>
                   
				   	<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" style="width: 100%;background-color:#F3D3D3" name="usuario" id="usuario" >
          
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Contraseña</label> 
								<div class="input-group">
									<input type="password" class="form-control"  name="contrasena" id="contrasena" style="background-color:#F3D3D3" placeholder="****************">
									<input type="hidden" class="form-control"  name="password" id="password" style="background-color:#F3D3D3" placeholder="****************">
									
									<span class="input-group-addon">
									<span id="show_hide_password" action="hide" class="glyphicon glyphicon-eye-open"></span>
									</span>
								</div>
								
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Nivel</label>                                  
								<select  class="form-control" style="width: 100%;" name="nivel" id="nivel">
									<option value="0">Seleccione</option>
									<option value="1">Administrador</option>
									<option value="3">Usuario</option>
                                </select>
                            </div>
                        </div>
                    </div>
					
                </div>   
            </div>
        </div>
    </div>
    </form>
	<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar Usuario</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea Eliminar al usuario <span id="label_usuario"></span> ?</p>
                    <p class="debug-url"></p>
                </div>
                <div class="modal-footer">
                    <button id="cerrar" type="button" class="btn btn-default btn-default-cerrar" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-eliminar">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
<script>  $(function () {$(".select2").select2({
    placeholder:"Seleccionar"
});}); </script>