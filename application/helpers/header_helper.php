<!DOCTYPE html>
<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>EMAPE S.A.</title>
    <link href="<?php base_url()?>images/favicon.ico"                                   rel="shortcut icon">
    
    <link href="<?php base_url()?>library/bootstrap/css/bootstrap.min.css"              rel="stylesheet" type="text/css" />

    <link href="<?php base_url()?>library/plugins/datatables/dataTables.bootstrap.css"  rel="stylesheet" type="text/css" />
    <link href="<?php base_url()?>library/dist/css/AdminLTE.min.css"                    rel="stylesheet" type="text/css" />
    <link href="<?php base_url()?>library/dist/css/skins/_all-skins.min.css"            rel="stylesheet" type="text/css" />
    <link href="<?php base_url()?>library/plugins/datepicker/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php base_url()?>css/font-awesome.min.css"                             rel="stylesheet" type="text/css" />
    <link href="<?php base_url()?>css/ionicons.min.css"                                 rel="stylesheet" type="text/css" />
    <link href="<?php base_url()?>library/plugins/select2/select2.min.css"                                  rel="stylesheet" type="text/css" />
    
    <script src="<?php base_url()?>js/jQuery-2.1.4.min.js"                    type="text/javascript"></script>
    <script src="<?php base_url()?>js/custom_jquery.js"             type="text/javascript"></script>
    <script src="<?php base_url()?>js/jquery/jquery-1.4.1.min.js"   type="text/javascript"></script>
    <script src="<?php base_url()?>js/menu_jquery.js"               type="text/javascript"></script>
    <script src="<?php base_url()?>js/ckeditor.js"                  type="text/javascript"></script>  
    
    <script>
    	    jQuery.noConflict();
    	    $(document).ready(function(){
				$("#minim_chat_window").click();
				setInterval('validarSesion()',120000);
				//listar_chat($("#conta_chat").val());
				//setInterval('listar_ver_msj()',100000);
				
    	        $.ajaxSetup({
    	            'beforeSend': function (xhr) {
    	                xhr.overrideMimeType('text/html; charset=UTF-8');
    	            },
    	        });
    	        var ajax_load = "<div style='text-align:center;padding-top:300px'> <button class='btn btn-lg btn-primary'><span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Cargando...</button></div>";
    	        $(".ajaxmenu").on("click", function () {
    	            myUrl = $(this).attr('href');
    	            if (myUrl.match('#')) {
    	                var myAnchor = myUrl.split('#')[1];
    	                var loadUrl = myUrl.split('#')[0];
    	            } else {
    	                var loadUrl = $(this).attr('href');
    	            }

    	            $("#container-ajax").html(ajax_load).load(loadUrl, function () {
    	                if (myUrl.match('#')) {
    	                    var targetOffset = $("a[name='" + myAnchor + "']").offset().top;
    	                    $('html').animate({ scrollTop: targetOffset }, 400);
    	                }
    	            }
                    );
    	            return false;
    	        });   
				
				notificacion_legal();
				
				listar_notificacion_legal();
        });
		
        function notificacion_legal(){
			$("#notif_hoy").html(0);
			$("#notif_ayer").html(0);
				var i=0;var cant=0;
			    $.ajax({
                url  : '<?php base_url()?>Maestro/notificacion_legal',
                type : 'POST',
                success : function(result) {
					var documento = eval(result); 
					$.each(documento,function(){
					if(i==0)
					$("#notif_hoy").html(this.cantidad);
					else
					$("#notif_ayer").html(this.cantidad);
					
					cant=cant+(this.cantidad*1);
					i++;
					});   

					$(".notif_tot").html(cant);
					
					
					
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });			
		}
		
		function listar_notificacion_legal(){
				var i=1;var j=1;var html = "";var html0 = "";
			    $.ajax({
                url  : '<?php base_url()?>Maestro/listar_notificacion_legal',
                type : 'POST',
                success : function(result) {
					var documento = eval(result); 
					$.each(documento,function(){
				
					if(this.fechaProgramada=='<?php echo date("Y-m-d");?>'){
					html += "<tr >";
					html += "<td>" + i + "</td>";
					html += "<td>" + this.detalle_actividad + "</td>";
					html += "<td>" + this.detalle_acto + "</td>";
					html += "<td>" + this.sumilla + "</td>";
					html += "<td>" + this.fechaProgramada + "</td>";
					html += "</tr>";i++;
					}
					else{
					html0 += "<tr >";
					html0 += "<td>" + j + "</td>";
					html0 += "<td>" + this.detalle_actividad + "</td>";
					html0 += "<td>" + this.detalle_acto + "</td>";
					html0 += "<td>" + this.sumilla + "</td>";
					html0 += "<td>" + this.fechaProgramada + "</td>";
					html0 += "</tr>";j++;
					}
					
					});   

					$("#cuerpoN1").html(html === "" ? " <tr><td colspan='5' align=center>No se encontraron resultados</td></tr>" : html);
					$("#cuerpoN2").html(html0 === "" ? " <tr><td colspan='5' align=center>No se encontraron resultados</td></tr>" : html0);
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });			
		}
		
        //chat js
        
        $(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '#new_chat', function (e) {
    var size = $( ".chat-window:last-child" ).css("margin-left");
     size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $( "#chat_window_1" ).clone().appendTo( ".container" );
    clone.css("margin-left", size_total);
});
$(document).on('click', '.icon_close', function (e) {
    //$(this).parent().parent().parent().parent().remove();
    $( "#chat_window_1" ).remove();
});

function validarSesion(){/*
	var user="<?php echo $_SESSION['usuario']?>";
	if(user==""){
		window.location = "http://" + location.host;
	}*/
		//listar_chat($("#conta_chat").val());
			
		$.ajax({
        url : '<?php base_url()?>acceso/verificar_sesion',
        type : 'POST',
        success : function(result) {
            if(result!='1')
				location.reload();
        },
        error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
        }
        });
}
    </script>
    
    <style>
        .alert{padding:14px 35px 14px 14px;margin-bottom:20px;background-color:#fcf8e3;border-radius: 0px;}
        .alert{color:#c09853;text-align: center}
        .alerta-success {color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6;}
        .alerta-info {color: #31708f;background-color: #d9edf7;border-color: #bce8f1;}
        .alerta-warning {color: #8a6d3b;background-color: #fcf8e3;border-color: #faebcc;}
        .alerta-danger {color: #a94442;background-color: #f2dede;border-color: #ebccd1;}
        
        .fade {
        opacity: 0;
        -webkit-transition: opacity 0.15s linear;
        -moz-transition: opacity 0.15s linear;
        -o-transition: opacity 0.15s linear;
        transition: opacity 0.15s linear;
        }
                
        .glyphicon-refresh-animate {
        -animation: spin .7s infinite linear;
        -webkit-animation: spin2 .7s infinite linear;
	}
	@-webkit-keyframes spin2 {
        from { -webkit-transform: rotate(0deg);}
        to { -webkit-transform: rotate(360deg);}
	}
	@keyframes spin {
        from { transform: scale(1) rotate(0deg);}
        to { transform: scale(1) rotate(360deg);}
	}
        .cabecera{
        cursor:default;zoom:1;padding:0;
        background-image:none;
        background-color:#c5c5c5;
        background-image:-webkit-gradient(linear,50% 0%,50% 100%,color-stop(0%,#f9f9f9),color-stop(100%,#e3e4e6));
        background-image:-webkit-linear-gradient(top,#f9f9f9,#e3e4e6);
        background-image:-moz-linear-gradient(top,#f9f9f9,#e3e4e6);
        background-image:-o-linear-gradient(top,#f9f9f9,#e3e4e6);
        background-image:-ms-linear-gradient(top,#f9f9f9,#e3e4e6);
        background-image:linear-gradient(top,#f9f9f9,#e3e4e6);
        }
        tr{
        cursor:pointer;
        }
        tr.highlighted td {
        background-color: rgb(102, 153, 204);
        color:#FFFFFF; 
        }
        th{
        border:1px solid #cfcfcf !important;
        font: normal 11px tahoma, arial,verdana;
        }
        td{
        border:1px solid #cfcfcf !important;
        font: normal 11px tahoma, arial,verdana;
        color:#2E37AB;
        }
        input{
        text-transform:uppercase;
        }
        #cke_1_contents{
        height:300px !important;
        }
        #cke_2_contents{
        height:300px !important;
        }
        .tree li {
        margin: 0px 0;
	
	list-style-type: none;
        position: relative;
	padding: 20px 5px 0px 5px;
        }

        .tree li::before{
        content: '';
	position: absolute; 
        top: 0;
	width: 1px; 
        height: 100%;
	right: auto; 
        left: -20px;
	border-left: 1px solid #ccc;
        bottom: 50px;
        }
        .tree li::after{
        content: '';
	position: absolute; 
        top: 30px; 
	width: 25px; 
        height: 20px;
	right: auto; 
        left: -20px;
	border-top: 1px solid #ccc;
        }
        .tree li a{
        display: inline-block;
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
        border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
        }

        /*Remove connectors before root*/
        .tree > ul > li::before, .tree > ul > li::after{
	border: 0;
        }
        /*Remove connectors after last child*/
        .tree li:last-child::before{ 
        height: 30px;
        }

        /*Time for some hover effects*/
        /*We will apply the hover effect the the lineage of the element also*/
        .tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
        }
        /*Connector styles on hover*/
        .tree li a:hover+ul li::after, 
        .tree li a:hover+ul li::before, 
        .tree li a:hover+ul::before, 
        .tree li a:hover+ul ul::before{
	border-color:  #94a0b4;
        }
        
        tr.highlighted td {
        background-color: rgb(102, 153, 204);
        color:#FFFFFF;
        }
</style>
        
    </style>
</head>

<body class="skin-blue" oncontextmenu='return false'>
    <div id="alert-green"   style="position:fixed;z-index:1100;width:100%;display:none" data-alert="" class="alert alerta-success fade in"><i class="fa fa-check-circle"></i> <span id="texto-green"></span></div>
    <div id="alert-blue"    style="position:fixed;z-index:1100;width:100%;display:none" data-alert="" class="alert alerta-info fade in"><i class="fa fa-info-circle"></i> <span id="texto-blue"></span></div>
    <div id="alert-red"     style="position:fixed;z-index:1100;width:100%;display:none" data-alert="" class="alert alerta-danger fade in"><i class="fa fa-times-circle"></i> <span id="texto-red"></span></div>
    <div id="alert-yellow"  style="position:fixed;z-index:1100;width:100%;display:none" data-alert="" class="alert alerta-warning fade in"><i class="fa fa-warning"></i> <span id="texto-yellow"></span></div>
   
    <div class="wrapper">
      <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="./" class="logo"><b>GEMA</b> </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>       
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account Menu -->
			  <?php if(in_array('47',$_SESSION['cOperador'])){?>
			  <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><i class="notif_tot">0</i></span>
            </a>
            <ul class="dropdown-menu">
			
              <li class="header">Tu tienes <i class="notif_tot"></i> notificacion(es)</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                  
				  <li>
                    <a href="#" data-toggle="modal" data-target="#notificacionModal">
                      <i class="fa fa-warning text-red"></i> <span id="notif_hoy"></span> Pendiente(s)
                    </a>
                  </li>
                  <li>
                    <a href="#" data-toggle="modal" data-target="#notificacionModal">
                      <i class="fa fa-warning text-yellow"></i> <span id="notif_ayer"></span> Pendiente(s)
                    </a>
                  </li>
                  
                </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
              </li>
			
              <!--<li class="footer"><a href="#">View all</a></li>-->
            </ul>
			</li>
			  <?php } ?>
              <li class="dropdown user user-menu" id="square-profile">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php base_url()?>images/user.png" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
				  
                  <span class="hidden-xs"><?php  if($_SESSION['pkDependencia']=="3") echo "Bienvenido(a) ".$_SESSION['email']; else if($_SESSION['nombre']!="") echo "Bienvenido(a) ".$_SESSION['nombre']; else echo "Bienvenido(a) ".$_SESSION['razonSocial'];
				  
				  ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php base_url()?>images/user.png" class="img-circle" alt="User Image" />
                    <p><?php if($_SESSION['pkDependencia']=="3") echo "Bienvenido(a) ".$_SESSION['email']; else if($_SESSION['nombre']!="") echo $_SESSION['nombre'].' '.$_SESSION['apellidoPaterno'].' '.$_SESSION['apellidoMaterno']; else echo $_SESSION['razonSocial'];?>
					<small>Código: <?php echo str_pad($_SESSION['codigo'], 6, '0', STR_PAD_LEFT);?></small>
                    </p>
                  </li>
                  <li class="user-footer">
				  <div class="pull-left">
                      <a href="./acceso/password" class="btn btn-default btn-flat ajaxmenu"><i class="fa fa-lock"></i> Cambiar Contraseña</a>
                    </div>
                    <div class="pull-right">
                      <a href="./acceso/cerrar_sesion" class="btn btn-default btn-flat"><i class="fa fa-power-off"></i> Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
    </header>
	  
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header"></li>
                <?php if(in_array('1',$_SESSION['cMenu'])){?>
                <li class="treeview">  
                <a href="#"><span>ADMINISTRACIÓN</span> <i class="fa fa-angle-left pull-right"></i></a>
				<?php if(in_array('37',$_SESSION['cSubmenu'])){?>
                <ul class="treeview-menu">
                <li><a href="./personal/index" class="ajaxmenu"><i class="fa fa-user"></i><span> Usuarios</span>  
                </a>	      
				</li>
                </ul>  
				<?php } ?>				
                </li>
                <?php } if(in_array('2',$_SESSION['cMenu'])){?>                
                <li class="treeview">    
                <a href="#"><span>TRÁMITE DOCUMENTARIO</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <?php if(in_array('5',$_SESSION['cSubmenu'])){?>
                    <ul class="treeview-menu">  
                    <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-book"></i><span> Documentos</span>  
                    </a>	      
                    </li>
                    </ul>
                    <?php } ?>
                </li>
                <?php } if(in_array('21',$_SESSION['cMenu'])){?>                
                <li class="treeview">    
                <a href="#"><span>PERSONAL</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <?php if(in_array('22',$_SESSION['cSubmenu'])){?>
                    <ul class="treeview-menu">  
                    <li><a href="./personal/control" class="ajaxmenu"><i class="fa fa-child"></i><span> Asistencia de Locadores</span>  
                    </a>	      
                    </li>
                    </ul>
                    <?php } ?>
                </li>
                
                <?php } if(in_array('3',$_SESSION['cMenu'])){?>  
                <li class="treeview">
                <a href="#"><span>LEGAL</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
				<?php  if(in_array('26',$_SESSION['cSubmenu'])){?>
				<li><a href="./documento/expediente" class="ajaxmenu"><i class="fa fa-legal"></i><span> Expedientes</span>  
                </a>	      
				</li>
				<?php } ?>
                </ul>
                </li>
                <?php } if(in_array('4',$_SESSION['cMenu'])){?>  
                <li class="treeview">
                <a href="#"><span>ARCHIVO</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-cubes"></i><span> Inventario</span>  
                </a>	      
		</li>
                <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-hand-o-up"></i><span> Solicitud</span>  
                </a>	      
		</li>
                <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-file"></i><span> Reportes</span>  
                </a>	      
		</li>
                </ul>
                </li>
                <?php }?>  
                
            </ul><!-- /.sidebar-menu -->

        </section>
        <!-- /.sidebar -->
		
    </aside>
    
    	<div class="modal fade" id="notificacionModal" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" >
                <h1 class="modal-title" style="font-size:18px;font-weight:bold"> Notificaciones </h1>
                <span style="float:right;margin-top:-28px">
                <span data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-cerrar-organo" style="font-size:12px" >
                   <i class="fa fa-close"></i>
                </span>
                </span>
                </div>
                <div class="modal-body">
				
	<label style="color:red">Actividades Vencidas</label><br> 			
	<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body pad table-responsive">
                    <table  id="tabla_n1" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th ><b>N. </b></th>
                            <th ><b>Actividad </b></th>
                            <th ><b>Acto </b></th>
                            <th ><b>Sumilla </b></th>
                            <th ><b>Fecha Programada </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoN1">
						<tr>
                            <td  colspan="5" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
	
	<label style="color:#D69C32">Actividades por Vencer</label><br> 			
	<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body pad table-responsive">
                    <table  id="tabla_n2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="tabla_inventario_info">
                        <thead>
                        <tr  class="cabecera">
                            <th ><b>N. </b></th>
                            <th ><b>Actividad </b></th>
                            <th ><b>Acto </b></th>
                            <th ><b>Sumilla </b></th>
                            <th ><b>Fecha Programada </b></th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoN2">
						<tr>
                            <td  colspan="5" align="center">No se encontraron resultados </td>
                        </tr>	    
                        </tbody>	
                    </table>
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->
					
                </div>   
            </div>
        </div>
    </div>