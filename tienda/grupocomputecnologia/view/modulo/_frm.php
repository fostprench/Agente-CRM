<script type="text/javascript" src="web/js/evnt/val_frmmodulo.js" ></script>
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
		<input type="hidden" name="idmodulo" id="idmodulo" value="<?php echo $obj->idmodulo; ?>"/>

			<div class="form-group">
				<label class="col-md-4 control-label" for="selectbasic">Crear: </label>
				<div class="col-md-4">
					<select id="crear" name="crear" class="form-control">
						<option value="1"> MODULO </option>
						<option value="2"> SUB-MODULO </option>
					</select>
				</div>
			</div>
			
			<div id="modulo_padre" class="form-group <?php if($obj->submodulo==NULL){ echo 'hidden';}?>">
				<label class="col-md-4 control-label" for="selectbasic">Padre: </label>
				<div class="col-md-4"><?php echo $ModulosPadres; ?></div>
			</div>

			
			<div class="form-group">
				<label class="col-md-4 control-label" for="selectbasic">Descripcion: </label>
				<div class="col-md-4">
					<input type='text'   name='descripcion' id='descripcion'maxlength="100" value="<?php echo $obj->descripcion;?>" class="form-control"   placeholder="Descripcion" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label" for="selectbasic">Url: </label>
				<div class="col-md-4">
					<input type='text'   name='url' id='url'  maxlength="100" value="<?php echo $obj->url;?>" class="form-control"   placeholder="Url" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label" for="selectbasic">Orden: </label>
				<div class="col-md-4">
					<input type='text'   name='orden' id='orden'  maxlength="10" value="<?php echo $obj->orden;?>" class="form-control"   placeholder="Orden" />
				</div>
			</div>
			
			<div id="modulo_icono" class="form-group <?php if($obj->submodulo){ echo 'hidden';}?>">
				<label class="col-md-4 control-label" for="selectbasic">Icono: </label>
				<div class="col-md-4">
					<input type='text'   name='icono' id='icono'  value="<?php echo $obj->icono;?>" class="form-control"   placeholder="Icono" />
				</div>
			</div>
			
			 <?php if( $obj->estado==1){$check="checked='checked'";}else {$check="";} ?>
			
			<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Estado: </label>
				  <div class="col-md-4 text-left">
					<input type='checkbox' name='estado' id='estado' <?php echo $check;?>/>
				  </div>
			</div>
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
			</div>
			
				
			<div class="form-group">
			  <div class="col-md-12">
				<?php if($p==1){?>
				<input type="submit" name="grabar" id="grabar" value="Registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="actualiza" id="actualiza" value="Actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>

	</fieldset>
</form>
					 