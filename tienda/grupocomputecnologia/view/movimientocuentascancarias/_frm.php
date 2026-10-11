<script type="text/javascript" src="web/js/evnt/movimientocuentascancarias.js" ></script>
<form class="form-horizontal" id="_form" name="_form" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend class='text-center'><?php echo $titulo; ?></legend>

		<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
		<input type="hidden" name="idmovimiento_cuentas" id="idmovimiento_cuentas" value="<?php echo $obj->idmovimiento_cuentas; ?>"/>
		
		
		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-xs-12 col-sm-3 col-md-3 control-label" for="selectbasic">Banco:</label>
		  <div class="col-xs-12 col-sm-3 col-md-3">
			<?php echo $bancos;?>
		  </div>
		  <label class="col-xs-12 col-sm-1 col-md-1 control-label" for="selectbasic">Saldo:</label>
		  <div class="col-xs-12 col-sm-2 col-md-2">
				<input type="text" name="monto_banco" id="monto_banco" class="form-control" />
		  </div>
		  <div class="col-xs-12 col-sm-2 col-md-2 text-left">
				<input type="button" name="act_saldo" id="act_saldo" value="Actualizar" class="btn btn-success"/>
		  </div>
		</div>
		
		<div class="form-group">
			<div class="col-md-12 text-center mensaje_ok">
				<div id="msg_saldo" ></div>
			</div>
		</div>
		
		<hr/>
		
		<div class="form-group">
		  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="selectbasic">Tipo Movimiento:</label>
		  <div class="col-xs-12 col-sm-12 col-md-4">
			<?php echo $motivo;?>
		  </div>
		</div>
		
		<div class="form-group">
				  <label class="col-xs-12 col-sm-12 col-md-4 control-label" for="textarea">Ingreso:</label>
				  <div class="col-xs-12 col-sm-12 col-md-1">    
					  <input class='radio' type='radio' name='tipo_ingreso' id='tipo_ingreso' value="1" <?php if($obj->tipo_movimiento==1){ echo  'checked="checked"';} ?>>
				  </div>
				  <label class="col-xs-12 col-sm-12 col-md-2 control-label" for="textarea">Egreso:</label>
				  <div class="col-xs-12 col-sm-12 col-md-1">    
					  <input class='radio' type='radio' name='tipo_ingreso' id='tipo_ingreso' value="2"  <?php if($obj->tipo_movimiento==2){ echo  'checked="checked"';} ?>>
				  </div>
		</div>
						
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Monto: </label>
		  <div class="col-md-4">
				<input type="text" name="monto" id="monto" class="form-control" maxlength="100" value="<?php echo $obj->monto;?>"/>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Fecha: </label>
		  <div class="col-md-4">
				<input type="text" name="fecha" id="fecha" class="form-control" maxlength="100" value="<?php if($fecha){ echo $fecha;}else{ echo date('d-m-Y');}?>"/>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Referencia: </label>
		  <div class="col-md-4">
				<input type="text" name="referencia" id="referencia" class="form-control" maxlength="100" value="<?php echo $obj->referencia;?>"/>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Observaci&oacute;n: </label>
		  <div class="col-md-4">
				<input type="text" name="observacion" id="observacion" class="form-control" maxlength="100" value="<?php echo $obj->observacion;?>"/>
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
				<input type="button" name="grabar" id="grabar" value="Registrar" class="btn btn-success" onclick="guardar_cuentas();"/>
				<?php }if($p==2){?>
				<input type="button" name="grabar" id="grabar" value="Actualizar" class="btn btn-success" onclick="guardar_cuentas();"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
	

	</fieldset>
</form>

 <div style='padding-top:250px;'> </div>
<br/>