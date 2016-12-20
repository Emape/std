<script>
$(document).ready(function(){
//listar_usuarios_chat();	

$("#input_chat").keyup(function(event){
    if(event.keyCode == 13){
        $("#btn-chat").click();
		modificar_visto();
    }
});

$("#input_chat").focus(function(){
		modificar_visto();
});

$(".return_chat").click(function(){

	document.title = " EMAPE S.A. "
	
	$("#contenedor_1").show();
	$("#contenedor_2").hide();
	
	$("#titulo_chat_1").show();
	$("#titulo_chat_2").hide();
	
	$(".panel-footer").hide();

});
});

function profile_chat(conta,pkUsuario){
	
	//document.title = " Nuevo Mensaje (1) - EMAPE S.A. "
	
	$("#chat_pk_destino").val(pkUsuario);
	
	$("#contenedor_1").hide();
	$("#contenedor_2").show();
	
	$("#titulo_chat_1").hide();
	$("#titulo_chat_2").show();
	
	$(".panel-footer").show();
	
	$("#label_name").html($("#chat_name"+conta).val().substring(0,13)+'...');
	modificar_visto();
	$("#conta_chat").val(conta);
	//listar_chat(conta);
	
	$(".msg_container_base").animate({ scrollTop: $('.msg_container_base').prop("scrollHeight")}, 1000);
}

