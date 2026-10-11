<?php if($obj->foto)
   {
		$FOTO = $obj->foto;
   }else
   {
		$FOTO = "default.jpg";
   }
?>
<style>
.font_size{
font-size: 12px;
}
.font_size2{
font-size: 14px;font-weight: bold;
}
.txt_user{
    COLOR: #90949c;
    font-weight: bold;
    word-wrap: break-word;
}
</style>

<div class="row">
<div class="col-xs-12 col-sm-1 col-md-1"></div>
<div class="col-xs-12 col-sm-10 col-md-10">
<div class="bs-example" data-example-id="contextual-panels">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title">CONFIGURACI&Oacute;N GENERAL DE LA CUENTA</h3>
      </div>
      <div class="panel-body">
				
				<div class="row">
					 <div class="col-xs-12 col-sm-1 col-md-1"></div>
					 <div class="col-xs-12 col-sm-2 col-md-2">
					 	<form id="_form" name="_form" class="form-horizontal">
							<fieldset>
								<legend class='text-center font_size2'>CONFIGURACI&Oacute;N</legend>
								<button type="button" onclick="cargar_pages('controller=User&action=change_password');" class="btn btn-primary btn-block">Cambiar Password</button>
								<button type="button" onclick="cargar_pages('controller=User&action=photo')" class="btn btn-primary btn-block">Actualizar Foto</button>
								<a href="." class="btn btn-danger btn-block">Inicio</a>
							</fieldset>
						</form>
					 </div>
					 
					
					<div class="col-xs-12 col-sm-5 col-md-5">
							<form id="_form" name="_form" class="form-horizontal">
							<fieldset>
								
								<legend class='text-center font_size2'>PERFIL DE USUARIO</legend>
								
								<div class="form-group ">
								  <label class="col-md-4 control-label font_size" >Nombre:</label>  
								  <label class="col-md-8 control-label font_size txt_user" style='text-align:left' ><?php echo $obj->nombres; ?></label> 
								</div>

								<div class="form-group ">
								  <label class="col-md-4 control-label font_size" >Telefono:</label>
								  <label class="col-md-8 control-label font_size txt_user" style='text-align:left'><?php echo $obj->telefono; ?></label>
								</div>

								<div class="form-group ">
									<label class="col-md-4 control-label font_size" >DNI:</label>  
									<label class="col-md-8 control-label font_size txt_user" style='text-align:left' ><?php echo $obj->dni; ?></label>
								</div>
								
								<div class="form-group ">
								  <label class="col-md-4 control-label font_size" >Sexo:</label>  
								  <label class="col-md-8 control-label font_size txt_user" style='text-align:left'><?php echo strtoupper($obj->sexo);?></label>
								</div>
								
							</fieldset>
						</form>
						
					</div>
					
					<div class="col-xs-12 col-sm-3 col-md-3">
						<form id="_form" name="_form" class="form-horizontal">
							<fieldset>
								<legend class='text-center font_size2'>DATOS DE USUARIO</legend>
								<img src="<?php echo $url;?><?php echo $FOTO;?>" class="thumbnail img-responsive" style="margin:0 auto"/><br/>
							</fieldset>
						</form>
					</div>
					
				</div>
				
				<div class="row">
						 <hr style="border-top: 1px solid #e5e5e5; width:100%"/>
				</div>
				
			
						
      </div>
    </div>
</div>
</div>
</div>
<div style="padding-top:60px"></div>