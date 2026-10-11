<script type="text/javascript" src="web/js/evnt/cliente.js" ></script>
<?php
function validar_fecha($fecha){
$fecha = strtotime($fecha);
$anio = (date('Y',$fecha));
$mes = (date('m',$fecha));
$dia =(date('d',$fecha));
return $dia.'-'.$mes.'-'.$anio;
}
?>
<SCRIPT>
	$(document).ready(function(){
		$('.style_nombres').addClass("hide");
		$('.style_razon').addClass("hide");
		<?php $tipo = $obj->tipo_cliente; if($tipo==1){?>
		$('.style_nombres').removeClass("hide").addClass("show");
		<?php }else if($tipo==2){ ?>
		$('.style_razon').removeClass("hide").addClass("show");
		<?php } if($p==3){ ?>
			$("#tipo_c").attr("disabled","disabled");
			$("#nombres").attr("disabled","disabled");
			$("#raz_social").attr("disabled","disabled");
			$("#dni").attr("disabled","disabled");
			$("#ruc").attr("disabled","disabled");
			$("#ubigeo").attr("disabled","disabled");
			$("#direccion").attr("disabled","disabled");
			$("#telefono").attr("disabled","disabled");
			$("#email").attr("disabled","disabled");
			$("#fecha").attr("disabled","disabled");
			$("#observaciones").attr("disabled","disabled");
		<?php } ?>
	});
function validar_numero(){
if(event.keyCode<48 || event.keyCode>57){event.returnValue = false;}
}
</SCRIPT>
<form id="_form" name="_form" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input type="hidden" name="controller" value="Cliente" /> 
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $obj->idcliente;?>">
	
		   
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Tipo cliente:</label>  
		  <div class="col-md-4">
				<select id="tipo_c" name="tipo_c" class="form-control">
				<option value="">::..Seleccione..::</option>
				<option value="1" <?php if($tipo==1){echo 'selected="selected"';}?>>Natural</option>
				<option value="2" <?php if($tipo==2){echo 'selected="selected"';}?>>Juridico</option>
				</select>
		  </div>
		</div>

		<div class="form-group style_nombres">
		  <label class="col-md-4 control-label" for="textinput">Nombres:</label>  
		  <div class="col-md-4">
		  <input type="text" name="nombres" id="nombres" value="<?php echo $obj->nombres; ?>"  placeholder="Nombres" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group style_razon">
		  <label class="col-md-4 control-label" for="textinput">Razon social:</label>  
		  <div class="col-md-4">
		  <input type="text" name="raz_social" id="raz_social"  value="<?php echo $obj->nombres; ?>" placeholder="Razon social" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group style_nombres">
		  <label class="col-md-4 control-label" for="textinput">DNI:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="dni" id="dni" size="13" maxlength="8" value="<?php echo $obj->ruc;?>" onkeypress="return permite(event,'num')" placeholder="DNI" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group style_razon">
		  <label class="col-md-4 control-label" for="textinput">RUC:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="ruc" id="ruc" size="13" maxlength="13" value="<?php echo $obj->ruc;?>" onkeypress="return permite(event,'num')" placeholder="RUC" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Ubigeo:</label>  
		  <div class="col-md-4">
			<?php echo $ubigeo;?>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Direcci&oacute;n:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="direccion" id="direccion" size="150" maxlength="150" value="<?php echo $obj->direccion;?>"  placeholder="Direccion" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group style_nombres">
		  <label class="col-md-4 control-label" for="textinput">Email:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="email" id="email" size="60" maxlength="60" value="<?php echo $obj->email;?>" placeholder="Email" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Telefono:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="telefono" id="telefono" size="45" maxlength="45" value="<?php echo $obj->telefono;?>" placeholder="Telefono" onkeypress="return permite(event,'num')"class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Fecha:</label>  
		  <div class="col-md-4">
		  <input type='text' name="fecha" id="fecha" size='8' value="<?php $fecha=$obj->fecha; if($fecha){echo validar_fecha($fecha);}else{echo date('d-m-Y');} ?>" placeholder="Fecha" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textarea">Observaciones:</label>
		  <div class="col-md-4">                     
			<textarea class="form-control" id="observaciones" name="observaciones"><?php echo $obj->observaciones;?></textarea>
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