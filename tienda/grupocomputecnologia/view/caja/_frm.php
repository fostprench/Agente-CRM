<script type="text/javascript" src="web/js/evnt/caja.js" ></script>

<form id="_form" name="_form" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input type="hidden" name="id_usuario" id="id_usuario"  value="<?php echo $_SESSION['id_usuario'];?>"/>
		<input type="hidden" name="oper" id="oper" value="<?php echo $p; ?>"/>
		<input type="hidden" name="id_caja" id="id_caja" value="<?php echo $idcaja; ?>"/>
					
		
		<?php if($p==1 || $p==2){?>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="fecha_a">Fecha Apertura: </label>  
		  <div class="col-md-4">
		  <input id="fecha_a" name="fecha_a" type="text" value="<?php if($fecha_apertura){echo $fecha_apertura; }else{echo date('d-m-Y');} ?>" placeholder="Fecha Apertura" class="form-control input-md" required="">
		    
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="fecha_a">Monto de Apertura: </label>
		  <div class="col-md-4">
		  <input id="monto_a" name="monto_a" type="text" value="<?php echo $saldo;?>" placeholder="Monto Apertura" class="form-control input-md" required="">
		    
		  </div>
		</div>

		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput"><?php echo $responsable; ?></label>  
		  <div class="col-md-4">
		  <input type="text" name="usuario" id="usuario" value="<?php if($usuario){echo $usuario;}else{echo $_SESSION['usuario'];};?>" readonly="true" placeholder="Responsable" class="form-control input-md">
			
		  </div>
		</div>
		
		<?php }elseif($p==3) { ?>
		<div class="form-group">
			  <div class="col-md-12 text-center">
					<div class="alert alert-danger" id="msg-parte" class="text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <?php echo $mensaje; ?></div>
			  </div>
		</div>
		<?php } ?>
			
		<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
		</div>
		
		<div class="form-group">
			<div class="col-md-12">
				<?php if($p==1){?>
				<input type="submit" name="grabar" id="grabar" value="Registrar" class="btn btn-success"/>
				<?php }elseif($p==2){ ?>
				<input type="submit" name="editar" id="editar" value="Actualizar" class="btn btn-success"/>
				<?php } ?>
				<input type="button" name="regresar" id="regresar" value="atras"  onclick="atras();" class="btn btn-warning"/>
			</div>
		</div>

	</fieldset>
</form>


 <div style='padding-top:200px;'> </div>
