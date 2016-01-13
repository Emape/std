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
        });
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
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php base_url()?>images/user.png" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo "Bienvenido ".$_SESSION['nombre'];?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php base_url()?>images/user.png" class="img-circle" alt="User Image" />
                    <p><?php echo $_SESSION['nombre'].' '.$_SESSION['apellidoPaterno'].' '.$_SESSION['apellidoMaterno'];?><small>Código: <?php echo str_pad($_SESSION['codigo'], 6, '0', STR_PAD_LEFT);?></small>
                    </p>
                  </li>
                  <li class="user-footer">
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
                <ul class="treeview-menu">
                <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-user"></i><span> Usuarios</span>  
                </a>	      
		</li>
                </ul>    
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
                <?php } if(in_array('3',$_SESSION['cMenu'])){?>  
                <li class="treeview">
                <a href="#"><span>LEGAL</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-legal"></i><span> Expedientes</span>  
                </a>	      
		</li>
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