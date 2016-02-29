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
        
        
         
       /* ocultar_botones();
        ocultar_botones0();


        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        
        $("#boton_imprimir").click(function(){
            doc=$('#tipo_doc').val();
            ini=$('#fecha_ini').val();
            fin=$('#fecha_fin').val();
            window.open("./documento/exportar_documento_movimiento?doc="+doc+"&ini="+ini+"&fin="+fin);	
        });
        
        $("#boton_hoja").click(function(){
            doc=$('#tipo_doc').val();
            ini=$('#fecha_ini').val();
            fin=$('#fecha_fin').val();
            nrodoc=$('#cod_documento').val();
            window.open("./documento/hoja_tramite?doc="+doc+"&ini="+ini+"&fin="+fin+"&nrodoc="+nrodoc);	
        });
        
        $("#boton_seguimiento").click(function(){
            doc=$('#tipo_doc').val();
            ini=$('#fecha_ini').val();
            fin=$('#fecha_fin').val();
            nrodoc=$('#cod_documento').val();

            $.ajax({
            url : '<?php base_url()?>Documento/arbol',
            data :'nrodoc='+nrodoc+'&doc='+doc+'&ini='+ini+'&fin='+fin,
            type : 'POST',
            success : function(result) {
                $("#arbol").html(result);
            },
            error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
            }
            });	
        });
        
        $(".btn-insertar1").click(function(){
            if($("#form_documento #tipo").val()=="0"){
                $("#texto-yellow").html("Seleccione el Tipo Documental");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #nroDocumento").val()==""){
                $("#texto-yellow").html("Ingrese el # Documento");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #fecha").val()==""){
                $("#texto-yellow").html("Seleccione la Fecha");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #entidad").val()=="0"){
                $("#texto-yellow").html("Seleccione la Entidad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #unidad").val()=="0"){
                $("#texto-yellow").html("Seleccione la Unidad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #persona").val()=="0"){
                $("#texto-yellow").html("Seleccione la Persona");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_documento #asunto").val()==""){
                $("#texto-yellow").html("Ingrese el asunto");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Documento/registrar_documento',
                data : "tipo_doc="+$('#tipo_doc').val()+"&cod_documento="+$('#cod_documento').val()+"&areaTrabajo="+CKEDITOR.instances['editor1'].getData()+ "&"+$('#form_documento').serialize(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar").click();
                    $("#texto-green").html("Se registró el documento correctamente");
                    $("#alert-green").slideDown('slow');
                    listar_documento();
                    ocultarAlerta();
                    $(".btn-limpiar1").click();
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
        
        $(".btn-insertar2").click(function(){
        $("#acciones").val($("#form_movimiento #accion").val());
            if($("#form_movimiento #unidad").val()=="0"){
                $("#texto-yellow").html("Seleccione la Unidad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #responsable").val()=="0"){
                $("#texto-yellow").html("Seleccione el Responsable");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #estado").val()=="0"){
                $("#texto-yellow").html("Seleccione el Estado");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #accion").val()==null){
                $("#texto-yellow").html("Seleccione Acciones");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #fechaVencimiento").val()==""){
                $("#texto-yellow").html("Seleccione la Fecha de Vencimiento");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#form_movimiento #asunto").val()==""){
                $("#texto-yellow").html("Ingrese el asunto");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Documento/registrar_movimiento',
                data : "cod_documento="+$('#cod_documento').val()+"&cod_movimiento="+$('#cod_movimiento').val()+"&areaTrabajo="+CKEDITOR.instances['editor2'].getData()+ "&"+$('#form_movimiento').serialize(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar").click();
                    $("#texto-green").html("Se registró el movimiento correctamente");
                    $("#alert-green").slideDown('slow');
                    listar_documento();
                    ocultarAlerta();
                    $(".btn-limpiar2").click();
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
        
        $(".btn-registrar-unidad").click(function(){
            if($("#detalle_unidad").val()==""){
                $("#texto-yellow").html("Ingrese Unidad");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_unidad',
                data : "detalle_unidad="+$('#detalle_unidad').val()+"&entidad="+$('#entidad').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-unidad").click();
                    $("#texto-green").html("Se registró la unidad correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
                    listar_dependencia();
                    $("#detalle_unidad").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
        
        $(".btn-registrar-persona").click(function(){
            if($("#detalle_paterno").val()==""){
                $("#texto-yellow").html("Ingrese Apellido Paterno");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#detalle_nombre").val()==""){
                $("#texto-yellow").html("Ingrese Nombre");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_persona',
                data : "detalle_paterno="+$('#detalle_paterno').val()+"&detalle_materno="+$('#detalle_materno').val()+"&detalle_nombre="+$('#detalle_nombre').val()+"&unidad="+$('#form_documento #unidad').val()+"&entidad="+$('#form_documento #entidad').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-persona").click();
                    $("#texto-green").html("Se registró a la persona correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
                    listar_persona();
                    $("#detalle_persona").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
        
        $(".btn-registrar-persona2").click(function(){
            if($("#detalle_paterno2").val()==""){
                $("#texto-yellow").html("Ingrese Apellido Paterno");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#detalle_nombre2").val()==""){
                $("#texto-yellow").html("Ingrese Nombre");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Maestro/registrar_persona',
                data : "detalle_paterno="+$('#detalle_paterno2').val()+"&detalle_materno="+$('#detalle_materno2').val()+"&detalle_nombre="+$('#detalle_nombre2').val()+"&unidad="+$('#form_movimiento #unidad').val()+"&entidad=1",
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $(".btn-default-cerrar-persona2").click();
                    $("#texto-green").html("Se registró a la persona correctamente");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
                    listar_persona_m();
                    $("#detalle_paterno2").val("");
                    $("#detalle_materno2").val("");
                    $("#detalle_nombre2").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
        
        $('#boton_agregar_d').click(function(){
            $('#tramite').val($('#nro_tramite').val());
            listar_dependencia_m();
            listar_estado();
            listar_accion();
        });
        
        $(".btn-limpiar1").click(function(){
        $("#form_documento #tipo").select2("val", "0" );
        $("#form_documento #entidad").select2("val", "0" );
        $("#form_documento #groupUnidad").css("display","none");
        $("#form_documento #groupPersona").css("display","none");
        $("#nroDocumento").val("");
        $("#form_documento #asunto").val("");
        
        CKEDITOR.instances.editor1.setData("");
        fecha_defecto();
        });
        
        $(".btn-limpiar2").click(function(){
        $('#prioridad > option[value="1"]').attr('selected', 'selected');   
        $("#form_movimiento #unidad").select2("val", "0" );
        $("#form_movimiento #responsable").select2("val", "0" );  
        $("#form_movimiento #estado").select2("val", "0" );  
        $("#form_movimiento #memo").val("");
        $('#form_movimiento #accion').select2("val", "" );
        $("#form_movimiento #decreto").val("");
        $("#form_movimiento #ampliacion").val("");
        $("#form_movimiento #asunto").val("");
        CKEDITOR.instances.editor2.setData("");
        calcularFecha();
        });
        
        $(".btn-eliminar1").click(function(){
            nrodoc=$('#cod_documento').val();

            $.ajax({
            url : '<?php base_url()?>Documento/anular_Documento',
            data :'nrodoc='+nrodoc,
            type : 'POST',
            success : function(result) {
                if(result=='1'){
                $(".btn-default-cerrar").click();
                $("#texto-green").html("Se eliminó el documento correctamente");
                $("#alert-green").slideDown('slow');
                listar_documento();
                ocultarAlerta();
                }
            },
            error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
            }
            });	
        });
        
        $(".btn-eliminar2").click(function(){
            nromov=$('#cod_movimiento').val();

            $.ajax({
            url : '<?php base_url()?>Documento/anular_Movimiento',
            data :'nromov='+nromov,
            type : 'POST',
            success : function(result) {
                if(result=='1'){
                $(".btn-default-cerrar").click();
                $("#texto-green").html("Se eliminó el movimiento correctamente");
                $("#alert-green").slideDown('slow');
                detalle_documento($("#cod_documento").val(),$("#nro_tramite").val());
                ocultarAlerta();
                }
            },
            error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
            }
            });	
        });
        */
    });
    
    /*$(document).on('change', '.btn-file :file', function() {
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
        
        theTable = $("#tabla_documento");
        $("#search").keyup(function () {
        $.uiTableFilter(theTable, this.value);
        });
    });
    
    $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');  
        if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
        if($("#tipo_doc").val()=='2'){
            $("#tipo_doc").val('1');
            $("#area_trabajo").css("display","block");
            $(".bloqueExterno").css("display","none");
            $(".bloqueInterno").css("display","inline-block");
        }
        else{
            $("#tipo_doc").val('2');
            $("#area_trabajo").css("display","none");
            $(".bloqueExterno").css("display","inline-block");
            $(".bloqueInterno").css("display","none");
        }
        }
        $(this).find('.btn').toggleClass('btn-default'); 
        $("#cuerpoMovimiento").html("<tr><td colspan='6' align=center>No se encontraron resultados</td></tr>");
	
        ocultar_botones();
        ocultar_botones0();
        ocultar_botones_d();
        listar_documento();
        listar_tipo();
    });
    
    function listar_documento(){
        ocultar_botones();
        ocultar_botones0();
        ocultar_botones_d();
        $("#nro_tramite").val("");
        $("#cuerpoMovimiento").html("<tr><td colspan='6' align=center>No se encontraron resultados</td></tr>");
	
        var fecha_ini=$("#fecha_ini").val();
        var fecha_fin=$("#fecha_fin").val();
        var tipo_doc=$("#tipo_doc").val();
        
        if(fecha_fin < fecha_ini){
            $("#texto-yellow").html("La fecha fin debe ser mayor o igual que la fecha inicio");
            $("#alert-yellow").slideDown('slow');
            ocultarAlerta();
            fecha_defecto();
        }
        else{
        $("#cuerpoDocumento").fadeIn(1000).html("<tr><td colspan='8' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
        $.ajax({
	url : '<?php base_url()?>Documento/listar_documento',
	data :'fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&tipo_doc='+tipo_doc,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            var html = "";
            $.each(documento, function () {
            html += "<tr id='fila" + this.pkDocumento + "' onclick=detalle_documento('" + this.pkDocumento +"','"+ this.nroTramite + "') >";
            html += "<td>" + this.nroTramite + "</td>";
            html += "<td>" + this.fechaDocumento + "</td>";
            html += "<td>" + this.tipo + "</td>";
            html += "<td>" + this.nroDocumento + "</td>";
            html += "<td>" + this.dependencia + "</td>";
            html += "<td>" + this.asunto + "</td>";
            html += "<td>" + this.usuarioCreador + "</td>";
            html += "<td>" + this.situacion + "</td>";
            html += "</tr>";
            });
            $("#cuerpoDocumento").html(html === "" ? " <tr><td colspan='8' align=center>No se encontraron resultados</td></tr>" : html);
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
        }
    }
     
    function listar_estado(){
    var exists=0;
        $('#estado').empty();
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_tipo',
	data :'grupo=4',
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            
            $('#estado').append($('<option>', { value: "0",text : "Seleccionar" })); 
            
            $.each(documento, function () {
            $('#estado').append($('<option>', { value: this.pkTipo,text : this.descripcion }));  
            });
          
            
            if($("#cod_movimiento").val()!=""){
            $('#estado option').each(function(){
            if (this.value == $("#estadok").val()) {
                exists = 1;}
            });
            
            if(exists=='0')
            $("#estado").select2("val", "0" );
            else
            $("#estado").select2("val", $("#estadok").val());
            
            }
            else
            $("#estado").select2("val", "0" );
            
            
            
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
  
    function listar_empresa(){
        $('#entidad').empty();
        
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_empresa',
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            
            $('#entidad').append($('<option>', { value: "0",text : "Seleccionar" })); 
            
            $.each(documento, function () {
            $('#entidad').append($('<option>', { value: this.pkEmpresa,text : this.razonSocial }));  
            });
            $("#entidad").select2("val", "0" );
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function listar_dependencia(){
        if($("#form_documento entidad").val()=='0') $("#agregar_unidad").css("display","none");
        else $("#agregar_unidad").css("display","inline-block");
        $("#cod_entidad").val($("#entidad option:selected").text());
        
        var entidad=$("#entidad").val();
        $("#groupUnidad").css("display","none");
        $("#groupPersona").css("display","none");
        $('#unidad').empty();
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_dependencia',
	data :'empresa='+entidad,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
        var exists = 0;    
            $('#unidad').append($('<option>', { value: "0",text : "Seleccionar" })); 
            
            $.each(documento, function () {
            $('#unidad').append($('<option>', { value: this.pkDependencia,text : this.descripcion }));  
            });
            
            if($("#cod_documento").val()!=""){
            $('#unidad option').each(function(){
            if (this.value == $("#dependenciak").val()) {
                exists = 1;}
            });
            
            if(exists=='0')
            $("#unidad").select2("val", "0" );
            else
            $("#unidad").select2("val", $("#dependenciak").val());
            
            }
            else
            $("#unidad").select2("val", "0" );

            $("#groupUnidad").css("display","block");
                
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function listar_dependencia_m(){
        var exists=0;
        $('#form_movimiento #unidad').empty();
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_dependencia',
	data :'empresa=1',
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
        //var exists = 0;    
            $('#form_movimiento #unidad').append($('<option>', { value: "0",text : "Seleccionar" })); 
            
            $.each(documento, function () {
            $('#form_movimiento #unidad').append($('<option>', { value: this.pkDependencia,text : this.descripcion }));  
            });
            
            if($("#cod_movimiento").val()!=""){
            $('#form_movimiento #unidad option').each(function(){
            if (this.value == $("#mdependenciak").val()) {
                exists = 1;}
            });
            
            if(exists=='0')
            $("#form_movimiento #unidad").select2("val", "0" );
            else
            $("#form_movimiento #unidad").select2("val", $("#mdependenciak").val());
            }
            else
           $("#form_movimiento #unidad").select2("val", "0" );              
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function listar_persona_m(){
        if($("#form_movimiento #unidad").val()=='0') $("#agregar_persona2").css("display","none");
        else $("#agregar_persona2").css("display","inline-block");
        $("#cod_unidad2").val($("#form_movimiento #unidad option:selected").text());
    
        var exists='0';
        $('#form_movimiento #responsable').empty();
        var unidad=$("#form_movimiento #unidad").val();
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_persona',
	data :'dependencia='+unidad,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
        //var exists = 0;  
                  
            $('#form_movimiento #responsable').append($('<option>', { value: "0",text : "Seleccionar" })); 
            $.each(documento, function () {
            
            if(this.apellidoPaterno!='')
            $('#form_movimiento #responsable').append($('<option>', { value: this.pkPersona,text : this.apellidoPaterno+' '+this.apellidoMaterno+' '+this.nombre }));  
            else
            $('#form_movimiento #responsable').append($('<option>', { value: this.pkPersona,text : this.razonSocial }));  
     
            });
            
            if($("#form_movimiento #responsable").val()!=""){
            $('#form_movimiento #responsable option').each(function(){
            if (this.value == $("#mpersonak").val()) {
                exists = 1;}
            });
            
            if(exists=='0')
            $("#form_movimiento #responsable").select2("val", "0" );
            else
            $("#form_movimiento #responsable").select2("val", $("#mpersonak").val());
            }
            else
            $("#form_movimiento #responsable").select2("val", "0" );
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function listar_persona(){
        if($("#unidad").val()=='0') $("#agregar_persona").css("display","none");
        else $("#agregar_persona").css("display","inline-block");
        $("#cod_unidad").val($("#unidad option:selected").text());
        
        var unidad=$("#unidad").val();
        $('#persona').html('');
        $("#groupPersona").css("display","none");
        $.ajax({
	url : '<?php base_url()?>Maestro/listar_persona',
	data :'dependencia='+unidad,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
        var exists = 0;  
                  
            $('#persona').append($('<option>', { value: "0",text : "Seleccionar" })); 
            $("#persona").select2("val", "0");
            $.each(documento, function () {
            
            if(this.apellidoPaterno!='')
            $('#persona').append($('<option>', { value: this.pkPersona,text : this.apellidoPaterno+' '+this.apellidoMaterno+' '+this.nombre }));  
            else
            $('#persona').append($('<option>', { value: this.pkPersona,text : this.razonSocial }));  
     
            
            });
            
            if($("#cod_documento").val()!=""){
            $('#persona option').each(function(){
            if (this.value == $("#personak").val()) {
                exists = 1;}
            });
            
            if(exists=='0')
            $("#persona").select2("val", "0" );
            else
            $("#persona").select2("val", $("#personak").val());
            
            }
            else
            $("#persona").select2("val", "0" );
        
            $("#groupPersona").css("display","block");
            
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
    
    function detalle_documento(cod,tramite) {
        $('#tabla_documento tr').removeClass('highlighted');
        $("#fila" + cod).addClass('highlighted');
        $("#cod_documento").val(cod);
        $("#nro_tramite").val(tramite);
        $("#boton_agregar_d").css("display","inline-block");
        $(".label_tramite").html(tramite);
        
        mostrar_botones();
        mostrar_botones0();
        ocultar_botones_d();
        $("#boton_agregar_d").show();
        $("#cuerpoMovimiento").fadeIn(1000).html("<tr><td colspan='5' align='center'><img src='<?php base_url();?>images/loader.gif' ></td></tr>");
        $.ajax({
	url : '<?php base_url()?>Documento/listar_movimiento',
	data :'cod='+cod,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            var html = "";
            var i=1;
            $.each(documento, function () {
            html += "<tr id='filad" + this.pkMovimiento + "' onclick=detalle_movimiento('" + this.pkMovimiento +"','"+ i + "','" + this.acciones +"') >";
            html += "<td>" + i + "</td>";
            html += "<td>" + this.dependencia + "</td>";
            html += "<td>" + this.gerente + "</td>";
            html += "<td>" + this.fechaCreada + "</td>";
            html += "<td>" + this.fechaVencimiento + "</td>";
            html += "<td>" + this.tipo + "</td>";
            html += "</tr>";
            i++;
            });
            $("#cuerpoMovimiento").html(html === "" ? " <tr><td colspan='6' align=center>No se encontraron resultados</td></tr>" : html);
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });

    }  
    
    function obtener_documento(){
    $('#textAccion').html('Modificar');
    $('.btn-limpiar1').css("display","none");
    
    var fecha_ini=$("#fecha_ini").val();
    var fecha_fin=$("#fecha_fin").val();
    var tipo_doc=$("#tipo_doc").val();
    var nrodoc=$("#cod_documento").val();
        
        $.ajax({
	url : '<?php base_url()?>Documento/obtener_documento',
	data :'fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&tipo_doc='+tipo_doc+'&nrodoc='+nrodoc,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            $.each(documento, function () {
            $("#dependenciak").val( this.pkDependencia );
            $("#personak").val( this.pkPersona );
            $("#form_documento #asunto").val(this.asunto);
            $("#form_documento #nroDocumento").val(this.nroDocumento);
            $("#form_documento #fecha").val(this.fechaDocumento.substring(8,10)+'/'+this.fechaDocumento.substring(5,7)+'/'+this.fechaDocumento.substring(0,4));
            $("#form_documento #tipo").select2("val", this.pkTipo );
            $("#form_documento #entidad").select2("val", this.pkEmpresa );
            //$("#form_documento #unidad").select2("val", this.pkDependencia );
            //$("#form_documento #persona").select2("val", this.pkPersona );

            CKEDITOR.instances.editor1.setData(this.areaTrabajo);
            
            
            });       
        },
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function obtener_movimiento(){
    //listar_persona_m();
    listar_dependencia_m();
    listar_estado();
    
    $('#textAccion2').html('Modificar');
    $('.btn-limpiar2').css("display","none");
    $("#tramite").val($("#nro_tramite").val());
    var nromov=$("#cod_movimiento").val();
    var nrodoc=$("#cod_documento").val();
        
        $.ajax({
	url : '<?php base_url()?>Documento/obtener_movimiento',
	data :'cod_movimiento='+nromov+'&cod_documento='+nrodoc,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            $.each(documento, function () {
            $("#estadok").val(this.situacion);
            
            //$("#accionesk").val(this.acciones);
            $("#mdependenciak").val(this.pkDependencia);
            $("#mpersonak").val(this.pkPersona);
            $("#form_movimiento #accion").select2({tags:true});
            $('#form_movimiento #prioridad > option[value="'+this.prioridad+'"]').attr('selected', 'selected'); 
            
            $("#form_movimiento #estado").select2("val", this.situacion );
            $("#form_movimiento #unidad").select2("val", this.pkDependencia );
            $("#form_movimiento #responsable").select2("val", this.pkDependencia );
           
            $("#form_movimiento #fecha_vencimiento").val(this.fechaVencimiento.substring(8,10)+'/'+this.fechaVencimiento.substring(5,7)+'/'+this.fechaVencimiento.substring(0,4));
            $("#form_movimiento #memo").val(this.nroMemo);
            $("#form_movimiento #ampliacion").val(this.ampliacion);
            $("#form_movimiento #decreto").val(this.decreto);
            $("#form_movimiento #asunto").val(this.asunto);
            CKEDITOR.instances.editor2.setData(this.areaTrabajo);
            
            });   
            
    
    
        },
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    }
    
    function detalle_movimiento(pkMovimiento,i,acciones) {
        
        $("#accionesk").val(acciones);
        listar_accion();
        
        
        $('#tabla_movimiento tr').removeClass('highlighted');
        $("#filad" + pkMovimiento).addClass('highlighted');
        $("#cod_movimiento").val(pkMovimiento);
        $("#label_tramite_d").html(i);
        mostrar_botones_d();
    }
    
    function ocultar_botones(){
        $("#boton_editar").hide();
        $("#boton_anular").hide();
        $("#boton_descargar").hide();
        $("#boton_hoja").hide();
        $("#boton_seguimiento").hide();
        $("#boton_agregar_d").hide();
    }
    function ocultar_botones0(){
        $("#boton_editar0").hide();
        $("#boton_anular0").hide();
        $("#boton_descargar0").hide();
        $("#boton_hoja0").hide();
        $("#boton_seguimiento0").hide();
        $("#boton_agregar_d").hide();
    }
    
    function mostrar_botones(){
        $("#boton_editar").show();
        $("#boton_anular").show();
        $("#boton_descargar").show();
        if($("#tipo_doc").val()=='2')$("#boton_hoja").show();
        $("#boton_seguimiento").show();
        $("#boton_agregar_d").hide();
    }
    
    function mostrar_botones0(){
        $("#boton_editar0").show();
        $("#boton_anular0").show();
        $("#boton_descargar0").show();
        $("#boton_seguimiento0").show();
        $("#boton_agregar_d").hide();
    }
    
    function ocultar_botones_d(){
        $("#boton_editar_d").hide();
        $("#boton_anular_d").hide();
        $("#boton_descargar_d").hide();
    }
    
    function mostrar_botones_d(){
        $("#boton_editar_d").show();
        $("#boton_anular_d").show();
        $("#boton_descargar_d").show();
       
    }
*/
   
    function listar_categoria(grupo){
        $.ajax({
	url : '<?php base_url()?>Legal/listar_categoria',
	data :'grupo='+grupo,
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            $.each(documento, function () {
                if(grupo=='1')
                $('#distrito').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
                else if(grupo=='2')
                $('#organo').append($('<option>', { value: this.pkCategoria,text : this.descripcion }));  
                else if(grupo=='3')
                $('#especialidad').append($('<option>', { value: this.pkCategoria,text : this.descripcion }));  
                else if(grupo=='4')
                $('#sede').append($('<option>', { value: this.pkCategoria,text : this.descripcion }));  
                else if(grupo=='5')
                $('#sala').append($('<option>', { value: this.pkCategoria,text : this.descripcion })); 
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
                <select name="anio" id="anio"  class="form-control">
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
                <?php if(in_array('8',$_SESSION['cOperador'])){?>  
                <span id="boton_agregar" class="btn btn-primary" title="Agregar"   style="font-size:12px;" data-toggle="modal" data-target="#registrarDocumentoModal" onclick="$('#cod_documento').val('');$('#nro_tramite').val('');$('#textAccion').html('Registrar');$('#tabla_documento tr').removeClass('highlighted');ocultar_botones();$('.btn-limpiar1').css('display','inline-block');$('#boton_agregar_d').css('display','none');$('.btn-limpiar1').click();$('.btn-limpiar2').click();$('#cuerpoMovimiento').html('<tr><td colspan=6 align=center>No se encontraron resultados</td></tr>');">
                    <i  class="fa fa-plus" ></i> 
                </span>
                <?php } if(in_array('9',$_SESSION['cOperador'])){?>  
                <span id="boton_editar" class="btn btn-primary" title="Modificar" style="font-size:12px" data-toggle="modal" data-target="#registrarDocumentoModal" onclick="obtener_documento();" >
                    <i  class="fa fa-pencil" ></i> 
                </span>
                <?php } if(in_array('10',$_SESSION['cOperador'])){?>  
                <span id="boton_anular" class="btn btn-primary" title="Anular"    id="anular"  style="font-size:12px" data-toggle="modal" data-target="#eliminarDocumentoModal" >
                    <i  class="fa fa-minus-circle" ></i> 
                </span>
                <?php } if(in_array('11',$_SESSION['cOperador'])){?>  
                <span id="boton_imprimir" class="btn btn-primary" title="Imprimir"  id="imprimir" style="font-size:12px" >
                    <i class="fa fa-print" ></i> 
                </span>
                <?php } if(in_array('12',$_SESSION['cOperador'])){?>  
                <a href="#" target="_blank">
                <span id="boton_descargar" class="btn btn-primary" title="Descargar" id="imprimir" style="font-size:12px" >
                    <i class="fa fa-download" ></i> 
                </span></a>
                <?php } if(in_array('13',$_SESSION['cOperador'])){?>  
                <span id="boton_hoja" class="btn btn-primary" title="Hoja de Tramite" id="hoja" style="font-size:12px" >
                    <i class="fa fa-file-text-o" ></i> 
                </span>
                <?php } if(in_array('14',$_SESSION['cOperador'])){?>  
                <span id="boton_seguimiento" class="btn btn-primary" title="Seguimiento"    id="seguimiento"  style="font-size:12px" data-toggle="modal" data-target="#arbolModal" >
                    <i  class="fa fa-sitemap" ></i> 
                </span>
                <?php } ?>  
                
                <span id="boton_seguimiento" class="btn btn-primary" title="Seguimiento"    id="seguimiento"  style="font-size:12px" data-toggle="modal" data-target="#arbolModal" >
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
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Distrito Judicial</label>
                                <div class='form-group'>
                                <select name="distrito" id="distrito"  class="form-control" >
                                <option value=""> Seleccionar </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Organo Juris.</label>
                                <div class='form-group'>
                                <select name="organo" id="organo"  class="form-control" >
                                <option value=""> Seleccionar </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Especialidad</label>
                                <div class='form-group'>
                                <select name="especialidad" id="especialidad"  class="form-control" >
                                <option value=""> Seleccionar </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Sede</label>
                                <div class='form-group'>
                                <select name="sede" id="sede"  class="form-control" >
                                <option value=""> Seleccionar </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Sala/Juzgado</label>
                                <div class='form-group'>
                                <select name="sala" id="sala"  class="form-control" >
                                <option value=""> Seleccionar </option>
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>N° Expediente</label>
                                <div class='form-group'>
                                <input type='text' name="search" id="search"  class="form-control" />
                                </div>
                            </div>
                        </div>
                      <!--  <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="dataTables_length">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                           
                            <div class="dataTables_length">
                                <span class="btn btn-primary" title="Buscar" id="imprimir" style="font-size:12px;margin-top:22px" onclick="listar_documento()">
                                <i class="fa fa-search" ></i> 
                                </span>
                            </div>
                        </div>
			-->
                    </div>	
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:680px" >
                    <table  id="tabla_documento" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th ><b>N. </b></th>
                            <th ><b>Código </b></th>
                            <th ><b>Expediente </b></th>
                            <th ><b>Involucrados </b></th>
                            <th ><b>Fecha </b></th>
                            <th ><b>Resumen </b></th>
		            <th ><b>Usuario </b></th>
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

    <div class="modal fade" id="eliminarDocumentoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar Documento</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea Eliminar Documento N°  <span class="label_tramite"></span> ?</p>
                    <p class="debug-url"></p>
                </div>
                <div class="modal-footer">
                    <button id="cerrar" type="button" class="btn btn-default btn-default-cerrar" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-eliminar1">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    
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
    <div class="modal fade" id="registrarDocumentoModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion"></span> Expediente</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" title="Guardar" class="btn btn-primary btn-insertar1" style="font-size:12px" >
                   <i class="fa fa-save"></i>
                </span>
                <span id="guardar" title="Limpiar" class="btn btn-success btn-limpiar1" style="font-size:12px" >
                   <i class="fa fa-paint-brush"></i>
                </span>
                <span data-dismiss="modal" title="Cerrar" aria-label="Close" class="btn btn-default btn-default-cerrar" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Tipo Documental</label>                             
                                <select class="form-control select2" style="width: 100%;" name="tipo" id="tipo">
                                </select>
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label># Documento</label>  
                                <input type='text' name="nroDocumento" id="nroDocumento"  class="form-control" />
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type='text' name="fecha" id="fecha"  class="form-control" readonly style="background-color: #eee" />
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Entidad</label>
                                <select onchange="listar_dependencia()" class="form-control select2" style="width: 100%;" name="entidad" id="entidad">
                                </select>
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" id="groupUnidad" style="display:none" >
                            <div class="form-group">
                                <label>Unidad</label>  <span data-toggle="modal" data-target="#registrarUnidadModal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;display:none" id="agregar_unidad" title="Agregar Unidad" class="btn btn-danger btn-insertar-unidad" style="font-size:12px">
                                                        <i class="fa fa-plus"></i>
                                                        </span>
                                <select onchange="listar_persona()" class="form-control select2" style="width: 100%;" name="unidad" id="unidad">
                                </select>
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" id="groupPersona" style="display:none">
                            <div class="form-group">
                                <label>Persona</label>  <span data-toggle="modal" data-target="#registrarPersonaModal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;display:none" id="agregar_persona" title="Agregar Persona" class="btn btn-danger btn-insertar-persona" style="font-size:12px">
                                                        <i class="fa fa-plus"></i>
                                                        </span>
                                <select  class="form-control select2" style="width: 100%;" name="persona" id="persona">
                                </select>
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
                                <input type="file" multiple name="archivo" id="archivo">
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
                                <textarea name="asunto" id="asunto"  class="form-control" style="resize: none;height:100px" />
                                
                                </textarea>
                            </div>
                        </div>
                    </div>                  
                    <div class="row" id="area_trabajo" name="area_trabajo" style="display:none">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group" >
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
    </form>
    <form id="form_movimiento">
    <div class="modal fade" id="registrarDecretoModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Decreto</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-insertar2" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span id="guardar" title="Limpiar" class="btn btn-success btn-limpiar2" style="font-size:12px" >
                   <i class="fa fa-paint-brush"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label># Trámite</label>  
                                <input type='text' name="tramite" id="tramite"  class="form-control"  disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4">
                            <div class="form-group">
                                <label>Unidad</label><br>
                                <select onchange="listar_persona_m()" name="unidad" id="unidad" class="form-control select2">
                                </select>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Responsable</label> <span data-toggle="modal" data-target="#registrarPersona2Modal" style="font-size: 8px;padding-left: 3px;padding-right: 3px;padding-top: 2px;padding-bottom: 2px;display:none" id="agregar_persona2" title="Agregar Persona" class="btn btn-danger btn-insertar-persona2" style="font-size:12px">
                                                        <i class="fa fa-plus"></i>
                                                        </span>
                                <select name="responsable" id="responsable" class="form-control select2">
                                </select>   
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Estado</label><br>
                                <select name="estado" id="estado" class="form-control select2" >
                                </select>   
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label># Memo</label>
                                <input type='text' name="memo" id="memo"  class="form-control" />
                            </div>
                        </div>
                    </div>	
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4" >
                            <div class="form-group">
                                <label>Acciones</label><br>
                                <select name="accion" id="accion" class="form-control select2" multiple style="height:90px" >
                                <input type="hidden" id="acciones" name="acciones">
                                </select>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-4" >
                            <div class="form-group">
                                <label>Prioridad</label>
                                <select onchange="calcularFecha()" name="prioridad" id="prioridad" class="form-control"   >
                                    <option value="1">Baja</option>
                                    <option value="2">Media</option>
                                    <option value="3">Alta</option>                                    
                                </select>   
                            </div>
                            
                            <div class="form-group">
                                <label>Fecha Vencimiento</label>
                                <input type='text' name="fecha_vencimiento" id="fecha_vencimiento"  class="form-control" />
                            </div>
                        </div>
			<div class="col-xs-12 col-sm-6 col-md-2 col-lg-4">
                            <div class="form-group">
                                <label>Decreto</label>
                                <input type='text' name="decreto" id="decreto"  class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Ampliación</label>
                                <input type='text' name="ampliacion" id="ampliacion"  class="form-control" />
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
                                <textarea name="asunto" id="asunto"  class="form-control" style="resize: none;" />
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
    </form>
    
    <div class="modal fade" id="registrarUnidadModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Registrar Unidad</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-unidad" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-unidad" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Entidad</label>  
                                <input type='text' name="cod_entidad" id="cod_entidad"  class="form-control"  disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Unidad</label><br>
                                <input type="text" name="detalle_unidad" id="detalle_unidad" class="form-control">  
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
    
        <div class="modal fade" id="registrarPersonaModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Registrar Persona</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-persona" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-persona" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Unidad</label>  
                                <input type='text' name="cod_entidad" id="cod_unidad"  class="form-control"  disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Apellido Paterno</label><br>
                                <input type="text" name="detalle_paterno" id="detalle_paterno" class="form-control">  
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Apellido Materno</label><br>
                                <input type="text" name="detalle_materno" id="detalle_materno" class="form-control">  
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Apellido Paterno</label><br>
                                <input type="text" name="detalle_nombre" id="detalle_nombre" class="form-control">  
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="registrarPersona2Modal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"><span id="textAccion2"></span> Registrar Responsable</h1>
                <span style="float:right;margin-top:-28px">
                <span id="guardar" class="btn btn-primary btn-registrar-persona2" style="font-size:12px"  >
                   <i class="fa fa-save"></i>
                </span>
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-persona2" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Unidad</label>  
                                <input type='text' name="cod_entidad2" id="cod_unidad2"  class="form-control"  disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Apellido Paterno</label><br>
                                <input type="text" name="detalle_paterno2" id="detalle_paterno2" class="form-control">  
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Apellido Materno</label><br>
                                <input type="text" name="detalle_materno2" id="detalle_materno2" class="form-control">  
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Apellido Paterno</label><br>
                                <input type="text" name="detalle_nombre2" id="detalle_nombre2" class="form-control">  
                            </div>
                        </div>
                    </div>	
                </div>   
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="arbolModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold">Seguimiento del Documento</h1>
                <span style="float:right;margin-top:-28px">
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">  
                                <label> # Trámite: <span class="label_tramite"></span> </label>
                                <div class="tree">
                                    <ul>
                                    <li>
                                    <a href="#">Inicio</a>
                                    
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
    
    
    
</section><!-- /.content -->
<script>  $(function () {$(".select2").select2({
    placeholder:"Seleccionar"
});}); </script>