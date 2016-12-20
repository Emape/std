<?php
mysql_connect("localhost", "root", "") or die("No fue posible conectar con el servidor");
mysql_select_db("db_documento") or die("No fue posible selecionar la base de datos");
set_include_path('D:\xampp\htdocs\std\library\phpmailer');
require 'PHPMailerAutoload.php';
$cabecera="<table style='border:1px #ccc solid;font-family:arial'><tr class='cabecera' style='background-color: #AEDFFB;'><th><b>N. </b></th><th><b>Actividad </b></th><th><b>Acto </b></th><th><b>Sumilla </b></th><th><b>Fecha Programada </b></th></tr>";
$pie="</table>";
session_start();

$query = mysql_query("(SELECT p.email,t.descripcion as detalle_actividad,t1.descripcion as detalle_acto,actividad.* FROM `actividad` LEFT JOIN tipo as t on t.pkTipo=actividad.actividad
LEFT JOIN tipo as t1 on t1.pkTipo=actividad.acto LEFT JOIN usuario as u on u.usuario=actividad.usuarioCreador LEFT JOIN persona as p on p.pkPersona=u.pkPersona where actividad.estado='1' and fechaProgramada='".date('Y-m-d')."' and u.estado='1' and p.estado='1') UNION (SELECT p.email,t.descripcion as detalle_actividad,t1.descripcion as detalle_acto,actividad.* FROM `actividad` LEFT JOIN tipo as t on t.pkTipo=actividad.actividad
LEFT JOIN tipo as t1 on t1.pkTipo=actividad.acto LEFT JOIN usuario as u on u.usuario=actividad.usuarioCreador LEFT JOIN persona as p on p.pkPersona=u.pkPersona where actividad.estado='1' and (fechaProgramada='".date( 'Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d'))))."' OR  fechaProgramada='".date( 'Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d'))))."') and u.estado='1' and p.estado='1') ORDER BY email");

$user_mail="";$i=1;$e=0;$cadena_msj=array();$correo=array();


while($r=mysql_fetch_array($query))
{	
	
	if($user_mail==$r['email'] or $user_mail==""){
		$correo[$e]=$r['email'];		
		$cadena_msj[$e] .= "<tr ><td style='border:1px #ccc solid'>" . $i . "</td><td style='border:1px #ccc solid'>" . $r['detalle_actividad'] . "</td><td style='border:1px #ccc solid'>" . $r['detalle_acto'] . "</td><td style='border:1px #ccc solid'>" . $r['sumilla'] . "</td><td style='border:1px #ccc solid'>" . substr($r['fechaProgramada'],8,2).'/'.substr($r['fechaProgramada'],5,2).'/'.substr($r['fechaProgramada'],0,4) . "</td></tr>";
		$i++;
				
	}
	else{
	$e++;
	$correo[$e]=$r['email'];
	$i=1;	
		$cadena_msj[$e] = "<tr ><td>" . $i . "</td><td>" . $r['detalle_actividad'] . "</td><td>" . $r['detalle_acto'] . "</td><td>" . $r['sumilla'] . "</td><td>" . $r['fechaProgramada'] . "</td></tr>";
		$i++;
	}
	$user_mail=$r['email'];
}
$m=0;

foreach ($cadena_msj as $val){
$email=$correo[$m];
$mail = new PHPMailer;
$mail->isSMTP();                                      	// Set mailer to use SMTP
$mail->Host = 'mailserver.emape.gob.pe';  				// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               	// Enable SMTP authentication
$mail->Username = 'gema@emape.gob.pe';                 	// SMTP username
$mail->Password = 'lima2016';                      		// SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    	// TCP port to connect to
$mail->From = 'gema@emape.gob.pe';
$mail->FromName = 'Administrador del Sistema';
$mail->addAddress($email);               			// Name is optional
$mail->AddBCC("desarrollo03@emape.gob.pe", "Copia");
$mail->isHTML(true);                                  	// Set email format to HTML
$mail->Subject = 'Notificación de Actividades';
$mail->Body    = "Estimado(a):<br><br>Se envia el reporte de las actividades por vencer a la fecha.<br><br>".$cabecera.$val.$pie."<br>Atte.<br><br>-----------------------------------<br>Administrador del Sistema";
$mail->AltBody = 'Correo Enviado Correctamente';
//$mail->CharSet = 'UTF-8';
$mail->send();

$m++;
}
?>