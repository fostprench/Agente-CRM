<script type="text/javascript" src="web/js/evnt/garantia.js" ></script>
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input type="hidden" name="idventa" id="idventa"/>
		<input type="hidden" name="idcliente" id="idcliente"/>
		<input type="hidden" name="idproducto" id="idproducto"/>
		
	<div class="col-xs-12 col-sm-12 col-md-3"></div>
	<div class="col-xs-12 col-sm-12 col-md-6">
		

	
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="selectbasic">Serie:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">   
			<div class="input-group">
							<input type="text" name="serie" id="serie"  placeholder="Serie" size="20" class="form-control input-sm">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_serie">
								  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
							</span>
			</div>
			<span class="help-block" ></span> 
		  </div>
		</div>
			
	
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="textarea">Producto:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">                     
			<input type="text" name='producto' id='producto'  placeholder="Producto" ReadOnly="True" class="form-control input-sm">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="textarea">Comprobante:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">  
				<div class="input-group">
							<input type="text" name='comprobante' id='comprobante'  placeholder="Comprobante" ReadOnly="True" class="form-control input-sm">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="ver_factura">
								  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
							</span>
			</div>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="textarea">Fecha Comprobante:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">                     
			<input type="text" name='f_comprobante' id='f_comprobante'  placeholder="Fecha Comprobante" ReadOnly="True" class="form-control input-sm">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="textarea">Cliente:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">                     
			<input type="text" name='cliente' id='cliente'  placeholder="Cliente" ReadOnly="True" class="form-control input-sm">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="textarea">Tipo Venta:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">                     
			<input type="text" name='tipo_venta' id='tipo_venta'  placeholder="Tipo Venta" ReadOnly="True" class="form-control input-sm">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="selectbasic">Falla: </label>
		  <div class="col-xs-12 col-sm-12 col-md-7" id="select_falla">
			<?php echo $falla;?>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-3 control-label" for="textarea">Detalle Falla:</label>
		  <div class="col-xs-12 col-sm-12 col-md-7">                     
			<textarea class="form-control" name="detalle_falla" rows="4" maxlength="500" id="detalle_falla"></textarea>
		  </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3"></div>
	
	
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
		</div>
	</div>
		
	
			
			<div class="form-group">
			  <div class="col-md-12">
				<input type="button" name="grabar" id="grabar" value="Registrar" class="btn btn-success"/>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
			

	</fieldset>
</form>