function listar_usuarios_chat(){
        $("#cuerpoUsuario").fadeIn(1000).html("<span><img src='<?php base_url();?>images/loader.gif' ></span>");
        $.ajax({
	url : '<?php base_url()?>Acceso/listar_usuario_chat',
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            var html = "";
			var conta=1;
            $.each(documento, function () {
				if('<?php echo $_SESSION['usuario'];?>'!=this.usuario){
            html += "<div class='row msg_container base_receive ' onclick='profile_chat("+conta+","+this.pkUsuario+")' style='cursor:pointer'><div class='col-md-2 colchat col-xs-2 avatar'><img src='images/avatar.png' class='img-responsive img-circle'><span style='left:30px;top:23px;position:absolute;display:none' class='msj_pendiente' id='msj_pendiente"+this.pkUsuario+"' ><img src='images/audio-speaker-on.png' width='15px'></span></div><div class='col-xs-10 colchat col-md-10'><div class='messages msg_receive'>";
            html += "<p><input type='hidden' name='chat_name' id='chat_name"+conta+"' value='"+this.razonSocial+"' >" + this.razonSocial.substring(0,25) + "</p>";
            html += "</div></div></div>";

			}
			conta++;  
            });
                            
            $("#cuerpoUsuario").html(html === "" ? " <span>No se encontraron resultados</span>" : html);
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    
}



function listar_chat(conta){
        $.ajax({
	url : '<?php base_url()?>Acceso/listar_chat',
	data :'destino='+$("#chat_pk_destino").val(),
	type : 'POST',
	success : function(result) {
	var documento = eval(result); 
            var html = "";
			var todo = "";
            $.each(documento, function () {
			todo=$("#todo_chat").val();
			if('<?php echo $_SESSION['codigo'];?>'==this.pkUsuario){
			html +="<div class='row msg_container base_sent'><div class='col-xs-10 colchat col-md-10'><div class='messages msg_sent' style='background-color:#D8E8F2'>";
            html +="<p>"+this.detalle+"</p>";
            html +="<time> Yo • "+this.fechaCreada+"</time>";
            html +="</div></div><div class='col-md-2 colchat col-xs-2 avatar'><img src='images/avatar.png' class='img-responsive img-circle'></div></div>";
			}else{
			html +="<div class='row msg_container base_receive' ><div class='col-md-2 colchat col-xs-2 avatar'><img src='images/avatar.png' class='img-responsive img-circle'></div><div class='col-xs-10 colchat col-md-10' ><div class='messages msg_receive' >";
            html +="<p>"+this.detalle+"</p>";
            html +="<time>"+$("#chat_name"+conta).val().substring(0,13)+" • "+this.fechaCreada+"</time>";
            html +="</div></div></div>";
			}
            });
			
            $("#todo_chat").val(html);                
            $("#cuerpoChat").html(html === "" ? " <br><span>No hay conversaciones.</span>" : html);
			
			if(todo!=html){
				$(".msg_container_base").animate({ scrollTop: $('.msg_container_base').prop("scrollHeight")}, 1000);
				if(todo!=""){
				document.title = " Nuevo Mensaje (1) - EMAPE S.A. "
				}
			}
			
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    
}

function listar_ver_msj(){
        $.ajax({
	url : '<?php base_url()?>Acceso/listar_ver_msj',
	type : 'POST',
	success : function(result) {
	document.title = "EMAPE S.A."
	$(".msj_pendiente").hide();
	var documento = eval(result); 
            $.each(documento, function () {
            $("#msj_pendiente"+this.pkUsuario).show();
			if('<?php echo $_SESSION['codigo'];?>'!=this.pkUsuario){
			document.title = " Nuevo Mensaje (1) - EMAPE S.A. ";
			}
            });
			
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    
}

function modificar_visto(){
        $.ajax({
	url : '<?php base_url()?>Acceso/modificar_visto',
	data :'destino='+$("#chat_pk_destino").val(),
	type : 'POST',
	success : function(result) {
	document.title = "EMAPE S.A."
	if(result!='1')
		alert("No se modifico");	
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    
}

function registrar_chat(){
	if($("#input_chat").val()!=""){
        $.ajax({
	url : '<?php base_url()?>Acceso/registrar_chat',
	data :'detalle='+$("#input_chat").val()+'&destino='+$("#chat_pk_destino").val(),
	type : 'POST',
	success : function(result) {
		if(result!='1'){
			alert('No se pudo enviar conversación');
		}           
	},
	error : function(request, xhr, status) {
            alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
	},
        });
    $("#input_chat").val("");
	$(".msg_container_base").animate({ scrollTop: $('.msg_container_base').prop("scrollHeight")}, 1000);
	}
}
</script>
<style>    
.colchat, .colchat{
    padding:0;
}
.panel{
    margin-bottom: 0px;
}
.chat-window{
    bottom:0;
    position:fixed;
    float:right;
    margin-left:10px;
    right: 0;
}
.chat-window > div > .panel{
    border-radius: 5px 5px 0 0;
}
.icon_minim{
    padding:2px 10px;
}
.msg_container_base{
  background: #e5e5e5;
  margin: 0;
  padding: 0 10px 10px;
  max-height:300px;
  overflow-x:hidden;
}
.top-bar {
  background: #666;
  color: white;
  padding: 10px;
  position: relative;
  overflow: hidden;
}
.msg_receive{
    padding-left:0;
    margin-left:0;
}
.msg_sent{
    padding-bottom:20px !important;
    margin-right:0;
}
.messages {
  background: white;
  padding: 10px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  max-width:100%;
}
.messages > p {
    font-size: 13px;
    margin: 0 0 0.2rem 0;
  }
.messages > time {
    font-size: 11px;
    color: #ccc;
}
.msg_container {
    padding: 4px;
	padding-left: 10px;
	padding-right: 15px;
    overflow: hidden;
    display: flex;
}

.avatar {
    position: relative;
}
.base_receive > .avatar:after {
    //content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border: 5px solid #FFF;
    border-left-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
}

.base_sent {
  justify-content: flex-end;
  align-items: flex-end;
}
.base_sent > .avatar:after {
    //content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 0;
    border: 5px solid white;
    border-right-color: transparent;
    border-top-color: transparent;
    box-shadow: 1px 1px 2px rgba(black, 0.2); // not quite perfect but close
}

.msg_sent > time{
    float: right;
}



.msg_container_base::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

.btn-group.dropup{
    position:fixed;
    left:0px;
    bottom:0;
}
</style>
<div class="content-wrapper"><input type='hidden' name='chat_pk_destino' id='chat_pk_destino'  ><input type='hidden' name='conta_chat' id='conta_chat'  >
<textarea id="todo_chat" style="display:none"></textarea>
	<div id="container-ajax"></div>
    <?php if(in_array('45',$_SESSION['cOperador'])){?>
	
        <div class="container">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;width:350px">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-6 col-xs-6" style="padding-left: 0px;width:80%" >
                        <h3 class="panel-title"><span id="titulo_chat_1" style="color:#3289C7"><img src="images/multiple-users-silhouette.png" width="22px" >&nbsp; <b>Chat</b></span>
						<span id="titulo_chat_2" style="color:#3289C7;display:none"><img src="images/back-button.png" width="22px" style="cursor:pointer" class="return_chat" >&nbsp; <b><span id="label_name"></span></b></span>
						
						</h3>
                    </div>
                    <div class="col-md-6 col-xs-6" style="text-align: right;padding-right: 0px;width:20%">
                        <!--<a href="#"><span id="" class="fa fa-group icon_group"></span></a>-->
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                        <!--<a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>-->
                    </div>
                </div>
                <div class="panel-body msg_container_base" style="height:300px">
					<span id="contenedor_1"><p></p>
					<!--<span id="titulo_chat_1" style="color:#3289C7">Conversaciones Recientes</span>-->
					<span id="cuerpoUsuario">
					</span>
					<!--<span id="titulo_chat_1" style="color:#3289C7">Conversaciones Anteriores</span>-->				
                    </span>
                    <span id="contenedor_2" style="display:none">
					
					<span id="cuerpoChat">
					</span>

                    </span>

                </div>
                <div class="panel-footer" style="display:none">
                    <div class="input-group">
                        <input id="input_chat" type="text" class="form-control input-sm chat_input" placeholder="Escribe mensaje Aquí" />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat" onclick="registrar_chat()" >Enviar</button>
                        </span>
                    </div>
                </div>
    		</div>
        </div>
    </div>
	<!--<div class="btn-group dropup">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-cog"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" id="new_chat"><span class="glyphicon glyphicon-plus"></span> Novo</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-list"></span> Ver outras</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-remove"></span> Fechar Tudo</a></li>
            <li class="divider"></li>
            <li><a href="#"><span class="glyphicon glyphicon-eye-close"></span> Invisivel</a></li>
        </ul>
    </div>-->
</div>
<?php } ?>
        
    </div>

