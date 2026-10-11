<script type="text/javascript" src="web/js/evnt/concepto.js" ></script>
<form id="_form" name="_form" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input name="idconcepto" id="idconcepto" type="hidden" value="<?php echo $obj->idconcepto ?>"/>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="cuenta">Nro.de Cuenta:</label>  
		  <div class="col-md-4">
		  <input id="cuenta" name="cuenta" type="text" maxlength="100" value="<?php echo $obj->n_cuenta;?>" onkeypress="return permite(event,'num')" placeholder="Nro. de cuenta" class="form-control input-md" required="">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="descripcion">Descripcion:</label>
		  <div class="col-md-4">                     
			<textarea class="form-control" id="descripcion" name="descripcion"><?php echo utf8_encode($obj->descripcion);?></textarea>
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
 <div style='padding-top:265px;'> </div>