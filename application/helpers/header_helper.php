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
    <script src="./js/ckeditor.js"     type="text/javascript"></script>
    
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
        #cke_1_contents{
        height:400px !important;
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
</style>
        
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
                </ul>
                </li>
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>