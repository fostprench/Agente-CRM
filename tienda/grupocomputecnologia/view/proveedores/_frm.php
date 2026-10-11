<script type="text/javascript" src="web/js/evnt/proveedor.js" ></script>
<SCRIPT>
<?php if($p==3){?>
		$('#descripcion').attr('disabled', true);
		$('#ruc').attr('disabled', true);
		$('#direccion').attr('disabled', true);
		$('#telefono').attr('disabled', true);
		$('#email').attr('disabled', true);
		$('#contacto').attr('disabled', true);
		$('#lugar').attr('disabled', true);
		<?php } ?>
</SCRIPT>

<form id="_form" name="_form" action="" method="POST" class="form-horizontal">
	<fieldset>

	<legend class='text-center'><?php echo $titulo; ?><?php if($p==3){?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button><?php } ?></legend>
	<input type="hidden" name="controller" value="Proveedores" />       
	<input type="hidden" name="oper" value="<?php echo $p;?>" />       
	<input type='hidden' id="idproveedor" name="idproveedor" value="<?php echo $obj->idproveedor;?>" />       

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Proveedor:</label>  
		  <div class="col-md-4">
		  <input type="text" name="descripcion" id="descripcion" value="<?php echo $obj->descripcion;?>"  placeholder="Proveedor" class="form-control input-md" required="">
			
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">RUC:</label>  
		  <div class="col-md-4">
		  <input type="text" name="ruc" id="ruc" value="<?php echo $obj->ruc;?>" onkeypress="validar_numero()" maxlength="11" size="11" placeholder="RUC" class="form-control input-md" required="">
			
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textarea">Direcci&oacute;n:</label>
		  <div class="col-md-4">                     
			<textarea class="form-control" name="direccion" id="direccion"  maxlength="100"><?php echo $obj->direccion;?></textarea>
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Telefono:</label>  
		  <div class="col-md-4">
		  <input type="text" name="telefono" id="telefono" value="<?php echo $obj->telefono;?>"  maxlength="20" placeholder="Telefono" class="form-control input-md">
			
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Email:</label>  
		  <div class="col-md-4">
		  <input type="text" name="email" id="email" value="<?php echo $obj->email;?>"  maxlength="40" placeholder="Email" class="form-control input-md">
			
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Contacto:</label>  
		  <div class="col-md-4">
		  <input type="text" name="contacto" id="contacto" value="<?php echo utf8_encode($obj->contacto);?>"  maxlength="45" placeholder="Contacto" class="form-control input-md">
			
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Ciudad:</label>  
		  <div class="col-md-4">
		  <input type="text" name="lugar" id="lugar" value="<?php echo utf8_encode($obj->lugar);?>"  placeholder="Ciudad" class="form-control input-md">
			
		  </div>
		</div>
		
		<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
		</div>
		
		<?php if($p==3){?>
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<input type="button" value="Cerrar" onclick="closeWindow();" class="btn btn-success"/>
			  </div>
			</div>
			
			<?php }else{ ?>
			
		<div class="form-group">
			  <div class="col-md-12">
				<?php if($p==1){?>
				<input type="button" name="grabar" id="grabar" value="Registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="button" name="grabar" id="grabar" value="Actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
			
			<?php } ?>

	</fieldset>
</form>
