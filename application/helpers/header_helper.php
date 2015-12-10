<!DOCTYPE html>
<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>EMAPE S.A.</title>
    <link rel="shortcut icon" href="./images/favicon.ico">
    
    <link href="./library/bootstrap/css/bootstrap.min.css"              rel="stylesheet" type="text/css" />
    <link href="./library/plugins/datatables/dataTables.bootstrap.css"  rel="stylesheet" type="text/css" />
    <link href="./library/dist/css/AdminLTE.min.css"                    rel="stylesheet" type="text/css" />
    <link href="./library/dist/css/skins/_all-skins.min.css"            rel="stylesheet" type="text/css" />
    <link href="./library/plugins/datepicker/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
    
    <link href="./css/font-awesome.min.css"                             rel="stylesheet" type="text/css" />
    <link href="./css/ionicons.min.css"                                 rel="stylesheet" type="text/css" />

    <script src="./js/jquery.js"                    type="text/javascript"></script>
    <script src="./js/custom_jquery.js"             type="text/javascript"></script>
    <script src="./js/jquery/jquery-1.4.1.min.js"   type="text/javascript"></script>
    <script src="./js/menu_jquery.js"               type="text/javascript"></script>
        
    <script>
    	    jQuery.noConflict();
    	    $(document).ready(function () {
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
        
    </style>
    
</head>

<body class="skin-blue" oncontextmenu='return false'>
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
                  <img src="./images/user.png" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">Roger Armijo</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="./images/user.png" class="img-circle" alt="User Image" />
                    <p>Roger Armijo<small>Código: 0050</small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="./login/Index.aspx" class="btn btn-default btn-flat"><i class="fa fa-power-off"></i> Salir</a>
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
                <li class="treeview">
                <a href="#"><span>TRÁMITE DOCUMENTARIO</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                <li><a href="./documento/index" class="ajaxmenu"><i class="fa fa-book"></i><span> Documentos</span> 
                        
                    </a>	      
		</li>
                <li><a href="#"><i class="fa fa-file-text-o"></i><span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
			            <ul class="treeview-menu" style="padding-left: 0px;">
                        <li><a id="A4" href="RepMovAlmacen.aspx" class="ajaxmenu"><i class="fa fa-random"></i> Movimientos</a></li>
                        <li><a id="A6" href="RepKardex.aspx" class="ajaxmenu"><i class="fa fa-cube"></i> Flujo</a></li>
                        </ul>	
		</li>
                </ul>
                </li>
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>