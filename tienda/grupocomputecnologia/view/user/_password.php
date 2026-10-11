<script type="text/javascript" src="web/js/change_password.js" ></script>
 <div class="bs-example" data-example-id="contextual-panels">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title">ACTUALIZAR FOTO DE USUARIO</h3>
      </div>
      <div class="panel-body">
				
				<div class="row">
					<div class="col-xs-12 col-sm-2 col-md-2"></div>
					 <div class="col-xs-12 col-sm-8 col-md-8">
						
						<form id="frmperfil" name="frmperfil" method="POST" class="form-horizontal" enctype="multipart/form-data" >
							<fieldset>
								
								<input type="hidden" name="controller" value="user" />
								<input type="hidden" name="action" value="save_photo" />
								
								<div class="form-group">
								  <label class="col-md-4 control-label" for="filebutton">Clave actual:</label>
								  <div class="col-md-4">
									<input type="password" id="password" name="password" class="form-control" />
									<span class="help-block"><a href="javascript:void(0);" style="color:#000" onclick="javascript:valida_password()">Validar Password</a></span>
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="col-md-4 control-label" for="filebutton">Nueva clave:</label>
								  <div class="col-md-4">
									<input type="password" id="clave" name="clave"    disabled="" class="form-control" />
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="col-md-4 control-label" for="filebutton">Confirme actual:</label>
								  <div class="col-md-4">
									<input type="password" id="clave2" name="clave2"    disabled="" class="form-control" />
								  </div>
								</div>
								
								<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
								
								 <div class="col-xs-12 col-sm-12 col-md-12 text-center">
									<div class="form-group">
									  <div class="col-md-3"></div>
									  <div class="col-md-3">
										<a class="btn btn-primary" id="cambiar_clave"  href="javascript:change_password();" style="display:none">Cambiar</a>
									  </div>
									  <div class="col-md-3">
										<a class="btn btn-primary" href="javascript:paginacion('controller=User&action=Panel')" style="display:block">Cancelar</a>
									  </div>
									  <div class="col-md-3"></div>
									</div>
									
								 </div>
								
								 
							</fieldset>
						</form>
					 </div>
					 		
			
					 <div class="col-xs-12 col-sm-12 col-md-12">
						<div class="alert alert-danger" id="msg" style="display:none;" class="text-center" role="alert"></div>
						<div id="res"></div>
						<div id="loader" style="display:none" align="center"><img src="images/ajax_load.gif" /></div>
					 </div>
					 
					 
				</div>
						
      </div>
    </div>
</div>
<div style="padding-top:130px"></div>