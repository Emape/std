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
    padding: 10px;
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
<div class="content-wrapper">
	<div id="container-ajax"></div>
        
        <div class="container">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-6 col-xs-6">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat </h3>
                    </div>
                    <div class="col-md-6 col-xs-6" style="text-align: right;">
                        <a href="#"><span id="" class="fa fa-group icon_group"></span></a>
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                    </div>
                </div>
                <div class="panel-body msg_container_base">
                    <span id="contenedor">
                    <div class="row msg_container base_sent">
                        <div class="col-xs-10 colchat col-md-10">
                            <div class="messages msg_sent">
                                <p>Hola que tal</p>
                                <time datetime="2009-11-13T20:00">Anibal • 10:30</time>
                            </div>
                        </div>
                        <div class="col-md-2 colchat col-xs-2 avatar">
                            <img src="images/avatar.jpg" class=" img-responsive img-circle ">
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 colchat col-xs-2 avatar">
                            <img src="images/avatar.jpg" class=" img-responsive img-circle">
                        </div>
                        <div class="col-xs-10 colchat col-md-10">
                            <div class="messages msg_receive">
                                <p>Puedes enviarme un correo con tus observaciones.</p>
                                <time datetime="2009-11-13T20:00">Jessica • 10:45</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 colchat col-xs-10 ">
                            <div class="messages msg_sent">
                                <p>Ok un momento</p>
                                <time datetime="2009-11-13T20:00">Anibal • 10:50</time>
                            </div>
                        </div>
                        <div class="col-md-2 colchat col-xs-2 avatar">
                            <img src="images/avatar.jpg" class=" img-responsive img-circle">
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 colchat col-xs-2 avatar">
                            <img src="images/avatar.jpg" class=" img-responsive img-circle">
                        </div>
                        <div class="col-xs-10 colchat col-md-10">
                            <div class="messages msg_receive">
                                <p>Por cierto ¡Feliz Cumpleaños!</p>
                                <time datetime="2009-11-13T20:00">Jessica • 10:52</time>
                            </div>
                        </div>
                    </div>
                    </span>
                    <span id="contenedor2">
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 colchat col-xs-2 avatar">
                            <img src="images/avatar.jpg" class=" img-responsive img-circle">
                        </div>
                        <div class="col-xs-10 colchat col-md-10">
                            <div class="messages msg_receive">
                                <p>Anibal Chamorro <span class="fa fa-circle" style="color:green" ></b></p>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 colchat col-xs-2 avatar">
                            <img src="images/avatar.jpg" class=" img-responsive img-circle">
                        </div>
                        <div class="col-xs-10 colchat col-md-10">
                            <div class="messages msg_receive">
                                <p>Jessica Poma</p>
                                
                            </div>
                        </div>
                    </div>
                    </span>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Escribe mensaje Aquí" />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat">Enviar</button>
                        </span>
                    </div>
                </div>
    		</div>
        </div>
    </div>
    
<!-- <div class="btn-group dropup">
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
        
    </div>

