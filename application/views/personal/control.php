<script src="<?php base_url()?>js/jquery.uitablefilter.js"      type="text/javascript"></script>
<script src="<?php base_url()?>library/plugins/select2/select2.full.min.js"></script>

<script>
    $(document).ready(function(){      
        fecha_defecto();
        listar_persona();
        verificar_cierre();
        
        $('#fecha').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
        
        $('#fecha_icon').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true,
        });
        
        theTable = $("#tabla_persona");
        $("#search").keyup(function () {
        $.uiTableFilter(theTable, this.value);
        });

        $("#boton_imprimir").click(function(){
            dependencia=<?php echo $_SESSION['pkDependencia']?>;
            fecha=$('#fecha').val();

            window.open("./maestro/exportar_asistencia?dependencia="+dependencia+"&fecha="+fecha);	
        });
        
        $("#boton_imprimir_detalle").click(function(){
            dependencia=<?php echo $_SESSION['pkDependencia']?>;
            fecha=$('#fecha').val();

            window.open("./maestro/exportar_asistencia_detalle?dependencia="+dependencia+"&fecha="+fecha);	
        });
           
           
            function validarCampos(){
            $("#total_error").val(0);
            var $inputs = $('#form_persona .horaMinuto2'); // Obtenemos los inputs de nuestro formulario
            var formvalido = true; // Para saber si el form esta vacio 
            var i=0;
            $inputs.each(function() {  // Recorremos los inputs del formulario (uno a uno)
            if(!isValidated($(this).val())){ // Verificamos que el input este vacio 
            i++;  
            $(this).css('background','#FFDBDB'); // Agregamos un fondo rojo si este esta vacio
            formvalido = false;
            
            }else{
            $(this).css('background','#eee'); // quitamos el fondo rojo si este esta lleno
            }
            });
            $("#total_error").val(eval(i));
            return formvalido; // retornamos segun corresponda
            }

            function isValidated(val){ 
			if(jQuery.trim(val).length!=0)  
            if(jQuery.trim(val).length!=5 ||  jQuery.trim(val).substr(2,1)!=":")
            return false;
            return true;
            }   
           
        $("#boton_registrar").click(function(){
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
					else{
						window.location = "http://" + location.host+"/std";
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
					else{
						window.location = "http://" + location.host+"/std";
					}
                },
                error : function(request, xhr, status) {                
                $("#texto-red").html("Error : "+status+' '+xhr.responseText+ ' - '+ request);
                $("#alert-red").slideDown('slow');
                }
                });
                

        });
        
        $("#todo").click(function(){
        var fecha= new Date();
        
        if(fecha.getHours()>9)
        hora= fecha.getHours();
        else
        hora= "0"+fecha.getHours();
        
        if(fecha.getMinutes()>9)
        minuto = fecha.getMinutes();
        else
        minuto= "0"+fecha.getMinutes();
        
            if($("#todo").is(':checked')) {
                $(".check0").prop('checked', true);
                $(".horaMinuto").val(hora+":"+minuto);
            } else {  
                $(".check0").prop('checked', false);
                $(".horaMinuto").val("");
            }
        });
        
        $("#todo2").click(function(){
        var fecha= new Date();
        
        if(fecha.getHours()>9)
        hora= fecha.getHours();
        else
        hora= "0"+fecha.getHours();
        
        if(fecha.getMinutes()>9)
        minuto = fecha.getMinutes();
        else
        minuto= "0"+fecha.getMinutes();
        
            if($("#todo2").is(':checked')) {
                $(".check2").prop('checked', true);
                $(".horaMinuto2").val(hora+":"+minuto);
            } else {  
                $(".check2").prop('checked', false);
                $(".horaMinuto2").val("");
            }
        });
        
    });
    
    $("#fecha").change(function(){
        listar_persona();
        verificar_cierre();
    });
    
    function fecha_defecto(){
        //fecha por defecto
        var f = new Date();
        var dia, mes;
        if(f.getDate()<10) dia="0"+f.getDate(); else dia=f.getDate();
        if((f.getMonth()*1+1)<10) mes="0"+(f.getMonth()+1); else mes=(f.getMonth()+1);
       
        var fecha_def_ini= "01/"+mes+ "/" + f.getFullYear();
        var fecha_def_fin= dia+"/"+mes+ "/" + f.getFullYear();
        
        $("#fecha_ini").val(fecha_def_ini);
        $("#fecha_fin").val(fecha_def_fin);
        $("#fecha").val(fecha_def_fin);
    }
    
    function chekear(v){
        var fecha= new Date();
        
        if(fecha.getHours()>9)
        hora= fecha.getHours();
        else
        hora= "0"+fecha.getHours();
        
        if(fecha.getMinutes()>9)
        minuto = fecha.getMinutes();
        else
        minuto= "0"+fecha.getMinutes();
        if($("#asistio0"+v).is(':checked')) {  
            $("#horaMinuto0"+v).val(hora+":"+minuto);
        } else {  
            $("#horaMinuto0"+v).val("");
          
        }  
        
    }
    
    function chekear2(v){
        var fecha= new Date();
        
        if(fecha.getHours()>9)
        hora= fecha.getHours();
        else
        hora= "0"+fecha.getHours();
        
        if(fecha.getMinutes()>9)
        minuto = fecha.getMinutes();
        else
        minuto= "0"+fecha.getMinutes();
        
        if($("#asistio2"+v).is(':checked')) {  
            $("#horaMinuto2"+v).val(hora+":"+minuto);
        } else {  
            $("#horaMinuto2"+v).val("");
        }  
        
    }
    
    function ocultarAlerta(){
        window.setTimeout(function(){
        $("#alert-green").slideUp('slow');
        $("#alert-red").slideUp('slow');
        $("#alert-blue").slideUp('slow');
        $("#alert-yellow").slideUp('slow');
        }, 8000);  
    }
  
    function listar_persona(){
        unidad=<?php echo $_SESSION['pkDependencia']?>;
        $("#cuerpoPersona").fadeIn(1000).html("<tr><td colspan='9' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
       
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_locador',
	data :'dependencia='+unidad+'&fecha='+$("#fecha").val(),
	type : 'POST',
	success : function(result) {
	var documento = eval(result);      
            var html = "";
            v=1;
            
            
            $.each(documento, function () {
            if(this.tiempo!="")
                check="checked";
            else
                check="";
                
            if(this.tiempo2!="")
                check2="checked";
            else
                check2="";
            
            html += "<tr id='fila" + this.pkPersona + "' >";
            html += "<td style='text-align:center'><input id='pkPersona"+v+"' name='pkPersona[]' type='hidden'  value='" + this.pkPersona + "' />"+v+"</td>";
            html += "<td style='text-align:center'>" + this.ruc + "</td>";
            html += "<td>" + this.razonSocial + "</td>";
            html += "<td>" + this.gerencia + "</td>";
            html += "<td style='text-align:center'><input type='checkbox' " + check + " id='asistio0"+v+"' class='check0' name='asistio0[]' onclick=chekear('" + v +"')></td>";
            html += "<td style='text-align:center'><span><input style='background:#eee;height:30px' type='text' class='form-control horaMinuto' name='horaMinuto[]' id='horaMinuto0"+v+"' value='"+this.tiempo+"' ></span></td>";
            html += "<td style='text-align:center'><input type='checkbox' " + check2 + " id='asistio2"+v+"' class='check2' name='asistio2[]' onclick=chekear2('" + v +"')></td>";   
            html += "<td style='text-align:center'><span><input maxlength='5' style='background:#eee;height:30px' type='text' class='form-control horaMinuto2' name='horaMinuto2[]' id='horaMinuto2"+v+"' value='"+this.tiempo2+"' ></span></td>";
            html += "<td style='text-align:center'><span><input style='background:#eee;height:30px' type='text' class='form-control observacion' name='observacion[]' id='observacion"+v+"' value='"+this.observacion+"' ></span></td>";
            
            html += "</tr>";
            v++;
            });
            $("#cuerpoPersona").html(html === "" ? " <tr><td colspan='9' align=center>No se encontraron resultados</td></tr>" : html);
	
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }  
    
    function verificar_cierre(){
        unidad=<?php echo $_SESSION['pkDependencia']?>;
        mes=$("#fecha").val().substr(3,2);
        anio=$("#fecha").val().substr(6,4);

        $.ajax({
	url : '<?php base_url()?>Maestro/verificar_cierre',
	data :'dependencia='+unidad+'&mes='+mes+'&anio='+anio,
	type : 'POST',
	success : function(result) {
	var estado = eval(result);  
        $.each(estado, function () {
        if(this.verify=='1'){
            $("#boton_registrar").hide();
            $("#boton_cerrar").hide();
        }
        else{
            $("#boton_registrar").show();
            $("#boton_cerrar").show();
        }
        });
	
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function obtenerMesAnio(){
        mes=$("#fecha").val().substr(3,2);
        if(mes=='01') mes="Enero";
        else if(mes=='02') mes="Febrero";
        else if(mes=='03') mes="Marzo";
        else if(mes=='04') mes="Abril";
        else if(mes=='05') mes="Mayo";
        else if(mes=='06') mes="Junio";
        else if(mes=='07') mes="Julio";
        else if(mes=='08') mes="Agosto";
        else if(mes=='09') mes="Setiembre";
        else if(mes=='10') mes="Octubre";
        else if(mes=='11') mes="Noviembre";
        else if(mes=='12') mes="Diciembre";
        anio=$("#fecha").val().substr(6,4);
        $("#mesanio").html( mes + ' ' + anio);
    }
</script>

<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Asistencia de Locadores </span>
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4 bloqueExterno" align="right">
                <?php if(isset($_SESSION['cOperador'])){if(in_array('24',$_SESSION['cOperador'])){?>  
                <span id="boton_registrar" class="btn btn-primary" title="Guardar"   style="font-size:12px;">
                    <i  class="fa fa-save" ></i> 
                </span>
                <?php } if(in_array('25',$_SESSION['cOperador'])){?>  
                <span id="boton_imprimir" class="btn btn-primary" title="Diario"  id="Diario" style="font-size:12px" >
                    <i class="fa fa-print" ></i> 
                </span>
                <?php } if(in_array('33',$_SESSION['cOperador'])){?>  
                <span id="boton_imprimir_detalle" class="btn btn-primary" title="Detallado"  id="Detallado" style="font-size:12px" >
                    <i class="fa fa-calendar" ></i> 
                </span>
                <?php } if(in_array('34',$_SESSION['cOperador'])){?>  
                <span onclick="obtenerMesAnio()" data-toggle="modal" data-target="#cierreModal" id="boton_cerrar" class="btn btn-danger" title="Cierre"  id="Detallado" style="font-size:12px" >
                    <i class="fa fa-lock" ></i> 
                </span>
                <?php }}  ?>  
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
                                <label>Razón Social <input type="hidden" id="total_error" value="0"></label>
                                <div class='input-group date'>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-search"></span>
                                </span>
                                <input type='text' name="search" id="search"  class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-5">
                            <div class="dataTables_length">
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Fecha</label>
                                <div class='input-group date' id="fecha_icon">
                                <input readonly style='background-color:#eee' type='text' name="fecha" id="fecha"  class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                            <div class="dataTables_length">
                                <span class="btn btn-primary" title="Buscar" id="imprimir" style="font-size:12px;margin-top:22px" onclick="listar_persona()">
                                <i class="fa fa-search" ></i> 
                                </span>
                            </div>
                        </div>-->
			
                    </div>	
                </div>
                <form id="form_persona" method="post">
                <div class="box-body pad table-responsive" style="overflow:scroll;height:700px" >
                    <table  id="tabla_persona" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                            
                            
                        <tr  class="cabecera">
                            <th style="border: 0px !important;background-color: #fff;"></th>
                            <th style="border: 0px !important;background-color: #fff;"></th>
                            <th style="border: 0px !important;background-color: #fff;"></th>
                            <th style="border: 0px !important;background-color: #fff;"></th>                            
                            <th colspan="2" style='width:60px;text-align:center'><b> Ingreso </b></th>

                            <th colspan="2" style='width:65px;text-align:center'><b> Salida </b></th>
                            <th style="border: 0px !important;background-color: #fff;"></th>
                        </tr>    
                        <tr  class="cabecera">
                            <th style='width:20px;text-align:center'><b> N. </b></th>
                            <th style='width:90px;;text-align:center'><b> RUC </b></th>
                            <th ><b> Razón Social </b></th>
                            <th ><b> Gerencia </b></th>
                            <th style='width:15px;text-align:center'><b> <input type="checkbox" name="todo" id="todo"></b></th>
                            <th style='width:65px;text-align:center'><b> HH:mm </b></th>
                            <th style='width:15px;text-align:center'><b> <input type="checkbox" name="todo2" id="todo2"></b></th>
                            <th style='width:65px;text-align:center'><b> HH:mm </b></th>
                            <th style='width:125px;text-align:center'><b> Observación </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoPersona">
			<tr >
                            <td  colspan="9" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
                </form>
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
    
    <div class="modal fade" id="cierreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Cierre del Mes</h4>
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