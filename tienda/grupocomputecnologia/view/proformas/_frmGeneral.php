<script type="text/javascript" src="web/js/evnt/proforma_general.js" ></script>
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend class='text-center'><?php echo $titulo; ?><?php if($p==3){?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button><?php } ?></legend>
		
		<input type="hidden" name="controller" value="Proforma_general" />
		<input type="hidden" name="action" value="save" />
		<input type="hidden" name="oper" id="oper" value="2"/>
		<input type="hidden" name="idproforma_general" id="idproforma_general" value="<?php echo $obj->idproforma_general; ?>"/>
		
	<div class="col-xs-12 col-sm-12 col-md-2"></div>
	
	<div class="col-xs-12 col-sm-12 col-md-6">
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="selectbasic">Garant&iacute;a Equipo: </label>
		  <div class="col-xs-12 col-sm-12 col-md-8">
			<input type="text" name='garantia' id='garantia' value="<?php echo $obj->garantia;?>" placeholder="Garantia" class="form-control input-sm"> 
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="textarea">Cheque:</label>
		  <div class="col-xs-12 col-sm-12 col-md-8">                     
			<textarea class="form-control" name="cheque" rows="3" id="cheque"><?php echo $obj->cheque; ?> </textarea>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="selectbasic">Plazo Max. Entrega: </label>
		  <div class="col-xs-12 col-sm-12 col-md-8">
			<input type="text" name='entrega' id='entrega' value="<?php echo $obj->entrega;?>" placeholder="Plazo Max. Entrega" class="form-control input-sm"> 
		  </div>
		</div>
		
		
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="textarea">Garant&iacute;a Componentes:</label>
		  <div class="col-xs-12 col-sm-12 col-md-8">
			<input type="text" name='descripcion' id='descripcion' value="<?php echo $obj->descripcion;?>" placeholder="Garantia de Componentes" class="form-control input-sm"> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="selectbasic">Mensaje: </label>
		  <div class="col-xs-12 col-sm-12 col-md-8">
			<input type="text" name='mensaje' id='mensaje' value="<?php echo $obj->mensaje;?>" placeholder="Mensaje" class="form-control input-sm"> 
		  </div>
		</div>
		
		
	</div>
	<div class="col-xs-12 col-sm-12 col-md-2"></div>

			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
			</div>
			

			
			<div class="form-group">
			  <div class="col-md-12">
				<input type="submit" name="grabar" id="grabar" value="Actualizar" class="btn btn-success"/>
			  </div>
			</div>
			

	</fieldset>
</form>

