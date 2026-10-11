<script type="text/javascript" src="web/js/evnt/val_frmperfil.js" ></script>
<form  id="_form" name="_form"   class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input name="idperfil" id="idperfil" type="hidden" value="<?php echo $obj->idperfil?>"/>
						   
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Descripcion: </label>  
		  <div class="col-md-4">
		  <input type="text"  name="descripcion" id="descripcion" maxlength="100" value="<?php echo $obj->descripcion;?>"placeholder="Descripcion" class="form-control input-md"> 
		  </div>
		</div>

		<?php if( $p==1 || $obj->estado==1){$check="checked='checked'";}else {$check="";} ?>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="checkboxes">Estado: </label>
		  <div class="col-md-4">
			<label class="checkbox-inline" for="checkboxes-0">
			  <input type="checkbox" name="estado" id="estado" <?php echo $check;?>/>
			  Activo
			</label>
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
				<input type="submit" name="grabar" id="grabar" value="registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="grabar" id="grabar" value="actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>

	</fieldset>
</form>
<div style="padding-top:200px;"></div>