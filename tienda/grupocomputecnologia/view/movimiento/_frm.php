<script type="text/javascript" src="web/js/evnt/movimiento.js" ></script>
<?php require_once('lib/funciones.php'); ?>
<?php if($idventa==NULL){?>
<form id="_form" name="_form" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input name="idcaja" id="idcaja" type="hidden" value="<?php echo $idcaja;?>"/>
		<input name="tipo_movimiento" id="tipo_movimiento" type="hidden" value="<?php $tipo = $obj->tipo_movimiento; if($tipo){echo $tipo;}else{echo $tipo_mov;} ?>"/>
		<input name="idmovimiento" id="idmovimiento" type="hidden" value="<?php echo $obj->idmovimiento;?>"/>
		<input type="hidden" name="id_usuario" id="id_usuario" size="3" value="<?php echo $_SESSION['id_usuario'];?>"/>
		
		<?php if($tipo_mov==1){ ?>
		<input name="idcontrolcaja" id="idcontrolcaja" type="hidden" value="<?php $idcontrolcaja = $obj->idcontrolcaja; if($idcontrolcaja){echo $idcontrolcaja;}else{echo $control_caja;} ?>"/>
		<?php }else{ ?>		
		<!--combo de control de caja-->
		<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Control Caja: </label>
				  <div class="col-md-4">
					<?php echo $control;?>
				  </div>
		</div>
		<?php } ?>	
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textarea">Descripci&oacute;n: </label>
		  <div class="col-md-4">                     
			<textarea class="form-control"  name="descripcion" id="descripcion" maxlength="300" required=""><?php echo ($obj->descripcion);?></textarea>
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Monto: </label>  
		  <div class="col-md-4">
		  <input type="text"  name="monto" id="monto"  value="<?php echo $obj->monto;?>" onkeypress="return permite(event,'num')"  placeholder="Monto" class="form-control input-sm" required="">
			
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Fecha: </label>  
		  <div class="col-md-4">
		  <input type="text" name="fecha" id="fecha" value="<?php $fecha = $obj->fecha; if($fecha){echo validar_fecha($fecha);}else{ echo date('d-m-Y');} ?>" onkeypress="return permite(event,'num')" placeholder="Fecha" class="form-control input-sm" required="">
			
		  </div>
		</div>
		
		<?php if($tipo_mov==2){ ?>
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Nro. Operaci&oacute;n: </label>  
			  <div class="col-md-4">
			  <input type="text"  name="operacion" id="operacion"  value="<?php echo $obj->operacion;?>" maxlength="50"   placeholder="Nro. Operacion" class="form-control input-sm">
				
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textarea">Observaciones: </label>
			  <div class="col-md-4">                     
				<textarea class="form-control"  name="observaciones" id="observaciones" maxlength="200" ><?php echo ($obj->observaciones);?></textarea>
			  </div>
			</div>
		<?php }?>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput"><?php echo $responsable; ?></label>  
		  <div class="col-md-4">
		  <input type="text" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'];?>" readonly="true" placeholder="Responsable" class="form-control input-sm">
			
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
 <div style='padding-top:150px;'> </div>
<?php } else{?>
<div class="alert alert-danger" role="alert">
        <strong>Ops!</strong> <?php echo $mensaje; ?>
 </div>
<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
 <div style='padding-top:347px;'> </div>
<?php } ?>