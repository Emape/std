<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"> 
	<title> EMAPE S.A.</title>
        
        <link href="<?php base_url()?>css/bloowa.css" rel="stylesheet" type="text/css" >
        <link href="<?php base_url()?>css/bootstrap.css" rel="stylesheet">
        <link href="<?php base_url()?>css/demo.css" rel="stylesheet">
        <link href="<?php base_url()?>css/login-theme-6.css" rel="stylesheet">
        <link href="<?php base_url()?>css/animate-custom.css" rel="stylesheet">
        
        <script src="<?php base_url()?>js/jquery-1.js" type="text/javascript" ></script>
        <script>
        $(document).ready(function(){
        $('#botontext').html("Iniciar Sesión");
        });
        </script>
    </head>
    <body>
	<div class="container" id="login-block">
    	<div class="row">
            <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4"> 
                <div class="login-box clearfix animated flipInY">
                    <div class="login-logo">
			<a href="#"><img width='75%' class="img-responsive" src="<?php base_url()?>images/login-logo.png" alt="Emape Logo" /></a>
                    </div> 
                    <hr />
                    <p align=center style="font-size:18px;color:#888"> Módulo GEMA</p>
                    <form id=form_login name=form_login action='#' method="post">
			<div class="login-form">
                        <input type="email" placeholder="Mi Usuario" id="usuario" name="usuario" class="input-field" /> 
			<input onkeyup="if(validateEnter(event) == true) { $('#enviar').click(); }" type="password" placeholder="Mi Contraseña" id="contrasena" name="contrasena" class="input-field" /> 
			<div id=divinfo style='display:none' class="alert alert-warning">Alerta: Ingrese su usuario.</div> 
			<div id=divinfo2 style='display:none' class="alert alert-warning">Alerta: Ingrese su contraseña.</div>
			<div id=diverror style='display:none' class="alert alert-danger"><b>Error: </b>Datos Incorrectos.</div> 	
			<input type=button  id='enviar' name='enviar' class="btn btn-login btn-reset" value="Iniciar Sesión">
			<!--<p align=center ><a  href="./recovery.php" style="text-decoration:none;cursor:pointer"> ¿Se olvidó su contraseña? </a></p>
			-->
                        </div> 
                    </form>
                </div>
            </div>
	</div>
    	</div>
     	<footer class="container">
            <p id="footer-text" style="font:15px 'Trebuchet MS'"><small>Copyright &copy; 2016 <a style="cursor:pointer" "href="http://www.emape.gob.pe/"> EMAPE S.A.</a></small></p>
     	</footer>

	<script>
	$("#enviar").click(function(){
	$('#diverror').slideUp("fast");
	$('#divinfo').slideUp("fast");
	$('#divinfo2').slideUp("fast");
	
	if($('#user').val()=='')
	{
	$('#diverror').slideUp("fast");
	$('#divinfo').slideDown("fast");
	$('#divinfo2').slideUp("fast");
	}
	else if ($('#pass').val()=='')  {
	$('#diverror').slideUp("fast");
	$('#divinfo').slideUp("fast");
	$('#divinfo2').slideDown("fast");
	}
	else{
        $.ajax({
	url:'<?php base_url()?>acceso/obtener_usuario',
	type:'POST',
	data:$('#form_login').serialize(),
	success:function(data){
        if(data!='0'){
	$('#diverror').slideUp("fast");
	$('#divinfo').slideUp("fast");
	$('#divinfo2').slideUp("fast");
	location.href="./";
	}
        else{
	$('#diverror').slideDown("fast");
	$('#divinfo').slideUp("fast");
	$('#divinfo2').slideUp("fast");
	}
	},
        error: function() { 
        alert("Error de conexión");
        }   
	});
	}
	});
	function validateEnter(e) {
	var key=e.keyCode || e.which;
	if (key==13){ return true; } else { return false; }
	}
	</script>
    </body>
</html>