<script src="<?php base_url()?>js/jquery.uitablefilter.js"      type="text/javascript"></script>
<script src="<?php base_url()?>library/plugins/select2/select2.full.min.js"></script>

<script>
    $(document).ready(function(){
			$("#square-profile").removeClass("open");  

	        $("#btn-guardar").click(function(){
            if($("#pass").val()==""){
                $("#texto-yellow").html("Ingresar nueva contraseña");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if($("#pass2").val()==""){
                $("#texto-yellow").html("Repetir nueva contraseña");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else if( $("#pass").val()!=$("#pass2").val() ){
                $("#texto-yellow").html("Las contraseñas deben ser iguales");
                $("#alert-yellow").slideDown('slow');
                ocultarAlerta();
            }
            else{
                $.ajax({
                url  : '<?php base_url()?>Acceso/cambiar_contrasena',
                data : "pass="+$('#pass').val()+"&pass2="+$('#pass2').val(),
                type : 'POST',
                success : function(result) {
                    if(result=='1'){
                    $("#texto-green").html("La contraseña fue actualizada");
                    $("#alert-green").slideDown('slow');
                    ocultarAlerta();
                    $("#pass").val("");$("#pass2").val("");
                    }
                },
                error : function(request, xhr, status) {
                alert("Error : "+status+' '+xhr.responseText+ ' - '+ request );
                }
                });	
            }
        });
    });
	
	function ocultarAlerta(){
        window.setTimeout(function(){
        $("#alert-green").slideUp('slow');
        $("#alert-red").slideUp('slow');
        $("#alert-blue").slideUp('slow');
        $("#alert-yellow").slideUp('slow');
        }, 8000);  
    }     
</script>
<section class="content-header">
    <div class="row">
       	<div class="col-xs-5 col-sm-6 col-md-8 col-lg-8"><span style="font-size:18px;font-weight:bold">Cambiar Contraseña
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
                </div>
                <div class="box-body pad table-responsive" style="overflow:scroll;height:700px" >
				<br><br>
                    <div class="row" style="margin-right:0px">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						</div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Ingresar nueva contraseña</label>
                                <div class='form-group'>
                                <input type=password name="pass" id="pass"  class="form-control" >
                                </div>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						</div>
					</div>
                    <div class="row" style="margin-right:0px">   
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						</div>					
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<label>Repetir nueva contraseña</label>
                            <div class="form-group">
                             <input type=password name="pass2" id="pass2"  class="form-control" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						</div>
                    </div>	
					<br>
					<div class="row" style="margin-right:0px">   
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						</div>					
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group" align=center>
								<button id="btn-guardar" type="button" class="btn btn-danger">Guardar</button>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						</div>
                    </div>	
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- ./row -->

</section><!-- /.content -->
