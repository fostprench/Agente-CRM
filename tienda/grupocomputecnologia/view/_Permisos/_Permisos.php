<style>
.permisos{
clear:both;height:400px; width:80%; overflow:auto; margin:0 auto;
}
.permisos_{
clear:both;height:auto; width:80%; overflow:auto; margin:0 auto;
}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $("#id_perfil").change(function(){
            vv = $(this).val();
            if(vv!=""){
            $("#result").hide("slow");
            $("#modulos").load("index.php","controller=_Permisos&action=Modulos&id_perfil="+vv,function(){
				  $("#modulos").removeClass("permisos").addClass("permisos_");
                  $("#modulos").slideDown("slow");
              });
            }
            else {
                $("#result,#modulos").hide("slow");                
            }
        });
        $("#save").click(function(){
            v = $("#id_perfil").val();
            if(v!=""){
                 $.each($("input:checkbox"), function(){
                    if($(this).attr("checked")){
                    }else {
                      $(this).attr("checked","checked")
                      $(this).val('off');
                    }
                });
                str = $("#frmpermisos").serialize();
				//alert(str);
                $("#result").hide("slow");
				ver_msg(0,'.::Guardando::..');
                $.post("index.php","controller=_Permisos&action=_Save&"+str, function(data)
                    { 
						 msg(1,data.msg,'controller=_Permisos');
					}
                ,'json');
		    }
                else {alert("Porfavor Seleccione un perfil antes de guardar los cambios.");
                      $("#id_perfil").focus();}
        });
    });   
</script>
<div class="bs-example" data-example-id="contextual-panels">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title">Administracion de Accesos</h3>
      </div>
      <div class="panel-body">
				
				<form class="form-horizontal" id="frmperfil" name="frmperfil"method="post" >
					<div class="form-group">
					  <label class="col-xs-12 col-sm-2 col-md-3 control-label text-center">Seleccione Perfil:</label>
					  <div class="col-xs-12 col-sm-6 col-md-6">
						<span><?php echo $cargos; ?></span>
					  </div>
					  <div class="col-xs-12 col-sm-4 col-md-3 text-center">
						<input type="button" id="save" value="Guardar Cambios" class="btn btn-primary" />
					  </div>
					</div>
				</form>
			

      </div>
    </div>
</div>
<div class="div_container">
<div id="msg">
	<div id="modulos" style='' class='permisos'></div>
</div>
</div>

