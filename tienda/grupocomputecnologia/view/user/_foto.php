<script type="text/javascript" src="web/js/evnt/actualizar_foto.js" ></script>
<div class="row">
<div class="col-xs-12 col-sm-3 col-md-3"></div>
<div class="col-xs-12 col-sm-6 col-md-6">

 <div class="bs-example" data-example-id="contextual-panels">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title">ACTUALIZAR FOTO DE USUARIO</h3>
      </div>
      <div class="panel-body">
				
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-3"></div>
					 <div class="col-xs-12 col-sm-6 col-md-6">
						
						<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" >
							<fieldset>
								
									
					
									<div class="form-group">
										<div class="col-xs-12 col-sm-12 col-md-12">
											 <div style='border:1px solid #ccc;'>
												<h5 class='text-center' style='background: #c9302c;border-color: #ac2925;color:#fff;margin-top: 0px !important;margin-bottom: 0px !important;padding: 5px;'>Vista Previa Imagen</h5>				  
												<div id="progress_bar" class=""><div class="porcentaje text-center">&nbsp;&nbsp;0%</div></div>
												 <div id='vista_previa' class='text-center'>
														<img class="img-responsive" src="view/fotos_user/<?php echo $obj->foto;?>"/>
												</div>
											 </div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-xs-12 col-sm-12 col-md-12">
													<div class="bootstrap-filestyle input-group">
														<input class="span3" type="file" name="image_file" id="image_file" style="display:none " />
														<input type="hidden" name="imagen_usuario" id="imagen_usuario" value="<?php  echo $obj->foto; ?>">
														<span class="group-span-filestyle input-group-btn" id="file_upload">
															<label for="filestyle-3" class="btn btn-primary "  style='width: 100%;'>
																<span class="glyphicon glyphicon-folder-open"> Subir Foto </span>
															</label>
														</span>
												  </div>
										</div>
									</div>
								
								<!---<hr style="border-top: 1px solid #e5e5e5; width:100%"/>--->
								
								<div class="form-group text-center">
									 <div class="col-xs-12 col-sm-12 col-md-12">
										<a class="btn btn-danger btn-block" href="javascript:paginacion('controller=User&action=Panel')"> Atras</a>
									 </div>
								 </div>
								 
							</fieldset>
						</form>
					 </div>
					 <div class="col-xs-12 col-sm-3 col-md-3"></div>
					 
					 <div class="col-xs-12 col-sm-12 col-md-12">
					 
						<div id="msg" style="display:none; font-size: 15px; color: red;" align="center"></div>
						<div id="res"></div>
						<div id="loader" style="display:none" align="center"><img src="images/ajax_load.gif" /></div>

					 </div>
					 
					 
				</div>
						
      </div>
    </div>
</div>

</div>
<div style="padding-top:240px"></div>