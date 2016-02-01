<script src="<?php base_url()?>js/jquery.uitablefilter.js"      type="text/javascript"></script>
<script src="<?php base_url()?>library/plugins/select2/select2.full.min.js"></script>

<script>
    $(document).ready(function(){      
        fecha_defecto();
        listar_persona();
        
        $('#fecha').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
        
        $('#fecha_icon').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
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
           
        $("#boton_registrar").click(function(){
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
        
    });
    
    function fecha_defecto(){
        //fecha por defecto
        var f = new Date();
        var dia, mes;
        if(f.getDate()<10) dia="0"+f.getDate(); else dia=f.getDate();
        if(f.getMonth()<10) mes="0"+(f.getMonth()+1); else mes=(f.getMonth()+1);
       
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
        
        if($("#asistio"+v).is(':checked')) {  
            $("#horaMinuto"+v).val(hora+":"+minuto);
        } else {  
            $("#horaMinuto"+v).val("");
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
        $("#cuerpoPersona").fadeIn(1000).html("<tr><td colspan='6' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
       
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
                
            html += "<tr id='fila" + this.pkPersona + "' >";
            html += "<td style='text-align:center'><input id='pkPersona"+v+"' name='pkPersona[]' type='hidden'  value='" + this.pkPersona + "' />"+v+"</td>";
            html += "<td style='text-align:center'>" + this.ruc + "</td>";
            html += "<td>" + this.razonSocial + "</td>";
            html += "<td>" + this.gerencia + "</td>";
            html += "<td style='text-align:center'><input type='checkbox' " + check + " id='asistio"+v+"' class='check0' name='asistio[]' onclick=chekear('" + v +"')></td>";
            html += "<td style='text-align:center'><span><input readonly style='background:#eee;height:30px' type='text' class='form-control horaMinuto' name='horaMinuto[]' id='horaMinuto"+v+"' value='"+this.tiempo+"' ></span></td>";
            html += "<td style='text-align:center'><span><input maxlength='5' style='background:#eee;height:30px' type='text' class='form-control horaMinuto2' name='horaMinuto2[]' id='horaMinuto2"+v+"' value='"+this.tiempo2+"' ></span></td>";
            html += "<td style='text-align:center'><span><input style='background:#eee;height:30px' type='text' class='form-control observacion' name='observacion[]' id='observacion"+v+"' value='"+this.observacion+"' ></span></td>";
            
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
</script>

<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Asistencia de Locadores </span>
        </div>
            <div class="col-xs-7 col-sm-6 col-md-4 col-lg-4 bloqueExterno" align="right">
                <?php if(in_array('24',$_SESSION['cOperador'])){?>  
                <span id="boton_registrar" class="btn btn-primary" title="Guardar"   style="font-size:12px;">
                    <i  class="fa fa-save" ></i> 
                </span>
                <?php } if(in_array('25',$_SESSION['cOperador'])){?>  
                <span id="boton_imprimir" class="btn btn-primary" title="Imprimir"  id="imprimir" style="font-size:12px" >
                    <i class="fa fa-print" ></i> 
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
                                <label>Razón Social</label>
                                <div class='input-group date'>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-search"></span>
                                </span>
                                <input type='text' name="search" id="search"  class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4">
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
                        <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                           
                            <div class="dataTables_length">
                                <span class="btn btn-primary" title="Buscar" id="imprimir" style="font-size:12px;margin-top:22px" onclick="listar_persona()">
                    <i class="fa fa-search" ></i> 
                </span>
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
                            <th ><b> Razón Social </b></th>
                            <th ><b> Gerencia </b></th>
                            <th style='width:60px;text-align:center'><b> Asistió <input type="checkbox" name="todo" id="todo"></b></th>
                            <th style='width:65px;text-align:center'><b> Ingreso HH:mm </b></th>
                            <th style='width:65px;text-align:center'><b> Salida HH:mm </b></th>
                            <th style='width:125px;text-align:center'><b> Observación </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoPersona">
			<tr >
                            <td  colspan="7" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
                </form>
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->

</section><!-- /.content -->