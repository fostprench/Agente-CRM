<script type="text/javascript" src="web/js/evnt/val_frmuser.js" ></script>
	

        
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">

            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="controller" value="User" />
			<input type="hidden" name="action" value="save" />
			
			<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
			
			<div class="col-xs-12 col-sm-6 col-md-6">
									
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Sucursal: </label>
				  <div class="col-md-6">
					<?php echo $sucursal;?>
				  </div>
				</div>

				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Perfil: </label>
				  <div class="col-md-6">
					<?php echo $perfil;?>
				  </div>
				</div>

								
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Nombres: </label>  
				  <div class="col-md-8">
				  <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $obj->idusuario; ?>"/>
				  <input type="text" name="nombres" id="nombres" value="<?php echo $obj->nombres; ?>" placeholder="Nombres" class="form-control input-md">
				  </div>
				</div>

				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="textinput">Telefono: </label>  
				  <div class="col-md-4">
					<input type="text" name="telefono" id="telefono" value="<?php echo $obj->telefono; ?>" placeholder="Telefono" onkeypress="return permite(event,'num')" class="form-control input-md" maxlength='15'>
				  </div>
				   <label class="col-md-2 control-label" for="textinput">DNI: </label>  
				  <div class="col-md-4">
					<input  type="text"  name="dni" id="dni"  value="<?php echo $obj->dni;?>"  onkeypress="return permite(event,'num')"  maxlength="8" class="form-control input-md" placeholder="DNI" >
				  </div>
				</div>
				
				<?php //$disbled='';if($p==2){$disbled="Readonly";}?>
				
				<div class="form-group">
				  <label class="col-md-3 control-label" for="textinput">Usuario: </label>  
				  <div class="col-md-3">
					<input  type="text"  name="usuario" id="usuario"  value="<?php echo $obj->usuario;?>" <?php //echo $disbled ?> placeholder="Usuario" size="13" maxlength="20" class="form-control input-md">
					<p id="resp"></p>
				 </div>
				   <label class="col-md-3 control-label" for="textinput">Clave: </label>  
				  <div class="col-md-3">
				  <input  type="password"  name="clave" id="clave"  value="<?php echo $obj->clave;?>" <?php //echo $disbled ?>  onkeydown="javascript:validar();" size="13" maxlength='20' placeholder="Password" class="form-control input-md">
				  </div>
				</div>
			
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="radios">Sexo: </label>
				  <div class="col-md-4"> 
					<label class="radio-inline" for="radios-0">
					  <input type="radio" name="sexo" id="sexo" value='Masculino' <?php if($obj->sexo == 'Masculino'){echo  "checked"; }?>>
					  Masculino
					</label> 
					<label class="radio-inline" for="radios-1">
					  <input type="radio" name="sexo" id="sexo" value='Femenino' <?php if($obj->sexo == 'Femenino'){echo  "checked"; }?>>
					  Femenino
					</label> 
				  </div>
				</div>
				

            </div>
            <div class="col-xs-12 col-sm-5 col-md-5">
					<div class="form-group">
						<label class="col-xs-12 col-sm-12 col-md-4 control-label"></label>
						<div class="col-xs-12 col-sm-12 col-md-8">
								<?PHP if($p==1 || $p==2) { ?>
									<div class="bootstrap-filestyle input-group">
										<input class="span3" type="file" name="image_file" id="image_file" style="display:none " />
										<input type="hidden" name="imagen_usuario" id="imagen_usuario" value="<?php  echo $obj->foto; ?>">
										<span class="group-span-filestyle input-group-btn" id="file_upload">
											<label for="filestyle-3" class="btn btn-primary "  style='width: 100%;'>
												<span class="glyphicon glyphicon-folder-open"> Click para Subir Foto </span>
											</label>
										</span>
								  </div>
							  <?PHP } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-xs-12 col-sm-12 col-md-4 control-label"></label>
						<div class="col-xs-12 col-sm-12 col-md-8">
							 <div style='border:1px solid #ccc;'>
								<h5 class='text-center' style='background: #c9302c;border-color: #ac2925;color:#fff;margin-top: 0px !important;margin-bottom: 0px !important;padding: 5px;'>Vista Previa Imagen</h5>				  
								<div id="progress_bar" class=""><div class="porcentaje text-center">&nbsp;&nbsp;0%</div></div>
								 <div id='vista_previa' class='text-center'>
									<?PHP if($p==2 || $p==3) { ?>
										<img class="img-responsive" src="view/fotos_user/<?php echo $obj->foto;?>"/>
									<?PHP } ?>
								</div>
							 </div>
						</div>
					</div>
            </div>
			
			<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
			</div>
			
				<?php if($p==3){ ?>
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<input type="button" value="Cerrar" onclick="closeWindow();" class="btn btn-success"/>
			  </div>
			</div>
			
			<?php }else{ ?>
			
		<div class="form-group">
			  <div class="col-md-12">
				<?php if($p==1){?>
				<input type="submit" name="grabar" id="grabar" value="registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="grabar" id="grabar" value="actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
			
			<?php } ?>
			</fieldset>
        </form>



