<script type="text/javascript" src="web/js/evnt/marca.js" ></script>
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend class='text-center'><?php echo $titulo; ?></legend>

		<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
		<input type="hidden" name="idmarca" id="idmarca" value="<?php echo $obj->idmarca; ?>"/>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Marca: </label>
		  <div class="col-md-4">
				<input type="text" name="descripcion" id="descripcion" class="form-control" maxlength="100" value="<?php echo $obj->descripcion;?>"/>
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
				<input type="submit" name="grabar" id="grabar" value="Actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
	

	</fieldset>
</form>

 <div style='padding-top:250px;'> </div>
<br/>