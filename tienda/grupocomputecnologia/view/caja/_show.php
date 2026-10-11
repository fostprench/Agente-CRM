<script type="text/javascript" src="web/js/evnt/cierra_caja.js" ></script>
<form id="_form" name="_form" class="form-horizontal">
	<fieldset>

		<legend class='text-center'>Realmente desea cerrar caja</legend>
		
		<input type="hidden" name="controller" value="Caja" />  
		<input type="hidden" name="idcaja" id='idcaja' value="<?php echo $idcaja;?>" />  
		
		<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
		</div>
		
		<div class="form-group text-center">
			<div class="col-md-12">
				<input type="button" name="Aceptar" id="Aceptar" value="Aceptar" class="btn btn-success"/>
				<input type="button" name="regresar" id="regresar" value="Cancelar"  onclick="closeWindow();" class="btn btn-warning"/>
			</div>
		</div>

	</fieldset>
</form>