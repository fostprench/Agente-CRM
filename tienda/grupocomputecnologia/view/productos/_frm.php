<?PHP if($p==1 || $p==2) { ?>
<script type="text/javascript" src="web/js/evnt/productos.js" ></script>
<?PHP } ?>
<script type="text/javascript">
    $(document).ready(function()
	{
	    $("#idmarca__").change(function()
		{
            _id = $(this).val();alert(_id);
             nombre = "idmodelo";			
            $.get("model/select.php",{id:_id, name:"idmodelo"} ,function(data)
                { 
                    $("#_select_modelo").empty().append(data);
                });
        });
		
		<?php if($p==3){?>
		$('#idtipo').attr('disabled', true);
		$('#idmarca').attr('disabled', true);
		$('#descripcion').attr('disabled', true);
		$('#informacion').attr('disabled', true);
		$('#mostrar_web').attr('disabled', true);
		<?php } ?>
    });  
</script>
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend class='text-center'><?php echo $titulo; ?><?php if($p==3){?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button><?php } ?></legend>
		
		<input type="hidden" name="controller" value="Productos" />
		<input type="hidden" name="action" value="save" />
		<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
		<input type="hidden" name="idproducto" id="idproducto" value="<?php echo $obj->idproducto; ?>"/>
		
	<div class="col-xs-12 col-sm-12 col-md-6">
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="selectbasic">Categoria: </label>
		  <div class="col-xs-12 col-sm-12 col-md-8">
			<?php echo $tipo;?>
		  </div>
		</div>

		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="selectbasic">Marca:</label>
		  <div class="col-xs-12 col-sm-12 col-md-8">
			<?php echo $marca;?>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="textarea">Descripci&oacute;n:</label>
		  <div class="col-xs-12 col-sm-12 col-md-8">                     
			<textarea class="form-control" name="descripcion" rows="2" id="descripcion"><?php echo $obj->descripcion;?></textarea>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="textarea">Informaci&oacute;n:</label>
		  <div class="col-xs-12 col-sm-12 col-md-8">                     
			<textarea class="form-control" name="informacion" rows="4" maxlength="500" id="informacion"><?php echo $obj->informacion;?></textarea>
		  </div>
		</div>
	</div>
		
	<div class="col-xs-12 col-sm-12 col-md-6">
		<div class="form-group">
			<label class="col-xs-12 col-sm-12 col-md-4 control-label"></label>
			<div class="col-xs-12 col-sm-12 col-md-8">
					<?PHP if($p==1 || $p==2) { ?>
						<div class="bootstrap-filestyle input-group">
							<input class="span3" type="file" name="image_file" id="image_file" style="display:none " />
							<input type="hidden" name="imagen_producto" id="imagen_producto" value="<?php  echo $obj->foto; ?>">
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
							<img class="img-responsive" src="web/images/upload/<?php echo $obj->foto;?>"/>
						<?PHP } ?>
					</div>
				 </div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
			  <div class="col-xs-12 col-sm-12 col-md-3">
				  <label >Mostrar en Web:</label> <input type="checkbox" name="mostrar_web" id="mostrar_web" <?php $estado = $obj->web; if( $estado==1){echo "checked='checked'";}; ?>>
			  </div>
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
				<input type="submit" name="grabar" id="grabar" value="Registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="grabar" id="grabar" value="Actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
			
			<?php } ?>

	</fieldset>
</form>

